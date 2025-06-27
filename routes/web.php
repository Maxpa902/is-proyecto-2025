<?php

use App\Http\Controllers\Auth\LogoutController;
use App\Livewire\Cliente\Perfil as PerfilCliente;
use App\Livewire\Cliente\Perfil\EditarPerfil;
use App\Livewire\Cliente\VistaCliente;
use App\Livewire\Inicio;
use App\Livewire\InicioSesion;
use App\Livewire\Recepcionista;
use App\Livewire\Recepcionista\Clases;
use App\Livewire\Recepcionista\Clientes;
use App\Livewire\Recepcionista\Perfil as PerfilRecepcionista;
use App\Livewire\Recepcionista\Planes;
use App\Livewire\Registro;
use Illuminate\Support\Facades\Route;

Route::get('/', Inicio::class)->name('inicio');

Route::view('componentes', 'probando-componentes');
Route::view('componentes2', 'componentes2');
Route::view('modal', 'modal');
Route::view('input', 'input');
Route::view('tabla', 'tabla');

Route::get('/vistaCliente', VistaCliente::class)->name('vistaCliente');

Route::post('/logout', LogoutController::class)->middleware(['auth'])->name('logout');

// Aca van las rutas de invitado
Route::middleware('guest')->group(function () {
    Route::get('iniciosesion', InicioSesion::class)->name('iniciosesion');

    Route::get('registro', Registro::class)
        ->name('registro');
});

Route::view('prueba', 'prueba');

// Aca van las rutas de autenticado y que sea cliente
Route::middleware(['auth', 'role:cliente'])->prefix('cliente')->group(function () {
    Route::get('bienvenida', VistaCliente::class)->name('cliente.bienvenida');
    Route::get('perfil', PerfilCliente\Ver::class)->name('cliente.perfil');
    Route::get('editar', EditarPerfil::class)->name('cliente.editar');
});

// Aca van las rutas de autenticado y que sea recepcionista
Route::middleware(['auth', 'role:recepcionista'])->prefix('recepcionista')->group(function () {
    Route::get('bienvenida', Recepcionista\Bienvenida::class)->name('recepcionista.bienvenida');
    Route::get('perfil', PerfilRecepcionista\Ver::class)->name('recepcionista.perfil');

    Route::get('clientes', Clientes\Mostrar::class)->name('clientes.mostrar');
    Route::get('clientes/crear', Clientes\Crear::class)->name('clientes.crear');
    Route::get('clientes/editar/{id}', Clientes\Editar::class)->name('clientes.editar');
    Route::get('clientes/ver/{id}', Clientes\Ver::class)->name('clientes.ver');

    Route::get('clases', Clases\Mostrar::class)->name('clases.mostrar');
    Route::get('clases/crear', Clases\Crear::class)->name('clases.crear');
    Route::get('clases/editar/{id}', Clases\Editar::class)->name('clases.editar');
    Route::get('clases/ver/{id}', Clases\Ver::class)->name('clases.ver');

    Route::get('planes', Planes\Mostrar::class)->name('planes.mostrar');
    Route::get('planes/crear', Planes\Crear::class)->name('planes.crear');
    Route::get('planes/editar/{id}', Planes\Editar::class)->name('planes.editar');
    Route::get('planes/ver/{id}', Planes\Ver::class)->name('planes.ver');
});
