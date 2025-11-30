<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\abonnement;
use App\Models\Paiement;
use App\Models\Souscription;
use Carbon\Carbon;

class PaiementController extends Controller
{

    protected function getUsdToXafRate()
    {
        try {
            $apiKey = env('EXCHANGERATE_API_KEY'); // ta clé API
            $response = Http::get("https://v6.exchangerate-api.com/v6/{$apiKey}/latest/USD"); // exemple pour exchangerate-api.com

            if ($response->successful()) {
                $data = $response->json();
                if (isset($data['conversion_rates']['XAF'])) {
                    return $data['conversion_rates']['XAF'];
                }
            }
            Log::error('Impossible de récupérer le taux de change', ['response' => $response->body()]);
        } catch (\Exception $e) {
            Log::error('Erreur récupération taux de change : ' . $e->getMessage());
        }

        // Si échec, on ne retourne rien ou on peut renvoyer null pour gérer ailleurs
        return null;
    }


    /**
     * Étape 1 : Initier un paiement CinetPay
     */
    public function process(Request $request, $abonnementId)
    {
        $abonnement = abonnement::findOrFail($abonnementId);
        $user = auth()->user();

        if (! $user) {
            Log::warning('Paiement: utilisateur non authentifié');
            return redirect()->route('auth.connexion')->with('error', 'Veuillez vous connecter pour effectuer un paiement.');
        }

        // Validation des champs client nécessaires pour paiement par carte
        $request->validate([
            'customer_phone_number' => 'required|string|max:30',
            'customer_address'      => 'required|string|max:255',
            'customer_city'         => 'required|string|max:100',
            'customer_state'        => 'required|string|max:100',
            'customer_zip_code'     => 'required|string|max:10',
        ]);

        $apiKey = env('CINETPAY_API_KEY');
        $siteId = env('CINETPAY_SITE_ID');
        $secretKey = env('CINETPAY_SECRET_KEY'); // utilisé pour HMAC si nécessaire

        // URLs
        $returnUrl = url('/callback.php');
        $notifyUrl = url('/callback.php');

        // Générer un ID de transaction unique
        $transactionId = uniqid('PAY-');

        // montant
        $prixUsd = $abonnement->prix;
        $prixXaf = round($prixUsd * $this->getUsdToXafRate());

        $formData = [
            "apikey"                => $apiKey,
            "site_id"               => $siteId,
            "transaction_id"        => $transactionId,
            "amount"                => $prixXaf,
            "currency"              => "XAF",
            "description"           => "Paiement abonnement : {$abonnement->examen}",
            "return_url"            => $returnUrl,
            "notify_url"            => $notifyUrl,
            "customer_id"           => $user->id,
            "customer_name"         => $user->name,
            "customer_surname"      => $user->name,
            "customer_email"        => $user->email,
            "customer_phone_number" => $request->input('customer_phone_number'),
            "customer_address"      => $request->input('customer_address'),
            "customer_city"         => $request->input('customer_city'),
            "customer_country"      => 'CM',
            "customer_state"        => $request->input('customer_state'),
            "customer_zip_code"     => $request->input('customer_zip_code'),
            "channels"              => "ALL",
            "metadata"              => "user:{$user->id},abonnement:{$abonnement->id}",
            "lang"                  => "fr",
        ];


        // Appel API CinetPay
        $response = Http::asJson()->post('https://api-checkout.cinetpay.com/v2/payment', $formData);

        if ($response->successful()) {
            $result = $response->json();
            Log::info('CinetPay init', $result);

            if (isset($result['data']['payment_url'])) {
                // Sauvegarder la transaction en attente
                Paiement::create([
                    'user_id' => $user->id,
                    'abonnement_id' => $abonnement->id,
                    'montant' => $prixXaf,
                    'methode' => 'cinetpay',
                    'transaction_id' => $transactionId,
                    'statut' => 'pending',
                    'devise' => 'XAF',
                    'details' => json_encode($result),
                ]);

                return redirect()->away($result['data']['payment_url']);
            }
        }

        Log::error('Erreur CinetPay', [
            'status' => $response->status(),
            'body' => $response->body()
        ]);

        return back()->with('error', 'Erreur lors de l’initiation du paiement.');
    }

    /**
     * Étape 2 : Notification silencieuse CinetPay (mise à jour de la base)
     */
    public function notify(Request $request)
    {
        Log::info('Notify reçu', $request->all());

        $transactionId = $request->input('transaction_id') ?? $request->input('cpm_trans_id');

        if (!$transactionId) {
            return response('transaction_id manquant', 400);
        }

        $apiKey = env('CINETPAY_API_KEY');
        $siteId = env('CINETPAY_SITE_ID');

        // Vérification de la transaction auprès de CinetPay
        $verifyResponse = Http::asJson()->post('https://api-checkout.cinetpay.com/v2/payment/check', [
            "apikey" => $apiKey,
            "site_id" => $siteId,
            "transaction_id" => $transactionId,
        ]);

        if (!$verifyResponse->successful()) {
            Log::error('Erreur vérification CinetPay', [
                'status' => $verifyResponse->status(),
                'body' => $verifyResponse->body()
            ]);
            return response()->json(['error' => 'Vérification échouée'], 500);
        }

        $data = $verifyResponse->json();
        Log::info('CinetPay verify', $data);

        $paiement = Paiement::where('transaction_id', $transactionId)->first();

        if ($paiement) {
            if (isset($data['data']['status']) && $data['data']['status'] === 'ACCEPTED') {
                $paiement->update(['statut' => 'success']);

                Souscription::create([
                    'user_id' => $paiement->user_id,
                    'abonnement_id' => $paiement->abonnement_id,
                    'date_debut' => Carbon::now(),
                    'date_fin' => Carbon::now()->addDays(30),
                ]);
            } else {
                $paiement->update(['statut' => 'failed']);
            }
        }

        return response()->json(['message' => 'OK']);
    }

    /**
     * Étape 3 : Retour utilisateur après paiement
     */
    public function return(Request $request)
    {
        $transactionId = $request->query('transaction_id');
        $paiement = Paiement::where('transaction_id', $transactionId)->first();

        if ($paiement && $paiement->statut === 'success') {
            return view('paiement.return')->with('success', true);
        } elseif ($paiement && $paiement->statut === 'failed') {
            return view('paiement.return')->with('error', true);
        }

        return view('paiement.return')->with('info', true);
    }
}