<?php

namespace Database\Seeders;

use App\Models\DiaSemana;
use Illuminate\Database\Seeder;

class DiasSemanaSeeder extends Seeder
{
    public function run(): void
    {
        $dias = [
            [
                'nombre' => 'lunes',
                'orden' => 1,
            ],
            [
                'nombre' => 'martes',
                'orden' => 2,
            ],
            [
                'nombre' => 'miercoles',
                'orden' => 3,
            ],
            [
                'nombre' => 'jueves',
                'orden' => 4,
            ],
            [
                'nombre' => 'viernes',
                'orden' => 5,
            ],
            [
                'nombre' => 'sabado',
                'orden' => 6,
            ],
            [
                'nombre' => 'domingo',
                'orden' => 7,
            ],
        ];

        foreach ($dias as $dia) {
            DiaSemana::create($dia);
        }

        $this->command->info('Días de la semana creados exitosamente');
    }
}
