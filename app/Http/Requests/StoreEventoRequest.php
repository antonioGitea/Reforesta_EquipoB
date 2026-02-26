<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEventoRequest extends FormRequest
{
    // Permite procesar esta solicitud.
    public function authorize(): bool
    {
        return true;
    }

    // Reglas de validación al crear/editar eventos.
    public function rules(): array
    {
        return [
            'nombre' => 'required|string|max:255',
            'tipo_evento' => 'required|in:Siembra,Limpieza,Riego',
            'fecha' => 'required|date|after_or_equal:today',
            'ubicacion' => 'required|string',
            'tipo_terreno' => 'nullable|string',
            'descripcion' => 'required|string|min:10',
            'id_especies' => 'nullable|array',
            'id_especies.*' => 'exists:especies,id',
        ];
    }

    // Mensajes personalizados de validación.
    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre es obligatorio.',
            'fecha.after_or_equal' => 'No puedes crear un evento en el pasado.',
            'tipo_evento.in' => 'Selecciona un tipo de evento válido.',
        ];
    }
}
