<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    // ... vos autres méthodes (index, destroy, etc.)

    public function update(Request $request, $id)
    {
        // 1. Validation des données
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'role' => 'required|string|in:admin,user',
        ]);

        // 2. Trouver l'utilisateur
        $user = User::findOrFail($id);

        // 3. Mettre à jour les attributs de l'utilisateur
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->role = $request->input('role');
        $user->save();

        // 4. Redirection avec un message de succès
            return redirect()->route('gestion_utilisateurs')->with('success', 'L\'utilisateur a été modifié avec succès.');

    }
}