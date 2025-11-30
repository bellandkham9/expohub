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
    public function inscription()
    {
        return view('start.inscription');
    }
    //Redirection à la pagge connexion
    public function connexion()
    {
        return view('start.connexion');
    }

    public function doConnexion(connexionRequest $request)
    {
        $credentials = $request->validated();

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();

            if ($user->role === 'admin') {
                return redirect()->route('gestion_utilisateurs')->with('success', 'Connexion réussie !');
            }

            return redirect()->route('client.dashboard')->with('success', 'Connexion réussie !');
        }

        return back()->with('error', 'Adresse e-mail ou mot de passe incorrect.')->withInput();
    }

    public function doInscription(inscriptionRequest $request)
    {
        $data = $request->validated();

        $user = User::create([
            'name' => $request->email,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        auth()->login($user);

        return redirect()->route('client.dashboard')->with('success', 'Inscription réussie ! Bienvenue !');
    }

    public function logout()
    {
        auth()->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect()->route('auth.connexion')->with('success', 'Vous avez été déconnecté avec succès.');
    }


    public function checkAuthenticatedOrRedirect()
    {
        if (!Auth::check()) {
            return redirect()->route('auth.connexion');
        }
        // L'utilisateur est connecté, continuer normalement
        return null;
    }
}
