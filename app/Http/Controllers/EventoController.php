<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use App\Models\Especie;
use Illuminate\Http\Request;
use App\Http\Requests\StoreEventoRequest;

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
        $validado['id_usuario'] = auth()->id();

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
        $evento->load(['anfitrion', 'usuarios', 'especies']);

        return view('eventos.show', compact('evento'));
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
    public function update(Request $request, string $id)
    {
        $evento = Evento::findOrFail($id);
        if ($evento) {
            /*$evento -> update(
                [
                    'nombre' => $request->nombre,
                    'email' => $request->email
                ]);
            return redirect()->route('contactos.show', $evento->id);
            */
        }
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
}
