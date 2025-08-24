<?php

// Dans routes/web.php
use App\Http\Controllers\ContactController; // ou le nom de votre contrôleur
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SocialAuthController;
use App\Http\Controllers\ComprehensionEcriteController;
use App\Http\Controllers\ComprehensionOraleController;
use App\Http\Controllers\ExpressionEcriteController;
use App\Http\Controllers\Client\CompteController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Middleware\CheckFreeTests;
use App\Http\Middleware\UpdateLastSeen;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\ExpressionOraleController1;
use App\Http\Controllers\StudentDashboardController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\HistoriqueTestController;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\Admin\IAComprehensionEcriteController;
use App\Http\Controllers\trainCo;
use App\Http\Controllers\IAExpressionEcriteController;
use App\Http\Controllers\IAExpressionOraleController;
use App\Http\Controllers\TrainController;
use App\Http\Controllers\SuggestionController;
use App\Http\Controllers\PaiementController;
use App\Http\Controllers\AbonnementController;
use App\Http\Controllers\TestTypeController;



Route::get('/auth/{provider}', [SocialAuthController::class, 'redirectToProvider'])->name('social.redirect');
Route::get('/auth/{provider}/callback', [SocialAuthController::class, 'handleProviderCallback'])->name('social.callback');

Route::get('/connexion', [\App\Http\Controllers\AuthController::class, 'connexion'])->middleware('guest')->name('auth.connexion');
Route::post('/connexion', [\App\Http\Controllers\AuthController::class, 'doConnexion']);

Route::get('/inscription', [\App\Http\Controllers\AuthController::class, 'inscription'])->middleware('guest')->name('auth.inscription');
Route::post('/inscription', [\App\Http\Controllers\AuthController::class, 'doInscription']);

Route::get('/logout', [\App\Http\Controllers\AuthController::class, 'logout'])->name('deconnexion');

Route::post('/envoyer-message', [ContactController::class, 'sendEmail'])->name('envoyer.message');

Route::get('/', function () {
    return view('start.home'); })->name('start.home');



// Application du middleware 'auth' sur les routes nécessitant une authentification
Route::middleware(['web', 'auth'])->group(function () {

    // Route vers le dashboard étudiant
    Route::get('/dashboard-student', [StudentDashboardController::class, 'dashboard'])
        ->name('client.dashboard');
    Route::post('/dashboard-student', [StudentDashboardController::class, 'dashboard'])
        ->name('client.dashboard');
    // route pour verifier si l'utilisateur a encore des tests gratuits disponible
    Route::get('/verifier-free-test', [StudentDashboardController::class, 'verifierAcces'])->name('tests.verifierAcces');

    // modification du compte client par le client
    Route::post('/client/compte/update', [CompteController::class, 'update'])->name('client.compte.update');

    // Suppresssion du compte client par le client
    Route::delete('/compte', [CompteController::class, 'destroy'])->name('client.compte.destroy');

    // Attribution de l'abonnement
    Route::post('/users/abonnement', [AdminUserController::class, 'attribuerAbonnement'])
        ->name('users.abonnement');

    // Route ves historique
    Route::get('/history', [HistoriqueTestController::class, 'index'])->name('client.history');

    // Route vers les tests 
    Route::get('/choix', [TestController::class, 'choixTest'])->name('test.choix_test');

    Route::get('/competence', function () {
        return view('test.competence');
    })->name('test.competence');

    // Le compte du client 
    Route::get('/mon_compte', function () {
        return view('client.compte');
    })->name('client.mon-compte');

    // la partie admin


    Route::get('/test-last-seen', function () {
        if (Auth::check()) {
            $user = Auth::user();
            $user->last_seen_at = now();
            $user->save();

            return '✅ last_seen_at mis à jour à : ' . $user->last_seen_at;
        } else {
            return '❌ Utilisateur non connecté';
        }
    });


    Route::get('/suggestion', [SuggestionController::class, 'index'])->name('suggestion.suggestion');
    Route::post('/suggestion/generate', [SuggestionController::class, 'generate'])->name('suggestions.generate');

    Route::post('/paiement/process/{abonnement}', [PaiementController::class, 'process'])->name('paiement.process');

    //  Route du chatbot
    Route::post('/chatbot/send', [ChatbotController::class, 'send'])->name('chatbot.send');

});

