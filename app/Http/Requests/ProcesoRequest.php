<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ProcesoRequest extends Request
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
            "codigoProceso" => "required|string|max:20|unique:proceso,codigoProceso,".$this->get('idProceso') .",idProceso,Compania_idCompania,".(\Session::get('idCompania')),
            "nombreProceso" => "required|string|max:80"
        ];
    }
}
