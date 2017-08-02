<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class MatrizRiesgoProcesoRequest extends Request
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
        $observacionriesgo = count($this->get('descripcionMatrizRiesgoProcesoDetalle'));

        $validacion = array(
            "fechaMatrizRiesgoProceso" => "required",
            "Tercero_idRespondable" => "required",
            "Proceso_idProceso" => "required",
        );

        for($i = 0; $i < $observacionriesgo; $i++)
        {
            if(trim($this->get('descripcionMatrizRiesgoProcesoDetalle')[$i]) == '')
            {    
                $validacion['descripcionMatrizRiesgoProcesoDetalle'.$i] =  'required';
            }
        }

        return $validacion;
        
    }

    public function messages()
    {
        $observacionriesgo = count($this->get('descripcionMatrizRiesgoProcesoDetalle'));        

        $mensajes = array();
        $mensajes["fechaMatrizRiesgoProceso.required"] = "[Encabezado] Debe ingresar la fecha de Elaboración";
        $mensajes["Tercero_idRespondable.required"] = "[Encabezado] Debe seleccionar el Responsable";
        $mensajes["Proceso_idProceso.required"] = "[Encabezado] Debe Seleccionar el Proceso";

        for($i = 0; $i < $observacionriesgo; $i++)
        {
            if(trim($this->get('descripcionMatrizRiesgoProcesoDetalle')[$i]) == '' )
            {    
                $mensajes["descripcionMatrizRiesgoProcesoDetalle".$i.".required"] = "[Detalle] Debe ingresar la descripción del riesgo en la línea ".($i+1);
            }           
        }

        return $mensajes;

    }

}
