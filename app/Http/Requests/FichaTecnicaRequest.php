<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class FichaTecnicaRequest extends Request
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
            "referenciaFichaTecnica" => "required|string|max:20|unique:fichatecnica,referenciaFichaTecnica,".$this->get('idFichaTecnica') .",idFichaTecnica,Compania_idCompania,".(\Session::get('idCompania')),
            "nombreFichaTecnica" => "required|string|max:80",
            "LineaProducto_idLineaProducto" => "required"
        ];
    }
}
