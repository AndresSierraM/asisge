<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ClasificacionRiesgoRequest extends Request
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
            "codigoClasificacionRiesgo" => "required|string|max:20|unique:clasificacionriesgo,codigoClasificacionRiesgo,".$this->get('idClasificacionRiesgo') .",idClasificacionRiesgo",
            "nombreClasificacionRiesgo" => "required|string|max:80"
        ];
    }
}
