<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class OrdenProduccionRequest extends Request
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
        
        $proc = count($this->get('nombreProceso'));

        $validacion = array(
            "numeroOrdenProduccion" => "required|unique:ordenproduccion,numeroOrdenProduccion,".$this->get('idOrdenProduccion') .",idOrdenProduccion,Compania_idCompania,".(\Session::get('idCompania')),
            "fechaElaboracionOrdenProduccion" => "required",
            "Tercero_idCliente" => "required",
            "FichaTecnica_idFichaTecnica" => "required",
            "cantidadOrdenProduccion" => "required|min:0.01"
        );

        for($i = 0; $i < $proc; $i++)
        {
            if(trim($this->get('ordenOrdenProduccionProceso')[$i]) == '' )
            {    
                $validacion['ordenOrdenProduccionProceso'.$i] =  'required';
            }
            if(trim($this->get('nombreProceso')[$i]) == '' )
            {    
                $validacion['nombreProceso'.$i] =  'required';
            }
        }

       
        return $validacion;
        
    }

    public function messages()
    {
        $proc = count($this->get('nombreProceso'));
        $nota = count($this->get('observacionOrdenProduccionNota'));

        $mensajes = array();
        $mensajes["numeroOrdenProduccion.required"] = "[Encabezado] Debe ingresar el número de la orden de producción";
        $mensajes["numeroOrdenProduccion.unique"] = "[Encabezado] La orden de produccion ingresada ya existe";
        $mensajes["fechaElaboracionOrdenProduccion.required"] = "[Encabezado] Debe ingresar la fecha de elaboración";
        $mensajes["Tercero_idCliente.required"] = "[Encabezado] Debe Seleccionar el cliente";
        $mensajes["FichaTecnica_idFichaTecnica.required"] = "[Encabezado] Debe Seleccionar la referencia de producto";
        $mensajes["cantidadOrdenProduccion.required"] = "[Encabezado] Debe ingresar la cantidad a producir";

        for($i = 0; $i < $proc; $i++)
        {
            if(trim($this->get('ordenOrdenProduccionProceso')[$i]) == '' )
            {    
                $mensajes["ordenOrdenProduccionProceso".$i.".required"] = "[Ruta de Procesos] Debe ingresar el orden del proceso de la línea ".($i+1);
            }
            if(trim($this->get('nombreProceso')[$i]) == '' )
            {    
                $mensajes["nombreProceso".$i.".required"] = "[Ruta de Procesos] Debe seleccionar un proceso de la lista en la línea ".($i+1);
            }
        }

        return $mensajes;
    }

}
