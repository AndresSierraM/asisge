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
        // validacion (where) para que no permita el mimso proceso pero por cada compania
        //, Compania_idCompania = ".$this->get('Compania_idCompania')
        // "Proceso_idProceso" => "required|integer|unique:procedimiento,Proceso_idProceso,".$this->get('idProcedimiento') .",idProcedimiento",
        // return [
        //     "Proceso_idProceso" => "required|integer",
        //     "nombreProcedimiento" => "required|string",
        //     "fechaElaboracionProcedimiento" => "required|date"
        // ];
        $validacion = array('Proceso_idProceso' => "required|integer",
            'nombreProcedimiento' => "required|string",
            'fechaElaboracionProcedimiento' => "required|date");
        
       return $validacion;
    }   
}
