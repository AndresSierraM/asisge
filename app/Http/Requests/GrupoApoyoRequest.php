<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class GrupoApoyoRequest extends Request
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
            "codigoGrupoApoyo" => "required|string|max:20|unique:grupoapoyo,codigoGrupoApoyo,".$this->get('idGrupoApoyo') .",idGrupoApoyo,Compania_idCompania,".(\Session::get('idCompania')),
            "nombreGrupoApoyo" => "required|string|max:80",
            "FrecuenciaMedicion_idFrecuenciaMedicion" => "required",
            "fechaConformacionGrupoApoyo" => "required",
            "fechaVencimientoGrupoApoyo" => "required"
        ];
    }
}
