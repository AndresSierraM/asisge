<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class CiudadRequest extends Request
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
        $validacionCodigo = ($this->get('idCiudad') != null 
            ? "required|string|unique:ciudad,codigoCiudad".$this->get('idCiudad') 
            : "required|string|unique:ciudad");
        return [
            "codigoCiudad" => $validacionCodigo,
            "nombreCiudad" => "required|string",
            "Departamento_idDepartamento" => "required"
        ];
    }
}
