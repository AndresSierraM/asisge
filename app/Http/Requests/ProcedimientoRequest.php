<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ProcedimientoRequest extends Request
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
            "Proceso_idProceso" => "required|integer|unique:procedimiento,Proceso_idProceso,".$this->get('idProcedimiento') .",idProcedimiento",
            "fechaElaboracionProcedimiento" => "required|date"
        ];
    }
}
