<?php

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Paiement;
use App\Models\Souscription;
use Carbon\Carbon;

require __DIR__ . '/../vendor/autoload.php';

// Démarrer Laravel (pour accéder aux Models & Config)
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$request = Illuminate\Http\Request::capture();
$response = $kernel->handle($request);

// =========================
//  PROTECTIONS DE BASE
// =========================

// 1. Vérifier qu'une clé secrète est fournie
$secret = $request->query('secret_key');
if ($secret !== env('PAYMENT_SECRET_KEY')) {
    Log::warning('Tentative d\'accès non autorisé au callback', [
        'ip' => $_SERVER['REMOTE_ADDR'],
        'params' => $request->all(),
    ]);
    http_response_code(403);
    exit('Accès refusé.');
}

// 2. Vérifier l'adresse IP du prestataire (exemple fictif CinetPay, adapte avec la doc officielle)
// Vérifier existence de l'ID de transaction (ou cpm_trans_id)
$transactionIdCheck = $request->input('transaction_id') ?? $request->input('cpm_trans_id');
if (!$transactionIdCheck) {
    Log::warning("Callback refusé : transaction_id manquant", [
        'ip' => $_SERVER['REMOTE_ADDR'],
        'params' => $request->all(),
    ]);
    http_response_code(400);
    exit("Vous n'est pas autorisé.");
}

// Vérifier que la transaction existe en base
if (!Paiement::where('transaction_id', $transactionIdCheck)->exists()) {
    Log::warning("Callback refusé : transaction inconnue", [
        'ip' => $_SERVER['REMOTE_ADDR'],
        'transaction_id' => $transactionIdCheck,
        'params' => $request->all(),
    ]);
    http_response_code(404);
    exit('Transaction inconnue.');
}

try {
    Log::info('Callback reçu', $request->all());

    $transactionId = $request->input('transaction_id') ?? $request->input('cpm_trans_id');

    if (!$transactionId) {
        $status = 'failed';
        $message = 'transaction_id manquant';
        $color = '#dc3545';
    } else {
        $apiKey = env('CINETPAY_API_KEY');
        $siteId = env('CINETPAY_SITE_ID');

        // Vérifier auprès de CinetPay
        $verifyResponse = Http::asJson()->post('https://api-checkout.cinetpay.com/v2/payment/check', [
            "apikey"         => $apiKey,
            "site_id"        => $siteId,
            "transaction_id" => $transactionId,
        ]);

        if (!$verifyResponse->successful()) {
            Log::error('Erreur vérification CinetPay', [
                'status' => $verifyResponse->status(),
                'body'   => $verifyResponse->body()
            ]);
            $status = 'failed';
            $message = 'Erreur lors de la vérification du paiement.';
            $color = '#dc3545';
            $data = [];
        } else {
            $data = $verifyResponse->json();
            Log::info('CinetPay verify', $data);

            $paiement = Paiement::where('transaction_id', $transactionId)->first();

            if ($paiement) {
                if (isset($data['data']['status']) && $data['data']['status'] === 'ACCEPTED') {
                    $paiement->update(['statut' => 'success']);
                    // Créer automatiquement la souscription
                    Souscription::create([
                        'user_id'        => $paiement->user_id,
                        'abonnement_id'  => $paiement->abonnement_id,
                        'date_debut'     => Carbon::now(),
                        'date_fin'       => Carbon::now()->addDays(30),
                        'paye'           => true,
                    ]);
                    $status = 'success';
                    $message = '✅ Paiement accepté ! Merci pour votre achat.<br>Votre abonnement est activé.';
                    $color = '#28a745';
                } else {
                    $paiement->update(['statut' => 'failed']);
                    $status = 'failed';
                    $message = '❌ Paiement refusé ou échoué.<br>Votre abonnement n\'a pas été activé.';
                    $color = '#dc3545';
                }
            } else {
                $status = 'pending';
                $message = '⏳ Paiement en attente ou transaction inconnue.<br>Merci de patienter ou contactez le support.';
                $color = '#ffc107';
            }
        }
    }

    // =========================
    //  Affichage HTML (client)
    // =========================
    ?>
    <!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title>Statut de votre paiement</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <style>
            body { background: #f8f9fa; font-family: Arial, sans-serif; }
            .facture-container {
                max-width: 500px;
                margin: 40px auto;
                background: #fff;
                border-radius: 10px;
                box-shadow: 0 2px 8px rgba(0,0,0,0.08);
                padding: 32px 24px;
                text-align: center;
            }
            .facture-header {
                font-size: 2rem;
                font-weight: bold;
                margin-bottom: 16px;
                color: <?= $color ?>;
            }
            .facture-message {
                font-size: 1.2rem;
                margin-bottom: 24px;
            }
            .facture-details {
                background: #f1f3f4;
                border-radius: 6px;
                padding: 16px;
                margin-bottom: 24px;
                text-align: left;
                font-size: 1rem;
            }
            .facture-footer {
                font-size: 0.95rem;
                color: #888;
            }
            .btn {
                display: inline-block;
                padding: 10px 24px;
                border-radius: 5px;
                background: <?= $color ?>;
                color: #fff;
                text-decoration: none;
                font-weight: bold;
                margin-top: 10px;
            }
        </style>
    </head>
    <body>
        <div class="facture-container">
            <div class="facture-header">
                Statut du paiement
            </div>
            <div class="facture-message">
                <?= $message ?>
            </div>
            <div class="facture-details">
                <strong>ID Transaction :</strong> <?= htmlspecialchars($transactionId ?? '-') ?><br>
                <strong>Montant :</strong> <?= isset($data['data']['amount']) ? htmlspecialchars($data['data']['amount']) . ' XAF' : '-' ?><br>
                <strong>Date :</strong> <?= date('d/m/Y H:i') ?><br>
                <strong>Statut :</strong> <?= htmlspecialchars($data['data']['status'] ?? $status) ?>
            </div>
            <a href="/dashboard-student" class="btn">Retour à l'accueil</a>
            <div class="facture-footer">
                Une copie de cette page peut servir de justificatif.<br>
                Merci pour votre confiance.
            </div>
        </div>
    </body>
    </html>
    <?php
    exit;
} catch (\Exception $e) {
    Log::error("Erreur callback: " . $e->getMessage());
    http_response_code(500);
    exit('Erreur interne.');
}
