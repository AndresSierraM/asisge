<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class CompetenciaRespuestaRequest extends Request
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
            'respuestaCompetenciaRespuesta' => 'required|string|max:45',
            'porcentajeNormalCompetenciaRespuesta' => 'required|numeric|max:100',
            'porcentajeInversoCompetenciaRespuesta' => 'required|numeric|max:100',

    ];


    }
}
