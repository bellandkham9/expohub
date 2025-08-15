<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Abonnement; // Assurez-vous d'avoir ce modèle
use App\Models\Paiement;
use App\Models\Souscription;
use Carbon\Carbon;

class PaiementController extends Controller
{
    public function process(Request $request, $abonnementId)
    {
        $abonnement = Abonnement::findOrFail($abonnementId);

        // Cette variable de configuration permet de basculer facilement
        // entre le mode réel et le mode simulation.
        $isLiveMode = env('CINETPAY_LIVE_MODE', false);

        if ($isLiveMode) {
            // Logique de l'API CinetPay (votre code initial)
            // Laissez ce bloc tel quel, il sera actif une fois vos documents validés
            // et votre .env configuré
            $transactionId = uniqid(); 

            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post('https://api-checkout.cinetpay.com/v2/payment', [
                // ... (vos paramètres CinetPay) ...
            ]);

            if ($response->successful()) {
                // ... (redirection vers l'URL de paiement) ...
            }
        } else {
            // ----------------------------------------------------
            // Logique de simulation de paiement pour le développement
            // ----------------------------------------------------

            $user = auth()->user();
            $transactionId = 'SIM-' . uniqid(); 
            $duree_jours = 30; // Définissez une durée par défaut pour la simulation

            // 1. Enregistrement du paiement dans la table `paiements`
            // C'est l'historique de la transaction, même si elle est simulée.
            Paiement::create([
                'user_id' => $user->id,
                'abonnement_id' => $abonnement->id,
                'montant' => $abonnement->prix,
                'methode' => 'simulation',
                'transaction_id' => $transactionId,
                'statut' => 'success', // Simuler un paiement réussi
                'devise' => 'XAF',
                'details' => json_encode(['message' => 'Paiement simulé réussi.']),
            ]);

            // 2. Création ou mise à jour de la souscription dans la table `souscriptions`
            // C'est l'enregistrement qui gère la période d'accès de l'utilisateur.
            Souscription::updateOrCreate(
                ['user_id' => $user->id], // Cherche une souscription existante pour cet utilisateur
                [
                    'abonnement_id' => $abonnement->id,
                    'date_debut' => Carbon::now(),
                    'date_fin' => Carbon::now()->addDays($duree_jours),
                ]
            );

            // 3. Redirection de l'utilisateur
            return redirect()->route('client.dashboard')->with('success', 'Votre abonnement a été activé avec succès ! (Mode simulation)');
        }

        return back()->with('error', 'Impossible d’initier le paiement.');
    }
}