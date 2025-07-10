<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('start/welcome');
});

Route::get('/connexion', function () {
    return view('start/connexion');
});

Route::get('/inscription', function () {
    return view('start/inscription');
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

Route::get('/expression_orale', function () {
    return view('test/expression_orale');
});

Route::get('/comprehension_ecrite', function () {
    return view('test/comprehension_ecrite');
});

Route::get('/comprehension_orale', function () {
    return view('test/comprehension_orale');
});

Route::get('/dashboard_details', function () {
    return view('test/dashboard_details');
});
// fin partie test

// partie suggestion

Route::get('/suggestion', function () {
    return view('suggestion/suggestion');
});

// fin partie suggestion

// la partie admin

Route::get('/admin/gestion_utilisateur', function () {
    return view('admin/gestion_utilisateur');
})->name('gestion_utilisateurs');

Route::get('/admin/gestion_test', function () {
    return view('admin/gestion_test');
})->name('gestion_test');

Route::get('/admin/statistiques', function () {
    return view('admin/statistiques');
})->name('statistiques');


Route::get('/admin/expression_ecrite', function () {
    return view('admin/expression_ecrite');
})->name('expression_ecrite');

Route::get('/admin/comprehension_ecrite', function () {
    return view('admin/comprehension_ecrite');
})->name('comprehension_ecrite');


Route::get('/admin/comprehension_orale', function () {
    return view('admin/comprehension_orale');
})->name('comprehension_orale');

Route::get('/admin/expression_orale', function () {
    return view('admin/expression_orale');
})->name('expression_orale');

