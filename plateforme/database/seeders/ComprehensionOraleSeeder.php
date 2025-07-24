<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ComprehensionOrale;

class ComprehensionOraleSeeder extends Seeder
{
    public function run(): void
    {
         for ($i = 1; $i <= 39; $i++) {
             ComprehensionOrale::create([
            'contexte_texte' => 'Ceci est un exemple de texte.', // ou 'images/image1.png'
            'question_audio' => 'audios/question1.mp3',
            'proposition_1' => 'Proposition A',
            'proposition_2' => 'Proposition B',
            'proposition_3' => 'Proposition C',
            'proposition_4' => 'Proposition D',
            'bonne_reponse' => '2',
        ]);
        }

      

        // Ajoute d'autres questions ici si besoin
    }
}
