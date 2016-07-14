<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ZonaRequest extends Request
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
            "codigoZona" => "required|string|max:20|unique:zona,codigoZona,".$this->get('idZona') .",idZona",
            "nombreZona" => "required|string|max:80",
            "Departamento_idDepartamento" => "required"
        ];
    }
}
