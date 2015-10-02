<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class TipoNormaLegalRequest extends Request
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
            "codigoTipoNormaLegal" => "required|string|max:20|unique:tiponormalegal,codigoTipoNormaLegal,".$this->get('idTipoNormaLegal') .",idTipoNormaLegal",
            "nombreTipoNormaLegal" => "required|string|max:80"
        ];
    }
}
