<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class CategoriaAgendaRequest extends Request
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
            "codigoCategoriaAgenda" => "required|string|max:20|unique:categoriaagenda,codigoCategoriaAgenda,".$this->get('idCategoriaAgenda') .",idCategoriaAgenda,Compania_idCompania,".(\Session::get('idCompania')),
            "nombreCategoriaAgenda" => "required|string|max:80"
        ];
    }
}
