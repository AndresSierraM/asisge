<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class SublineaProductoRequest extends Request
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
            "codigoSublineaProducto" => "required|string|max:20|unique:sublineaproducto,codigoSublineaProducto,".$this->get('idSublineaProducto') .",idSublineaProducto,Compania_idCompania,".(\Session::get('idCompania')),
            "nombreSublineaProducto" => "required|string|max:80"
        ];
    }
}
