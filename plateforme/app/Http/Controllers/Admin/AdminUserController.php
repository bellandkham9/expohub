<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use App\Models\abonnement;
use App\Models\Souscription;
use App\Models\HistoriqueTest;
use App\Models\TestType;
use Illuminate\Support\Facades\Auth;
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
        $abonnements = abonnement::all();

        return view('admin.gestion_utilisateur', [
            'users' => $users,
            'abonnements' => $abonnements,
        ] + $stats);
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


        // Total de tests passés
        $totalTests = HistoriqueTest::count();

        $totalAbonnements = Souscription::count();

        // Tests passés la semaine dernière
        $startOfLastWeek = Carbon::now()->subWeek()->startOfWeek();
        $endOfLastWeek = Carbon::now()->subWeek()->endOfWeek();


        // 📌 Abonnements uniquement pour CE MOIS
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        $totalAbonnementsMois = Souscription::whereBetween('created_at', [$startOfMonth, $endOfMonth])->count();

        $testsLastWeek = HistoriqueTest::whereBetween('completed_at', [$startOfLastWeek, $endOfLastWeek])->count();

        // Tests abandonnés (duration null ET score = 0)
        $testsAbandonnes = HistoriqueTest::whereNull('duration')
            ->where('score', 0)
            ->count();

        // Tests abandonnés cette semaine
        $testsAbandonnesSemaine = HistoriqueTest::whereNull('duration')
            ->where('score', 0)
            ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
            ->count();


        /////////////////////////////////
        ////Information de la courbe////
        ///////////////////////////////

        $currentYear = Carbon::now()->year;

        // Tableau des mois
        $months = collect(range(1, 12))->map(function ($m) {
            return Carbon::createFromDate(null, $m, 1)->format('M');
        });

        // Total des souscriptions par mois
        $subscriptionsPerMonth = [];
        foreach (range(1, 12) as $month) {
            $subscriptionsPerMonth[] = Souscription::whereYear('created_at', $currentYear)
                ->whereMonth('created_at', $month)
                ->count();
        }

        // Total des utilisateurs inscrits par mois
        $usersPerMonth = [];
        foreach (range(1, 12) as $month) {
            $usersPerMonth[] = User::whereYear('created_at', $currentYear)
                ->whereMonth('created_at', $month)
                ->count();
        }

        return [
            'totalUsers' => $totalUsers,
            'usersLastWeek' => $usersLastWeek,
            'activeUsers' => $activeUsers,
            'nombreUtilisateursActifs' => $nombreUtilisateursActifs,
            'nombreUtilisateursActifsCetteSemaine' => $nombreUtilisateursActifsCetteSemaine,
            'nombreUtilisateursInactifs' => $nombreUtilisateursInactifs,
            'nombreUtilisateursInactifsSemainepassé' => $nombreUtilisateursInactifsSemainepassé,
            'totalTests' => $totalTests,
            'testsLastWeek' => $testsLastWeek,
            'totalAbonnements' => $totalAbonnements,
            'totalAbonnementsMois' => $totalAbonnementsMois,
            'testsAbandonnes' => $testsAbandonnes,
            'testsAbandonnesSemaine' => $testsAbandonnesSemaine,
            'subscriptionsPerMonth' => $subscriptionsPerMonth,
            'usersPerMonth' => $usersPerMonth,
        ];
    }


    // Supprimer un utilisateur
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('gestion_utilisateurs')->with('success', 'Utilisateur supprimé avec succès.');
    }


    protected function checkAdminRole(): ?RedirectResponse
    {
        // Vérifie si l'utilisateur est authentifié ET si son rôle n'est PAS 'admin'
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            // Redirige vers la page d'accueil avec un message d'erreur
            return redirect('/')->with('error', 'Accès non autorisé.')->send();
        }

        return null; // L'utilisateur est admin, continuez l'exécution de la méthode appelante
    }

    // Attribuer un abonnement 
    public function attribuerAbonnement(Request $request)
    {
        // ✅ Validation des données reçues depuis le formulaire ou la requête
        // Vérifie que l'utilisateur (user_id) existe bien dans la table users
        // Vérifie aussi que l'abonnement (abonnement_id) existe bien dans la table abonnements
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'abonnement_id' => 'required|exists:abonnements,id',
        ]);

        // ✅ On récupère l'utilisateur concerné
        $user = User::findOrFail($request->user_id);

        // ✅ On récupère l'abonnement choisi
        $abonnement = Abonnement::findOrFail($request->abonnement_id);

        // ✅ Création de la souscription dans la table "souscriptions"
        // Ici on dit : cet utilisateur a cet abonnement, avec une date de début = maintenant
        // et une date de fin = maintenant + durée définie dans le modèle Abonnement
        Souscription::create([
            'user_id' => $user->id,
            'abonnement_id' => $abonnement->id,
            'date_debut' => now(),
            'date_fin' => now()->addDays($abonnement->duree), // Exemple : si durée = 30 jours
        ]);

        // ✅ Retourne en arrière avec un message de succès
        return redirect()->back()->with('success', 'Abonnement attribué avec succès.');
    }
    // Statitiques des tests dans la plateforme
    public function indexTestStats()
    {
        // Total de tests passés
        $totalTests = HistoriqueTest::count();

        $totalAbonnements = Souscription::count();

        // Tests passés la semaine dernière
        $startOfLastWeek = Carbon::now()->subWeek()->startOfWeek();
        $endOfLastWeek = Carbon::now()->subWeek()->endOfWeek();


        // 📌 Abonnements uniquement pour CE MOIS
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        $totalAbonnementsMois = Souscription::whereBetween('created_at', [$startOfMonth, $endOfMonth])->count();

        $testsLastWeek = HistoriqueTest::whereBetween('completed_at', [$startOfLastWeek, $endOfLastWeek])->count();

        // Tests abandonnés (duration null ET score = 0)
        $testsAbandonnes = HistoriqueTest::whereNull('duration')
            ->where('score', 0)
            ->count();

        // Tests abandonnés cette semaine
        $testsAbandonnesSemaine = HistoriqueTest::whereNull('duration')
            ->where('score', 0)
            ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
            ->count();



        $listAbonnement=abonnement::with('testType')->get();
        $tests = TestType::all();
        // Tu peux retourner les données pour ton dashboard ou les passer à une vue
        return view('admin.gestion_test', [
            'totalTests' => $totalTests,
            'testsLastWeek' => $testsLastWeek,
            'totalAbonnements' => $totalAbonnements,
            'totalAbonnementsMois' => $totalAbonnementsMois,
            'testsAbandonnes' => $testsAbandonnes,
            'testsAbandonnesSemaine' => $testsAbandonnesSemaine,
            'abonnements' => $listAbonnement,
            'tests' =>  $tests
        ]);
    }
    // envoyer un message à un utilisateur ou tout les users


    public function sendMessage(Request $request)
{
    $request->validate([
        'title' => 'required|string',
        'message' => 'required|string',
        'user_id' => 'nullable|exists:users,id',
    ]);

    \App\Models\NotificationAdmin::create($request->only('title', 'message', 'user_id'));

    return back()->with('success', 'Notification envoyée');
}
public function markAsRead(Request $request, \App\Models\NotificationAdmin $notification)
    {
        $notification->read = true;
        $notification->save();

        return response()->json([
            'success' => true,
            'id' => $notification->id
        ]);
    
    
}
public function supprimer($id)
{
    $notif = \App\Models\NotificationAdmin::findOrFail($id);
    $notif->delete();

    return response()->json(['success' => true]);
}


}