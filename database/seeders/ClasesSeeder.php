<?php

namespace Database\Seeders;

use App\Models\Actividad;
use App\Models\Clase;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClasesSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('es_AR');

        DB::transaction(function () use ($faker) {
            $actividad = Actividad::find(id: 1);

            if (! $actividad) {
                $this->command->error('No se encontró la actividad con ID 1');

                return;
            }

            // Configuración de clases variadas
            $clasesData = [
                [
                    'hora_inicio' => '08:00',
                    'hora_fin' => '09:00',
                    'lugar' => 'Piscina 1',
                    'capacidad_maxima' => 20,
                    'dias' => [1, 3, 5], // Lunes, Miércoles, Viernes
                ],
                [
                    'hora_inicio' => '09:00',
                    'hora_fin' => '10:00',
                    'lugar' => 'Piscina 1',
                    'capacidad_maxima' => 20,
                    'dias' => [1, 3, 5], // Lunes, Miércoles, Viernes
                ],
                [
                    'hora_inicio' => '10:00',
                    'hora_fin' => '11:00',
                    'lugar' => 'Piscina 2',
                    'capacidad_maxima' => 15,
                    'dias' => [2, 4, 6], // Martes, Jueves, Sábado
                ],
                [
                    'hora_inicio' => '17:00',
                    'hora_fin' => '18:00',
                    'lugar' => 'Piscina 1',
                    'capacidad_maxima' => 20,
                    'dias' => [1, 3, 5], // Lunes, Miércoles, Viernes
                ],
                [
                    'hora_inicio' => '18:00',
                    'hora_fin' => '19:00',
                    'lugar' => 'Piscina 2',
                    'capacidad_maxima' => 15,
                    'dias' => [2, 4], // Martes, Jueves
                ],
                [
                    'hora_inicio' => '19:00',
                    'hora_fin' => '20:00',
                    'lugar' => 'Piscina 1',
                    'capacidad_maxima' => 20,
                    'dias' => [1, 3, 5], // Lunes, Miércoles, Viernes
                ],
            ];

            foreach ($clasesData as $claseData) {
                $datos = [
                    'id_actividad' => $actividad->id,
                    'hora_inicio' => $claseData['hora_inicio'],
                    'hora_fin' => $claseData['hora_fin'],
                    'capacidad_maxima' => $claseData['capacidad_maxima'],
                    'estado' => Clase::ESTADO_ACTIVA,
                    'nombre_completo_profesor' => $faker->name,
                    'lugar' => $claseData['lugar'],
                ];

                $actividad->crearClase($datos, $claseData['dias']);
            }
        });

        $this->command->info('6 clases creadas con éxito para la actividad 1');
    }
}
