<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ManualGestionRequest extends Request
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

         $interesadoManual = count($this->get('interesadoManualGestionParte'));
         $necesidadManual = count($this->get('necesidadManualGestionParte'));
         $cumplimientoManual = count($this->get('cumplimientoManualGestionParte'));


        $validacion = array(
            "codigoManualGestion" => "required",
            "nombreManualGestion" => "required",
            "fechaManualGestion" => "required",
            "Tercero_idEmpleador" => "required"
        );

        for($i = 0; $i < $interesadoManual; $i++)
        {
            if(trim($this->get('interesadoManualGestionParte')[$i]) == '')
            {    
                $validacion['interesadoManualGestionParte'.$i] =  'required';
            }
        }

        for($i = 0; $i < $necesidadManual; $i++)
        {
            if(trim($this->get('necesidadManualGestionParte')[$i]) == '')
            {    
                $validacion['necesidadManualGestionParte'.$i] =  'required';
            }
        }
        for($i = 0; $i < $cumplimientoManual; $i++)
        {
            if(trim($this->get('cumplimientoManualGestionParte')[$i]) == '')
            {    
                $validacion['cumplimientoManualGestionParte'.$i] =  'required';
            }
        }
   

 
        return $validacion;
        
    }

    public function messages()
    {
         $interesadoManual = count($this->get('interesadoManualGestionParte'));
         $necesidadManual = count($this->get('necesidadManualGestionParte'));
         $cumplimientoManual = count($this->get('cumplimientoManualGestionParte'));

        $mensajes = array();
        $mensajes["codigoManualGestion.required"] = "[Encabezado] Debe ingresar el código";
        $mensajes["nombreManualGestion.required"] = "[Encabezado] Debe ingresar el nombre ";
        $mensajes["fechaManualGestion.required"] = "[Encabezado] ingresar la fecha de Elaboración";
        $mensajes["Tercero_idEmpleador.required"] = "[Encabezado] Debe seleccionar el Empleador";


        
        // --FOR PARA MULTIREGISTRO LIMITES
         for($i = 0; $i < $interesadoManual; $i++)
        {
            if(trim($this->get('interesadoManualGestionParte')[$i]) == '' )
            {    
                $mensajes["interesadoManualGestionParte".$i.".required"] = "[Detalle Partes interesadas] Debe ingresar la parte interesada en la línea ".($i+1);
            }           
        }
       for($i = 0; $i < $necesidadManual; $i++)
        {
            if(trim($this->get('necesidadManualGestionParte')[$i]) == '' )
            {    
                $mensajes["necesidadManualGestionParte".$i.".required"] = "[Detalle Partes interesadas] Debe ingresar la necesidad en la línea ".($i+1);
            }           
        }
       for($i = 0; $i < $cumplimientoManual; $i++)
        {
            if(trim($this->get('cumplimientoManualGestionParte')[$i]) == '' )
            {    
                $mensajes["cumplimientoManualGestionParte".$i.".required"] = "[Detalle Partes interesadas] Debe ingresar cómo se cumplen las necesidades en la línea ".($i+1);
            }           
        }
        return $mensajes;

    }


}
