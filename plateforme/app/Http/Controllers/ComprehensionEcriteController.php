<?php

// app/Http/Controllers/ExpressionEcriteController.php

namespace App\Http\Controllers;

use App\Models\ComprehensionEcrite;
use App\Models\ComprehensionEcriteResultat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class ComprehensionEcriteController extends Controller
{
    public function index()
{
    $questions = ComprehensionEcrite::orderBy('numero')->get();

    if ($questions->isEmpty()) {
        abort(404, 'Aucune question disponible dans la base de données.');
    }

    return view('test.comprehension_ecrite', compact('questions'));
}

   

public function enregistrerReponse(Request $request)
{
    $question = ComprehensionEcrite::findOrFail($request->question_id);
    $reponseUtilisateur = strtoupper($request->reponse);
    $isCorrect = $reponseUtilisateur === strtoupper($question->reponse);

    DB::table('comprehension_ecrite_user_answers')->updateOrInsert(
        [
            'user_id' => 1,
            'question_id' => $question->id
        ],
        [
            'reponse' => $reponseUtilisateur,
            'is_correct' => $isCorrect,
            'updated_at' => now(),
            'created_at' => now()
        ]
    );

    return response()->json([
        'success' => true,
        'correct' => $isCorrect
    ]);
}

public function enregistrerResultatFinal()
{
    $userId = auth()->id() ?? 1;

    $reponses = DB::table('comprehension_ecrite_user_answers')
        ->where('user_id', $userId)
        ->get();

    $score = $reponses->where('is_correct', true)->count();
    $total = $reponses->count();

    DB::table('comprehension_ecrite_resultats')->insert([
        'user_id' => $userId,
        'score' => $score,
        'total' => $total,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    return response()->json(['message' => 'Résultat enregistré', 'score' => $score, 'total' => $total]);
}



public function resultat()
{
    $userId = 1;

    $reponses = DB::table('comprehension_ecrite_user_answers')
        ->join('comprehension_ecrite', 'comprehension_ecrite.id', '=', 'comprehension_ecrite_user_answers.question_id')
        ->where('comprehension_ecrite_user_answers.user_id', $userId)
        ->select(
            'comprehension_ecrite.numero',
            'comprehension_ecrite.question',
            'comprehension_ecrite.reponse as bonne_reponse',
            'comprehension_ecrite_user_answers.reponse as reponse_utilisateur',
            'comprehension_ecrite_user_answers.is_correct'
        )
        ->orderBy('comprehension_ecrite.numero')
        ->get();


    $total = $reponses->count();
    $correctes = $reponses->where('is_correct', true)->count();

     $score = $reponses->where('is_correct', true)->count();
    $total = $reponses->count();

    // 2. Enregistrer dans la table des scores (si ce n'est pas déjà fait)
    DB::table('comprehension_ecrite_resultats')->insert([
        'user_id' => $userId,
        'score' => $score,
        'total' => $total,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    // 3. Historique des scores pour le graphique
    $historique = DB::table('comprehension_ecrite_resultats')
    ->where('user_id', $userId)
    ->orderBy('created_at', 'asc')
    ->get()
    ->map(function ($item) {
        $item->created_at = \Carbon\Carbon::parse($item->created_at);
        return $item;
    });


  
    return view('test.comprehension_ecrite_resultat', [
        'reponses' => $reponses,
        'score' => $correctes,
        'total' => $total,
        'historique' => $historique
    ]);
}


}
