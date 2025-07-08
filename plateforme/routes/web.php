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

Route::get('/utilisateur', function () {
    return view('admin/gestion_utilisateur');
});