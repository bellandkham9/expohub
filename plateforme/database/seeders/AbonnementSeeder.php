<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // N'oubliez pas d'importer la façade DB

class AbonnementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = now(); // Obtient l'heure actuelle pour created_at et updated_at

        // Insertion des données dans la table 'abonnements'
        DB::table('abonnements')->insert([
            [
                'nom_du_plan' => 'Annuel Premium',
                'examen' => 'TCF', // Corresponds à 'type_dexamen' de votre ancien seeder
                'prix' => 99.99,
                'duree' => 365, // Nouveau champ 'duree'
                'description' => 'Accès complet à toutes les ressources de préparation au TCF pendant un an.', // Nouveau champ 'description'
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'nom_du_plan' => 'Mensuel Basique',
                'examen' => 'DELF',
                'prix' => 19.99,
                'duree' => 30,
                'description' => 'Accès limité aux ressources de préparation au DELF pendant un mois.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'nom_du_plan' => 'Essai Découverte',
                'examen' => 'DALF',
                'prix' => 0.00,
                'duree' => 7,
                'description' => 'Accès gratuit aux fonctionnalités de base pendant 7 jours.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'nom_du_plan' => 'Trimestriel Intensif',
                'examen' => 'TEF',
                'prix' => 49.99,
                'duree' => 90,
                'description' => 'Préparation intensive au TEF sur trois mois avec support dédié.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}