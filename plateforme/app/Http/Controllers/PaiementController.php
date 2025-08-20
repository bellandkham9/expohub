<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Abonnement;
use App\Models\Paiement;
use App\Models\Souscription;
use Carbon\Carbon;

class PaiementController extends Controller
{
    /**
     * Initier un paiement CinetPay
     */
    public function process(Request $request, $abonnementId)
    {
        $abonnement = Abonnement::findOrFail($abonnementId);
        $user = auth()->user();

        $apiKey = env('CINETPAY_API_KEY');
        $siteId = env('CINETPAY_SITE_ID');
        $secretKey = env('CINETPAY_SECRET_KEY');

        $notifyUrl = route('paiement.notify'); // URL callback
        $returnUrl = route('client.dashboard'); // URL retour utilisateur

        $transactionId = uniqid('PAY-');

        $formData = [
            "apikey" => $apiKey,
            "site_id" => $siteId,
            "transaction_id" => $transactionId,
            "amount" => 100,
            "currency" => "XAF",
            "description" => "Paiement abonnement : {$abonnement->examen}",
            "return_url" => $returnUrl,
            "notify_url" => $notifyUrl,
            "customer_name" => $user->name,
            "customer_email" => $user->email,
            "channels" => "ALL",
        ];

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post('https://api-checkout.cinetpay.com/v2/payment', $formData);

        if ($response->successful()) {
            $result = $response->json();
            Log::info('CinetPay init', $result);

            if (isset($result['data']['payment_url'])) {
                // Sauvegarder la transaction avant redirection
                Paiement::create([
                    'user_id' => $user->id,
                    'abonnement_id' => $abonnement->id,
                    'montant' => $abonnement->prix,
                    'methode' => 'cinetpay',
                    'transaction_id' => $transactionId,
                    'statut' => 'pending',
                    'devise' => 'XAF',
                    'details' => json_encode($result),
                ]);

                return redirect()->away($result['data']['payment_url']);
            }
        }

        return back()->with('error', 'Erreur lors de l’initiation du paiement.');
    }

    /**
     * Callback silencieux CinetPay (notify_url)
     */
    public function notify(Request $request)
    {
        $transactionId = $request->input('cpm_trans_id');
        $hmacHeader = $request->header('X-TOKEN');

        if (!$transactionId) {
            return response('cpm_trans_id non fourni', 400);
        }

        // Vérification HMAC
        $data_post = implode('', $request->all());
        $generated_token = hash_hmac('SHA256', $data_post, env('CINETPAY_SECRET_KEY'));

        if (!hash_equals($hmacHeader, $generated_token)) {
            return response('HMAC non conforme', 403);
        }

        // Vérifier le statut réel du paiement auprès de CinetPay
        $response = Http::post('https://api-checkout.cinetpay.com/v2/payment/check', [
            'apikey' => env('CINETPAY_API_KEY'),
            'site_id' => env('CINETPAY_SITE_ID'),
            'transaction_id' => $transactionId,
        ]);

        if ($response->successful()) {
            $result = $response->json();
            Log::info('CinetPay notify', $result);

            $paiement = Paiement::where('transaction_id', $transactionId)->first();

            if ($paiement && isset($result['data']['status'])) {
                if ($result['data']['status'] === 'ACCEPTED') {
                    $paiement->update(['statut' => 'success']);

                    // Activer la souscription
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
        }

        return response()->json(['message' => 'Notification traitée avec succès.']);
    }

    /**
     * Retour après paiement (return_url)
     */
    public function return(Request $request)
    {
        $transactionId = $request->input('transaction_id');

        if (!$transactionId) {
            return redirect('/')->with('error', 'transaction_id non transmis');
        }

        $response = Http::post('https://api-checkout.cinetpay.com/v2/payment/check', [
            'apikey' => env('CINETPAY_API_KEY'),
            'site_id' => env('CINETPAY_SITE_ID'),
            'transaction_id' => $transactionId,
        ]);

        if ($response->successful()) {
            $result = $response->json();

            if (isset($result['data']['status']) && $result['data']['status'] === 'ACCEPTED') {
                return redirect(route('client.dashboard'))->with('success', 'Paiement réussi');
            }
        }

        return redirect(route('client.dashboard'))->with('error', 'Paiement échoué');
    }
}