Route::get('/contact', function () {
    return view('client.contact');
})->name('client.contact');

Route::get('/paiement', [AbonnementController::class, 'index'])->name('client.paiement');

Route::middleware(['web', 'auth', AdminMiddleware::class, UpdateLastSeen::class])->group(function () {

    Route::get('/admin/gestion_utilisateur', function () {
        return view('admin.gestion_utilisateur');
    })->name('gestion_utilisateurs');

    // Modifier un utilisateur
    Route::put('/admin/utilisateurs/{id}', [AdminUserController::class, 'update'])->name('admin.utilisateur.modifier');

    // Ajouter un utilisateur
    Route::post('/admin/utilisateurs', [AdminUserController::class, 'store'])->name('admin.utilisateur.creer');

    // Recuperé tout les utilisateur
    Route::get('/admin/gestion_utilisateur', [AdminUserController::class, 'index'])->name('gestion_utilisateurs');

    // Supprimer un utilisateur
    Route::delete('/admin/utilisateurs/{user}', [AdminUserController::class, 'destroy'])->name('admin.utilisateur.supprimer');

    Route::get('/admin/statistiques', function () {
        return view('admin.statistiques');
    })->name('statistiques');

    Route::get('/admin/statistiques', [AdminUserController::class, 'indexStatistiques'])->name('statistiques');

    Route::get('/admin/gestion_test', [AdminUserController::class, 'indexTestStats'])->name('gestion_test');

    Route::get('/admin/expression_ecrite', function () {
        return view('admin.expression_ecrite');
    })->name('admin.expression_ecrite');

    Route::get('/admin/comprehension_orale', function () {
        return view('admin.comprehension_orale');
    })->name('comprehension_orale');

    Route::get('/admin/expression_orale', function () {
        return view('admin.expression_orale');
    })->name('expression_orale');

    Route::get('/dashboard_details', function () {
        return view('test.dashboard_details');
    })->name('test.dashboard_details');
    // fin partie test

    Route::resource('abonnements', AbonnementController::class);
    //la gestion des type de tests
    Route::resource('tests', TestTypeController::class)->except(['show']);

    Route::post('/notifications/send', [AdminUserController::class, 'sendMessage'])->name('notifications.send');

    Route::post('/paiement/process/{abonnement}', [PaiementController::class, 'process'])->name('paiement.process');
    Route::post('/paiement/notify', [PaiementController::class, 'notify'])->name('paiement.notify');

    // ================= Dashboard =================
    Route::get('/admin/train-dashboard', [TrainController::class, 'index'])->name('train.dashboard');

    // ================= Comprehension Ecrite =================

    Route::post('/admin/train/ce/generate', [IAComprehensionEcriteController::class, 'generate'])->name('train.ce.generate');

    // ================= Expression Ecrite =================

    Route::post('/admin/train/ee/generate', [IAExpressionEcriteController::class, 'genererNouvellesTaches'])->name('train.ee.generate');

    // ================= Comprehension Orale =================

    Route::post('/admin/train/co/generate', [trainCo::class, 'genererNouvellesQuestions'])->name('train.co.generate');

    // ================= Expression Orale =================

    Route::post('/admin/train/eo/generate', [IAExpressionOraleController::class, 'genererNouvellesTaches'])->name('train.eo.generate');

});

