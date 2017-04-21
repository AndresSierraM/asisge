<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class TipoCalidadRequest extends Request
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
            "codigoTipoCalidad" => "required|string|max:20|unique:tipocalidad,codigoTipoCalidad,".$this->get('idTipoCalidad') .",idTipoCalidad,Compania_idCompania,".(\Session::get('idCompania')),
            "nombreTipoCalidad" => "required|string|max:80"
        ];
    }
}
