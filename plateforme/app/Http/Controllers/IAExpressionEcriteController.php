<?php

namespace App\Http\Controllers;

use App\Models\ExpressionEcrite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class IAExpressionEcriteController extends Controller
{
    /**
     * Formulaire admin pour générer de nouvelles tâches
     */
    public function formGenerer()
    {
        $taches = ExpressionEcrite::latest()->take(2)->get();
        return view('Admin.train_EE', compact('taches'));
    }

    /**
     * Génère de nouvelles tâches via IA
     */
    public function genererNouvellesTaches(Request $request)
    {
        set_time_limit(300); // 5 minutes max pour éviter les timeouts

        $request->validate([
            'nb_taches' => 'required|integer|min:1|max:10',
        ]);

        // Récupérer quelques exemples existants
        $exemples = ExpressionEcrite::inRandomOrder()->take(3)->get()->toArray();

        // Prompt ultra-précis
        $prompt = <<<EOT
Tu es un concepteur de tests d'expression écrite pour le français.

Voici 3 exemples de tâches déjà existantes :
{$this->jsonSafe($exemples)}

Ta tâche : Génère EXACTEMENT {$request->nb_taches} nouvelles tâches au même format JSON.

FORMAT STRICT :
[
  {
    "numero_tache": 1,
    "contexte_texte": "Texte ou situation à lire",
    "consigne": "Instruction pour l'élève"
  }
]

⚠️ Retourne uniquement le JSON, rien d'autre.
EOT;

        // Appel API OpenRouter
        $response = Http::timeout(120)
            ->withHeaders([
                'Authorization' => 'Bearer ' . env('OPENROUTER_API_KEY'),
                'Content-Type' => 'application/json',
            ])
            ->post('https://openrouter.ai/api/v1/chat/completions', [
                'model' => 'deepseek/deepseek-chat',
                'messages' => [
                    ['role' => 'system', 'content' => 'Tu renvoies uniquement du JSON valide.'],
                    ['role' => 'user', 'content' => $prompt],
                ],
                'max_tokens' => 400
            ]);



        if ($response->failed()) {
            return back()->with('error', 'Erreur API IA : ' . $response->body());
        }

        // Récupérer le contenu brut
        $rawContent = $response->json()['choices'][0]['message']['content'] ?? $response->body();

        // Nettoyer la réponse pour récupérer un JSON pur
        if (!preg_match('/\[\s*\{.*\}\s*\]/s', $rawContent, $matches)) {
            return back()->with('error', "Réponse IA non JSON : {$rawContent}");
        }

        $jsonContent = $matches[0];
        $questions = json_decode($jsonContent, true);

        if (!is_array($questions)) {
            return back()->with('error', "JSON mal formé : {$jsonContent}");
        }

        // Vérification et insertion en BDD
        foreach ($questions as $q) {
            if (!isset($q['numero_tache'], $q['contexte_texte'], $q['consigne'])) {
                return back()->with('error', "Objet IA incomplet : " . json_encode($q));
            }

            ExpressionEcrite::create([
                'numero_tache' => $q['numero_tache'],
                'contexte_texte' => $q['contexte_texte'],
                'consigne' => $q['consigne'],
            ]);
        }

        return back()->with([
            'success' => 'Tâches générées avec succès.',
            'generated_section' => 'expression_ecrite',
            'generated_taches' => $questions
        ]);


    }

    /**
     * Encode proprement les exemples en JSON lisible
     */
    private function jsonSafe($data)
    {
        return json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }


}
