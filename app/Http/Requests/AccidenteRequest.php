<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class AccidenteRequest extends Request
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
        
        return[
            "Tercero_idCoordinador" => "required|integer",
            "nombreAccidente" => "required|string|max:80",
            "fechaOcurrenciaAccidente" => "required|date",
            "clasificacionAccidente" => "required|string"
        ];
    }
}