<?php

use App\Models\Usuario;
use Livewire\Livewire;

test('login screen can be rendered', function () {
    $response = $this->get(route('iniciosesion'));

    $response
        ->assertOk()
        ->assertSee('Iniciar Sesión'); // O algún texto clave que esté en tu vista
});

test('users can authenticate using the login screen', function () {
    $user = Usuario::factory()->create([
        'password' => bcrypt('password'),
    ]);
    $user->assignRole('cliente');

    Livewire::test('InicioSesion') // nombre del componente, ej: LoginComponent.php → 'auth.login'
        ->set('form.email', $user->email)
        ->set('form.password', 'password')
        ->call('login')
        ->assertHasNoErrors()
        ->assertRedirect(route('cliente.bienvenida', absolute: false));

    $this->assertAuthenticatedAs($user);
});

test('users can not authenticate with invalid password', function () {
    $user = Usuario::factory()->create([
        'password' => bcrypt('password'),
    ]);

    Livewire::test('InicioSesion')
        ->set('form.email', $user->email)
        ->set('form.password', 'wrong-password')
        ->call('login')
        ->assertHasErrors()
        ->assertNoRedirect();

    $this->assertGuest();
});

test('navigation menu can be rendered', function () {
    $user = Usuario::factory()->create();
    $user->assignRole('cliente');

    $this->actingAs($user);

    $response = $this->get('/cliente/bienvenida');

    $response
        ->assertOk()
        ->assertSee('Horarios Semanales');
});

test('users can logout', function () {
    $user = Usuario::factory()->create();
    $user->assignRole('cliente');

    $this->actingAs($user);

    $response = $this->post(route('logout'));

    $response->assertRedirect('/');

    $this->assertGuest();
});
