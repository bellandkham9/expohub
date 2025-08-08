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
                'skill' => 'expression orale',
                'contexte' => "Un ami te demande ton avis sur l'utilisation des téléphones portables en classe.",
                'consigne' => "Exprime ton opinion de manière claire et donne au moins deux arguments.",
            ],
            [
                'type' => 'tcf-quebec',
                'numero' => 2,
                'skill' => 'expression orale',
                'contexte' => "Tu participes à un débat sur la place de la télévision dans l’éducation des enfants.",
                'consigne' => "Parle de ton point de vue et donne des exemples précis pour soutenir tes idées.",
            ],
            [
                'type' => 'tcf-canada',
                'numero' => 3,
                'skill' => 'expression orale',
                'contexte' => "Ton professeur veut savoir si les sorties pédagogiques sont utiles.",
                'consigne' => "Donne ton avis avec des exemples concrets. Tu peux parler d’une expérience personnelle.",
            ],
            [
                'type' => 'tcf-quebec',
                'numero' => 1,
                'skill' => 'expression orale',
                'contexte' => "Un étudiant se demande s’il doit faire de longues études.",
                'consigne' => "Conseille-le en exprimant ton opinion, avec des avantages et des inconvénients.",
            ],
            [
                'type' => 'tcf-canada',
                'numero' => 2,
                'skill' => 'expression orale',
                'contexte' => "Une émission radio discute du lien entre les diplômes et le succès professionnel.",
                'consigne' => "Donne ton avis en citant des exemples ou des expériences autour de toi.",
            ],
            [
                'type' => 'tcf-quebec',
                'numero' => 3,
                'skill' => 'expression orale',
                'contexte' => "Tu participes à une réunion scolaire où on parle des matières culturelles comme l’art ou la musique.",
                'consigne' => "Exprime ton point de vue : sont-elles importantes ou non ? Justifie ta réponse.",
            ],
            [
                'type' => 'tcf-canada',
                'numero' => 1,
                'skill' => 'expression orale',
                'contexte' => "Une étudiante étrangère te demande si l’université est accessible à tous au Canada.",
                'consigne' => "Donne ton opinion et parle des obstacles possibles selon toi.",
            ],
            [
                'type' => 'tcf-quebec',
                'numero' => 3,
                'skill' => 'expression orale',
                'contexte' => "Ton collègue travaille à temps plein et fait aussi des études.",
                'consigne' => "Parle des difficultés et des avantages de cette situation. Donne ton opinion personnelle.",
            ],

        ];

        foreach ($questions as $question) {
            ExpressionOrale::create($question);
        }
    }
}
