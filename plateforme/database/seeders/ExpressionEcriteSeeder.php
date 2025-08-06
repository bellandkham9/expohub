<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ExpressionEcrite;


class ExpressionEcriteSeeder extends Seeder
{
    public function run()
    {
        $taches = [
            [
                'numero_tache' => 1,
                'contexte_texte' => "Tu viens de déménager dans une nouvelle ville pour tes études.",
                'consigne' => "Écris une lettre à ton ami pour lui parler de ta nouvelle vie. L’IA te posera des questions en retour par rapport à ta réponse. Elle ne te suggère rien, elle te suit jusqu’à la fin du temps puis t’évalue."
            ],
            [
                'numero_tache' => 2,
                'contexte_texte' => "Dans ton quartier, il y a un problème de propreté et de bruit.",
                'consigne' => "Écris une lettre à la mairie pour expliquer la situation et proposer des solutions. L’IA te posera des questions à partir de tes arguments, sans donner de conseils."
            ],
            [
                'numero_tache' => 3,
                'contexte_texte' => "Un forum en ligne t’invite à donner ton avis sur l’école à distance.",
                'consigne' => "Écris un message pour exprimer ton opinion et partager ton expérience. L’IA discutera avec toi en te posant des questions précises sur tes réponses."
            ],
            [
                'numero_tache' => 3,
                'contexte_texte' => "Tu vas raconter un événement marquant qui a changé ta façon de penser.",
                'consigne' => "Écris un courriel à ton professeur pour raconter cette expérience. L’IA te posera des questions sans faire de suggestions, et t’évaluera à la fin."
            ],
        ];

        foreach ($taches as $tache) {
            ExpressionEcrite::create($tache);
        }
    }
}



