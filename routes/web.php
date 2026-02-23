<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;
use Illuminate\Support\Facades\Auth;


Route::resource('usuarios', UsuarioController::class);


Route::get('login', [UsuarioController::class, 'loginForm']) -> name('login');
Route::get('logout', [UsuarioController::class, 'logout'])->name('logout');
Route::post('login', [UsuarioController::class, 'login']);

