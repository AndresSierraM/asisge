<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class TipoExamenMedicoRequest extends Request
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
            "codigoTipoExamenMedico" => "required|string|max:20|unique:tipoexamenmedico,codigoTipoExamenMedico,".$this->get('idTipoExamenMedico') .",idTipoExamenMedico",
            "nombreTipoExamenMedico" => "required|string|max:80"
        ];
    }
}
