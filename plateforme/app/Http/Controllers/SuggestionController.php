<?php

namespace App\Http\Controllers;

use App\Models\Suggestion;
use App\Notifications\NewSuggestionNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class SuggestionController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Suggestions pour lui + générales
        $suggestions = Suggestion::whereNull('user_id')
            ->orWhere('user_id', $user->id)
            ->latest()
            ->get();

        return view('suggestion.suggestion', compact('suggestions'));
    }

    public function generate()
    {
        $user = Auth::user();

        // Exemple : appeler une IA pour générer une astuce
        // Ici je te simule un appel (tu peux remplacer par OpenAI API)
        $prompt = "Génère une astuce courte pour améliorer la compréhension(écite,orale), expression(écrite,orale) tout dépends de toi,  en français pour un apprenant par rapport à ces reponses, bref son niveau.";
        
        $response = Http::withToken(env('OPENAI_API_KEY'))
            ->post('https://api.openai.com/v1/chat/completions', [
                'model' => 'gpt-4o-mini',
                'messages' => [
                    ['role' => 'system', 'content' => 'Tu es un coach linguistique.'],
                    ['role' => 'user', 'content' => $prompt]
                ],
                'max_tokens' => 200,
            ]);

        $content = $response->json('choices.0.message.content');

        // Enregistrer en base
        $suggestion = Suggestion::create([
            'user_id' => $user->id,
            'type'    => 'astuce',
            'title'   => 'Nouvelle astuce générée par IA',
            'content' => $content,
            'source'  => 'AI',
        ]);

        // Notifier l’utilisateur
        $user->notify(new NewSuggestionNotification($suggestion));

        return back()->with('success', 'Nouvelle astuce générée ✅');
    }
}
