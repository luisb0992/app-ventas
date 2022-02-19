<?php

namespace App\Http\Requests;

use App\Models\Brand;
use Illuminate\Foundation\Http\FormRequest;

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
        $idBrand = request()->get('id');
        $logo = request()->file('logo');
        // dd(
        //     $logo,
        //     // $logo->getClientOriginalName(),
        //     // $logo->getClientOriginalExtension(),
        //     // $logo->getClientMimeType(),
        //     // $logo->getRealPath(),
        // );
        return [
            'name' => "required|max:250|unique:brands,name,{$idBrand},id,deleted_at,NULL",
            'logo' => 'required|file|max:2048',
            'email_one' => 'required|email',
            'email_two' => 'required|email',
        ];
    }
}
