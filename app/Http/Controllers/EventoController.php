<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use App\Models\Especie;
use Illuminate\Http\Request;
use App\Http\Requests\StoreEventoRequest;
use App\Models\Usuario;
use Illuminate\Support\Facades\Auth;

class EventoController extends Controller
{
    // Lista todos los eventos.
    public function index()
    {
        $eventos = Evento::all();
        return view('eventos.index', compact('eventos'));
    }

    // Muestra el formulario para crear eventos.
    public function create()
    {
        $especies = Especie::all();
        return view('eventos.create', compact('especies'));
    }

    // Guarda un evento nuevo.
    public function store(StoreEventoRequest $request)
    {
        $validado = $request->validated();
        $validado['id_usuario'] = Auth::id();

        $evento = Evento::create($validado);

        if ($request->has('id_especies')) {
            $evento->especies()->attach($request->id_especies);
        }

        return redirect()->route('home')->with('success', 'Evento creado con exito.');
    }

    // Muestra el detalle del evento.
    public function show(Evento $evento)
    {
        $especies = Especie::all();
        $evento->load(['anfitrion', 'usuarios', 'especies']);
        return view('eventos.show', compact('evento', 'especies'));
    }

    // Muestra el formulario para editar el evento.
    public function edit(Evento $evento)
    {
        if (Auth::id() != $evento->id_usuario && Auth::user()->tipo != 'admin') {
            abort(403, 'No tienes permiso para editar este evento.');
        }

        $especies = Especie::all();
        return view('eventos.edit', compact('evento', 'especies'));
    }

    // Actualiza un evento existente.
    public function update(StoreEventoRequest $request, Evento $evento)
    {
        if (Auth::id() != $evento->id_usuario && Auth::user()->tipo != 'admin') {
            abort(403, 'No tienes permiso para modificar este evento.');
        }

        $validado = $request->validated();

        $evento->update([
            'nombre' => $validado['nombre'],
            'descripcion' => $validado['descripcion'],
            'fecha' => $validado['fecha'],
            'ubicacion' => $validado['ubicacion'],
            'tipo_terreno' => $validado['tipo_terreno'] ?? null,
            'tipo_evento' => $validado['tipo_evento'],
        ]);

        if ($request->has('id_especies')) {
            $evento->especies()->sync($request->id_especies);
        } else {
            $evento->especies()->detach();
        }

        return redirect()->route('eventos.show', $evento->id)->with('success', 'Evento actualizado.');
    }

    // Elimina un evento.
    public function destroy(string $id)
    {
        Evento::findOrFail($id)->delete();
        $eventos = Evento::all();
        return view('eventos.index', compact('eventos'));
    }

    // Actualiza las especies del evento.
    public function updateEspecies(Request $request, Evento $evento)
    {
        if (Auth::id() != $evento->id_usuario && Auth::user()->tipo != 'admin') {
            abort(403);
        }

        if ($request->has('especies')) {
            $evento->especies()->sync($request->especies);
        }

        return back()->with('success', 'Especies guardadas');
    }

    // Une al usuario autenticado sin duplicar registros.
    public function unirse(Evento $evento)
    {
        //Recogemos ID
        $idUsuario = Auth::id();

        // 1. Validamos que el usuario no sea el organizador
        if ($evento->id_usuario === $idUsuario) {
            return back()->with('error', 'No puedes unirte a un evento que organizas.');
        }

        // Agregamos el nuevo ID al valor de usuarios de la tabla intermedia
        $evento->usuarios()->attach($idUsuario);

        // Buscamos el usuario por ID e incrementamos su Karma
        Usuario::where('id', $idUsuario)->increment('karma', 3);

        return back()->with('success', 'Te has unido al evento y sumaste 3 de karma.');


        return back()->with('info', 'Ya formas parte de este evento.');
    }

    public function desunirse(Evento $evento)
    {
        //Recogemos ID
        $idUsuario = Auth::id();

        // 1. Verificar si el usuario está unido al evento
        if ($evento->usuarios()->where('id_usuario', $idUsuario)->exists()) {

            // Eliminamos el ID del valor de usuarios de la tabla intermedia
            $evento->usuarios()->detach($idUsuario);

            // Buscamos el usuario por ID y decrementamos su Karma
            Usuario::where('id', $idUsuario)->decrement('karma', 3);

            return back()->with('success', 'Has abandonado el evento. Se han restado 2 puntos de karma.');
        }

        return back()->with('error', 'No formas parte de este evento.');
    }
}
