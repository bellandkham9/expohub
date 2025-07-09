<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('start/welcome');
});

Route::get('/connexion', function () {
    return view('start/connexion');
});
Route::get('/home', function () {
    return view('client/home');
});

Route::get('/dashboard', function () {
    return view('client/dashboard');
});
Route::get('/history', function () {
    return view('client/history');
});

Route::get('/contact', function () {
    return view('client/contact');
});

Route::get('/paiement', function () {
    return view('client/paiement');
});

// partie test

Route::get('/choix', function () {
    return view('test/choix_test');
});

Route::get('/competence', function () {
    return view('test/competence');
});

Route::get('/expression_ecrite', function () {
    return view('test/expression_ecrite');
});
// fin partie test



// la partie admin

Route::get('/admin/gestion_utilisateur', function () {
    return view('admin/gestion_utilisateur');
})->name('gestion_utilisateurs');

Route::get('/admin/fichier_q_r', function () {
    return view('admin/fichier_q_r');
})->name('fichier_q_r');

Route::get('/admin/model_question', function () {
    return view('admin/model_question');
})->name('model_question');

Route::get('/admin/gestion_tests', function () {
    return view('admin/gestion_tests');
})->name('gestion_tests');

Route::get('/admin/model_examen', function () {
    return view('admin/model_examen');
})->name('model_examen');

Route::get('/admin/model_reponse', function () {
    return view('admin/model_reponse');
})->name('model_reponse');

Route::get('/admin/statistiques', function () {
    return view('admin/statistiques');
})->name('statistiques');

Route::get('/admin/gestion_activites', function () {
    return view('admin/gestion_activites');
})->name('gestion_activites');