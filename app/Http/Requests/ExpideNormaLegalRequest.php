<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ExpideNormaLegalRequest extends Request
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
            "codigoExpideNormaLegal" => "required|string|max:20|unique:expidenormalegal,codigoExpideNormaLegal,".$this->get('idExpideNormaLegal') .",idExpideNormaLegal",
            "nombreExpideNormaLegal" => "required|string|max:80"
        ];
    }
}
