<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Models\User;

class ForgotPasswordController extends Controller
{
    // Formulaire pour demander un reset
    public function showLinkRequestForm()
    {
        return view('auth.passwords.email');
    }

    // Envoi du lien par mail
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return back()->with('error', 'Cet email est introuvable.');
        }

        // Générer token
        $token = Str::random(60);

        // Sauvegarder en base
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            ['token' => $token, 'created_at' => now()]
        );

        // Envoyer mail
        $resetLink = url('/reset-password/'.$token);
        Mail::raw("Cliquez ici pour réinitialiser votre mot de passe : $resetLink", function($message) use ($request) {
            $message->to($request->email);
            $message->subject('Réinitialisation du mot de passe');
        });

        return back()->with('success', 'Un lien de réinitialisation a été envoyé à votre adresse email.');
    }

    // Formulaire de reset
    public function showResetForm($token)
    {
        return view('auth.passwords.reset', ['token' => $token]);
    }

    // Réinitialiser le mot de passe
    public function reset(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|confirmed|min:6',
            'token' => 'required'
        ]);

        $reset = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->where('token', $request->token)
            ->first();

        if (!$reset) {
            return back()->with('error', 'Token invalide ou expiré.');
        }

        // Mise à jour du mot de passe
        User::where('email', $request->email)->update([
            'password' => Hash::make($request->password),
        ]);

        // Supprimer le token
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return redirect()->route('auth.connexion')->with('success', 'Votre mot de passe a été réinitialisé avec succès.');
    }

}
