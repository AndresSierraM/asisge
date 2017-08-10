<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class MatrizDofaRequest extends Request
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
        $descripcionDofa = count($this->get('descripcionMatrizDOFADetalle_Oportunidad'));
        $descripcionDofaFortaleza = count($this->get('descripcionMatrizDOFADetalle_Fortaleza'));
        $descripcionDofaAmenaza = count($this->get('descripcionMatrizDOFADetalle_Amenaza'));
        $descripcionDofaDebilidad = count($this->get('descripcionMatrizDOFADetalle_Debilidad'));

        $validacion = array(
            "fechaElaboracionMatrizDOFA" => "required",
            "Tercero_idResponsable" => "required",
            "Proceso_idProceso" => "required",
        );

        for($i = 0; $i < $descripcionDofa; $i++)
        {
            if(trim($this->get('descripcionMatrizDOFADetalle_Oportunidad')[$i]) == '')
            {    
                $validacion['descripcionMatrizDOFADetalle_Oportunidad'.$i] =  'required';
            }
        }
         for($i = 0; $i < $descripcionDofaFortaleza; $i++)
        {
            if(trim($this->get('descripcionMatrizDOFADetalle_Fortaleza')[$i]) == '')
            {    
                $validacion['descripcionMatrizDOFADetalle_Fortaleza'.$i] =  'required';
            }
        }
         for($i = 0; $i < $descripcionDofaAmenaza; $i++)
        {
            if(trim($this->get('descripcionMatrizDOFADetalle_Amenaza')[$i]) == '')
            {    
                $validacion['descripcionMatrizDOFADetalle_Amenaza'.$i] =  'required';
            }
        }
         for($i = 0; $i < $descripcionDofaDebilidad; $i++)
        {
            if(trim($this->get('descripcionMatrizDOFADetalle_Debilidad')[$i]) == '')
            {    
                $validacion['descripcionMatrizDOFADetalle_Debilidad'.$i] =  'required';
            }
        }


        return $validacion;
        
    }

    public function messages()
    {
        $descripcionDofa = count($this->get('descripcionMatrizDOFADetalle_Oportunidad'));  
        $descripcionDofaFortaleza = count($this->get('descripcionMatrizDOFADetalle_Fortaleza'));  
        $descripcionDofaAmenaza = count($this->get('descripcionMatrizDOFADetalle_Amenaza'));        
        $descripcionDofaDebilidad = count($this->get('descripcionMatrizDOFADetalle_Debilidad'));  

        $mensajes = array();
        $mensajes["fechaElaboracionMatrizDOFA.required"] = "[Encabezado] Debe ingresar la fecha de Elaboración";
        $mensajes["Tercero_idResponsable.required"] = "[Encabezado] Debe seleccionar el Responsable";
        $mensajes["Proceso_idProceso.required"] = "[Encabezado] Debe Seleccionar el Proceso";

        for($i = 0; $i < $descripcionDofa; $i++)
        {
            if(trim($this->get('descripcionMatrizDOFADetalle_Oportunidad')[$i]) == '' )
            {    
                $mensajes["descripcionMatrizDOFADetalle_Oportunidad".$i.".required"] = "[Detalle Oportunidad] Debe ingresar la descripción  en la línea ".($i+1);
            }           
        }
         for($i = 0; $i < $descripcionDofaFortaleza; $i++)
        {
            if(trim($this->get('descripcionMatrizDOFADetalle_Fortaleza')[$i]) == '' )
            {    
                $mensajes["descripcionMatrizDOFADetalle_Fortaleza".$i.".required"] = "[Detalle Fortaleza] Debe ingresar la descripción  en la línea ".($i+1);
            }           
        }
         for($i = 0; $i < $descripcionDofaAmenaza; $i++)
        {
            if(trim($this->get('descripcionMatrizDOFADetalle_Amenaza')[$i]) == '' )
            {    
                $mensajes["descripcionMatrizDOFADetalle_Amenaza".$i.".required"] = "[Detalle Amenazas] Debe ingresar la descripción  en la línea ".($i+1);
            }           
        }
         for($i = 0; $i < $descripcionDofaDebilidad; $i++)
        {
            if(trim($this->get('descripcionMatrizDOFADetalle_Debilidad')[$i]) == '' )
            {    
                $mensajes["descripcionMatrizDOFADetalle_Debilidad".$i.".required"] = "[Detalle Debilidades] Debe ingresar la descripción  en la línea ".($i+1);
            }           
        }

        return $mensajes;

    }

}
