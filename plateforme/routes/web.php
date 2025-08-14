<?php

// Dans routes/web.php
use App\Http\Controllers\ContactController; // ou le nom de votre contrôleur
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SocialAuthController;
use App\Mail\ContactFormMail;
use App\Http\Controllers\ComprehensionEcriteController;
use App\Http\Controllers\ComprehensionOraleController;
use App\Http\Controllers\ExpressionEcriteController;
use App\Http\Controllers\Client\CompteController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Middleware\UpdateLastSeen;
use App\Http\Controllers\ExpressionOraleController1;
use App\Http\Controllers\StudentDashboardController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\HistoriqueTestController;
use App\Http\Controllers\Admin\IAComprehensionEcriteController;
use App\Http\Controllers\trainCo; 
use App\Http\Controllers\IAExpressionEcriteController;
use App\Http\Controllers\IAExpressionOraleController; 
use App\Http\Controllers\train_dashboardController;

Route::get('/auth/{provider}', [SocialAuthController::class, 'redirectToProvider'])->name('social.redirect');
Route::get('/auth/{provider}/callback', [SocialAuthController::class, 'handleProviderCallback'])->name('social.callback');

Route::get('/connexion', [\App\Http\Controllers\AuthController::class, 'connexion'])->name('auth.connexion');
Route::post('/connexion', [\App\Http\Controllers\AuthController::class, 'doConnexion']);

Route::get('/inscription', [\App\Http\Controllers\AuthController::class, 'inscription'])->name('auth.inscription');
Route::post('/inscription', [\App\Http\Controllers\AuthController::class, 'doInscription']);

Route::get('/logout', [\App\Http\Controllers\AuthController::class, 'logout'])->name('deconnexion');

Route::post('/envoyer-message', [ContactController::class, 'sendEmail'])->name('envoyer.message');

Route::get('/', function () {return view('start.home');})->name('start.home');



