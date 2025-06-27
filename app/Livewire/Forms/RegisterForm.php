<?php

namespace App\Livewire\Forms;

use App\Models\EstadoUsuario;
use App\Models\Usuario;
use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Livewire\Form;

class RegisterForm extends Form
{
    public string $nombre = '';
    public string $apellido = '';
    public string $dni = '';
    public string $nacimiento = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Registrar un nuevo usuario en la base de datos.
     *
     * @throws ValidationException
     */
    public function registrar(): Usuario
    {
        event(new Registered($user = Usuario::create([
            'nombre' => $this->nombre,
            'apellido' => $this->apellido,
            'dni' => $this->dni,
            'fecha_nacimiento' => $this->nacimiento,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'fecha_registro' => now(),
            'id_estado_usuario' => EstadoUsuario::ESTADO_ACTIVO['id'],
        ])));
        $user->assignRole('cliente');

        return $user;
    }

    public function rules(): array
    {
        $minDate = Carbon::now()->subYears(90)->format('Y-m-d');
        $maxDate = Carbon::now()->subYears(18)->format('Y-m-d');

        return [
            'nombre' => 'required|string|max:50',
            'apellido' => 'required|string|max:50',
            'dni' => 'required|digits:8|unique:usuarios,dni',
            'nacimiento' => "required|date|after:$minDate|before:$maxDate",
            'email' => 'required|email|unique:usuarios,email',
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required|string|min:8',
        ];
    }
}
