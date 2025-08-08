<?php

// database/seeders/ComprehensionEcriteSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ComprehensionEcrite;

class ComprehensionEcriteSeeder extends Seeder
{
    public function run()
    {

$questions =[
    [
        'numero' => 40,
        'situation' => "Situation 40 : Vous lisez une annonce concernant un chat gris avec un collier jaune qui a disparu.",
        'question' => "Qu'est-ce que Stéphanie cherche ?",
        'propositions' => ['Un animal.', 'Un bijou.', 'Un sac.', 'Un téléphone.'],
        'reponse' => 'A'
    ],
    [
        'numero' => 41,
        'situation' => "Situation 41 : Vous regardez une affiche pour une pièce de théâtre intitulée 'Le Rhinocéros'.",
        'question' => "Que présente l’affiche ?",
        'propositions' => ['Un cours.', 'Une fête.', 'Un match.', 'Un spectacle.'],
        'reponse' => 'D'
    ],
    [
        'numero' => 42,
        'situation' => "Situation 42 : Vous lisez un conseil de 'Vie pratique' sur la consommation de fruits et légumes.",
        'question' => "Que permet le conseil de « Vie pratique » ?",
        'propositions' => ['De faire des économies.', 'De pratiquer un sport.', 'De rester en bonne santé.', 'De trouver des produits bio.'],
        'reponse' => 'C'
    ],
    [
        'numero' => 43,
        'situation' => "Situation 43 : Vous lisez un message d'Emma demandant de l'aide pour son anniversaire.",
        'question' => "Qu’est-ce qu’Emma demande à Jean-Eudes ?",
        'propositions' => ['De choisir une salle pour la fête.', 'De s’occuper de la décoration.', 'De trouver un bon restaurant.', 'D’organiser son anniversaire chez lui.'],
        'reponse' => 'B'
    ],
    [
        'numero' => 44,
        'situation' => "Situation 44 : Vous lisez un message d'Ariane demandant à rencontrer Françoise.",
        'question' => "Pourquoi Ariane écrit-elle ce message ?",
        'propositions' => ['Elle doit partir une journée.', 'Elle propose un déjeuner.', 'Elle souhaite parler à Françoise.', 'Elle veut visiter une entreprise.'],
        'reponse' => 'C'
    ],
    [
        'numero' => 45,
        'situation' => "Situation 45 : Vous lisez une publicité pour une société appelée Airplus.",
        'question' => "Que propose la société Airplus ?",
        'propositions' => ['Des avions.', 'Des jeux.', 'Des stages.', 'Des statistiques.'],
        'reponse' => 'C'
    ],
    [
        'numero' => 46,
        'situation' => "Situation 46 : Vous lisez une proposition pour devenir reporter pour un mensuel.",
        'question' => "Qui a écrit cette proposition ?",
        'propositions' => ['Un journal.', 'Un restaurant.', 'Une association.', 'Une école.'],
        'reponse' => 'A'
    ],
    [
        'numero' => 47,
        'situation' => "Situation 47 : Vous lisez un message informant M. Giannorsi que sa commande est arrivée à La Poste.",
        'question' => "Qu’est-ce que M. Giannorsi doit faire ?",
        'propositions' => ['Aller chercher un colis.', 'Échanger son achat.', 'Envoyer une lettre.', 'Réserver son article.'],
        'reponse' => 'A'
    ],
    [
        'numero' => 48,
        'situation' => "Situation 48 : Vous lisez un texte sur les Français et leurs animaux de compagnie.",
        'question' => "Qu’apprend-on sur les Français et les animaux ?",
        'propositions' => ['Ils aiment en voir dans la nature.', 'Ils les regardent à la télévision.', 'Ils sont nombreux à en avoir.', 'Ils vont les voir dans des zoos.'],
        'reponse' => 'C'
    ],
    [
        'numero' => 49,
        'situation' => "Situation 49 : Vous lisez un avis sur un documentaire traitant de l'alimentation.",
        'question' => "Quel est le thème du documentaire ?",
        'propositions' => ['L’alimentation.', 'L’éducation.', 'La cuisine.', 'Le commerce.'],
        'reponse' => 'A'
    ],
    [
        'numero' => 50,
        'situation' => "Situation 50 : Vous lisez un message d'Anne demandant à Pierre d'acheter du pain et du fromage.",
        'question' => "Que doit faire Pierre ?",
        'propositions' => ['Aller chercher Anne.', 'Faire des courses.', 'Préparer le repas.', 'Se coucher tôt.'],
        'reponse' => 'B'
    ],
    [
        'numero' => 51,
        'situation' => "Situation 51 : Vous lisez un article sur l'événement 'Avenir Jeunesse' organisé par les écoles de commerce.",
        'question' => "Quel était le but de l’événement « Avenir Jeunesse » ?",
        'propositions' => ['Accueillir les étudiants étrangers.', 'Faciliter la recherche d’emploi.', 'Préparer la rentrée universitaire.', 'Présenter de nouvelles formations.'],
        'reponse' => 'B'
    ],
    [
        'numero' => 52,
        'situation' => "Situation 52 : Vous lisez une annonce proposant une chambre à louer à un étudiant.",
        'question' => "Qu’est-ce qui est proposé dans cette annonce ?",
        'propositions' => ['Un échange de maison.', 'Un studio en centre-ville.', 'Une chambre chez l’habitant.', 'Une colocation entre étudiants.'],
        'reponse' => 'C'
    ],
    [
        'numero' => 53,
        'situation' => "Situation 53 : Vous lisez une lettre informant qu'une facture de téléphone est disponible en ligne.",
        'question' => "Que peut faire la personne qui reçoit cette lettre ?",
        'propositions' => ['Changer d’abonnement.', 'Choisir un appareil.', 'Payer une commande.', 'Vérifier sa consommation.'],
        'reponse' => 'D'
    ],
    [
        'numero' => 54,
        'situation' => "Situation 54 : Vous lisez une annonce concernant des perturbations sur la ligne 25.",
        'question' => "Qu'est-ce qui est annoncé ?",
        'propositions' => ["Des pannes d'autobus.", 'Des travaux sur la ligne.', 'Un accident de circulation.', 'Une grève des transports.'],
        'reponse' => 'B'
    ],
    [
        'numero' => 55,
        'situation' => "Situation 55 : Vous lisez un texte faisant la promotion d'un lieu d'accueil dans le Haut-Rhin.",
        'question' => "De quoi le texte fait-il la publicité ?",
        'propositions' => ['D’un lieu d’accueil.', 'D’un monument historique.', 'D’une épicerie familiale.', 'D’un restaurant traditionnel.'],
        'reponse' => 'A'
    ],
    [
        'numero' => 56,
        'situation' => "Situation 56 : Vous lisez un article sur les activités extrascolaires des enfants.",
        'question' => "Qu’est-ce qui incite les parents à inscrire leurs enfants à des activités sportives ?",
        'propositions' => ['La pression de la société.', 'La réputation des clubs.', 'Les bienfaits pour la santé.', 'Les envies des adolescents.'],
        'reponse' => 'A'
    ],
    [
        'numero' => 57,
        'situation' => "Situation 57 : Vous lisez un article sur les bienfaits de la lecture.",
        'question' => "Que démontre l’auteur de cet article à propos de la lecture ?",
        'propositions' => ['C’est une activité qui enrichit l’imagination.', 'Elle permet d’améliorer ses performances.', 'Il est difficile de s’y livrer si on est angoissé.', 'Sa pratique exige des connaissances variées.'],
        'reponse' => 'B'
    ],
    [
        'numero' => 58,
        'situation' => "Situation 58 : Vous lisez une critique du film 'Normandie nue'.",
        'question' => "Quelle est l’opinion du journaliste sur le film « Normandie nue » ?",
        'propositions' => ['Il est facile de s’identifier aux personnages.', 'Les lieux de tournage sont authentiques.', 'On y dresse un portrait juste de la société.', 'Son humour fait passer un message sérieux.'],
        'reponse' => 'D'
    ],
    [
        'numero' => 59,
        'situation' => "Situation 59 : Vous lisez une description de la série télévisée 'Parents mode d'emploi'.",
        'question' => "Quel est l’objectif de cette série télévisée ?",
        'propositions' => ['Informer sur de nouvelles méthodes éducatives.', 'Montrer la vie de tous les jours d’un jeune couple.', 'Présenter les relations familiales avec humour.', 'Proposer des solutions à des situations de crise.'],
        'reponse' => 'C'
    ],
    [
        'numero' => 60,
        'situation' => "Situation 60 : Vous lisez une annonce pour une activité de maquillage pendant les vacances de Pâques.",
        'question' => "Quelle activité proposera-t-on aux enfants pendant les vacances de Pâques ?",
        'propositions' => ['Un spectacle de cirque.', 'Une activité de maquillage.', 'Une rencontre avec un clown.', 'Une sortie au zoo.'],
        'reponse' => 'B'
    ],
    [
        'numero' => 61,
        'situation' => "Situation 61 : Vous lisez un article sur une députée proposant un décret concernant les photos retouchées.",
        'question' => "Que propose cette députée à propos des publicités mettant en scène des femmes ?",
        'propositions' => ['D’interdire les photos portant atteinte à leur dignité.', 'De diversifier le type de femmes prises pour modèles.', 'De mentionner les références précises des produits.', 'De signaler sur les photos les modifications effectuées.'],
        'reponse' => 'D'
    ],
    [
        'numero' => 62,
        'situation' => "Situation 62 : Vous lisez un article sur l'évolution du camping comme mode d'hébergement touristique.",
        'question' => "Que constate l'expert à propos du camping ?",
        'propositions' => ['Le confort a été très nettement amélioré.', 'Le mode d’hébergement est écologique.', 'Les prestations proposées sont inédites.', 'Les prix deviennent de plus en plus attractifs.'],
        'reponse' => 'A'
    ],
    [
        'numero' => 63,
        'situation' => "Situation 63 : Vous lisez un article sur les mesures prises par les grandes surfaces pour réduire le gaspillage alimentaire.",
        'question' => "Selon cet article, quel type d’action faudrait-il poursuivre ?",
        'propositions' => ['De nouvelles pratiques de vente.', 'Des comportements d’achat différents.', 'Des habitudes alimentaires saines.', 'Des modes de recyclage innovants.'],
        'reponse' => 'A'
    ],
    [
        'numero' => 64,
        'situation' => "Situation 64 : Vous lisez un courrier de Marco Leno se plaignant de nuisances sonores.",
        'question' => "Quel est l’objet de ce courrier ?",
        'propositions' => ['C’est un dépôt de plainte destiné aux services de police.', 'C’est une lettre de menace destinée à des voisins bruyants.', 'C’est une mise en demeure destinée à un propriétaire.', 'C’est une réclamation destinée au gérant d’un immeuble.'],
        'reponse' => 'D'
    ],
    [
        'numero' => 65,
        'situation' => "Situation 65 : Vous lisez un article sur les nouvelles orientations des grandes écoles de management.",
        'question' => "D'après ce texte, quelle est la nouvelle orientation des grandes écoles ?",
        'propositions' => ['Créer des partenariats avec le milieu associatif.', 'Former des jeunes défavorisés au management.', 'Intégrer des valeurs sociales et environnementales.', 'Préparer des techniciens aux dangers de la finance.'],
        'reponse' => 'C'
    ],
    [
        'numero' => 66,
        'situation' => "Situation 66 : Vous lisez un article sur la brigade italienne chargée de traquer les imitations alimentaires.",
        'question' => "Quel est l’objectif de cette brigade spéciale ?",
        'propositions' => ['Contrôler la qualité sanitaire des fromages.', 'Empêcher le trafic des fromages de contrebande.', 'Enquêter sur les vols de fromages de luxe.', 'Protéger les secrets d’élaboration des fromages.'],
        'reponse' => 'D'
    ],
    [
        'numero' => 67,
        'situation' => "Situation 67 : Vous lisez un article sur la pollution sonore sous-marine.",
        'question' => "De quoi est-il question dans cet article ?",
        'propositions' => ['D’un moyen de communication inédit.', 'D’un système de guidage par ondes.', 'D’une innovation technologique.', 'D’une pollution imperceptible.'],
        'reponse' => 'D'
    ],
    [
        'numero' => 68,
        'situation' => "Situation 68 : Vous lisez un extrait décrivant le comportement des acheteurs dans un magasin.",
        'question' => "Dans cet extrait, qu’apprend-on sur les acheteurs ?",
        'propositions' => ['Ils donnent l’impression de vénérer les produits.', 'Ils ont l’air éblouis par le gigantisme des magasins.', 'Ils paraissent manipulés par une force supérieure.', 'Ils semblent perdus dans le labyrinthe des rayons.'],
        'reponse' => 'A'
    ],
    [
        'numero' => 69,
        'situation' => "Situation 69 : Vous lisez un article sur le succès du chef Paul Bocuse.",
        'question' => "D’après ce journaliste, quelle a été la clé du succès de Paul Bocuse ?",
        'propositions' => ['Sa connaissance des médias.', 'Ses méthodes ancestrales.', 'Ses recettes originales.', 'Son charisme incroyable.'],
        'reponse' => 'D'
    ],
    [
        'numero' => 70,
        'situation' => "Situation 70 : Vous lisez un article sur les stratégies des plateformes de streaming.",
        'question' => "D’après l’article, que privilégient les plateformes de streaming ?",
        'propositions' => ['La longévité des programmes.', 'La qualité des services offerts.', 'Le changement régulier des séries.', 'Le contentement de leurs abonnés.'],
        'reponse' => 'C'
    ],
    [
        'numero' => 71,
        'situation' => "Situation 71 : Vous lisez un article sur le rôle des enseignants à l'ère du numérique.",
        'question' => "Selon Marcel Gauchet, quel va être le rôle de l’enseignant auprès des élèves ?",
        'propositions' => ['Développer leur esprit critique.', 'Encourager les débats entre eux.', 'Enrichir leur capacité mémorielle.', 'Évaluer régulièrement leurs acquis.'],
        'reponse' => 'A'
    ],
    [
        'numero' => 72,
        'situation' => "Situation 72 : Vous lisez un article sur les néo-nomades vivant dans des camions ou des cars scolaires transformés.",
        'question' => "Selon le journaliste, quelle est l’origine du néo-nomadisme ?",
        'propositions' => ['L’attirance pour les espaces naturels.', 'L’insécurité des zones urbaines.', 'La précarité du monde professionnel.', 'Le désir de vivre en communauté.'],
        'reponse' => 'C'
    ],
    [
        'numero' => 73,
        'situation' => "Situation 73 : Vous lisez une description d'une exposition d'art contemporain.",
        'question' => "Qu’est-ce qui fait la singularité de cette exposition ?",
        'propositions' => ['La liberté accordée aux visiteurs.', 'La simplicité des moyens artistiques.', 'Le classicisme de sa présentation.', 'Le discours politique des plasticiens.'],
        'reponse' => 'A'
    ],
    [
        'numero' => 74,
        'situation' => "Situation 74 : Vous lisez un article sur la perception de la mobilité territoriale par les Français.",
        'question' => "Quand une mobilité territoriale est-elle bien vécue ?",
        'propositions' => ['Si c’est une occasion d’élargir son réseau social.', 'Si c’est une opportunité de changer de mode de vie.', 'Si c’est la possibilité de trouver un emploi.', 'Si c’est le fruit d’une décision personnelle.'],
        'reponse' => 'D'
    ],
    [
        'numero' => 75,
        'situation' => "Situation 75 : Vous lisez un article sur l'introduction d'un grand oral au baccalauréat.",
        'question' => "Selon l’auteur, quel est l’intérêt d’une épreuve orale au baccalauréat ?",
        'propositions' => ['Elle favorise l’égalité des chances.', 'Elle prépare à la vie professionnelle.', 'Elle remplace l’évaluation continue.', 'Elle simplifie le travail des enseignants.'],
        'reponse' => 'A'
    ],
    [
        'numero' => 76,
        'situation' => "Situation 76 : Vous lisez un article sur le nouveau modèle universitaire proposé par l'université de Nantes.",
        'question' => "Quel est l’objectif de cette université ?",
        'propositions' => ['Attirer davantage d’étudiants brillants.', 'Être à la pointe de la technologie.', 'Ouvrir ses cours à un public élargi.', 'Proposer des disciplines inédites.'],
        'reponse' => 'C'
    ],
    [
        'numero' => 77,
        'situation' => "Situation 77 : Vous lisez un article sur les effets de la lumière naturelle sur l'organisme.",
        'question' => "Sur quoi insiste l’auteur de cet article ?",
        'propositions' => ['L’importance des agencements intérieurs.', 'L’insuffisance des plages de repos.', 'Les bienfaits d’un éclairage électrique optimal.', 'Les effets du surmenage sur la santé.'],
        'reponse' => 'A'
    ],
    [
        'numero' => 78,
        'situation' => "Situation 78 : Vous lisez une critique sur une série de courts-métrages inspirés de l'œuvre de Paul Éluard.",
        'question' => "Selon cette critique, quel est l’apport de ce dernier ensemble de courts-métrages ?",
        'propositions' => ['Il constitue une création artistique novatrice.', 'Il établit des ponts avec d’autres auteurs.', 'Il fait connaître les travaux d’un écrivain.', 'Il ouvre la voie à de prochaines réalisations.'],
        'reponse' => 'C'
    ]
    ];
        
     foreach ($questions as $question) {
            ComprehensionEcrite::create($question);
        }   
    
    }

}

