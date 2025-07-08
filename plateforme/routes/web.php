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
});

Route::get('/admin/test', function () {
    return view('admin/test');
});

Route::get('/admin/fichier_q_r', function () {
    return view('admin/fichier_q_r');
});

Route::get('/admin/model_question', function () {
    return view('admin/model_question');
});


Route::get('/admin/gestion_tests', function () {
    return view('admin/gestion_tests');
});
