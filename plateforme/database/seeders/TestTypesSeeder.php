<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TestType;

class TestTypesSeeder extends Seeder
{
    public function run()
    {
        $types = [
            ['nom' => 'tcf_canada', 'description' => 'description TCF Canada'],
            ['nom' => 'tcf_quebec', 'description' => 'description TCF Québec'],
            ['nom' => 'delf', 'description' => 'description DELF'],
            ['nom' => 'dalf', 'description' => 'description DALF'],
            ['nom' => 'tef', 'description' => 'description TEF'],
        ];

        foreach ($types as $type) {
            TestType::updateOrCreate(['nom' => $type['nom']], $type);
        }
    }
}
