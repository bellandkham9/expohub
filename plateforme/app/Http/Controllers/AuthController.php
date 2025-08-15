<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\inscriptionRequest;
use App\Http\Requests\connexionRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;



class AuthController extends Controller
{
    //Redirection à la pagge inscription
    public  function inscription(){
        return view('start.inscription');
    }
    //Redirection à la pagge connexion
    public  function connexion(){
        return view('start.connexion');
    }

    public function doConnexion(connexionRequest $request)
{
    $credentials = $request->validated();

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();

        // Récupérer l'utilisateur actuellement authentifié
        $user = Auth::user();

        // Vérifier le rôle de l'utilisateur
        if ($user->role === 'admin') {
            return redirect()->route('gestion_utilisateurs'); // Redirection pour les admins
        }

        // Redirection par défaut pour les autres rôles (par exemple, 'client')
        return redirect()->route('client.dashboard');
    }

    return back()->withErrors([
        'email' => 'Adresse e-mail ou mot de passe incorrect.',
    ])->withInput();
}





    public  function doInscription(inscriptionRequest  $request){
        $data = $request->validated();

        $user = User::create([
        'name' => $request->email,
        'email' => $request->email,
        'password' => Hash::make($request->password),
    ]);
    auth()->login($user);

    return redirect()->route('client.dashboard')->with('success', 'Inscription réussie !');

    } 

    public function logout() {
    auth()->logout(); // Déconnecte l'utilisateur

    // Vide la session si tu en utilises directement
    request()->session()->invalidate();
    request()->session()->regenerateToken();

    // Redirige vers la page de connexion ou d'accueil
    return redirect()->route('auth.connexion')->with('success', 'Vous avez été déconnecté.');
    }


    public function checkAuthenticatedOrRedirect() {
    if (!Auth::check()) {
        return redirect()->route('auth.connexion');
    }
    // L'utilisateur est connecté, continuer normalement
    return null;
}
}
