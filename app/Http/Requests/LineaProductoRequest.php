<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class LineaProductoRequest extends Request
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
            "codigoLineaProducto" => "required|string|max:20|unique:lineaproducto,codigoLineaProducto,".$this->get('idLineaProducto') .",idLineaProducto,Compania_idCompania,".(\Session::get('idCompania')),
            "nombreLineaProducto" => "required|string|max:80"
        ];
    }
}
