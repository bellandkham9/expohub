<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ComprehensionEcriteController;
use App\Http\Controllers\PaiementController;

Route::post('/api/comprehension_ecrite/repondre', [ComprehensionEcriteController::class, 'enregistrerReponse']);


// Route::post('/paiement/notify', [PaiementController::class, 'notify'])->name('paiement.notify');
// Route::match(['get'],'/paiementValider', [PaiementController::class, 'return'])->name('paiement.return');

Route::match(['get', 'post'],'/paiementValider', [PaiementController::class, 'return'])->name('paiement.return');
Route::post('/paiement/notify', [PaiementController::class, 'notify'])->name('paiement.notify');