// Application du middleware 'auth' sur les routes nécessitant une authentification
Route::middleware(['web', 'auth', CheckFreeTests::class])->group(function () {

    // Les routes pour passer les testes d'expressions orale
    Route::post('/expression-orale/repondre', [ExpressionOraleController1::class, 'repondre'])->name('expression_orale.repondre');
    Route::post('/expression-orale/handle-message', [ExpressionOraleController1::class, 'handleMessage'])->name('expression_orale.handleMessage');
    Route::post('/expression-orale/changer-tache', [ExpressionOraleController1::class, 'changerTache'])->name('expression_orale.changer_tache');
    Route::get('/expression-orale', [ExpressionOraleController1::class, 'afficherTest'])->name('test.expression_orale');
    Route::get('/expression-orale/resultat', [ExpressionOraleController1::class, 'afficherResultat'])->name('test.expression_orale_resultat');
    Route::post('/expression-orale/reinitialiser', [ExpressionOraleController1::class, 'reinitialiserTest'])->name('expression_orale.reinitialiser');
    Route::post('/expression-orale/resultat/final', [ExpressionOraleController1::class, 'enregistrerResultatFinal'])->name('expression_orale.resultat_final');


    // Les routes pour passer les testes de compréhension écrite
    Route::get('/comprehension_ecrite', [ComprehensionEcriteController::class, 'index'])->name('test.comprehension_ecrite');
    Route::get('/comprehension_ecrite/resultat', [ComprehensionEcriteController::class, 'resultat'])->name('test.comprehension_ecrite_resultat');
    Route::post('/comprehension_ecrite/repondre', [ComprehensionEcriteController::class, 'enregistrerReponse']);
    Route::post('/comprehension_ecrite/reinitialiser', [ComprehensionEcriteController::class, 'reinitialiserTest'])->name('comprehension_ecrite.reinitialiser');
    Route::post('/comprehension_ecrite/resultat/final', [ComprehensionEcriteController::class, 'enregistrerResultatFinal'])->name('comprehension_ecrite.resultat_final');


    // Les routes pour passer les testes de compréhension orale
    Route::get('/comprehension_orale', [ComprehensionOraleController::class, 'index'])->name('test.comprehension_orale');
    Route::post('/comprehension_orale/repondre', [ComprehensionOraleController::class, 'enregistrerReponse']);
    Route::get('/comprehension_orale/resultat', [ComprehensionOraleController::class, 'resultat'])->name('test.dashboard_details');
    Route::post('/comprehension_orale/resultat/final', [ComprehensionOraleController::class, 'enregistrerResultatFinal'])->name('comprehension_orale.resultat_final');
    Route::post('/comprehension_orale/reinitialiser', [ComprehensionOraleController::class, 'reinitialiserTest'])->name('comprehension_orale.reinitialiser');



    // Les routes pour passer les testes d'expressions écrites
    Route::get('/expression-ecrite', [ExpressionEcriteController::class, 'afficherTest'])->name('test.expression_ecrite');
    Route::post('/expression_ecrite/repondre', [ExpressionEcriteController::class, 'submitReponse'])->name('expression_ecrite.repondre');
    Route::post('/expression-ecrite/changer-tache', [ExpressionEcriteController::class, 'changerTache'])->name('expression_ecrite.changer_tache');
    Route::get('/expression-ecrite/resultat', [ExpressionEcriteController::class, 'afficherResultat'])->name('test.expression_ecrite_resultat');
    Route::post('/expression_ecrite/reinitialiser', [ExpressionEcriteController::class, 'reinitialiserTest'])->name('expression_ecrite.reinitialiser');
    Route::post('/expression-ecrite/resultat/final', [ExpressionEcriteController::class, 'enregistrerResultatFinal'])->name('expression_ecrite.resultat_final');


});

Route::get('/contact', function () {
    return view('client.contact');
})->name('client.contact');

Route::get('/paiement', [AbonnementController::class, 'index'])->name('client.paiement');


Route::post('admin/notifications/{notification}/read', [AdminUserController::class, 'markAsRead'])
    ->name('admin.notifications.read');
Route::delete('/admin/notifications/{id}', [AdminUserController::class, 'supprimer'])
    ->name('notifications.supprimer');
