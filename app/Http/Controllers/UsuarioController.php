<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUsuarioRequest;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $usuarios = Usuario::all();
        return view('usuarios.index', compact('usuarios'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Usuario $usuario)
    {
        $usuario = Usuario::findOrFail($usuario->id);
        return view("usuarios.show", compact("usuario"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $usuario = Usuario::findOrFail($id);
        return view('usuarios.edit', compact('usuario'));
    }

    /**
     * Update the specified resource in storage.
    */
    public function update(StoreUsuarioRequest $request, Usuario $usuario)
    {
        // 1. Recolectamos los datos validados (excepto password y avatar por ahora)
        $data = $request->only(['nombre', 'nick', 'email', 'ubicacion']);

        // 2. Lógica para la Contraseña: solo se actualiza si el usuario escribió algo
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        // 4. Actualizamos el modelo con el array final
        $usuario->update($data);

        // 5. Redireccionamos con un mensaje de éxito
        return redirect()->route('usuarios.show', $usuario->id);
    }

    /**
     * Remove the specified resource from storage.
    */
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
