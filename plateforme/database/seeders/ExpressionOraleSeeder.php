<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ExpressionOrale;

class ExpressionOraleSeeder extends Seeder
{
    public function run(): void
    {
        $questions = [
            [
                'type' => 'tcf-canada',
                'numero' => 1,
                'skill'=>'expression orale',
                'contexte' => 'Votre ami vous demande de l\'aide pour déménager ce week-end.',
                'consigne' => 'Vous devez répondre à votre ami par un court message vocal. Acceptez ou refusez poliment son invitation, et donnez une brève raison.',
            ],
            [
                'type' => 'tcf-canada',
                'numero' => 2,
                'skill'=>'expression orale',
                'contexte' => 'Vous avez récemment visité une nouvelle ville au Canada.',
                'consigne' => 'Parlez pendant environ 2 minutes pour décrire votre expérience : ce que vous avez aimé, ce que vous avez fait, et ce que vous recommandez à d\'autres visiteurs.',
            ],
            [
                'type' => 'tcf-quebec',
                'numero' => 3,
                'skill'=>'expression orale',
                'contexte' => 'Certaines personnes pensent qu\'il est préférable de vivre en ville, d\'autres préfèrent la campagne.',
                'consigne' => 'Donnez votre opinion en l\'appuyant avec des arguments. Comparez les deux modes de vie et concluez en expliquant ce que vous préférez et pourquoi.',
            ],
        ];

        foreach ($questions as $question) {
            ExpressionOrale::create($question);
        }
    }
}
