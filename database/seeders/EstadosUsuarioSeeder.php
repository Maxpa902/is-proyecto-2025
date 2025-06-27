<?php

namespace Database\Seeders;

use App\Models\EstadoUsuario;
use Illuminate\Database\Seeder;

class EstadosUsuarioSeeder extends Seeder
{
    public function run(): void
    {
        $estados = [
            [
                'nombre' => 'Activo',
            ],
            [
                'nombre' => 'Inactivo',
            ],
        ];

        foreach ($estados as $estado) {
            EstadoUsuario::create($estado);
        }

        $this->command->info('Estados de usuario creados exitosamente');
    }
}
