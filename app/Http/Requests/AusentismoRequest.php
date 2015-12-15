<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class AusentismoRequest extends Request
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
        
        return[
            "Tercero_idTercero" => "required|integer",
            "nombreAusentismo" => "required|string|max:80",
            "fechaElaboracionAusentismo" => "required|date",
            "tipoAusentismo" => "required|string",
            "fechaInicioAusentismo" => "required|date",
            "fechaFinAusentismo" => "required|date"
        ];
    }
}
