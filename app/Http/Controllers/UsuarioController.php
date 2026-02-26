<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUsuarioRequest;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{

    // Lista todos los usuarios.
    public function index()
    {
        $usuarios = Usuario::all();
        return view('usuarios.index', compact('usuarios'));
    }

    // Muestra el formulario de registro.
    public function create()
    {
        return view('usuarios.create');
    }

    // Guarda un usuario nuevo y lo autentica.
    public function store(StoreUsuarioRequest $request)
    {
        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);
        $data['tipo'] = $data['tipo'] ?? 'usuario';

        $usuario = Usuario::create($data);
        Auth::login($usuario);

        return redirect()->route('home')->with('success', 'Registro completado con éxito.');
    }

    // Muestra el perfil de un usuario.
    public function show(Usuario $usuario)
    {
        $usuario = Usuario::findOrFail($usuario->id);
        return view("usuarios.show", compact("usuario"));
    }

    // Muestra el formulario para editar usuario.
    public function edit(string $id)
    {
        $usuario = Usuario::findOrFail($id);
        return view('usuarios.edit', compact('usuario'));
    }

    // Actualiza los datos del usuario.
    public function update(StoreUsuarioRequest $request, Usuario $usuario)
    {
        // Datos que se pueden editar.
        $data = $request->only(['nombre', 'nick', 'email', 'ubicacion']);

        // Solo cambia la clave si llega una nueva.
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        // Guarda cambios.
        $usuario->update($data);

        // Vuelve al perfil.
        return redirect()->route('usuarios.show', $usuario->id);
    }

    // Elimina un usuario (pendiente).
    public function destroy(Usuario $usuario)
    {
        //
    }

    public function loginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credenciales = $request->only('nick', 'password');

        if (Auth::attempt($credenciales)) {
            return redirect()->intended(route('home'));
        }
        return back()->withInput($request->only('nick'))->withErrors(['login_error' => 'El nick o la contraseña no coinciden.']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}

