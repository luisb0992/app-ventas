<?php

namespace App\Http\Requests;

use App\Models\Brand;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateBrandRequest extends FormRequest
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
        $data = request()->all();
        $isLogoRequired = $data['logo']->getClientOriginalName() !== Brand::find($data['id'])->logo;

        return [
            'name' => "required|max:250|unique:brands,name,{$data['id']},id,deleted_at,NULL",
            'logo' => Rule::requiredIf($isLogoRequired).'|file',
            'email_one' => 'required|email',
            'email_two' => 'required|email',
        ];
    }
}
