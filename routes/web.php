<?php

use App\Http\Controllers\EventoController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Support\Facades\Route;

// --- RUTA PÚBLICA (Home) ---
Route::get('/', [EventoController::class, 'index'])->name('home');

// --- RUTAS PARA INVITADOS (Solo si NO estás loggeado) ---
Route::middleware('guest')->group(function () {
    Route::get('login', [UsuarioController::class, 'loginForm'])->name('auth.login');
    Route::post('login', [UsuarioController::class, 'login']);
});

// --- RUTAS PROTEGIDAS (Solo si ESTÁS loggeado) ---
Route::middleware('auth')->group(function () {
    
    // Logout
    Route::post('logout', [UsuarioController::class, 'logout'])->name('auth.logout');
    
    // Recursos protegidos (Normalmente quieres que solo usuarios loggeados creen/editen)
    Route::resource('usuarios', UsuarioController::class);
    Route::resource('eventos', EventoController::class)->except(['index', 'show']);

    // Ruta para mostrar el formulario de edición
    Route::get('/eventos/{evento}/edit', [EventoController::class, 'edit'])->name('eventos.edit');
    
    // Ruta para procesar la actualización (PUT/PATCH)
    Route::put('/eventos/{evento}', [EventoController::class, 'update'])->name('eventos.update');
    
    // Ruta para eliminar el evento
    Route::delete('/eventos/{evento}', [EventoController::class, 'destroy'])->name('eventos.destroy');
    
    // Ruta personalizada para unirse al evento (POST por seguridad)
    Route::post('/eventos/{evento}/unirse', [EventoController::class, 'unirse'])->name('eventos.unirse');
});

// Permitir ver eventos (index y show) a todo el mundo si lo deseas:
Route::resource('eventos', EventoController::class)->only(['index', 'show']);