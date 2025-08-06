<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Models\Abonnement;
use App\Models\Paiement;
use App\Models\Souscription;

class PaiementController extends Controller
{
    

public function process($abonnementId)
{
    $abonnement = Abonnement::findOrFail($abonnementId);

    $transactionId = uniqid(); // ou un UUID

    $response = Http::withHeaders([
        'Content-Type' => 'application/json',
    ])->post('https://api-checkout.cinetpay.com/v2/payment', [
        'apikey' => env('CINETPAY_APIKEY'),
        'site_id' => env('CINETPAY_SITE_ID'),
        'transaction_id' => $transactionId,
        'amount' => $abonnement->prix,
        'currency' => 'XAF',
        'description' => $abonnement->nom_du_plan,
        'return_url' => route('client.dashboard'),
        'notify_url' => route('client.dashboard'),
        'customer_name' => auth()->user()->name ?? 'Inconnu',
        'customer_email' => auth()->user()->email ?? 'noemail@example.com',
        'channels' => 'ALL', // ou 'MOBILE_MONEY', 'CARD', etc.
        'metadata' => json_encode([
            'abonnement_id' => $abonnement->id,
            'user_id' => auth()->id()
        ]),
    ]);

    if ($response->successful() && isset($response['data']['https://api-checkout.cinetpay.com/v2/payment'])) {
        return redirect()->away($response['data']['https://api-checkout.cinetpay.com/v2/payment']);
    }

    return back()->with('error', 'Impossible d’initier le paiement. Vérifie ta configuration CinetPay.');
}


    // Callback pour recevoir la réponse de CinetPay
    public function callback(Request $request)
    {
        // Vérifie la transaction avec CinetPay (selon leur doc)
        // $transaction = CinetPay::verify($request->transaction_id);

        // Exemple d'enregistrement :
        Paiement::create([
            'user_id' => auth()->id(),
            'abonnement_id' => $request->abonnement_id,
            'montant' => $request->amount,
            'methode' => 'cinetpay',
            'transaction_id' => $request->transaction_id,
            'statut' => $request->status,
            'devise' => $request->currency,
            'details' => json_encode($request->all()),
        ]);

        // Crée la souscription si paiement réussi
        if ($request->status === 'success') {
            Souscription::create([
                'user_id' => auth()->id(),
                'abonnement_id' => $request->abonnement_id,
                'date_debut' => now(),
                'date_fin' => now()->addDays(30), // adapte selon la durée
            ]);
        }

        // Redirige vers une page de succès ou d'échec
        return redirect()->route('paiement.resultat');
    }
}