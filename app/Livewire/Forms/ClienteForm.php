<?php

namespace App\Livewire\Forms;

use App\Models\EstadoUsuario;
use App\Models\Usuario;
use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Livewire\Form;

class ClienteForm extends Form
{
    public ?Usuario $usuario = null;
    public ?int $usuarioId = null;
    public string $nombre = '';
    public string $apellido = '';
    public string $dni = '';
    public string $nacimiento = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';
    public ?string $telefono = null;
    public ?string $sexo = null;
    public ?int $altura = null;
    public ?int $peso = null;

    /**
     * Registrar un nuevo usuario en la base de datos.
     *
     * @throws ValidationException
     */
    public function crearCliente(): Usuario
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
            'telefono' => $this->telefono,
            'sexo' => $this->sexo,
            'altura' => $this->altura,
            'peso' => $this->peso,
        ])));
        $user->assignRole('cliente');

        return $user;
    }

    public function setCliente(Usuario $usuario): void
    {
        $this->usuarioId = $usuario->id;
        $this->nombre = $usuario->nombre;
        $this->apellido = $usuario->apellido;
        $this->dni = $usuario->dni;
        $this->nacimiento = $usuario->fecha_nacimiento?->format('Y-m-d');
        $this->email = $usuario->email;
        $this->telefono = $usuario->telefono;
        $this->sexo = $usuario->sexo;
        $this->altura = $usuario->altura;
        $this->peso = $usuario->peso;
    }
    public function actualizarCliente(Usuario $usuario): Usuario
    {
        $usuario->update([
            'nombre' => $this->nombre,
            'apellido' => $this->apellido,
            'dni' => $this->dni,
            'fecha_nacimiento' => $this->nacimiento,
            'email' => $this->email,
            'telefono' => $this->telefono,
            'sexo' => $this->sexo,
            'altura' => $this->altura,
            'peso' => $this->peso,
        ]);

        return $usuario;
    }

    public function rules(): array
    {
        $minDate = Carbon::now()->subYears(90)->format('Y-m-d');
        $maxDate = Carbon::now()->subYears(18)->format('Y-m-d');
        $usuarioId = $this->usuarioId ?? 'NULL';

        return [
            'nombre' => 'required|string|max:50',
            'apellido' => 'required|string|max:50',
            'dni' => 'required|digits:8|unique:usuarios,dni,' . $usuarioId . ',id',
            'nacimiento' => "required|date|after:$minDate|before:$maxDate",
            'email' => 'required|email|unique:usuarios,email,' . $usuarioId . ',id',
            'password' => $usuarioId ? 'nullable|string|min:8|confirmed' : 'required|string|min:8|confirmed',
            'password_confirmation' => $usuarioId ? 'nullable|string|min:8' : 'required|string|min:8',

            'telefono' => ['nullable', 'string', 'max:20', 'regex:/^[+0-9()\s\-]{7,20}$/'],
            'sexo' => 'nullable|in:' . implode(',', Usuario::SEXOS_VALIDOS),
            'altura' => 'nullable|integer|min:100|max:250',
            'peso' => 'nullable|integer|min:30|max:200',
        ];
    }
}
