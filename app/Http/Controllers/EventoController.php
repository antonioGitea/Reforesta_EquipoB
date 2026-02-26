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
        $idUsuario = Auth::id();

        // 1. Validar que el usuario no sea el organizador
        if ($evento->id_usuario === $idUsuario) {
            return back()->with('error', 'No puedes unirte a un evento que organizas.');
        }

        // 2. Verificar si ya está unido (especificando la tabla users para evitar ambigüedad)
        if (!$evento->usuarios()->where('id_usuario', $idUsuario)->exists()) {

            // Relacionar en la tabla pivote
            $evento->usuarios()->attach($idUsuario);

            // 3. Incremento forzado vía Modelo (Esto no falla si la columna es numérica)
            Usuario::where('id', $idUsuario)->increment('karma', 3);

            return back()->with('success', 'Te has unido al evento y sumaste 3 de karma.');
        }

        return back()->with('info', 'Ya formas parte de este evento.');
    }

    public function desunirse(Evento $evento)
    {
        $userId = Auth::id();

        // 1. Verificar si el usuario realmente está unido al evento
        if ($evento->usuarios()->where('id_usuario', $userId)->exists()) {

            // Eliminar la relación en la tabla pivote
            $evento->usuarios()->detach($userId);

            // 2. Restar 2 de karma usando el modelo Usuario
            Usuario::where('id', $userId)->decrement('karma', 3);

            return back()->with('success', 'Has abandonado el evento. Se han restado 2 puntos de karma.');
        }

        return back()->with('error', 'No formas parte de este evento.');
    }
}
