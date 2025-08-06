<?php

// Dans routes/web.php
use App\Http\Controllers\ContactController; // ou le nom de votre contrôleur
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SocialAuthController;
use App\Mail\ContactFormMail;
use App\Http\Controllers\ComprehensionEcriteController;
use App\Http\Controllers\ComprehensionOraleController;
use App\Http\Controllers\ExpressionEcriteController;
use App\Http\Controllers\ExpressionOraleController1;
use App\Http\Controllers\StudentDashboardController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\HistoriqueTestController;

Route::get('/auth/{provider}', [SocialAuthController::class, 'redirectToProvider'])->name('social.redirect');
Route::get('/auth/{provider}/callback', [SocialAuthController::class, 'handleProviderCallback'])->name('social.callback');

Route::get('/connexion', [\App\Http\Controllers\AuthController::class, 'connexion'])->name('login');
Route::post('/connexion', [\App\Http\Controllers\AuthController::class, 'doConnexion']);

Route::get('/inscription', [\App\Http\Controllers\AuthController::class, 'inscription'])->name('auth.inscription');
Route::post('/inscription', [\App\Http\Controllers\AuthController::class, 'doInscription']);

Route::get('/logout', [\App\Http\Controllers\AuthController::class, 'logout'])->name('deconnexion');

Route::post('/envoyer-message', [ContactController::class, 'sendEmail'])->name('envoyer.message');

Route::get('/', function () {
    return view('start.home');
})->name('start.home');

Route::get('/dashboard-student', [StudentDashboardController::class, 'dashboard'])
    ->name('client.dashboard');



Route::get('/history', [HistoriqueTestController::class, 'index'])->name('client.history');

Route::get('/contact', function () {
    return view('client.contact');
})->name('client.contact');

Route::get('/paiement', function () {
    return view('client.paiement');
})->name('client.paiement');

// partie test

Route::get('/choix', [TestController::class, 'choixTest'])->name('test.choix_test');



Route::middleware(['auth'])->group(function () {
    // Expression Orale
    Route::post('/expression-orale/repondre', [ExpressionOraleController1::class, 'repondre'])->name('expression_orale.repondre');
    Route::post('/expression-orale/handle-message', [ExpressionOraleController1::class, 'handleMessage'])->name('expression_orale.handleMessage');
    Route::post('/expression-orale/changer-tache', [ExpressionOraleController1::class, 'changerTache'])->name('expression_orale.changer_tache');
    Route::get('/expression-orale', [ExpressionOraleController1::class, 'afficherTest'])->name('test.expression_orale');
    Route::get('/expression-orale/resultat', [ExpressionOraleController1::class, 'afficherResultat'])->name('test.expression_orale_resultat');
    Route::post('/expression-orale/reinitialiser', [ExpressionOraleController1::class, 'reinitialiserTest'])->name('expression_orale.reinitialiser');
    Route::post('/expression-orale/resultat/final', [ExpressionOraleController1::class, 'enregistrerResultatFinal'])->name('expression_orale.resultat_final');

});



Route::middleware(['auth'])->group(function () {
    // Compréhension Écrite
    Route::get('/comprehension_ecrite', [ComprehensionEcriteController::class, 'index'])->name('test.comprehension_ecrite');
    Route::get('/comprehension_ecrite/resultat', [ComprehensionEcriteController::class, 'resultat'])->name('test.comprehension_ecrite_resultat');
    Route::post('/comprehension_ecrite/repondre', [ComprehensionEcriteController::class, 'enregistrerReponse']);
    Route::post('/comprehension_ecrite/reinitialiser', [ComprehensionEcriteController::class, 'reinitialiserTest'])->name('comprehension_ecrite.reinitialiser');
    Route::post('/comprehension_ecrite/resultat/final', [ComprehensionEcriteController::class, 'enregistrerResultatFinal'])->name('comprehension_ecrite.resultat_final');

});




Route::middleware(['auth'])->group(function () {
    // Compréhension Orale
    Route::get('/comprehension_orale', [ComprehensionOraleController::class, 'index'])->name('test.comprehension_orale');
    Route::post('/comprehension_orale/repondre', [ComprehensionOraleController::class, 'enregistrerReponse']);
    Route::get('/comprehension_orale/resultat', [ComprehensionOraleController::class, 'resultat'])->name('test.dashboard_details');
    Route::post('/comprehension_orale/resultat/final', [ComprehensionOraleController::class, 'enregistrerResultatFinal'])->name('comprehension_orale.resultat_final');
    Route::post('/comprehension_orale/reinitialiser', [ComprehensionEcriteController::class, 'reinitialiserTest'])->name('comprehension_orale.reinitialiser');
});




// Expression Écrite
Route::middleware(['auth'])->group(function () {
    Route::get('/expression-ecrite', [ExpressionEcriteController::class, 'afficherTest'])->name('test.expression_ecrite');
    Route::post('/expression_ecrite/repondre', [ExpressionEcriteController::class, 'submitReponse'])->name('expression_ecrite.repondre');
    Route::post('/expression-ecrite/changer-tache', [ExpressionEcriteController::class, 'changerTache'])->name('expression_ecrite.changer_tache');
    Route::get('/expression-ecrite/resultat', [ExpressionEcriteController::class, 'afficherResultat'])->name('test.expression_ecrite_resultat');
    Route::post('/expression_ecrite/reinitialiser', [ExpressionEcriteController::class, 'reinitialiserTest'])->name('expression_ecrite.reinitialiser');
    Route::post('/expression-ecrite/resultat/final', [ExpressionEcriteController::class, 'enregistrerResultatFinal'])->name('expression_ecrite.resultat_final');  


});

Route::get('/dashboard_details', function () {
    return view('test.dashboard_details');
})->name('test.dashboard_details');
// fin partie test

// partie suggestion

Route::get('/suggestion', function () {
    return view('suggestion.suggestion');
})->name('suggestion.suggestion');

// fin partie suggestion

// la partie admin

Route::get('/admin/gestion_utilisateur', function () {
    return view('admin.gestion_utilisateur');
})->name('gestion_utilisateurs');

Route::get('/admin/gestion_test', function () {
    return view('admin.gestion_test');
})->name('gestion_test');

Route::get('/admin/statistiques', function () {
    return view('admin.statistiques');
})->name('statistiques');

Route::get('/admin/expression_ecrite', function () {
    return view('admin.expression_ecrite');
})->name('admin.expression_ecrite');

Route::get('/admin/comprehension_ecrite', function () {
    return view('admin.comprehension_ecrite');
})->name('admin.comprehension_ecrite');

Route::get('/admin/comprehension_orale', function () {
    return view('admin.comprehension_orale');
})->name('comprehension_orale');

Route::get('/admin/expression_orale', function () {
    return view('admin.expression_orale');
})->name('expression_orale');
