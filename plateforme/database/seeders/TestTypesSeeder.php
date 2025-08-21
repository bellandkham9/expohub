<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TestType;

class TestTypesSeeder extends Seeder
{
    public function run()
    {
        $types = [
            ['examen' => 'TCF', 'description' => 'description TCF'],
            ['examen' => 'DELF', 'description' => 'description DELF Québec'],
            ['examen' => 'DALF', 'description' => 'description DALF'],
            ['examen' => 'TEF', 'description' => 'description TEF'],
        ];

        foreach ($types as $type) {
            TestType::updateOrCreate(['examen' => $type['examen']], $type);
        }
    }
}
