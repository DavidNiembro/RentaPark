<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ParkCreateRequest extends FormRequest
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
            'parNumber' => 'required|max:20',
            'parAddress' => 'required|max:255',
            'parPostCode' => 'required',
            'parCity' => 'required',
            'parPrice' => 'required|numeric'
        ];
    }
}
