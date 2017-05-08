<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class AusentismoRequest extends Request
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
            "Tercero_idTercero" => "required|integer",
            "nombreAusentismo" => "required|string|max:80",
            "fechaElaboracionAusentismo" => "required|date",
            "tipoAusentismo" => "required|string",
            "fechaInicioAusentismo" => "required|date",
            "fechaFinAusentismo" => "required|date"
        ];
    }

    public function messages()
            {
                return[
                'Tercero_idTercero.required' => 'Debe Seleccionar un Empleado.',
                'nombreAusentismo.required'=> 'Debe ingresar la Descripci&#243;n.',
                'fechaElaboracionAusentismo.required'=> 'Debe Seleccionar la Fecha de Elaboracio&#243;n del Ausentismo.',
                'tipoAusentismo.required'=> 'Debe Seleccionar el tipo de Ausentismo.',
                'fechaInicioAusentismo.required'=> 'Debe Seleccionar la Fecha de Inicio del Ausentismo.',
                'fechaFinAusentismo.required'=> 'Debe Seleccionar la Fecha de Final del Ausentismo.'

                ];
            }
    
}
