<?php

use App\Http\Controllers\EventoController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\UsuarioLogController;
use Illuminate\Support\Facades\Auth;


Route::resource('usuarios', UsuarioController::class);
Route::resource('eventos', EventoController::class);

Route::get('/', [EventoController::class, 'index'])->name('home');


Route::get('login', [UsuarioController::class, 'loginForm']) -> name('login');
Route::get('logout', [UsuarioController::class, 'logout']) -> name('logout');
Route::post('login', [UsuarioController::class, 'login']);