<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ComprehensionOrale;
use App\Models\ComprehensionOraleReponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\ExpressionEcriteReponse;
use App\Models\ComprehensionEcriteResultat;
use App\Models\ExpressionOraleReponse;
use App\Models\Niveau;
use App\Models\abonnement;
use Illuminate\Support\Carbon;
use App\Models\Souscription;

class ComprehensionOraleController extends Controller
{
    public function index()
    {
        $userId = Auth::id(); // Renvoie directement l'ID
        $questions = ComprehensionOrale::inRandomOrder()->get();

        $reponses = ComprehensionOraleReponse::where('user_id', $userId)
            ->pluck('reponse', 'question_id'); // clé = question_id


        // Récupérer le type de test dynamiquement, par exemple depuis la table abonnements
        $test_type = abonnement::where('examen', 'TCF')->firstOrFail();

        if ($questions->isEmpty()) {
            return view('test.indisponible', [
                'test' => 'Compréhension Orale'
            ]);
        }

        // Passer $questions et $test_type à la vue
        return view('test.comprehension_orale', compact('questions', 'test_type', 'reponses'));
    }

    public function enregistrerReponse(Request $request)
    {
        $validated = $request->validate([
            'test_type' => 'required|string'
        ]);


        $userId = Auth::id(); // Renvoie directement l'ID

        if (!$userId)
            return response()->json(['error' => 'Utilisateur non authentifié'], 401);

        // $userId = Auth::id();
        if (!$userId)
            return response()->json(['error' => 'Utilisateur non authentifié'], 401);

        $question = ComprehensionOrale::findOrFail($request->question_id);
        $reponse = $request->reponse;
        $isCorrect = $reponse === strtoupper($question->bonne_reponse);



        $testTypeString = $validated['test_type']; // Exemple: "TCF-Plan1"
        $abonnementId = $request->abonnement_id; // id réel de la table abonnements

        DB::table('comprehension_orale_user_answers')->updateOrInsert(
            [
                'user_id' => $userId,
                'question_id' => $question->id,
            ],
            [
                'reponse' => $reponse,
                'is_correct' => $isCorrect,
                'score' => $isCorrect ? 1 : 0,
                'test_type' => $testTypeString,
                'abonnement_id' => $abonnementId, // ✅ ajouté ici
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );


        return response()->json([
            'correct' => $isCorrect,
        ]);
    }


    private function determineNiveau(float $score): string
    {
        return match (true) {
            $score >= 600 && $score <= 699 => 'C2', // Utilisateur expérimenté maîtrise, proche du bilinguisme
            $score >= 500 && $score <= 599 => 'C1', // Utilisateur expérimenté autonome, bonne compréhension des textes et dialogues complexes
            $score >= 400 && $score <= 499 => 'B2', // Utilisateur indépendant avancé, conversation spontanée sur divers sujets
            $score >= 300 && $score <= 399 => 'B1', // Utilisateur indépendant, autonome lors d'un voyage ou au travail
            $score >= 200 && $score <= 299 => 'A2', // Utilisateur élémentaire intermédiaire, capacité à parler de l'environnement quotidien
            $score >= 100 && $score <= 199 => 'A1', // Utilisateur élémentaire débutant, phrases simples liées à la vie quotidienne
            default => 'A0', // (0-99 points) : Débutant, reconnaissance de quelques mots
        };
    }

    public function enregistrerResultatFinal(Request $request)
    {
        $validated = $request->validate([
            'test_type' => 'required|string'
        ]);

        $userId = Auth::id();
        if (!$userId) {
            return response()->json(['error' => 'Utilisateur non authentifié'], 401);
        }

        $testTypeString = $validated['test_type']; // Exemple: "TCF-Plan1"

        $reponses = DB::table('comprehension_orale_user_answers')
            ->where('user_id', $userId)
            ->where('test_type', $testTypeString) // ✅ cohérence
            ->get();

        $score = $reponses->where('is_correct', true)->count();
        $score *= 18;

        $total = $reponses->count();
        $abonnementId = $request->abonnement_id; // id réel de la table abonnements
        // (optionnel : conserver table de résultats bruts)
        /*  DB::table('comprehension_orale_resultats')->insert([
             'user_id'    => $userId,
             'score'      => $score * 18,
             'abonnement_id' => $abonnementId, // ✅ ajouté ici
             'total'      => $total,
             'created_at' => now(),
             'updated_at' => now(),
         ]);
      */
        // Découper test_type
        [$examen, $plan] = explode('-', $testTypeString);

        $testType = abonnement::where('examen', $examen)
            ->where('nom_du_plan', $plan)
            ->firstOrFail();

        $niveauComp = $this->determineNiveau($score);

        // Mise à jour du niveau
        Niveau::updateOrCreate(
            [
                'user_id' => $userId,
                'test_type' => $testType->id,
            ],
            [
                'comprehension_orale' => $niveauComp,
                'updated_at' => now(),
            ]
        );

        // Vérifier abonnement actif
        $hasActiveSubscription = Souscription::where('user_id', $userId)
            ->where('date_debut', '<=', now())
            ->where('date_fin', '>=', now())
            ->exists();

        // Vérifier tests gratuits
        $freeTestsUsed = DB::table('historique_tests')
            ->where('user_id', $userId)
            ->where('is_free', true)
            ->count();

        $isFree = (!$hasActiveSubscription && $freeTestsUsed < 5);

        // Insertion dans historique_tests
        DB::table('historique_tests')->insert([
            'user_id' => $userId,
            'is_free' => $isFree,
            'test_type' => $testTypeString, // ✅ ex: "TCF-Plan1"
            'skill' => 'comprehension_orale',
            'score' => $score,
            'niveau' => $niveauComp,
            'duration' => null,
            'details_route' => 'test.dashboard_details',
            'refaire_route' => 'comprehension_orale.reinitialiser',
            'completed_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json([
            'message' => 'Résultat enregistré',
            'score' => $score,
            'total' => $total,
            'test_type' => $testTypeString,
        ]);
    }


    public function resultat()
    {
        $user = Auth::user();
        if (!$user)
            abort(403, 'Non authentifié');

        $userId = $user->id;

        $reponses = DB::table('comprehension_orale_user_answers')
            ->join('comprehension_orales', 'comprehension_orales.id', '=', 'comprehension_orale_user_answers.question_id')
            ->where('user_id', $userId)
            ->select(
                'comprehension_orales.id as question_id',
                'contexte_texte',
                'question_audio',
                'proposition_1',
                'proposition_2',
                'proposition_3',
                'proposition_4',
                'bonne_reponse',
                'reponse as reponse_utilisateur',
                'is_correct'
            )
            ->get();

        $historique = DB::table('comprehension_orale_user_answers')
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as total'),
                DB::raw('SUM(is_correct) as score')
            )
            ->where('user_id', $userId)
            ->groupBy('date')
            ->get();

        $score = $reponses->where('is_correct', true)->count();
        $total = $reponses->count();
        $pourcentage = $total > 0 ? round(($score / $total) * 100) : 0;
        $titre = 'TCF CANADA, Compréhension orale';

        $totalPoints = 0;
        $bonnesReponses = 0;
        $mauvaisesReponses = 0;

        foreach ($reponses as $reponse) {
            if ($reponse->is_correct) {
                $totalPoints += 3 * 2;
                $bonnesReponses++;
            } else {
                $totalPoints -= 0;
                $mauvaisesReponses++;
            }
        }



        $route = 'test.comprehension_orale';

        $tousLesAbonnements = abonnement::all();

        // Récupérer la souscription active de l'utilisateur avec l'abonnement associé
        $souscriptionActives = Souscription::where('user_id', $user->id)
            ->where('date_fin', '>=', Carbon::now())
            ->with('abonnement') // Charger la relation 'abonnement'
            ->get();


        // 3. Fusionner les deux collections et marquer les abonnements payés
        $testTypes = $tousLesAbonnements->map(function ($abonnement) use ($souscriptionActives) {
            $abonnement->paye = $souscriptionActives->contains(function ($souscription) use ($abonnement) {
                return $souscription->abonnement_id == $abonnement->id;
            });
            return $abonnement;
        });


        $userLevels = [];
        $souscriptionsPayees = [];

        foreach ($testTypes as $abonnement) {
            // Clé unique combinant examen + nom_du_plan
            $key = $abonnement->examen . '_' . $abonnement->nom_du_plan;

            // Récupérer le niveau global pour cet abonnement
            $niveau = Niveau::where('user_id', $user->id)
                ->where('test_type', $abonnement->id)
                ->first();

            $userLevels[$key] = $niveau ? [
                'comprehension_ecrite' => $niveau->comprehension_ecrite,
                'comprehension_orale' => $niveau->comprehension_orale,
                'expression_ecrite' => $niveau->expression_ecrite,
                'expression_orale' => $niveau->expression_orale,
            ] : [
                'comprehension_ecrite' => 'Non défini',
                'comprehension_orale' => 'Non défini',
                'expression_ecrite' => 'Non défini',
                'expression_orale' => 'Non défini',
            ];

            // Vérifier si l’utilisateur a souscrit et payé cet abonnement
            $souscriptionsPayees[$key] = Souscription::where('user_id', $user->id)
                ->where('paye', true)
                ->where('abonnement_id', $abonnement->id)
                ->first();
        }

        // Récupérer les 5 derniers tests complétés par abonnement et compétence
        $completedTests = [];

        // Comprehension Ecrite
        foreach (ComprehensionEcriteResultat::where('user_id', $user->id)
            ->latest()->take(5)->get() as $reponse) {
            $abonnement = abonnement::find($reponse->abonnement_id); // Assurez-vous d'avoir ce champ
            if (!$abonnement)
                continue;

            $completedTests[] = [
                'id' => $reponse->id,
                'test_type' => $abonnement->examen . ' - ' . $abonnement->nom_du_plan,
                'skill' => 'Compréhension Écrite',
                'date' => $reponse->created_at,
                'duration' => 360,
                'score' => $reponse->score,
                'max_score' => 699,
                'level' => $reponse->niveau,
                'correct_answers' => $reponse->nb_bonnes_reponses,
                'total_questions' => $reponse->nb_total_questions,
            ];
        }

        // Comprehension Orale
        foreach (ComprehensionOraleReponse::where('user_id', $user->id)
            ->latest()->take(5)->get() as $reponse) {
            $abonnement = abonnement::find($reponse->abonnement_id);
            if (!$abonnement)
                continue;

            $completedTests[] = [
                'id' => $reponse->id,
                'test_type' => $abonnement->examen . ' - ' . $abonnement->nom_du_plan,
                'skill' => 'Compréhension Orale',
                'date' => $reponse->created_at,
                'duration' => 160,
                'score' => $reponse->score,
                'max_score' => 699,
                'level' => $reponse->niveau,
                'correct_answers' => $reponse->nb_bonnes_reponses,
                'total_questions' => $reponse->nb_total_questions,
            ];
        }

        // Expression Ecrite
        foreach (ExpressionEcriteReponse::where('user_id', $user->id)
            ->latest()->take(5)->get() as $reponse) {
            $abonnement = abonnement::find($reponse->abonnement_id);
            if (!$abonnement)
                continue;

            $completedTests[] = [
                'id' => $reponse->id,
                'test_type' => $abonnement->examen . ' - ' . $abonnement->nom_du_plan,
                'skill' => 'Expression Écrite',
                'date' => $reponse->created_at,
                'duration' => 60,
                'score' => $reponse->score,
                'max_score' => 699,
                'level' => $reponse->niveau,
                'correct_answers' => null,
                'total_questions' => null,
            ];
        }

        // Expression Orale
        foreach (ExpressionOraleReponse::where('user_id', $user->id)
            ->latest()->take(5)->get() as $reponse) {
            $abonnement = abonnement::find($reponse->abonnement_id);
            if (!$abonnement)
                continue;

            $completedTests[] = [
                'id' => $reponse->id,
                'test_type' => $abonnement->examen . ' - ' . $abonnement->nom_du_plan,
                'skill' => 'Expression Orale',
                'date' => $reponse->created_at,
                'duration' => 15,
                'score' => $reponse->score,
                'max_score' => 699,
                'level' => $reponse->niveau,
                'correct_answers' => null,
                'total_questions' => null,
            ];
        }



        $learningGoal = [
            'target_level' => 'C1',
            'current_progress' => 65,
            'target_date' => Carbon::now()->addMonths(3)
        ];

        return view('test.comprehension_orale_resultat', compact(
            'titre',
            'route',
            'totalPoints',
            'bonnesReponses',
            'mauvaisesReponses',
            'niveau',
            'reponses',
            'pourcentage',
            'score',
            'historique',
            'total',
            'route',
            'userLevels',
            'completedTests',
            'learningGoal',
            'testTypes',
            'souscriptionsPayees'
        ));
    }

    public function reinitialiserTest()
    {
        $user = Auth::user();

        // Supprimer toutes les réponses de l'utilisateur pour ce test
        ComprehensionOraleReponse::where('user_id', $user->id)->delete();

        // Rediriger vers la page du test
        return redirect()->route('test.comprehension_orale');
    }

}
