<?php

namespace Database\Seeders;

use App\Models\Actividad;
use Illuminate\Database\Seeder;

class ActividadesSeeder extends Seeder
{
    public function run(): void
    {
        Actividad::create([
            'nombre' => 'Natación con Profesor',
            'descripcion' => 'Clases de natacion para adultos con profesor',
            'estado' => Actividad::ESTADO_ACTIVA,
        ]);

        $this->command->info('Actividad creada con exito');
    }
}
