<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class CompteController extends Controller
{
    /**
     * Met à jour les informations du compte utilisateur.
     */
    public function update(Request $request)
    {
        // Récupère l'utilisateur connecté
        $user = auth()->user();

        // Valide les données du formulaire
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6|confirmed',
            'avatar' => 'nullable|image|max:2048', // max 2 Mo
        ]);

        // Met à jour les données de base
        $user->name = $request->name;
        $user->email = $request->email;

        // Si un nouveau mot de passe est fourni
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        // Si une nouvelle image est uploadée
        if ($request->hasFile('avatar')) {
    // Supprime l'ancienne image si elle existe
        if ($user->avatar_url && file_exists(public_path('images/' . basename($user->avatar_url)))) {
            unlink(public_path('images/' . basename($user->avatar_url)));
        }

        // Enregistre la nouvelle image dans le dossier public/images
        $file = $request->file('avatar');
        $filename = uniqid() . '_' . $file->getClientOriginalName();
        $file->move(public_path('images'), $filename);
        $user->avatar_url = 'images/' . $filename;
    }

        // Sauvegarde des modifications
        $user->save();

        // Redirection avec message de succès
        return redirect()->back()->with('success', 'Votre compte a été mis à jour avec succès.');
    }


    public function destroy(Request $request)
{
    $request->validate([
        'password' => ['required', 'current_password'],
    ]);

    $user = $request->user();
    Auth::logout();
    
    // Au lieu de supprimer de manière définitive, Laravel mettra à jour la colonne 'deleted_at'
    $user->delete();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/')->with('success', 'Votre compte a été désactivé avec succès. Vous pouvez le restaurer en contactant le support.');
}



}
