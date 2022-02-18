<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateBrandRequest extends FormRequest
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
            'name' => 'required|max:250|unique:brands,name,NULL,id,deleted_at,NULL',
            'logo' => 'required|file|mimes:jpg,bmp,png,jpeg,svg|max:2048',
            'email_one' => 'required|email',
            'email_two' => 'required|email',
        ];

        // ['required', Rule::unique('users')->ignore($this->user)->whereNull('deleted_at')]
    }
}
