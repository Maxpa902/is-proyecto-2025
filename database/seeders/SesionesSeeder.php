<?php

namespace Database\Seeders;

use App\Models\Clase;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class SesionesSeeder extends Seeder
{
    public function run(): void
    {
        // Configurar rango de fechas (3 meses desde hoy)
        $fechaInicio = Carbon::now()->startOfMonth()->format('Y-m-d');
        $fechaFin = Carbon::now()->addMonths(3)->endOfMonth()->format('Y-m-d');

        $this->command->info("Generando sesiones desde {$fechaInicio} hasta {$fechaFin}");

        // Obtener todas las clases activas con sus días
        $clases = Clase::with(['dias'])
            ->where('estado', Clase::ESTADO_ACTIVA)
            ->get();

        $totalSesiones = 0;

        foreach ($clases as $clase) {
            $sesionesCreadas = $clase->generarSesionesEnRango($fechaInicio, $fechaFin);
            $totalSesiones += $sesionesCreadas;

            $this->command->info("Clase {$clase->id} (Actividad {$clase->id_actividad}): {$sesionesCreadas} sesiones");
        }

        $this->command->info("Total de sesiones creadas: {$totalSesiones}");
    }
}
