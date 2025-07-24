<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ComprehensionEcriteController;

Route::post('/api/comprehension_ecrite/repondre', [ComprehensionEcriteController::class, 'enregistrerReponse']);

