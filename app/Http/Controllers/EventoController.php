<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use App\Models\Especie;
use Illuminate\Http\Request;
use App\Http\Requests\StoreEventoRequest;
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
        $usuarioId = Auth::id();

        if (!$usuarioId) {
            return redirect()->route('login');
        }

        if ($evento->id_usuario == $usuarioId) {
            return back()->with('error', 'No puedes unirte a un evento que organizas.');
        }

        $evento->usuarios()->syncWithoutDetaching([$usuarioId]);

        return back()->with('success', 'Te has unido al evento.');
    }
}
