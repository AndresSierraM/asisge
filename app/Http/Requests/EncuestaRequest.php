<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class EncuestaRequest extends Request
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
        
        $preguntas = ($this->get('preguntaEncuestaPregunta')[0]);
        echo 'total = '.$preguntas;
        echo 'id '.$this->get('idEncuesta');
        $validacion = array(
            'tituloEncuesta' => "required|string|unique:encuesta,tituloEncuesta,".$this->get('idEncuesta') .",idEncuesta,Compania_idCompania,".(\Session::get('idCompania')),
            'descripcionEncuesta' => "required|string");
        
        for($i = 0; $i < $preguntas; $i++)
        {
            if(trim($this->get('preguntaEncuestaPregunta')[$i]) === '' )
            {    
                $validacion['preguntaEncuestaPregunta'.$i] =  'required';
            }

            if(trim($this->get('tipoRespuestaEncuestaPregunta')[$i]) == '' )
            {    
                $validacion['tipoRespuestaEncuestaPregunta'.$i] =  'required';
            }
        }
    print_r($validacion);
        return $validacion;
    }
}
