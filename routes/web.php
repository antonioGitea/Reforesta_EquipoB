<?php

use App\Http\Controllers\EventoController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\EspecieController;
use App\Models\Especie;
use Illuminate\Support\Facades\Route;

// 1. RUTAS PÚBLICAS (Accesibles por todos)
Route::get('/', [EventoController::class, 'index'])->name('home');
Route::resource('eventos', EventoController::class)->only(['index', 'show'])->whereNumber('evento');

// 2. RUTAS PARA INVITADOS (Solo si NO estás logueado)
Route::middleware('guest')->group(function () {
    // Login
    Route::get('login', [UsuarioController::class, 'loginForm'])->name('login');
    Route::post('login', [UsuarioController::class, 'login']);

    // Registro
    Route::get('registro', [UsuarioController::class, 'create'])->name('usuarios.create');
    Route::post('usuarios', [UsuarioController::class, 'store'])->name('usuarios.store');
});

// 3. RUTAS PROTEGIDAS (Solo si ESTÁS logueado)
Route::middleware('auth')->group(function () {
    
    Route::post('logout', [UsuarioController::class, 'logout'])->name('auth.logout');
    
    // Usuarios: Ver lista, perfil, editar y borrar
    Route::resource('usuarios', UsuarioController::class)->except(['create', 'store']);
    
    // Eventos: Crear, editar y borrar
    Route::resource('eventos', EventoController::class)->except(['index', 'show']);
    Route::post('/eventos/{evento}/unirse', [EventoController::class, 'unirse'])->name('eventos.unirse');
    Route::post('/eventos/{evento}/desunirse', [EventoController::class, 'desunirse'])->name('eventos.desunirse');
    Route::resource('especies', EspecieController::class)->only(['index', 'show'])->whereNumber('especie');

    Route::put('/eventos/{evento}/especies', [App\Http\Controllers\EventoController::class, 'updateEspecies'])
        ->name('eventos.updateEspecies')
        ->middleware('auth');
});
