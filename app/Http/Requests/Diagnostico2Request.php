<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class Diagnostico2Request extends Request
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
       
         $respuesta = count($this->get('respuestaDiagnostico2Detalle'));
        
         $validacion = array('codigoDiagnostico2' => "required|string|max:20|unique:diagnostico2,codigoDiagnostico2,".$this->get('idDiagnostico2') .",idDiagnostico2,Compania_idCompania,".(\Session::get('idCompania')),
                             'nombreDiagnostico2' => 'required|string|max:80',
                            'fechaElaboracionDiagnostico2' => 'required|date');

          for($i = 0; $i < $respuesta; $i++)
        {
            if(trim($this->get('respuestaDiagnostico2Detalle')[$i]) == '' or trim($this->get('respuestaDiagnostico2Detalle')[$i]) == 'SELECCIONE')
            {    
                $validacion['respuestaDiagnostico2Detalle'.$i] =  'required';
            }
        }   
        return $validacion;
    }


     public function messages()
    {
        $respuesta = count($this->get('respuestaDiagnostico2Detalle'));

        $mensajes = array();
        $mensajes["codigoDiagnostico2.unique"] = "[Encabezado] Este Codigo ya esta en uso";
        $mensajes["nombreDiagnostico2.required"] = "[Encabezado] Ingrese el Nombre del Diagnostico Version 2";
        $mensajes["fechaElaboracionDiagnostico2.required"] = "[Encabezado] Ingrese la fecha de elaboracion";



        for($i = 0; $i < $respuesta; $i++)
        {
            if(trim($this->get('respuestaDiagnostico2Detalle')[$i]) == '' or trim($this->get('respuestaDiagnostico2Detalle')[$i]) == 0)
            {    
            $mensajes["respuestaDiagnostico2Detalle".$i.".required"] = "[Detalle] Debe seleccionar la Respuesta del Diagnostico ".($i+1);
            }
        }


        return $mensajes;

    }
}
