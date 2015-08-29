<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class DiagnosticoRequest extends Request
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
            "codigoDiagnostico" => "required|string|max:20|unique:diagnostico,codigoDiagnostico,".$this->get('idDiagnostico') .",idDiagnostico",
            "nombreDiagnostico" => "required|string|max:80",
            "fechaElaboracionDiagnostico" => "required|date",
            "puntuacionDiagnosticoDetalle0" => "integer|between:1,5"
        ];
    }
}
