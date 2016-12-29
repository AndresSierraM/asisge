<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class PlanTrabajoAlertaRequest extends Request
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
 
        // $validacion = array('documentoAspiranteEntrevista' => 'required',
        //     "documentoAspiranteEntrevista" => "required|numeric|max:30|unique:entrevista,documentoAspiranteEntrevista,".$this->get('idEntrevista') .",idEntrevista,Compania_idCompania,".(\Session::get('idCompania')),
        //     'nombre1Tercero' => 'required|string|max:20',
        //     'apellido1Tercero' => 'required|string|max:20',
        //     'nombre2Tercero' => 'string|max:20',
        //     'apellido2Tercero' => 'string|max:20',
        //     'fechaCreacionTercero' => 'required',
        //     'tipoTercero' => 'required',
        //     'direccionTercero' => 'required|max:200',
        //     'Ciudad_idCiudad' => 'required',
        //     'telefonoTercero' => 'required|max:20');

        // return $validacion;


    }
}
