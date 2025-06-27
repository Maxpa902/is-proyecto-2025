<?php

namespace Database\Seeders;

use App\Models\EstadoUsuario;
use App\Models\Usuario;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsuariosSeeder extends Seeder
{
    public function run(): void
    {
        // Obtener estado activo
        $estadoActivo = EstadoUsuario::where('nombre', 'Activo')->first();

        if (! $estadoActivo) {
            $this->command->error('Estado "Activo" no encontrado. Ejecuta EstadosUsuarioSeeder primero.');

            return;
        }

        // Crear usuario Cliente
        $cliente = Usuario::create(
            [
                'id_estado_usuario' => $estadoActivo->id,
                'dni' => '12345678',
                'nombre' => 'María',
                'apellido' => 'González',
                'email' => 'cliente@natatorio.com',
                'password' => Hash::make('password123'),
                'altura' => 165.50,
                'peso' => 62.30,
                'telefono' => '+54 297 461-4567',
                'sexo' => 'F',
                'fecha_nacimiento' => '2000-03-15',
                'fecha_registro' => now()->toDateString(),
            ]
        );

        // Asignar rol cliente
        $cliente->assignRole('cliente');

        // Crear usuario Recepcionista
        $recepcionista = Usuario::create(
            [
                'id_estado_usuario' => $estadoActivo->id,
                'dni' => '87654321',
                'nombre' => 'Carlos',
                'apellido' => 'Rodríguez',
                'email' => 'recepcionista@natatorio.com',
                'password' => Hash::make('password123'),
                'altura' => 178.00,
                'peso' => 75.50,
                'telefono' => '+54 297 487-6543',
                'sexo' => 'M',
                'fecha_nacimiento' => '1995-11-22',
                'fecha_registro' => now()->toDateString(),
            ]
        );

        // Asignar rol recepcionista
        $recepcionista->assignRole('recepcionista');

        for ($i = 0; $i < 10; $i++) {
            /**
             * @var Usuario $usuario
             */
            $usuario = Usuario::factory()->create();
            $usuario->assignRole('cliente');
        }

        $this->command->info('✅ Usuarios de ejemplo creados exitosamente:');
    }

}
