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
     * Initier un paiement CinetPay (mode test friendly)
     */
    public function process(Request $request, $abonnementId)
    {
        $abonnement = Abonnement::findOrFail($abonnementId);
        $user = auth()->user();

        $apiKey = env('CINETPAY_API_KEY');
        $siteId = env('CINETPAY_SITE_ID');
        $secretKey = env('CINETPAY_SECRET_KEY');

        $notifyUrl = url('/api/paiement/notify'); 
        $returnUrl = url('/api/paiementValider');; // Utilisation d'une route dédiée

        

        $transactionId = uniqid('PAY-');

        // Montant fixe pour test (100 XAF)
        $prixXaf = 100;

        $formData = [
            "apikey" => $apiKey,
            "site_id" => $siteId,
            "transaction_id" => $transactionId,
            "amount" => $prixXaf,
            "currency" => "XAF",
            "description" => "Paiement abonnement : {$abonnement->examen}",
            "return_url" => $returnUrl,
            "notify_url" => $notifyUrl,
            "customer_name" => $user->name,
            "customer_email" => $user->email,
            "channels" => "ALL",
        ];

        $response = Http::withHeaders(['Content-Type' => 'application/json'])
            ->post('https://api-checkout.cinetpay.com/v2/payment', $formData);

        if ($response->successful()) {
            $result = $response->json();
            Log::info('CinetPay init', $result);

            if (isset($result['data']['payment_url'])) {
                // Sauvegarder la transaction
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

        return back()->with('error', 'Erreur lors de l’initiation du paiement.');
    }

    /**
     * Callback silencieux CinetPay
     */
    public function notify(Request $request)
    {
        $transactionId = $request->input('cpm_trans_id'); // Utilisé par CinetPay
        $hmacHeader = $request->header('X-TOKEN');

        if (!$transactionId) return response('cpm_trans_id non fourni', 400);

        // Mode test : on désactive HMAC pour simplifier
        $paiement = Paiement::where('transaction_id', $transactionId)->first();
        if ($paiement) {
            $paiement->update(['statut' => 'success']);

            Souscription::create([
                'user_id' => $paiement->user_id,
                'abonnement_id' => $paiement->abonnement_id,
                'paye'=>true,
                'date_debut' => Carbon::now(),
                'date_fin' => Carbon::now()->addDays(30),
            ]);
        }

        return response()->json(['message' => 'Notification traitée avec succès.']);
    }

    /**
     * Retour après paiement
     */
    public function return(Request $request)
    {

        dd($request->all());
        $transactionId = $request->query('transaction_id', $request->input('transaction_id'));

        if (!$transactionId) {
            return redirect('/')->with('error', 'transaction_id non transmis');
        }

        $paiement = Paiement::where('transaction_id', $transactionId)->first();

        if ($paiement && $paiement->statut === 'success') {
            return redirect(route('client.dashboard'))->with('success', 'Paiement réussi');
        }

        return redirect(route('client.dashboard'))->with('error', 'Paiement échoué');
    }
}
