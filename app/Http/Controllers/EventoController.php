<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use App\Models\Especie;
use Illuminate\Http\Request;
use App\Http\Requests\StoreEventoRequest;
use Illuminate\Support\Facades\Auth;

class EventoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $eventos = Evento::all();
        return view('eventos.index', compact('eventos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $especies = Especie::all();
        return view('eventos.create', compact('especies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEventoRequest $request)
    {
        // Si el código llega aquí, es que la validación ya pasó con éxito.

        // 1. Obtener los datos validados
        $validado = $request->validated();

        // 2. Añadir el usuario
        $validado['id_usuario'] = Auth::id();

        // 3. Crear el evento
        $evento = Evento::create($validado);

        // 4. Especies
        if ($request->has('id_especies')) {
            $evento->especies()->attach($request->id_especies);
        }

        return redirect()->route('home')->with('success', '¡Evento creado con éxito!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Evento $evento)
    {
        // Cargamos el anfitrión, los participantes y las especies asociadas
        $especies = Especie::all();
        $evento->load(['anfitrion', 'usuarios', 'especies']);
        return view('eventos.show', compact('evento', 'especies'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $evento = Evento::findOrFail($id);
        return view('eventos.edit', compact('contacto'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Evento $evento)
    {
        // 1. Verificación de seguridad
        if (Auth::user()->id !== $evento->user_id && Auth::user()->rol !== 'admin') {
            abort(403, 'No tienes permiso para modificar las especies de este evento.');
        }

        // 2. Actualizar datos del evento
        $evento->update($request->only(['nombre', 'descripcion', 'fecha', 'ubicacion']));

        // 3. Sincronizar especies (el método sync borra las que no estén en el array y añade las nuevas)
        if ($request->has('especies')) {
            $evento->especies()->sync($request->especies);
        } else {
            // Si no mandan nada, quitamos todas las especies del evento
            $evento->especies()->detach();
        }

        return redirect()->route('eventos.show', $evento->id)->with('success', 'Evento actualizado.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Evento::findOrFail($id)->delete();
        $eventos = Evento::all();
        return view("eventos.index", compact('eventos'));
    }

    public function updateEspecies(Request $request, Evento $evento)
    {
        // 1. ¿Eres el dueño o el jefe? Si no, fuera.
        if (Auth::id() != $evento->id_usuario && Auth::user()->tipo != 'admin') {
            abort(403);
        }

        // 2. Guardar los cambios (sync hace toda la magia)
        // Toma la lista de la web y la deja igual en la base de datos
        $evento->especies()->attach($request->especies);

        // 3. Volver a la página del evento
        return back()->with('success', 'Especies guardadas');
    }
}
