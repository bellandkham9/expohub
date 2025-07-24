<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ComprehensionOrale;
use Illuminate\Support\Facades\DB;

class ComprehensionOraleController extends Controller
{
    public function index()
    {
        $questions = ComprehensionOrale::inRandomOrder()->get(); // nombre ajustable
        return view('test.comprehension_orale', compact('questions'));
    }

    public function enregistrerReponse(Request $request)
    {
        $question = ComprehensionOrale::findOrFail($request->question_id);
        $reponse = $request->reponse;

        $isCorrect = $reponse === $question->bonne_reponse;

        DB::table('comprehension_orale_user_answers')->updateOrInsert(
            [
                'user_id' => auth()->id() ?? 1, // ou remplacer par auth()->id() si login
                'question_id' => $question->id,
            ],
            [
                'reponse' => $reponse,
                'is_correct' => $isCorrect,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        return response()->json([
            'correct' => $isCorrect,
        ]);
    }
public function resultat()
{
    $userId = auth()->id() ?? 1;

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

    return view('test.comprehension_orale_resultat', compact('reponses', 'pourcentage', 'score','historique', 'total'));
}

}

