<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class EjecucionTrabajoRequest extends Request
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
        
        $cal = count($this->get('TipoCalidad_idTipoCalidad'));

        $validacion = array(
            "numeroEjecucionTrabajo" => "required|unique:ejecuciontrabajo,numeroEjecucionTrabajo,".$this->get('idEjecucionTrabajo') .",idEjecucionTrabajo,Compania_idCompania,".(\Session::get('idCompania')),
            "fechaElaboracionEjecucionTrabajo" => "required",
            "OrdenTrabajo_idOrdenTrabajo" => "required",
            "cantidadEjecucionTrabajo" => "required|min:0.01"
        );

        for($i = 0; $i < $cal; $i++)
        {
            if(trim($this->get('TipoCalidad_idTipoCalidad')[$i]) == '' )
            {    
                $validacion['TipoCalidad_idTipoCalidad'.$i] =  'required';
            }
            if(trim($this->get('cantidadEjecucionTrabajoDetalle')[$i]) == '' )
            {    
                $validacion['cantidadEjecucionTrabajoDetalle'.$i] =  'required|min:0.01';
            }
        }

       
        return $validacion;
        
    }

    public function messages()
    {
        $cal = count($this->get('TipoCalidad_idTipoCalidad'));

        $mensajes = array();
        $mensajes["numeroEjecucionTrabajo.required"] = "[Encabezado] Debe ingresar el número de la Ejecución de Trabajo";
        $mensajes["numeroEjecucionTrabajo.unique"] = "[Encabezado] La Ejecución de Trabajo ingresada ya existe";
        $mensajes["fechaElaboracionEjecucionTrabajo.required"] = "[Encabezado] Debe ingresar la fecha de elaboración";
        $mensajes["OrdenTrabajo_idOrdenTrabajo.required"] = "[Encabezado] Debe Seleccionar la Orden de Trabajo";
        $mensajes["cantidadEjecucionTrabajo.required"] = "[Encabezado] Debe ingresar la cantidad Ejecutada";

        for($i = 0; $i < $cal; $i++)
        {
            if(trim($this->get('TipoCalidad_idTipoCalidad')[$i]) == '' )
            {    
                $mensajes["TipoCalidad_idTipoCalidad".$i.".required"] = "[Cantidades] Debe Seleccionar el tipo de calidad de la línea ".($i+1);
            }
            if(trim($this->get('cantidadEjecucionTrabajoDetalle')[$i]) == '' )
            {    
                $mensajes["cantidadEjecucionTrabajoDetalle".$i.".required"] = "[Cantidades] Debe ingresar la cantidad en la línea ".($i+1);
                $mensajes["cantidadEjecucionTrabajoDetalle".$i.".min"] = "[Cantidades] La cantidad debe ser mayor a cero en la línea ".($i+1);
            }
        }

        return $mensajes;
    }

}
