<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ComprehensionEcrite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class IAComprehensionEcriteController extends Controller
{
    public function index()
    {
        $questions = ComprehensionEcrite::latest()->take(5)->get(); // dernières questions pour contexte
        return view('admin.train_CE', compact('questions'));
    }

    public function generate(Request $request)
    {



        $request->validate([
            'nb_questions' => 'required|integer|min:1|max:20'
        ]);

        $questionsExistantes = ComprehensionEcrite::inRandomOrder()->take(10)->get()->toArray();

        $prompt = "Analyse ces questions de compréhension écrite et génère {$request->nb_questions} nouvelles questions 
au format JSON suivant, sans texte additionnel :

[
  {
    \"contexte\": \"<texte du contexte>\",
    \"question\": \"<texte de la question>\",
    \"proposition_1\": \"<réponse A>\",
    \"proposition_2\": \"<réponse B>\",
    \"proposition_3\": \"<réponse C>\",
    \"proposition_4\": \"<réponse D>\",
    \"bonne_reponse\": \"A\"
  }
]

Voici des exemples : " . json_encode($questionsExistantes, JSON_PRETTY_PRINT);

        try {
            $response = Http::timeout(60)->withHeaders([
                'Authorization' => 'Bearer ' . env('OPENROUTER_API_KEY'),
            ])->post('https://openrouter.ai/api/v1/chat/completions', [
                        'model' => 'deepseek/deepseek-chat',
                        'max_tokens' => 400,
                        'messages' => [
                            ['role' => 'system', 'content' => 'Tu es un générateur de questions TCF. Retourne uniquement un tableau JSON strictement valide, sans virgule finale, sans texte additionnel.'],
                            ['role' => 'user', 'content' => $prompt]
                        ],
                    ]);

            if ($response->failed()) {
                $status = $response->status();
                \Log::error("Erreur API IA: HTTP $status", ['response_body' => $response->body()]);
                return back()->with('error', "Erreur API IA: HTTP $status");
            }

            $jsonResponse = $response->json();
            $content = $jsonResponse['choices'][0]['message']['content'] ?? null;

            if (!$content) {
                \Log::error('Réponse IA vide ou invalide', ['body' => $response->body()]);
                return back()->with('error', 'Réponse IA vide ou invalide.');
            }

            $content = trim($content);
            $content = preg_replace('/^```json\s*/', '', $content);
            $content = preg_replace('/```$/', '', $content);
            $content = trim($content);

            // Nettoyer le bloc de code markdown
            $content = preg_replace('/^```json\s*/', '', $content);
            $content = preg_replace('/```$/', '', $content);

            // Supprimer une virgule avant la fermeture du tableau ]
            $content = preg_replace('/,\s*]/', ']', $content);

            // Supprimer une virgule avant un objet }
            $content = preg_replace('/,\s*}/', '}', $content);

            $jsonIA = json_decode($content, true);


            if (!is_array($jsonIA)) {
                \Log::error('JSON IA invalide', ['content' => $content]);
                return back()->with('error', 'Le JSON renvoyé par l’IA est invalide.');
            }

        } catch (\Illuminate\Http\Client\RequestException $e) {
            \Log::error('Timeout ou erreur réseau', ['message' => $e->getMessage()]);
            return back()->with('error', 'Erreur réseau ou délai d’attente dépassé.');
        }

        // Sauvegarde en BD
        $lastNumero = ComprehensionEcrite::max('numero') ?? 0;
        foreach ($jsonIA as $q) {
            $lastNumero++;
            ComprehensionEcrite::create([
                'numero' => $lastNumero,
                'situation' => $q['contexte'] ?? '',
                'question' => $q['question'] ?? '',
                'propositions' => json_encode([
                    $q['proposition_1'] ?? '',
                    $q['proposition_2'] ?? '',
                    $q['proposition_3'] ?? '',
                    $q['proposition_4'] ?? '',
                ], JSON_UNESCAPED_UNICODE),
                'reponse' => $q['bonne_reponse'] ?? '',
            ]);
        }

        return back()->with([
            'success' => 'Nouvelles questions générées avec succès.',
            'generated_section' => 'comprehension_ecrite',
            'generated_questions' => $jsonIA
        ]);

    }


}
