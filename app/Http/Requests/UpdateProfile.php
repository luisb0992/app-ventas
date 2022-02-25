<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfile extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id = request()->user()->id;

        return [
            'name'      => 'required|string|max:255|min:3',
            'lastname'  => 'required|string|max:255|min:3',
            'user'      => 'required|string|max:255|unique:users,user,' . $id,
            // 'password'  => ['required', 'confirmed', Rules\Password::defaults()],
        ];
    }

    /**
     * Obtener los mensajes personalizados de validación para un campo específico.
     *
     * @return void
     */
    public function messages()
    {
        return [
            'name.required'      => 'El nombre es requerido',
            'name.string'        => 'El nombre debe ser una cadena de texto',
            'name.max'           => 'El nombre debe tener como máximo 255 caracteres',
            'name.min'           => 'El nombre debe tener como mínimo 3 caracteres',
            'lastname.required'  => 'El apellido es requerido',
            'lastname.string'    => 'El apellido debe ser una cadena de texto',
            'lastname.max'       => 'El apellido debe tener como máximo 255 caracteres',
            'lastname.min'       => 'El apellido debe tener como mínimo 3 caracteres',
            'user.required'      => 'El usuario es requerido',
            'user.string'        => 'El usuario debe ser una cadena de texto',
            'user.max'           => 'El usuario debe tener como máximo 255 caracteres',
            'user.unique'        => 'El usuario ya existe, intente con otro nombre de usuario',
        ];
    }
}
