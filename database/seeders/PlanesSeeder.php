<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Seeder;

class PlanesSeeder extends Seeder
{
    public function run(): void
    {
        $planes = [
            [
                'id_actividad' => 1,
                'precio_plan' => 35_000,
                'dias_acceso_actividad' => 30,
                'created_at' => now(),
                'updated_at' => now(),

            ],
            [
                'id_actividad' => 1,
                'precio_plan' => 60_000,
                'dias_acceso_actividad' => 60,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];
        Plan::insert($planes);

        $this->command->info('Planes creados éxitosamente:');
    }
}
