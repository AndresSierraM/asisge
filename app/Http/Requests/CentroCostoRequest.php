<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class CentroCostoRequest extends Request
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
            "codigoCentroCosto" => "required|string|max:20|unique:centrocosto,codigoCentroCosto,".$this->get('idCentroCosto') .",idCentroCosto,Compania_idCompania,".(\Session::get('idCompania')),
            "nombreCentroCosto" => "required|string|max:80"
        ];
    }
    public function messages()
    {
        return[
        'codigoCentroCosto.unique' => 'Este codigo ya se encuentra en uso.',
        'nombreCentroCosto.required'=> 'El campo nombre Costo es Obligatorio.'

        ];
    }
}
