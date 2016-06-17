<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class RolRequest extends Request
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
        
        $opcion = count($this->get('Opcion_idOpcion'));
        
        $validacion = array(
            "nombreRol" => "required|string|max:80");

        //"codigoRol" => "required|string|unique:rol,codigoRol,".$this->get('idRol') .",idRol",        
        for($i = 0; $i < $opcion; $i++)
        {
            if(trim($this->get('Opcion_idOpcion')[$i]) == 0)
            {    
                $validacion['Opcion_idOpcion'.$i] =  'required';
            }
        }

        return $validacion;

    }
}
