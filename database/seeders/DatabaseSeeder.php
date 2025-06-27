<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RolesSeeder::class,
            EstadosUsuarioSeeder::class,
            DiasSemanaSeeder::class,
            UsuariosSeeder::class,
            ActividadesSeeder::class,
            ClasesSeeder::class,
            PlanesSeeder::class,
            SuscripcionesSeeder::class,
            SesionesSeeder::class,
        ]);

        $this->command->info(' Todos los seeders ejecutados exitosamente');
    }
}
