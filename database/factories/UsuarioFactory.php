<?php

namespace Database\Factories;

use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class UsuarioFactory extends Factory
{
    protected $model = Usuario::class;

    public function definition(): array
    {
        return [
            'id_estado_usuario' => 1,
            'dni' => $this->faker->unique()->numerify('########'),
            'nombre' => $this->faker->firstName(),
            'apellido' => $this->faker->lastName(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => Hash::make('password'),
            'altura' => $this->faker->randomFloat(2, 150, 200),
            'peso' => $this->faker->randomFloat(2, 50, 120),
            'telefono' => $this->faker->phoneNumber(),
            'sexo' => $this->faker->randomElement(Usuario::SEXOS_VALIDOS),
            'fecha_nacimiento' => $this->faker->date('Y-m-d', '2000-01-01'),
            'fecha_registro' => now(),
            'fecha_dado_baja' => null,
        ];
    }

    public function activo(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'fecha_dado_baja' => null,
            ];
        });
    }

    public function inactivo(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'fecha_dado_baja' => now(),
            ];
        });
    }

    public function masculino(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'sexo' => Usuario::SEXO_MASCULINO,
            ];
        });
    }

    public function femenino(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'sexo' => Usuario::SEXO_FEMENINO,
            ];
        });
    }
}
