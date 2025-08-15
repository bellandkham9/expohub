<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

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
            return redirect()->route('admin.gestion_utilisateurs')->with('success', 'L\'utilisateur a été modifié avec succès.');

    }



    public function store(Request $request)
{
    // 1. Validation des données du formulaire
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8',
        'role' => ['required', Rule::in(['admin', 'user'])],
    ]);

    // 2. Création de l'utilisateur
    User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password), // Crypte le mot de passe
        'role' => $request->role,
    ]);

    // 3. Redirection avec un message de succès
    return redirect()->route('admin.gestion_utilisateurs')->with('success', 'Utilisateur ajouté avec succès !');
}



//envoi les donnée dans la page Gestions d'utilisateurs
    public function index()
    {
        $stats = $this->getUserStats();
        $users = User::all();

        return view('admin.gestion_utilisateur', array_merge(['users' => $users], $stats));
    }

    //envoi les donnée dans la page Statistiques
    public function indexStatistiques()
    {
        $stats = $this->getUserStats();
        return view('admin.statistiques', $stats);
    }


    // Méthode pour obtenir les statistiques des utilisateurs
    // Cette méthode est utilisée dans index et indexStatistiques
    private function getUserStats()
    {
        $totalUsers = User::count();

        $lastWeek = Carbon::now()->subWeek();
        $usersLastWeek = User::whereBetween('created_at', [$lastWeek->startOfWeek(), $lastWeek->endOfWeek()])->count();

        $seuil = Carbon::now()->subMinutes(5);
        $activeUsers = User::where('last_seen_at', '>=', $seuil)->count();
        $nombreUtilisateursActifs = $activeUsers;

        $debutSemaine = Carbon::now()->startOfWeek();
        $finSemaine = Carbon::now()->endOfWeek();
        $nombreUtilisateursActifsCetteSemaine = User::whereBetween('last_seen_at', [$debutSemaine, $finSemaine])->count();

        $nombreUtilisateursInactifs = $totalUsers - $nombreUtilisateursActifs;

        $debutSemaineDerniere = Carbon::now()->subWeek()->startOfWeek();
        $finSemaineDerniere = Carbon::now()->subWeek()->endOfWeek();

        $nombreUtilisateursInactifsSemaineDerniere = User::whereBetween('created_at', [$debutSemaineDerniere, $finSemaineDerniere])
            ->where(function ($query) use ($debutSemaineDerniere, $finSemaineDerniere) {
                $query->whereNull('last_seen_at')
                    ->orWhere('last_seen_at', '<', $debutSemaineDerniere)
                    ->orWhere('last_seen_at', '>', $finSemaineDerniere);
            })->count();

        $nombreUtilisateursInactifsSemainepassé = $nombreUtilisateursInactifsSemaineDerniere - $nombreUtilisateursActifsCetteSemaine;

        return [
            'totalUsers' => $totalUsers,
            'usersLastWeek' => $usersLastWeek,
            'activeUsers' => $activeUsers,
            'nombreUtilisateursActifs' => $nombreUtilisateursActifs,
            'nombreUtilisateursActifsCetteSemaine' => $nombreUtilisateursActifsCetteSemaine,
            'nombreUtilisateursInactifs' => $nombreUtilisateursInactifs,
            'nombreUtilisateursInactifsSemainepassé' => $nombreUtilisateursInactifsSemainepassé,
        ];
    }



    // Supprimer un utilisateur
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('gestion_utilisateurs')->with('success', 'Utilisateur supprimé avec succès.');
    }



}