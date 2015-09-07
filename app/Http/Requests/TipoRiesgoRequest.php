<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class TipoRiesgoRequest extends Request
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
            "codigoTipoRiesgo" => "required|string|max:20|unique:tiporiesgo,codigoTipoRiesgo,".$this->get('idTipoRiesgo') .",idTipoRiesgo",
            "nombreTipoRiesgo" => "required|string|max:80"
        ];
        return [
            //
        ];
    }
}
