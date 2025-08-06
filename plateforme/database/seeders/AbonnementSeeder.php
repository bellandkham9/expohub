<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AbonnementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = now();
        \DB::table('abonnements')->insert([
            [
                'user_id' => 1,
                'nom_du_plan' => 'Annuel',
                'date_debut' => $now,
                'date_fin' => $now->copy()->addDays(365),
                'type_dexamen' => 'TCF',
                'prix' => 99.99,
                'statut' => 'actif',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'user_id' => 2,
                'nom_du_plan' => 'Mensuel',
                'date_debut' => $now,
                'date_fin' => $now->copy()->addDays(30),
                'type_dexamen' => 'DELF',
                'prix' => 19.99,
                'statut' => 'expiré',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'user_id' => 3,
                'nom_du_plan' => 'Essai',
                'date_debut' => $now,
                'date_fin' => $now->copy()->addDays(7),
                'type_dexamen' => 'DALF',
                'prix' => 0.00,
                'statut' => 'actif',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}
