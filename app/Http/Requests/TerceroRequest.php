<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class TerceroRequest extends Request
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
            'TipoIdentificacion_idTipoIdentificacion' => 'required',
            "documentoTercero" => "required|string|max:30|unique:tercero,documentoTercero,".$this->get('idTercero') .",idTercero",
            'nombre1Tercero' => 'required|string|max:20',
            'apellido1Tercero' => 'required|string|max:20',
            'nombre2Tercero' => 'string|max:20',
            'apellido2Tercero' => 'string|max:20',
            'fechaCreacionTercero' => 'required',
            'tipoTercero' => 'required',
            'direccionTercero' => 'required|max:200',
            'Ciudad_idCiudad' => 'required',
            'telefonoTercero' => 'required|max:20',
            'fechaNacimientoTercero' => 'required'
        ];
    }
}
