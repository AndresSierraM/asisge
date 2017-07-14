<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class OrdenTrabajoRequest extends Request
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
            "numeroOrdenTrabajo" => "required|unique:ordentrabajo,numeroOrdenTrabajo,".$this->get('idOrdenTrabajo') .",idOrdenTrabajo,Compania_idCompania,".(\Session::get('idCompania')),
            "fechaElaboracionOrdenTrabajo" => "required",
            "OrdenProduccion_idOrdenProduccion" => "required",
            "Proceso_idProceso" => "required",
            "cantidadOrdenTrabajo" => "required|min:0.01"
        );

        for($i = 0; $i < $cal; $i++)
        {
            if(trim($this->get('TipoCalidad_idTipoCalidad')[$i]) == '' )
            {    
                $validacion['TipoCalidad_idTipoCalidad'.$i] =  'required';
            }
            if(trim($this->get('cantidadOrdenTrabajoDetalle')[$i]) == '' )
            {    
                $validacion['cantidadOrdenTrabajoDetalle'.$i] =  'required|min:0.01';
            }
        }

       
        return $validacion;
        
    }

    public function messages()
    {
        $cal = count($this->get('TipoCalidad_idTipoCalidad'));

        $mensajes = array();
        $mensajes["numeroOrdenTrabajo.required"] = "[Encabezado] Debe ingresar el número de la orden de Trabajo";
        $mensajes["numeroOrdenTrabajo.unique"] = "[Encabezado] La orden de Trabajo ingresada ya existe";
        $mensajes["fechaElaboracionOrdenTrabajo.required"] = "[Encabezado] Debe ingresar la fecha de elaboración";
        $mensajes["OrdenProduccion_idOrdenProduccion.required"] = "[Encabezado] Debe Seleccionar la Orden de Producción";
        $mensajes["Proceso_idProceso.required"] = "[Encabezado] Debe Seleccionar El proceso";
        $mensajes["cantidadOrdenTrabajo.required"] = "[Encabezado] Debe ingresar la cantidad a Remisionar";

        for($i = 0; $i < $cal; $i++)
        {
            if(trim($this->get('TipoCalidad_idTipoCalidad')[$i]) == '' )
            {    
                $mensajes["TipoCalidad_idTipoCalidad".$i.".required"] = "[Cantidades] Debe Seleccionar el tipo de calidad de la línea ".($i+1);
            }
            if(trim($this->get('cantidadOrdenTrabajoDetalle')[$i]) == '' )
            {    
                $mensajes["cantidadOrdenTrabajoDetalle".$i.".required"] = "[Cantidades] Debe ingresar la cantidad en la línea ".($i+1);
                $mensajes["cantidadOrdenTrabajoDetalle".$i.".min"] = "[Cantidades] La cantidad debe ser mayor a cero en la línea ".($i+1);
            }
        }

        return $mensajes;
    }

}
