<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class InspeccionRequest extends Request
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
        $validacion = array('TipoInspeccion_idTipoInspeccion' => "required|integer",
                            'Tercero_idRealizadaPor' => 'required|integer',
                            'fechaElaboracionInspeccion' => 'required|date');

       
        return $validacion;
    }
}
