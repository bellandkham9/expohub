<?php

namespace App\Http\Controllers;

use App\Models\ComprehensionEcrite;
use App\Models\ComprehensionOrale;
use App\Models\ExpressionEcrite;
use App\Models\ExpressionOrale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class TrainController extends Controller
{
    // ================= Dashboard =================
    public function index(){
        $stats = [
            'total_questions' => ComprehensionEcrite::count() + ComprehensionOrale::count(),
            'oral_questions' => ComprehensionOrale::count(),
            'ecrite_tasks' => ExpressionEcrite::count() + ExpressionOrale::count(),
        ];

        $recent_ecrite = ComprehensionEcrite::latest()->take(5)->get();
        $recent_orale = ComprehensionOrale::latest()->take(5)->get();
        $recent_expression_ecrite = ExpressionEcrite::latest()->take(5)->get();
        $recent_expression_orale = ExpressionOrale::latest()->take(5)->get();

        return view('Admin.train_dashboard', compact(
            'stats',
            'recent_ecrite',
            'recent_orale',
            'recent_expression_ecrite',
            'recent_expression_orale'
        ));
    }

    // ================= Comprehension Ecrite =================
    public function ceIndex()
    {
        $questions = ComprehensionEcrite::latest()->take(5)->get();
        return view('Admin.train_CE', compact('questions'));
    }

    public function ceGenerate(Request $request)
    {
        $request->validate([
            'nb_questions' => 'required|integer|min:1|max:20'
        ]);

        $examples = ComprehensionEcrite::inRandomOrder()->take(10)->get()->toArray();

        $prompt = "Analyse ces questions et génère {$request->nb_questions} nouvelles questions JSON : " . json_encode($examples, JSON_PRETTY_PRINT);

        try {
            $response = Http::timeout(60)->withHeaders([
                'Authorization' => 'Bearer ' . env('OPENROUTER_API_KEY'),
            ])->post('https://openrouter.ai/api/v1/chat/completions', [
                        'model' => 'deepseek/deepseek-r1-0528',
                        'max_tokens' => 4000,
                        'messages' => [
                            ['role' => 'system', 'content' => 'Tu es un générateur de questions TCF. Retourne uniquement un JSON valide.'],
                            ['role' => 'user', 'content' => $prompt]
                        ]
                    ]);

            if ($response->failed()) {
                return back()->with('error', 'Erreur API IA: HTTP ' . $response->status());
            }

            $content = $response->json()['choices'][0]['message']['content'] ?? null;
            $content = trim(preg_replace('/^```json\s*|```$/', '', $content));
            $jsonIA = json_decode($content, true);

            if (!is_array($jsonIA)) {
                return back()->with('error', 'JSON IA invalide.');
            }

        } catch (\Exception $e) {
            Log::error('Erreur CE Generate', ['message' => $e->getMessage()]);
            return back()->with('error', 'Erreur réseau ou délai dépassé.');
        }

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

    // ================= Expression Ecrite =================
    public function eeIndex()
    {
        $taches = ExpressionEcrite::latest()->take(2)->get();
        return view('Admin.train_EE', compact('taches'));
    }

    public function eeGenerate(Request $request)
    {
        set_time_limit(300);
        $request->validate(['nb_taches' => 'required|integer|min:1|max:10']);
        $examples = ExpressionEcrite::inRandomOrder()->take(3)->get()->toArray();

        $prompt = "Génère {$request->nb_taches} nouvelles tâches expression écrite, format JSON strict, exemples : " . $this->jsonSafe($examples);

        $response = Http::timeout(120)->withHeaders([
            'Authorization' => 'Bearer ' . env('OPENROUTER_API_KEY'),
        ])->post('https://openrouter.ai/api/v1/chat/completions', [
                    'model' => 'deepseek/deepseek-chat',
                    'messages' => [
                        ['role' => 'system', 'content' => 'Tu renvoies uniquement du JSON valide.'],
                        ['role' => 'user', 'content' => $prompt],
                    ],
                    'max_tokens' => 800
                ]);

        $rawContent = $response->json()['choices'][0]['message']['content'] ?? $response->body();
        preg_match('/\[\s*\{.*\}\s*\]/s', $rawContent, $matches);
        $tasks = json_decode($matches[0] ?? '[]', true);

        foreach ($tasks as $t) {
            ExpressionEcrite::create([
                'numero_tache' => $t['numero_tache'],
                'contexte_texte' => $t['contexte_texte'],
                'consigne' => $t['consigne'],
            ]);
        }

        return back()->with([
            'success' => 'Tâches générées avec succès.',
            'generated_section' => 'expression_ecrite',
            'generated_taches' => $tasks
        ]);
    }

    // ================= Comprehension Orale =================
    public function coIndex()
    {
        $questions = ComprehensionOrale::latest()->take(2)->get();
        return view('Admin.train_CO', compact('questions'));
    }

    public function coGenerate(Request $request)
    {
        set_time_limit(300);
        $request->validate(['nb_questions' => 'required|integer|min:1|max:20']);
        $examples = ComprehensionOrale::inRandomOrder()->take(5)->get()->toArray();

        $prompt = "Génère {$request->nb_questions} questions CO, format JSON strict, exemples : " . $this->jsonSafe($examples);

        $response = Http::timeout(60)->withHeaders([
            'Authorization' => 'Bearer ' . env('OPENROUTER_API_KEY'),
        ])->post('https://openrouter.ai/api/v1/chat/completions', [
                    'model' => 'deepseek/deepseek-chat',
                    'messages' => [
                        ['role' => 'system', 'content' => 'Tu es un générateur de CO.'],
                        ['role' => 'user', 'content' => $prompt],
                    ],
                    'max_tokens' => 400
                ]);

        $rawContent = $response->json()['choices'][0]['message']['content'] ?? null;
        $rawContent = preg_replace('/^```json\s*|```$/', '', trim($rawContent));
        $questions = json_decode($rawContent, true);
      
        foreach ($questions as $q) {
            $question = ComprehensionOrale::create([
                'contexte_texte' => $q['contexte_texte'],
                'question_audio' => '',
                'proposition_1' => $q['proposition_1'],
                'proposition_2' => $q['proposition_2'],
                'proposition_3' => $q['proposition_3'],
                'proposition_4' => $q['proposition_4'],
                'bonne_reponse' => $q['bonne_reponse'],
            ]);

            $audioFile = $this->genererAudio($q['question']);
            if ($audioFile)
                $question->update(['question_audio' => $audioFile]);
        }

        return back()->with([
            'success' => 'Audios générés avec succès.',
            'generated_section' => 'comprehension_orale',
        ]);
    }

    // ================= Expression Orale =================
    public function eoIndex()
    {
        $taches = ExpressionOrale::latest()->take(2)->get();
        return view('Admin.train_EO', compact('taches'));
    }

    public function eoGenerate(Request $request)
    {
        set_time_limit(600);
        $request->validate(['nb_taches' => 'required|integer|min:1|max:10']);
        $examples = ExpressionOrale::inRandomOrder()->take(3)->get()->toArray();

        $prompt = "Génère {$request->nb_taches} tâches EO, format JSON strict, exemples : " . $this->jsonSafe($examples);

        $response = Http::timeout(120)->withHeaders([
            'Authorization' => 'Bearer ' . env('OPENROUTER_API_KEY'),
        ])->post('https://openrouter.ai/api/v1/chat/completions', [
                    'model' => 'deepseek/deepseek-chat',
                    'messages' => [
                        ['role' => 'system', 'content' => 'Tu renvoies uniquement du JSON valide.'],
                        ['role' => 'user', 'content' => $prompt],
                    ],
                    'max_tokens' => 400
                ]);

        $jsonContent = $response->json()['choices'][0]['message']['content'] ?? '[]';
        $tasks = json_decode($jsonContent, true);

        foreach ($tasks as $t) {
            $task = ExpressionOrale::create([
                'numero' => $t['numero'],
                'type' => $t['type'],
                'contexte' => $t['contexte'],
                'consigne' => $t['consigne'],
                'consigne_audio' => '',
            ]);

            $audioFile = $this->genererAudio($t['consigne']);
            if ($audioFile)
                $task->update(['consigne_audio' => $audioFile]);
        }

        return back()->with([
            'success' => 'Tâches EO générées avec succès.',
            'generated_section' => 'expression_orale',
        ]);
    }

    // ================= Helpers =================
    private function jsonSafe($data)
    {
        return json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    private function genererAudio($texte)
    {
        try {
            $response = Http::timeout(60)
                ->withHeaders([
                    'xi-api-key' => env('ELEVENLABS_API_KEY'),
                    'Accept' => 'audio/mpeg',
                    'Content-Type' => 'application/json',
                ])
                ->post("https://api.elevenlabs.io/v1/text-to-speech/" . env('ELEVENLABS_VOICE_ID'), [
                    'text' => $texte,
                    'voice_settings' => [
                        'stability' => 0.5,
                        'similarity_boost' => 0.75,
                    ],
                ]);

            if ($response->successful()) {
                $audioPath = 'audios/' . uniqid() . '.mp3';
                Storage::disk('public')->put($audioPath, $response->body());
                return $audioPath;
            }

        } catch (\Exception $e) {
            Log::error("Erreur génération audio : " . $e->getMessage());
        }

        return null;
    }
}
