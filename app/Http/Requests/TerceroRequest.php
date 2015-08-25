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
            'documentoTercero' => 'required',
            'nombre1Tercero' => 'required|string',
            'apellido1Tercero' => 'required|string',
            'fechaCreacionTercero' => 'required',
            'tipoTercero' => 'required',
            'direccionTercero' => 'required',
            'Ciudad_idCiudad' => 'required',
            'telefonoTercero' => 'required',
            'fechaNacimientoTercero' => 'required'
        ];
    }
}
