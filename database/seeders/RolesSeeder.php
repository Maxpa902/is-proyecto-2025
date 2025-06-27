<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesSeeder extends Seeder
{
    public function run(): void
    {
        Role::firstOrCreate(['name' => 'cliente']);
        Role::firstOrCreate(['name' => 'recepcionista']);

        $this->command->info('✅ Roles creados exitosamente:');
        $this->command->info('   - cliente');
        $this->command->info('   - recepcionista');
    }
}
