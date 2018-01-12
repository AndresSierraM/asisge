<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ProgramaRequest extends Request
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
        $responsable = count($this->get('Tercero_idResponsable'));
        $documento = count($this->get('Documento_idDocumento'));
        $DetalleActividad = count($this->get('actividadProgramaDetalle'));

        $validacion = array(
            "nombrePrograma" => "required|String",
            "fechaElaboracionPrograma" => "required|date",
            "ClasificacionRiesgo_idClasificacionRiesgo" => "required",
            "CompaniaObjetivo_idCompaniaObjetivo" => "required",
            "Tercero_idElabora" => "required");


        for($i = 0; $i < $DetalleActividad; $i++)
        {
            if(trim($this->get('actividadProgramaDetalle')[$i]) == '' or trim($this->get('actividadProgramaDetalle')[$i]) == '')
            {    
                $validacion['actividadProgramaDetalle'.$i] =  'required';
            }
        }
        
        for($i = 0; $i < $responsable; $i++)
        {
            if(trim($this->get('Tercero_idResponsable')[$i]) == '' or trim($this->get('Tercero_idResponsable')[$i]) == 0)
            {    
                $validacion['Tercero_idResponsable'.$i] =  'required';
            }
        }

        for($i = 0; $i < $documento; $i++)
        {
            if(trim($this->get('Documento_idDocumento')[$i]) == '' or trim($this->get('Documento_idDocumento')[$i]) == 0)
            {    
                $validacion['Documento_idDocumento'.$i] =  'required';
            }
        }

      

        return $validacion;
    }

     public function messages()
    {
        $responsable = count($this->get('Tercero_idResponsable'));
        $documento = count($this->get('Documento_idDocumento'));
        $DetalleActividad = count($this->get('actividadProgramaDetalle'));

        $mensajes = array();
        $mensajes["nombrePrograma.required"] = "[Encabezado] Debe ingresar el nombre del programa";
        $mensajes["fechaElaboracionPrograma.required"] = "[Encabezado] Debe ingresar la fecha de Elaboración ";
        $mensajes["ClasificacionRiesgo_idClasificacionRiesgo.required"] = "[Encabezado] Debe seleccionar la clasificación del riesgo";
        $mensajes["CompaniaObjetivo_idCompaniaObjetivo.required"] = "[Encabezado] Debe seleccionar el objetivo general";
        $mensajes["Tercero_idElabora.required"] = "[Encabezado] Debe seleccionar el tercero que elabora el programa";



         for($i = 0; $i < $DetalleActividad; $i++)
        {
            if(trim($this->get('actividadProgramaDetalle')[$i]) == '' )
            {    
                $mensajes["actividadProgramaDetalle".$i.".required"] = "[Detalle] Debe ingresar la actividad en la línea ".($i+1);
            }           
        }
        for($i = 0; $i < $responsable; $i++)
        {
            if(trim($this->get('Tercero_idResponsable')[$i]) == '' )
            {    
                $mensajes["Tercero_idResponsable".$i.".required"] = "[Detalle] Debe seleccionar el responsable en la línea ".($i+1);
            }           
        }
        for($i = 0; $i < $documento; $i++)
        {
            if(trim($this->get('Documento_idDocumento')[$i]) == '' )
            {    
                $mensajes["Documento_idDocumento".$i.".required"] = "[Detalle] Debe seleccionar el documento en la línea ".($i+1);
            }           
        }

       


        return $mensajes;

    }
}
