<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ProgramaRequest extends Request
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
        // validacion (where) para que no permita el mimso proceso pero por cada compania
        //, Compania_idCompania = ".$this->get('Compania_idCompania')
        return [
            "nombrePrograma" => "required|String",
            "fechaElaboracionPrograma" => "required|date"
        ];
    }
}
