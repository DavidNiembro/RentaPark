<?php
/**
 * ETML
 * Auteur: David Niembro
 * Date:
 * Description: Contient la fonction de validation
 */

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ParkUpdateRequest extends FormRequest
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
        $id = $this->Park;
        return [

            //champs à valider avec les spécifications
            'parNumber' => 'required|max:20'. $id,
            'parAddress' => 'required|max:255'. $id,
            'parPostCode' => 'required'. $id,
            'parCity' => 'required'. $id,
            'parPrice' => 'required|numeric'. $id,

        ];
    }
}
