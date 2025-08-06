<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User; 
use Carbon\Carbon;


class UserController extends Controller
{
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




    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('gestion_utilisateurs')->with('success', 'Utilisateur supprimé avec succès.');
    }

    
}
