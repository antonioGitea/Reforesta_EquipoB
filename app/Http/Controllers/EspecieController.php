<?php

namespace App\Http\Controllers;

use App\Models\Especie;
use Illuminate\Http\Request;

class EspecieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $especies = Especie::all();
        return view('especies.index', compact('especies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //return view("contactos.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        /*$contacto = Contacto::create([
            "nombre" => $request->nombre,
            "email" => $request->email
        ]);
        return redirect()->route('contactos.show', $contacto->id);
        */
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $especie = Especie::findOrFail($id);
        return view('especies.show', compact('especie'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $especie = Especie::findOrFail($id);
        //return view('contactos.edit', compact('contacto'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $especie = Especie::findOrFail($id);
        if ($especie){
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
        Especie::findOrFail($id)->delete();
        //$listaContactos = Contacto::all();
        //return view("contactos.index", compact('listaContactos'));
    }
}
