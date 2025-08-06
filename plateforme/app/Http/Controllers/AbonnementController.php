<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\abonnement;
use Illuminate\Http\Request;

class AbonnementController extends Controller
{
    //


     public function index()
    {
        // Récupère tous les abonnements depuis la base de données
        $abonnements = abonnement::all();

        // Envoie les données à la vue "abonnement.plans"
        return view('client.paiement', compact('abonnements'));
    }
}
