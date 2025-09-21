<?php

// app/Http/Controllers/ExpressionEcriteController.php

namespace App\Http\Controllers;

use App\Models\ComprehensionEcrite;
use App\Models\ComprehensionEcriteResultat;
use App\Models\ComprehensionOraleReponse;
use App\Models\ExpressionEcriteReponse;
use App\Models\ExpressionOraleReponse;
use App\Models\ComprehensionEcriteUserAnswer;
use App\Models\Niveau;
use App\Models\Souscription;
use App\Models\abonnement;
use App\Models\TestType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class ComprehensionEcriteController extends Controller
{
    public function index(Request $request)
    {
        $userId = Auth::id();
    if (!$userId)
        return response()->json(['error' => 'Utilisateur non authentifié'], 401);


        $questions = ComprehensionEcrite::orderBy('numero')->get();
        $test_type = abonnement::where('examen', 'TCF')->firstOrFail();
        $reponses = ComprehensionEcriteUserAnswer::where('user_id', $userId)
    ->pluck('reponse', 'question_id'); // clé = question_id

        if ($questions->isEmpty()) {
            return view('test.indisponible', [
                'test' => 'Comprehension Ecrite'
            ]);
        }


    return view('test.comprehension_ecrite', compact('questions', 'test_type', 'reponses'));
    }

    public function enregistrerReponse(Request $request)
{
    $userId = Auth::id();
    if (!$userId)
        return response()->json(['error' => 'Utilisateur non authentifié'], 401);

    $question = ComprehensionEcrite::findOrFail($request->question_id);
    $reponseUtilisateur = strtoupper($request->reponse);
    $isCorrect = $reponseUtilisateur === strtoupper($question->reponse);

    // ✅ Récupération du type de test depuis la requête
    $typeTest = $request->test_type ?? 'INCONNU';

    // Si c'est un JSON, on le décode
    if (is_string($typeTest)) {
        $typeTestObj = json_decode($typeTest, true);
        if ($typeTestObj && isset($typeTestObj['examen'], $typeTestObj['nom_du_plan'])) {
            $typeTest = $typeTestObj['examen'] . '-' . $typeTestObj['nom_du_plan'];
        }
    }


    Log::info('Valeur de test_type : ' . $typeTest);
    DB::table('comprehension_ecrite_user_answers')->updateOrInsert(
        [
            'user_id' => $userId,
            'question_id' => $question->id
        ],
        [
            'reponse' => $reponseUtilisateur,
            'is_correct' => $isCorrect,
            'test_type' => $typeTest, // maintenant TCF-Basique
            'updated_at' => now(),
            'created_at' => now()
        ]
    );


    return response()->json([
        'success' => true,
        'correct' => $isCorrect
    ]);
}


public function enregistrerResultatFinal(Request $request)
{
    $userId = Auth::id();
    if (!$userId) {
        return response()->json(['error' => 'Utilisateur non authentifié'], 401);
    }

    $reponses = DB::table('comprehension_ecrite_user_answers')
        ->where('user_id', $userId)
        ->get();

    $score = $reponses->where('is_correct', true)->count();
    $total = $reponses->count();
    $abonnementId = $request->abonnement_id; // id réel de la table abonnements

    DB::table('comprehension_ecrite_resultats')->insert([
        'user_id' => $userId,
        'score' => $score * 18,
        'abonnement_id' => $abonnementId, // ✅ ajouté ici
        'total' => $total,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    // ✅ récupération
    $typeTest = $request->test_type;         // ex: "TCF-Canada"
    
    Log::info('Valeur de test_type : ' . $typeTest);
    Log::info('Valeur de abonnement_id : ' . $abonnementId);

    $niveauComp = $this->determineNiveau($score);

    Niveau::updateOrCreate(
        [
            'user_id' => $userId,
            'test_type' => $typeTest,
        ],
        [
            'comprehension_ecrite' => $niveauComp,
            'updated_at' => now(),
        ]
    );

    // Vérifier abonnement
    $hasActiveSubscription = Souscription::where('user_id', $userId)
        ->where('date_debut', '<=', now())
        ->where('date_fin', '>=', now())
        ->exists();

    $freeTestsUsed = DB::table('historique_tests')
        ->where('user_id', $userId)
        ->where('is_free', true)
        ->count();

    $isFree = !$hasActiveSubscription && $freeTestsUsed < 5;

    DB::table('historique_tests')->insert([
        'user_id'       => $userId,
        'is_free'       => $isFree,
        'test_type'     => $typeTest,
        'skill'         => 'comprehension_ecrite',
        'score'         => $score,
        'niveau'        => $niveauComp,
        'duration'      => null,
        'details_route' => 'test.comprehension_ecrite_resultat',
        'refaire_route' => 'comprehension_ecrite.reinitialiser',
        'completed_at'  => now(),
        'created_at'    => now(),
        'updated_at'    => now(),
    ]);

    return response()->json(['message' => 'Résultat enregistré', 'score' => $score, 'total' => $total]);
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

    public function reinitialiserTest()
{
    $user = Auth::user();
    
    // Supprimer toutes les réponses de l'utilisateur pour ce test
    ComprehensionEcriteResultat::where('user_id', $user->id)->delete();

    // Rediriger vers la page du test
    return redirect()->route('test.comprehension_ecrite');
}

    public function resultat()
    {
        $user = Auth::user();
        if (!$user)
            abort(403, 'Non authentifié');

        $reponses = DB::table('comprehension_ecrite_user_answers')
            ->join('comprehension_ecrite', 'comprehension_ecrite.id', '=', 'comprehension_ecrite_user_answers.question_id')
            ->where('comprehension_ecrite_user_answers.user_id', $user->id)
            ->select(
                'comprehension_ecrite.numero',
                'comprehension_ecrite.situation',
                'comprehension_ecrite.question',
                'comprehension_ecrite.reponse as bonne_reponse',
                'comprehension_ecrite_user_answers.reponse as reponse_utilisateur',
                'comprehension_ecrite_user_answers.is_correct'
            )
            ->orderBy('comprehension_ecrite.numero')
            ->get();

        $score = $reponses->where('is_correct', true)->count();
        $total = $reponses->count();

       /*  DB::table('comprehension_ecrite_resultats')->insert([
            'user_id' => $user->id,
            'score' => $score,
            'total' => $total,
            'created_at' => now(),
            'updated_at' => now(),
        ]); */

         $historique = DB::table('comprehension_ecrite_resultats')
            ->where('user_id', $user)
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(function ($item) {
                $item->created_at = \Carbon\Carbon::parse($item->created_at);
                return $item;
            });

            $totalPoints = 0;
            $bonnesReponses = 0;
            $mauvaisesReponses = 0;

            foreach ($reponses as $reponse) {
                if ($reponse->is_correct) {
                    $totalPoints += 3;
                    $bonnesReponses++;
                } else {
                    $totalPoints -= 2;
                    $mauvaisesReponses++;
                }
            }

            // Détermination du niveau
        
        $route='test.comprehension_ecrite';

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
    // Créer une clé unique pour ce plan
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
    if (!$abonnement) continue;

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
    if (!$abonnement) continue;

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
    if (!$abonnement) continue;

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
    if (!$abonnement) continue;

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

        return view('test.comprehension_ecrite_resultat', [
            'titre' => 'TCF CANADA, Compréhension écrite',
            'reponses' => $reponses,
            'score' => $score,
            'total' => $total,
            'historique' => $historique,
            'totalPoints' => $totalPoints,
            'bonnesReponses' => $bonnesReponses,
            'mauvaisesReponses' => $mauvaisesReponses,
            'niveau' => $niveau,
            'route'=> $route,
            'userLevels' => $userLevels,
            'completedTests' => $completedTests,
            'learningGoal' => $learningGoal,
            'testTypes' => $testTypes,
            'souscriptionsPayees'=> $souscriptionsPayees
        ]);
    }

    
}
