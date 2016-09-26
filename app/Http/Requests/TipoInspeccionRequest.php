<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class TipoInspeccionRequest extends Request
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
        $pregunta = count($this->get('numeroTipoInspeccionPregunta'));
        
        $validacion = array(
            "codigoTipoInspeccion" => "required|unique:tipoinspeccion,codigoTipoInspeccion,".$this->get('idTipoInspeccion') .",idTipoInspeccion,Compania_idCompania,".(\Session::get('idCompania')),
            "nombreTipoInspeccion" => "required|string|max:80",
            "FrecuenciaMedicion_idFrecuenciaMedicion" => "required");

        for($i = 0; $i < $pregunta; $i++)
        {
            if(trim($this->get('numeroTipoInspeccionPregunta')[$i]) == '' or trim($this->get('numeroTipoInspeccionPregunta')[$i]) == 0)
            {    
                $validacion['numeroTipoInspeccionPregunta'.$i] =  'required';
            }

            if(trim($this->get('contenidoTipoInspeccionPregunta')[$i]) == '')
            {    
                $validacion['contenidoTipoInspeccionPregunta'.$i] =  'required';
            }
        }
        return $validacion;
    }
}
