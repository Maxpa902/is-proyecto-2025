<?php

namespace Database\Seeders;

use App\Models\Plan;
use App\Models\Suscripcion;
use App\Models\Usuario;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class SuscripcionesSeeder extends Seeder
{
    public function run(): void
    {
        $plan = Plan::find(1);
        $cliente = Usuario::find(1);

        $fecha_hoy = Carbon::now();

        Suscripcion::create([
            'id_plan' => $plan->id,
            'id_usuario' => $cliente->id,
            'fecha_inicio' => $fecha_hoy->toDateString(),
            'fecha_fin' => $fecha_hoy->addDays($plan->dias_acceso_actividad)->toDateString(),
            'estado' => Suscripcion::ESTADO_ACTIVA,
        ]);

        $this->command->info('Suscripciones creadas éxitosamente:');
    }
}
