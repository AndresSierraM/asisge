<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ActaGrupoApoyoRequest extends Request
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
            "GrupoApoyo_idGrupoApoyo" => "required|integer",
            "fechaActaGrupoApoyo" => "required|date",
            "horaInicioActaGrupoApoyo" => "required",
            "horaFinActaGrupoApoyo" => "required"
        ];
    }
}