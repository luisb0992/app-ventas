<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateSaleRequest extends FormRequest
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
            'service'   => 'required|min:3|max:250',
            'count'     => 'required|numeric|min:1',
            'amount'    => 'required|numeric|min:1',
            'client'    => 'required|min:3|max:250',
            'voucher'   => 'required|file|max:10024',
        ];
    }
}
