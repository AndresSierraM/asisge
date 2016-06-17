<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class CuadroMandoRequest extends Request
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
            "numeroCuadroMando" => "required|string|unique:cuadromando,numeroCuadroMando,".$this->get('idCuadroMando') .",idCuadroMando,Compania_idCompania,".(\Session::get('idCompania')),
            "CompaniaObjetivo_idCompaniaObjetivo" => "required",
            "Proceso_idProceso" => "required",
            "indicadorCuadroMando" => "required",
            "formulaCuadroMando" => "required",
            "operadorMetaCuadroMando" => "required",
            "valorMetaCuadroMando" => "required",
            "tipoMetaCuadroMando" => "required",
            "FrecuenciaMedicion_idFrecuenciaMedicion" => "required",
            "Tercero_idResponsable" => "required"

        ];
    }
}
