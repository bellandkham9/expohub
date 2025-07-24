<?php

// Dans routes/web.php
use App\Http\Controllers\ContactController; // ou le nom de votre contrôleur
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SocialAuthController;
use App\Mail\ContactFormMail;
use App\Http\Controllers\ComprehensionEcriteController;
use App\Http\Controllers\ComprehensionOraleController;
use App\Http\Controllers\ExpressionEcriteController;


Route::get('/auth/{provider}', [SocialAuthController::class, 'redirectToProvider'])->name('social.redirect');
Route::get('/auth/{provider}/callback', [SocialAuthController::class, 'handleProviderCallback'])->name('social.callback');


Route::get('/connexion',[\App\Http\Controllers\AuthController::class,'connexion'])->name('auth.connexion');
Route::post('/connexion',[\App\Http\Controllers\AuthController::class,'doConnexion']);


Route::get('/inscription', [\App\Http\Controllers\AuthController::class,'inscription'])->name('auth.inscription');
Route::post('/inscription', [\App\Http\Controllers\AuthController::class,'doInscription']);

Route::get('/logout', [\App\Http\Controllers\AuthController::class, 'logout'])->name('deconnexion');




Route::post('/envoyer-message', [ContactController::class, 'sendEmail'])->name('envoyer.message');

Route::get('/', function () {
    return view('start.home');
})->name('start.home');

Route::get('/dashboard-student', function () {
    return view('client.dashboard');
})->name('client.dashboard');

Route::get('/history', function () {
    return view('client.history');
})->name('client.history');

Route::get('/contact', function () {
    return view('client.contact');
})->name('client.contact');

Route::get('/paiement', function () {
    return view('client.paiement');
})->name('client.paiement');

// partie test

Route::get('/choix', function () {
    return view('test.choix_test');
})->name('test.choix_test');

Route::get('/competence', function () {
    return view('test.competence');
})->name('test.competence');

/* Route::get('/expression_ecrite', function () {
    return view('test.expression_ecrite');
})->name('test.expression_ecrite'); */

Route::get('/expression_orale', function () {
    return view('test.expression_orale');
})->name('test.expression_orale');

/* Route::get('/comprehension_ecrite', function () {
    return view('test.comprehension_ecrite');
})->name('test.comprehension_ecrite');
 */

Route::get('/comprehension_ecrite', [ComprehensionEcriteController::class, 'index'])->name('test.comprehension_ecrite');
Route::get('/comprehension_ecrite/resultat', [ComprehensionEcriteController::class, 'resultat'])->name('test.comprehension_ecrite_resultat');
Route::post('/comprehension_ecrite/repondre', [ComprehensionEcriteController::class, 'enregistrerReponse']);




Route::get('/comprehension_orale', [ComprehensionOraleController::class, 'index'])->name('test.comprehension_orale');
Route::post('/comprehension_orale/repondre', [ComprehensionOraleController::class, 'enregistrerReponse']);
Route::get('/comprehension_orale/resultat', [ComprehensionOraleController::class, 'resultat'])->name('comprehension_orale_resultat');




// Route GET : afficher l'interface
Route::get('/expression_ecrite', [ExpressionEcriteController::class, 'afficherTest'])->name('expression_ecrite');

// Route POST (AJAX) : dialogue avec l’IA
Route::post('/expression_ecrite/message', [ExpressionEcriteController::class, 'envoyerMessage'])->name('expression_ecrite_message');

// Résultat final
Route::get('/expression_ecrite/resultat', [ExpressionEcriteController::class, 'resultat'])->name('expression_ecrite_resultat');


/* Route::get('/comprehension_orale', function () {
    return view('test.comprehension_orale');
})->name('test.comprehension_orale'); */

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
})->name('expression_ecrite');

Route::get('/admin/comprehension_ecrite', function () {
    return view('admin.comprehension_ecrite');
})->name('comprehension_ecrite');


Route::get('/admin/comprehension_orale', function () {
    return view('admin.comprehension_orale');
})->name('comprehension_orale');

Route::get('/admin/expression_orale', function () {
    return view('admin.expression_orale');
})->name('expression_orale');








