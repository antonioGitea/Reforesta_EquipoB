<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUsuarioRequest extends FormRequest
{
    // Permite procesar esta solicitud.
    public function authorize(): bool
    {
        // Debe estar en true para aceptar el formulario.
        return true;
    }

    // Validaciones de los campos de creacion
    public function rules(): array
    {

        return [
            'nombre' => 'required|string|max:255',
            'nick' => 'required|string|max:50|unique:usuarios,nick',
            'email' => 'required|email|max:255|unique:usuarios,email',
            'password' => 'required|string|min:6|confirmed',
            'ubicacion' => ['required', 'max:255', 'regex:/^[\pL\s]+$/u'],
        ];
    }

    // Mensajes personalizados si no se supera la validacion
    public function messages(): array
    {
        return [
            'nombre.required'   => 'El nombre es obligatorio.',
            'nombre.max'        => 'El nombre es demasiado largo.',
            'nombre.regex'      => 'El nombre no puede contener números ni símbolos.',

            'nick.required'     => 'El nickname es obligatorio.',
            'nick.unique'       => 'Este nickname ya está siendo utilizado.',

            'email.required'    => 'El correo electrónico es obligatorio.',
            'email.email'       => 'Introduce un formato de correo válido.',
            'email.unique'      => 'Este correo ya está registrado.',

            'password.min'      => 'La contraseña debe tener al menos 6 caracteres.',
            'password.confirmed'=> 'Las contraseñas no coinciden.',

            'ubicacion.required'=> 'La ubicación es obligatoria.',
            'ubicacion.regex'      => 'La ubicaion no puede contener números ni símbolos.',
        ];
    }
}
