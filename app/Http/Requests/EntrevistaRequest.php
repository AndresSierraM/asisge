<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class EntrevistaRequest extends Request
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
            'documentoAspiranteEntrevista' => 'required|numeric',
            'estadoEntrevista' => 'required',
            'nombre1AspiranteEntrevista' => 'required|string|max:20',
            'apellido1AspiranteEntrevista' => 'required|string|max:20',
            // 'Tercero_idAspirante' => 'required',
            'fechaEntrevista' => 'required',
            'Tercero_idEntrevistador' => 'required',
            'Cargo_idCargo' => 'required',
            'experienciaAspiranteEntrevista' => 'required|numeric|min:0',
            'experienciaRequeridaEntrevista' => 'required|numeric|min:0',

    ];


    }
}
