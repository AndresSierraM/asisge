<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class FrecuenciaMedicionRequest extends Request
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
            "codigoFrecuenciaMedicion" => "required|string|max:20|unique:frecuenciamedicion,codigoFrecuenciaMedicion,".$this->get('idFrecuenciaMedicion') .",idFrecuenciaMedicion",
            "nombreFrecuenciaMedicion" => "required|string|max:80",
            "valorFrecuenciaMedicion" => "required|integer|between:0,99",
            "unidadFrecuenciaMedicion" => "required|string"
        ];
    }
}
