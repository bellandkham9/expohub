<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ComprehensionOrale;

class ComprehensionOraleSeeder extends Seeder
{
    public function run(): void
    {
        $questions = [
            // Partie 1 - Questions 1 à 6
              [
                'contexte_texte' => '1.png',
                'question_audio' => 'audios/1.mp3',
                'proposition_1' => 'Allez y, entrer',
                'proposition_2' => 'Assayez-vous, je vous en prie',
                'proposition_3' => "Fermer la porte s'il vous plait!",
                'proposition_4' => 'Merci pour ce café',
                'bonne_reponse' => '2' // A
            ],
            [
                'contexte_texte' => '2.png',
                'question_audio' => 'audios/2.mp3',
                'proposition_1' => 'A bientot, au plaisir de vous revoir',
                'proposition_2' => 'la programme est affiché sur la porte',
                'proposition_3' => 'Voici la salle pour prendre le petit déjeuné',
                'proposition_4' => 'Vous pouvez laisser vos bagages là',
                'bonne_reponse' => '4' // A
            ],
            [
                'contexte_texte' => 'Partie 1 - Compréhension Orale',
                'question_audio' => 'audios/3.mp3',
                'proposition_1' => 'A l"heure',
                'proposition_2' => 'A paris',
                'proposition_3' => 'A pied',
                'proposition_4' => 'A 8h',
                'bonne_reponse' => '3' // A
            ],
            [
                'contexte_texte' => 'Partie 1 - Compréhension Orale',
                'question_audio' => 'audios/4.mp3',
                'proposition_1' => 'Attends, je vais y aller',
                'proposition_2' => 'Laisse, je vais la réparer.',
                'proposition_3' => 'Regarde, je vais te montrer',
                'proposition_4' => 'Tiens, je vais lui demander',
                'bonne_reponse' => '3' // C
            ],
            [
                'contexte_texte' => 'Partie 1 - Compréhension Orale',
                'question_audio' => 'audios/5.mp3',
                'proposition_1' => 'Avec plaisir, je suis livre demain',
                'proposition_2' => "Bonne idée, j'adore la neige",
                'proposition_3' => "D'acord, je pars tout seul",
                'proposition_4' => 'Super, je connais bien cette ville',
                'bonne_reponse' => '1' // D
            ],
              [
                'contexte_texte' => 'Situation commerciale',
                'question_audio' => 'audios/6.mp3',
                'proposition_1' => "l'annulation d'un cour",
                'proposition_2' => "Le retard d'un professeur",
                'proposition_3' => "Les horaires d'un examen",
                'proposition_4' => "Un changement de salle",
                'bonne_reponse' => '1' // À confirmer
            ],
            
            // Question 15
            [
                'contexte_texte' => 'Expérience client',
                'question_audio' => 'audios/7.mp3',
                'proposition_1' => "C'est un jeune autheur",
                'proposition_2' => "il est en solde aujourd'hui",
                'proposition_3' => 'Je le trouve interressent',
                'proposition_4' => "Ma soeur me l'a offert",
                'bonne_reponse' => '1' // À confirmer
            ],
            
            // Question 16
            [
                'contexte_texte' => 'Recrutement',
                'question_audio' => 'audios/8.mp3',
                'proposition_1' => 'Ce sera parfait avec du riz',
                'proposition_2' => 'Ils sont content de venir',
                'proposition_3' => "Je m'occupe du dessert",
                'proposition_4' => "On peut manger au salon",
                'bonne_reponse' => '2' // À confirmer
            ],
            
            // Question 17
            [
                'contexte_texte' => 'Le goût des C2',
                'question_audio' => 'audios/9.mp3',
                'proposition_1' => "Acheter des médicaments",
                'proposition_2' => "Envoyer une lettre",
                'proposition_3' => "Prendre un transport",
                'proposition_4' => "Voir un film",
                'bonne_reponse' => '2' // À confirmer
            ],
            [
                'contexte_texte' => 'Partie 1 - Compréhension Orale',
                'question_audio' => 'audios/10.mp3',
                'proposition_1' => 'D\'arriver en retard.',
                'proposition_2' => 'D\'avoir une mauvaise note.',
                'proposition_3' => 'De manquer de temps.',
                'proposition_4' => 'De tomber malade.',
                'bonne_reponse' => '1' // A
            ],
            [
                'contexte_texte' => 'Partie 1 - Compréhension Orale',
                'question_audio' => 'audios/11.mp3',
                'proposition_1' => 'La communication avec ses clients.',
                'proposition_2' => 'La recherche d\'un nouveau travail.',
                'proposition_3' => 'L\'achat d\'un nouveau téléphone fixe.',
                'proposition_4' => 'L\'utilisation de son ordinateur portable.',
                'bonne_reponse' => '1' // A
            ],
            [
                'contexte_texte' => 'Partie 1 - Compréhension Orale',
                'question_audio' => 'audios/12.mp3',
                'proposition_1' => 'De cinéma.',
                'proposition_2' => 'De lecture.',
                'proposition_3' => 'De musique.',
                'proposition_4' => 'De théâtre.',
                'bonne_reponse' => '3' // C
            ],
            [
                'contexte_texte' => 'Partie 1 - Compréhension Orale',
                'question_audio' => 'audios/13.mp3',
                'proposition_1' => 'Pour annuler un achat.',
                'proposition_2' => 'Pour modifier une commande.',
                'proposition_3' => 'Pour réclamer un paquet.',
                'proposition_4' => 'Pour retourner un colis.',
                'bonne_reponse' => '2' // D
            ],
              [
                'contexte_texte' => 'Situation commerciale',
                'question_audio' => 'audios/14.mp3',
                'proposition_1' => "l'annulation d'un cour",
                'proposition_2' => "Le retard d'un professeur",
                'proposition_3' => "Les horaires d'un examen",
                'proposition_4' => "Un changement de salle",
                'bonne_reponse' => '1' // À confirmer
            ],
            
            // Question 15
            [
                'contexte_texte' => 'Expérience client',
                'question_audio' => 'audios/15.mp3',
                'proposition_1' => 'Elle passe ss congés dans la région',
                'proposition_2' => 'Elle réside là depuis son enfance',
                'proposition_3' => 'Elle travail dans le tourisme local',
                'proposition_4' => 'Elle vient participer à un concour local',
                'bonne_reponse' => '3' // À confirmer
            ],
            
            // Question 16
            [
                'contexte_texte' => 'Recrutement',
                'question_audio' => 'audios/16.mp3',
                'proposition_1' => 'La répartition des horaires',
                'proposition_2' => 'Le contact avec les élèves',
                'proposition_3' => 'Les activités pédagogiques',
                'proposition_4' => "L'organisation des leçons",
                'bonne_reponse' => '2' // À confirmer
            ],
            
            // Question 17
            [
                'contexte_texte' => 'Le goût des C2',
                'question_audio' => 'audios/17.mp3',
                'proposition_1' => "Confirmer la date d'entretien d'embauche",
                'proposition_2' => "Se renseigner sur les conditions de travail",
                'proposition_3' => "S'informer sur une formation professionnelle",
                'proposition_4' => "Vérifier si un courrier est bien arrivé",
                'bonne_reponse' => '1' // À confirmer
            ],
            [
                'contexte_texte' => 'Partie 1 - Compréhension Orale',
                'question_audio' => 'audios/18.mp3',
                'proposition_1' => 'Le prix élevé des produits.',
                'proposition_2' => 'Les délais pour être livrée.',
                'proposition_3' => 'Les difficultés en cas d\'échange.',
                'proposition_4' => 'Les tailles de vêtements différentes.',
                'bonne_reponse' => '3' // C
            ],
            [
                'contexte_texte' => 'Partie 1 - Compréhension Orale',
                'question_audio' => 'audios/19.mp3',
                'proposition_1' => 'Les conditions de recrutement sont plus difficiles aujourd\'hui.',
                'proposition_2' => 'Les étudiants ignorent le fonctionnement de l\'entreprise.',
                'proposition_3' => 'Les jeunes étaient préparés plus sérieusement dans le passé.',
                'proposition_4' => 'Les patrons actuels ont un degré d\'exigence trop élevé.',
                'bonne_reponse' => '3' // C
            ],

            // Le goût des C2 - Questions 20 à 29
            [
                'contexte_texte' => 'Le goût des C2',
                'question_audio' => 'audios/20.mp3',
                'proposition_1' => 'D\'acheter un roman.',
                'proposition_2' => 'D\'attendre son collègue.',
                'proposition_3' => 'De réserver un livre.',
                'proposition_4' => 'De revenir le lendemain.',
                'bonne_reponse' => '1' // A
            ],
            [
                'contexte_texte' => 'Le goût des C2',
                'question_audio' => 'audios/21.mp3',
                'proposition_1' => 'Il fait plus beau qu\'hier.',
                'proposition_2' => 'Il fait plus mauvais qu\'hier.',
                'proposition_3' => 'Il pleut plus qu\'hier.',
                'proposition_4' => 'Il y a moins de soleil qu\'hier.',
                'bonne_reponse' => '2' // B
            ],
            [
                'contexte_texte' => 'Le goût des C2',
                'question_audio' => 'audios/22.mp3',
                'proposition_1' => 'La diffusion d\'une langue qui exprime les nuances des sentiments.',
                'proposition_2' => 'La multiplication des actions pour la défense des droits de l\'homme.',
                'proposition_3' => 'La promotion d\'un moyen d\'échanges entre les différentes nationalités.',
                'proposition_4' => 'La reconnaissance d\'un patrimoine culturel unique par sa richesse.',
                'bonne_reponse' => '4' // D
            ],
            [
                'contexte_texte' => 'Le goût des C2',
                'question_audio' => 'audios/23.mp3',
                'proposition_1' => 'Elles entrent dans la vie active avant les jeunes garçons.',
                'proposition_2' => 'Elles se rebellent très vite face à l\'autorité familiale au quotidien.',
                'proposition_3' => 'Elles sont en désaccord avec leurs parents au sujet de leurs études.',
                'proposition_4' => 'Elles sont mieux préparées aux tâches de tous les jours.',
                'bonne_reponse' => '4' // D
            ],
            [
                'contexte_texte' => 'Le goût des C2',
                'question_audio' => 'audios/24.mp3',
                'proposition_1' => 'Découvrir une région de France.',
                'proposition_2' => 'Partir vivre sur la Côte d\'Azur.',
                'proposition_3' => 'Rejoindre son épouse dans le Sud.',
                'proposition_4' => 'Rendre visite à un ami français.',
                'bonne_reponse' => '1' // A
            ],
            [
                'contexte_texte' => 'Le goût des C2',
                'question_audio' => 'audios/25.mp3',
                'proposition_1' => 'Pour conserver le poisson.',
                'proposition_2' => 'Pour ranger leur matériel.',
                'proposition_3' => 'Pour se réchauffer.',
                'proposition_4' => 'Pour se reposer.',
                'bonne_reponse' => '3' // C
            ],
            [
                'contexte_texte' => 'Le goût des C2',
                'question_audio' => 'audios/26.mp3',
                'proposition_1' => 'Elle a arrêté d\'exercer sa profession.',
                'proposition_2' => 'Elle a décidé d\'enrichir son curriculum vitae.',
                'proposition_3' => 'Elle a obtenu un congé de longue durée.',
                'proposition_4' => 'Elle a réduit son nombre d\'heures de travail.',
                'bonne_reponse' => '4' // D
            ],
            [
                'contexte_texte' => 'Le goût des C2',
                'question_audio' => 'audios/27.mp3',
                'proposition_1' => 'Le jeu de l\'acteur.',
                'proposition_2' => 'Les dialogues.',
                'proposition_3' => 'La musique.',
                'proposition_4' => 'Le scénario.',
                'bonne_reponse' => '2' // B
            ],
            [
                'contexte_texte' => 'Le goût des C2',
                'question_audio' => 'audios/28.mp3',
                'proposition_1' => 'Elle a gardé des enfants dans une famille britannique.',
                'proposition_2' => 'Elle a passé son enfance dans un pays étranger.',
                'proposition_3' => 'Elle a suivi des études dans un lycée bilingue.',
                'proposition_4' => 'Elle a travaillé avec une institutrice américaine.',
                'bonne_reponse' => '2' // B
            ],
            [
                'contexte_texte' => 'Le goût des C2',
                'question_audio' => 'audios/29.mp3',
                'proposition_1' => 'D\'un appel à projets imaginaires.',
                'proposition_2' => 'D\'un examen de fin d\'études.',
                'proposition_3' => 'D\'un nouveau plan d\'urbanisme.',
                'proposition_4' => 'D\'une rénovation d\'un monument.',
                'bonne_reponse' => '3' // C
            ],

            // Questions 30 à 36
            [
                'contexte_texte' => 'Compréhension Orale - Suite',
                'question_audio' => 'audios/30.mp3',
                'proposition_1' => 'L\'attitude des touristes accélère sa dégradation.',
                'proposition_2' => 'Le financement des travaux d\'entretien est menacé.',
                'proposition_3' => 'Les autorités restaurent actuellement les vestiges.',
                'proposition_4' => 'L\'intérêt pour l\'architecture des lieux est en déclin.',
                'bonne_reponse' => '1' // A
            ],
            [
                'contexte_texte' => 'Compréhension Orale - Suite',
                'question_audio' => 'audios/31.mp3',
                'proposition_1' => 'C\'est un temps de découverte et d\'humanité.',
                'proposition_2' => 'C\'est une occasion de dépenser son énergie.',
                'proposition_3' => 'C\'est une opportunité d\'apprécier la solitude.',
                'proposition_4' => 'C\'est une possibilité quotidienne d\'évasion.',
                'bonne_reponse' => '1' // A
            ],
            [
                'contexte_texte' => 'Compréhension Orale - Suite',
                'question_audio' => 'audios/32.mp3',
                'proposition_1' => 'C\'est la reproduction d\'un café du siècle dernier.',
                'proposition_2' => 'Il contient un dépôt-vente de meubles design.',
                'proposition_3' => 'C\'est à la fois un restaurant et une galerie d\'art.',
                'proposition_4' => 'Il y organise un festival de musique électronique.',
                'bonne_reponse' => '3' // C
            ],
            [
                'contexte_texte' => 'Compréhension Orale - Suite',
                'question_audio' => 'audios/33.mp3',
                'proposition_1' => 'À comparer les étapes du clonage naturel et artificiel.',
                'proposition_2' => 'À observer l\'effet des activités humaines sur la nature.',
                'proposition_3' => 'À orienter la recherche en prenant la nature comme modèle.',
                'proposition_4' => 'À sensibiliser les hommes à respecter leur milieu naturel.',
                'bonne_reponse' => '3' // C
            ],
            [
                'contexte_texte' => 'Compréhension Orale - Suite',
                'question_audio' => 'audios/34.mp3',
                'proposition_1' => 'Ils consomment plus que la jeune génération.',
                'proposition_2' => 'Ils dépensent beaucoup pour leur santé.',
                'proposition_3' => 'Ils profitent peu des effets de la croissance.',
                'proposition_4' => 'Ils sont à l\'origine de créations d\'emplois.',
                'bonne_reponse' => '4' // D
            ],
            [
                'contexte_texte' => 'Compréhension Orale - Suite',
                'question_audio' => 'audios/35.mp3',
                'proposition_1' => 'Ils dégagent une odeur agréable.',
                'proposition_2' => 'Ils ont des résultats spectaculaires.',
                'proposition_3' => 'Ils ont l\'avantage d\'être peu chers.',
                'proposition_4' => 'Ils répondent à ses convictions.',
                'bonne_reponse' => '4' // D
            ],
            [
                'contexte_texte' => 'Compréhension Orale - Suite',
                'question_audio' => 'audios/36.mp3',
                'proposition_1' => 'C\'est aux parents de choisir pour leurs enfants.',
                'proposition_2' => 'Il faut l\'étendre à toutes les générations.',
                'proposition_3' => 'Le dispositif fonctionne bien tel qu\'il est.',
                'proposition_4' => 'L\'État doit l\'imposer à la population.',
                'bonne_reponse' => '2' // B
            ],
              [
                'contexte_texte' => 'Compréhension Orale - Complément',
                'question_audio' => 'audios/37.mp3',
                'proposition_1' => 'La relation liant Camille Claudel et Rodin.',
                'proposition_2' => 'La richesse du musée Auguste Rodin.',
                'proposition_3' => 'Les difficultés rencontrées par Rodin.',
                'proposition_4' => 'Les sources d\'inspiration de Rodin.',
                'bonne_reponse' => '1' // A (à vérifier)
            ],
            [
                'contexte_texte' => 'Compréhension Orale - Complément',
                'question_audio' => 'audios/38.mp3',
                'proposition_1' => 'Elles demandent un nouveau statut juridique.',
                'proposition_2' => 'Elles exigent des garanties réelles et tangibles.',
                'proposition_3' => 'Elles mettent en doute la viabilité du projet.',
                'proposition_4' => 'Elles veulent que les terres restent intactes.',
                'bonne_reponse' => '2' // B (à vérifier)
            ],
            [
                'contexte_texte' => 'Compréhension Orale - Complément',
                'question_audio' => 'audios/39.mp3',
                'proposition_1' => 'Elle est régie par des normes internationales strictes.',
                'proposition_2' => 'Elle est réputée sans danger pour le milieu naturel.',
                'proposition_3' => 'Les inconvénients qu\'elle présente sont manifestes.',
                'proposition_4' => 'Les sociétés de production en exagèrent la rentabilité.',
                'bonne_reponse' => '3' // C (à vérifier)
            ]
        ];

        foreach ($questions as $question) {
            ComprehensionOrale::create($question);
        }
    }
}