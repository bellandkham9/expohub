<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/connexion', function () {
    return view('connexion');
});
Route::get('/home', function () {
    return view('home');
});

Route::get('/history', function () {
    return view('history');
});

Route::get('/contact', function () {
    return view('contact');
});

Route::get('/paiement', function () {
    return view('paiement');
});