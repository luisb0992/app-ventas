<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules;

class UpdatePasswordProfile extends FormRequest
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
        return [
            'password'  => ['required', 'min:8', Rules\Password::defaults()],
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
            'password.required'  => 'La contraseña es requerida',
            'password.min'       => 'La contraseña debe tener al menos 8 caracteres',
        ];
    }
}