// Application du middleware 'auth' sur les routes nécessitant une authentification
Route::middleware(['web', 'auth', UpdateLastSeen::class])->group(function () {
    
    
    
    // Route::get('/dashboard-student', function () {
    //     return view('client.dashboard');
    // })->name('client.dashboard');

    // Route vers le dashboard étudiant
    Route::get('/dashboard-student', [StudentDashboardController::class, 'dashboard'])
    ->name('client.dashboard');

    // modification du compte client
    Route::post('/client/compte/update', [CompteController::class, 'update'])->name('client.compte.update');





    // Route::get('/history', function () {
    //     return view('client.history');
    // })->name('client.history');

    // Route ves historique
    Route::get('/history', [HistoriqueTestController::class, 'index'])->name('client.history');
    
    // Route::get('/choix', function () {
    //     return view('test.choix_test');
    // })->name('test.choix_test');

    // Route vers les tests 
    Route::get('/choix', [TestController::class, 'choixTest'])->name('test.choix_test');

    // Route::get('/comprehension_ecrite', [ComprehensionEcriteController::class, 'index'])->name('test.comprehension_ecrite');
    // Route::get('/comprehension_ecrite/resultat', [ComprehensionEcriteController::class, 'resultat'])->name('test.comprehension_ecrite_resultat');
    // Route::post('/comprehension_ecrite/repondre', [ComprehensionEcriteController::class, 'enregistrerReponse']);


    Route::get('/competence', function () {
        return view('test.competence');
    })->name('test.competence');

    Route::get('/comprehension_orale', [ComprehensionOraleController::class, 'index'])->name('test.comprehension_orale');
    Route::post('/comprehension_orale/repondre', [ComprehensionOraleController::class, 'enregistrerReponse']);
    Route::get('/comprehension_orale/resultat', [ComprehensionOraleController::class, 'resultat'])->name('comprehension_orale_resultat');

    Route::get('/expression_ecrite', [ExpressionEcriteController::class, 'afficherTest'])->name('expression_ecrite');

    // Route POST (AJAX) : dialogue avec l’IA
    Route::post('/expression_ecrite/message', [ExpressionEcriteController::class, 'envoyerMessage'])->name('expression_ecrite_message');

    // Résultat final
    Route::get('/expression_ecrite/resultat', [ExpressionEcriteController::class, 'resultat'])->name('expression_ecrite_resultat');


    //  Route::get('/expression_orale', function () {
    //     return view('test.expression_orale');
    // })->name('test.expression_orale');

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

    Route::get('/admin/gestion_utilisateur', function () {
        return view('admin.gestion_utilisateur');
    })->name('gestion_utilisateurs');


    Route::put('/admin/utilisateurs/{id}', [AdminUserController::class, 'update'])->name('admin.utilisateur.modifier');
    
    Route::get('/admin/gestion_utilisateur', [UserController::class, 'index'])->name('gestion_utilisateurs');


    Route::get('/admin/gestion_test', function () {
        return view('admin.gestion_test');
    })->name('gestion_test');

    Route::get('/admin/statistiques', function () {
        return view('admin.statistiques');
    })->name('statistiques');

    Route::get('/admin/statistiques', [UserController::class, 'indexStatistiques'])->name('statistiques');




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




    
    // partie suggestion

    Route::get('/suggestion', function () {
        return view('suggestion.suggestion');
    })->name('suggestion.suggestion');

    // fin partie suggestion


    Route::get('/paiement/process/{abonnement}', [\App\Http\Controllers\PaiementController::class, 'process'])->name('paiement.process');


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
    Route::post('/comprehension_orale/reinitialiser', [ComprehensionEcriteController::class, 'reinitialiserTest'])->name('comprehension_orale.reinitialiser');



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

Route::get('/paiement', [\App\Http\Controllers\AbonnementController::class, 'index'])->name('client.paiement');





use App\Http\Controllers\TrainController;

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




/* // Dashboard
Route::get('/admin/generate-data', [train_dashboardController::class, 'index'])
    ->name('dashboard_train');

// Compréhension écrite
Route::post('/admin/comprehension-ecrite/generate', [IAComprehensionEcriteController::class, 'generate'])
    ->name('admin.comprehension_ecrite.generate');

// Compréhension orale
Route::post('/admin/comprehension-orale/generate', [trainCo::class, 'genererNouvellesQuestions'])
    ->name('admin.comprehension_orale.generate');

// Expression écrite
Route::post('/admin/expression-ecrite/generate', [IAExpressionEcriteController::class, 'genererNouvellesTaches'])
    ->name('admin.expression_ecrite.generate');

// Expression orale
Route::post('/admin/expression-orale/generate', [IAExpressionOraleController::class, 'genererNouvellesTaches'])
    ->name('admin.expression_orale.generate');

 */



/* 

// Compréhension écrite
Route::get('/admin/generate-data', [train_dashboardController::class, 'index'])
    ->name('dashboard_train');
Route::post('/admin/generate-data', [IAComprehensionEcriteController::class, 'generate'])
    ->name('admin.comprehension_ecrite.generate');

// Compréhension orale
Route::get('/comprehension-orale/train', [trainCo::class, 'formGenerer'])
    ->name('comprehension-orale.form-generer');
Route::post('/comprehension-orale/train', [trainCo::class, 'genererNouvellesQuestions'])
    ->name('admin.comprehension_orale.generate');

// Expression écrite
Route::get('/expression-ecrite/train', [IAExpressionEcriteController::class, 'formGenerer'])
    ->name('expression-ecrite.form-generer');
Route::post('/expression-ecrite/train', [IAExpressionEcriteController::class, 'genererNouvellesTaches'])
    ->name('admin.expression_ecrite.generate');

// Expression orale
Route::get('/expression-orale/train', [IAExpressionOraleController::class, 'formGenerer'])
    ->name('expression-orale.form-generer');
Route::post('/expression-orale/train', [IAExpressionOraleController::class, 'genererNouvellesTaches'])
    ->name('admin.expression_orale.generate');
 */