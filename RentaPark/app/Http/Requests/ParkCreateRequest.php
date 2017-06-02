<?php
/**
 * ETML
 * Auteur: David Niembro
 * Date:
 * Description: Contient la fonction de validation
 */

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
            //champs à valider avec les spécifications
            'parNumber' => 'required|max:20',
            'parAddress' => 'required|max:255',
            'parPostCode' => 'required',
            'parCity' => 'required',
            'parPrice' => 'required|numeric'
        ];
    }
}
