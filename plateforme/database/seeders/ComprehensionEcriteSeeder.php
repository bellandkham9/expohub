<?php

// database/seeders/ComprehensionEcriteSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ComprehensionEcrite;

class ComprehensionEcriteSeeder extends Seeder
{
    public function run()
    {
        for ($i = 1; $i <= 39; $i++) {
            ComprehensionEcrite::create([
                'numero' => $i,
                'situation' => "Situation $i : Vous êtes dans une situation...",
                'question' => "Quelle est votre réaction ?",
                'propositions' => ['Réponse A', 'Réponse B', 'Réponse C', 'Réponse D'],
                'reponse' => 'A'
            ]);
        }
    }
}

