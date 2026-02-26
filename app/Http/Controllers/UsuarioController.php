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
        // Recogemos los datos que han pasado la validacion y ciframos la password
        $datosEntrada = $request->validated();
        $datosEntrada['password'] = Hash::make($datosEntrada['password']);

        //Creamos usuario y lo loggeamos
        $usuario = Usuario::create($datosEntrada);
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
        // Recogemos los datos que son editables
        $datosEntrada = $request->only(['nombre', 'nick', 'email', 'ubicacion']);

        // Validamos que el campo este rellenado y hasheamos el nuevo password
        if ($request->filled('password')) {
            $datosEntrada['password'] = Hash::make($request->password);
        }

        // Modificamos los datos
        $usuario->update($datosEntrada);

        // Vuelve al perfil.
        return redirect()->route('usuarios.show', $usuario->id);
    }

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

