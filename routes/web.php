<?php

use App\Http\Controllers\EventoController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\EspecieController;
use Illuminate\Support\Facades\Route;

// Home
Route::get('/', [EventoController::class, 'index'])->name('home');

// Rutas visibles por los usuarios invitados
Route::middleware('guest')->group(function () {
    // Login
    Route::get('login', [UsuarioController::class, 'loginForm'])->name('login');
    Route::post('login', [UsuarioController::class, 'login']);

    // Registro
    Route::get('registro', [UsuarioController::class, 'create'])->name('usuarios.create');
    Route::post('usuarios', [UsuarioController::class, 'store'])->name('usuarios.store');
});

// Mostrar eventos y usuarios
Route::get('eventos', [EventoController::class, 'index'])->name('eventos.index');
Route::get('eventos/{evento}', [EventoController::class, 'show'])->name('eventos.show')->whereNumber('evento');


// Rutas visibles para usuarios logeados
Route::middleware('auth')->group(function () {

    Route::post('logout', [UsuarioController::class, 'logout'])->name('auth.logout');

    // Usuarios: Excepto crear y guardar (que están arriba en guest)
    Route::resource('usuarios', UsuarioController::class)->except(['create', 'store']);

    // Eventos: Solo los métodos de escritura
    Route::resource('eventos', EventoController::class)->except(['index', 'show']);

    // Acciones específicas de Eventos (Unirse/Desunirse/Especies)
    Route::prefix('eventos/{evento}')->group(function () {
        Route::post('unirse', [EventoController::class, 'unirse'])->name('eventos.unirse');
        Route::post('desunirse', [EventoController::class, 'desunirse'])->name('eventos.desunirse');
        Route::put('especies', [EventoController::class, 'updateEspecies'])->name('eventos.updateEspecies');
    });

    // Especies: Solo lectura para loggeados
    Route::resource('especies', EspecieController::class)->only(['index', 'show'])->whereNumber('especie');
});
