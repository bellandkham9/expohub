<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ExpressionEcrite;
class ExpressionEcriteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
{
    ExpressionEcrite::create([
        'contexte_texte' => 'Démenagement dans une nouvelle ville.',
        'consigne' => "l'étudiant dois Écris une lettre à son ami pour lui parler de ta nouvelle vie. L’IA te posera des questions en retour par rapport à tes reponse.il ne te suggere rien, il te suis jusquà la fin du temps puis t'évalue."
    ]);
}
}



