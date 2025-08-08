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
            'contexte_texte' => "Dans ton école, certains élèves utilisent leur téléphone portable pendant les cours.",
            'consigne' => "Écris un message à ton directeur pour donner ton avis sur cette situation et proposer une solution. L’IA te posera des questions en se basant uniquement sur tes arguments.",
        ],
        [
            'numero_tache' => 2,
            'contexte_texte' => "Un journal en ligne organise un débat sur l'impact de la télévision dans l’éducation des enfants.",
            'consigne' => "Écris un message pour donner ton opinion, avec des exemples personnels. L’IA discutera avec toi sur tes idées sans te conseiller.",
        ],
        [
            'numero_tache' => 3,
            'contexte_texte' => "Ton école souhaite organiser davantage de sorties pédagogiques, mais certains parents ne sont pas convaincus.",
            'consigne' => "Écris une lettre pour expliquer les avantages de ces sorties et convaincre les parents. L’IA te posera des questions sur tes arguments.",
        ],
        [
            'numero_tache' => 1,
            'contexte_texte' => "Une discussion est lancée sur les réseaux sociaux sur l'importance de faire de longues études.",
            'consigne' => "Exprime ton point de vue en illustrant avec ton parcours ou celui de ton entourage. L’IA débattra avec toi sans faire de suggestions.",
        ],
        [
            'numero_tache' => 2,
            'contexte_texte' => "Ton université propose un sondage sur la relation entre les diplômes et la réussite professionnelle.",
            'consigne' => "Partage ton opinion avec des exemples. L’IA te posera des questions sur ta vision du succès.",
        ],
        [
            'numero_tache' => 3,
            'contexte_texte' => "Dans certaines écoles, des matières culturelles sont supprimées pour se concentrer sur les matières scientifiques.",
            'consigne' => "Écris un texte d’opinion pour dire si tu es pour ou contre, avec des arguments. L’IA interagira avec toi sur ta position.",
        ],
        [
            'numero_tache' => 1,
            'contexte_texte' => "Un débat est organisé dans ton université sur l’accessibilité aux études supérieures pour tous.",
            'consigne' => "Exprime ton avis dans un message et propose des pistes d’amélioration. L’IA échangera avec toi sur tes propositions.",
        ],
        [
            'numero_tache' => 3,
            'contexte_texte' => "Tu travailles à mi-temps tout en poursuivant tes études.",
            'consigne' => "Écris un texte pour parler des avantages et inconvénients de cette situation. L’IA discutera avec toi en fonction de ton vécu.",
        ],


        ];

        foreach ($taches as $tache) {
            ExpressionEcrite::create($tache);
        }
    }
}



