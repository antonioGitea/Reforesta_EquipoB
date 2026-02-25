<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUsuarioRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Importante: debe estar en true para que permita procesar el formulario
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        // Obtenemos el ID del usuario de la ruta para ignorar su propio nick/email en el unique
        $usuarioId = $this->route('usuario') ? $this->route('usuario')->id : $this->route('id');

        return [
            'nombre'    => ['required', 'max:255', 'regex:/^[\pL\s]+$/u'],
            'nick'      => 'required|string|max:50|unique:usuarios,nick,' . $usuarioId,
            'email'     => 'required|email|max:255|unique:usuarios,email,' . $usuarioId,
            'password'  => 'nullable|string|min:6|confirmed',
            'ubicacion' => ['required', 'max:255', 'regex:/^[\pL\s]+$/u'],
        ];
    }

    /**
     * Custom error messages.
     */
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
