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

        $transactionId = uniqid('PAY-');
        $prixXaf = 100; // Montant pour test

        $returnUrl = route('paiement.return', ['transactionId' => $transactionId]);
        $notifyUrl = route('paiement.notify', ['transactionId' => $transactionId]);

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

        // Appel à l'API CinetPay
        $response = Http::withHeaders([
            'Content-Type' => 'application/json'
            ])->post('https://api-checkout.cinetpay.com/v2/payment', $formData);

        if ($response->successful()) {
            $result = $response->json();
            Log::info('CinetPay init', $result);

            if ($result['code'] === '201'&& $result['message'] === 'CREATED') {
                // Sauvegarder la transaction dans DB
                Log::error('CinetPay transaction initialization failed', [
                'response' => $response->json(),
                'request' => $response,
]);
                $paiement = Paiement::create([
                    'user_id' => $user->id,
                    'abonnement_id' => $abonnement->id,
                    'montant' => $prixXaf,
                    'methode' => 'cinetpay',
                    'transaction_id' => $transactionId,
                    'statut' => 'pending',
                    'devise' => 'XAF',
                    'details' => json_encode($result),
                ]);

                return redirect($result['data']['payment_url']);
            }
        }
            Log::error('CinetPay transaction initialization failed', [
                        'response' => $response->json(),
                        'request' => $response,
                    ]);
        return back()->with('error', 'Erreur lors de l’initiation du paiement.');
    }

    /**
     * Callback utilisateur (return_url)
     */
    public function return(Request $request, $transactionId)
    {
        return $this->verify($request, $transactionId);
    }

    /**
     * Notification serveur (notify_url)
     */
    public function notify(Request $request,$transactionId)
    {
        log::info('notify' . $request->all());

        try {
            $paiement = Paiement::where('transaction_id', $transactionId)->first();

            if (!$paiement) {
                Log::warning("Paiement non trouvé pour la transaction_id: {$transactionId}");
                return response();
            }

            $this->checkStatus($paiement);

            return response();
        } catch (\Exception $e) {
            Log::error("Erreur lors du traitement de la notification CinetPay: " . $e->getMessage());
            return response();
        }
   }



protected function verify(Request $request, $transactionId)
{
    $paiement = Paiement::where('transaction_id', $transactionId)->first();

    if ($paiement) {
        if ($paiement->statut === 'completed') {
            return view('paiement.return')->with('success', true);
        } elseif ($paiement->statut === 'failed') {
            return view('paiement.return')->with('error', true);
        } else {
            $this->checkStatus($paiement);
            $paiement->refresh();

            if ($paiement->statut === 'completed') {
                return view('paiement.return')->with('success', true);
            } elseif ($paiement->statut === 'failed') {
                return view('paiement.return')->with('error', true);
            }
        }
    }

   return view('paiement.return')->with('info', 'Aucune transaction trouvée ou statut inconnu.');
}



   protected function checkStatus($paiement)
   {
       $response = Http::withHeaders([
            'Content-Type' => 'application/json'
            ])->post('https://api-checkout.cinetpay.com/v2/payment' . '/check', [
                'apikey' => env('CINETPAY_API_KEY'),
                'site_id' => env('CINETPAY_SITE_ID'),
                'transaction_id' => $paiement->transaction_id,
            ]);


            if ($response->successful()) {
                $result = $response->json();
                if ($result['code'] === '00'&& $result['message'] === 'SUCCES') {

                    $paiement = Paiement::where('transaction_id',$paiement->transaction_id)->first();
                    $paiement->statut = 'completed';
                    $paiement->created_at = now();
                    $paiement->updated_at = now();
                }
                else{
                    $paiement->statut = 'failed';
                }    
                    $paiement->save();      
            }

         return true;
   }
}
