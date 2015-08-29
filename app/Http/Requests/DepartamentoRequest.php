<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class DepartamentoRequest extends Request
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
            "codigoDepartamento" => "required|string|max:20|unique:departamento,codigoDepartamento,".$this->get('idDepartamento') .",idDepartamento",
            "nombreDepartamento" => "required|string|max:80",
            "Pais_idPais" => "required"
        ];
    }
}
