<?php

namespace Tests\Feature\Auth;

use Carbon\Carbon;
use Livewire\Livewire;

test('registration screen can be rendered', function () {
    $response = $this->get('/registro');

    $response
        ->assertOk()
        ->assertSee('Registrarse');
});

test('new users can register', function () {
    Livewire::test('Registro')
        ->set('form.nombre', 'UsuarioPrueba')
        ->set('form.apellido', 'UsuarioPrueba')
        ->set('form.dni', '45252423')
        ->set('form.nacimiento', Carbon::now()->subYears(20)->format('Y-m-d')) // corregido
        ->set('form.email', 'UsuarioPrueba@email.com')
        ->set('form.password', 'UsuarioPrueba')
        ->set('form.password_confirmation', 'UsuarioPrueba') // agregado
        ->set('form.fecha_registro', Carbon::now()->format('Y-m-d'))
        ->set('form.id_estado_usuario', 1)
        ->call('registrar')
        ->assertHasNoErrors()
        ->assertRedirect(route('cliente.bienvenida', absolute: false));

    $this->assertAuthenticated();
});
