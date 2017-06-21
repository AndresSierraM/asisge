<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ActoInseguroRequest extends Request
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

        "Tercero_idEmpleadoReporta" => "required",
         "fechaElaboracionActoInseguro" => "required"
 
        ];
    }
     public function messages()
    {
        return[
        'Tercero_idEmpleadoReporta.required' => 'Debe Seleccionar la Persona que Reporta.',
        'fechaElaboracionActoInseguro.required'=> 'Debe Seleccionar la Fecha de Elaboración.'

        ];
    }
}