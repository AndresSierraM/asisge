<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class EntrevistaRequest extends Request
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

        $EntrevistaHijos = count($this->get('nombreEntrevistaHijo'));
        $RelacionFamiliar = count($this->get('parentescoEntrevistaRelacionFamiliar'));
        $CompetenciaPregunta = count($this->get('valorEntrevistaCompetencia'));
        $EntrevistaFormacion = count($this->get('calificacionEntrevistaFormacion'));
        $EntrevistaEducacion = count($this->get('calificacionEntrevistaEducacion'));
        $EntrevistaHabilidad = count($this->get('calificacionEntrevistaHabilidad'));
        $EncuestaPregunta = count($this->get('idEncuestaPregunta'));
          
        $validacion = array("documentoAspiranteEntrevista" => "required|string|max:30|",
            "estadoEntrevista" => "required",
            "nombre1AspiranteEntrevista" => 'required|string|max:20',
            "apellido1AspiranteEntrevista" => 'required|string|max:20',
            "fechaEntrevista" => "required",
            "Tercero_idEntrevistador" => "required",
            "Cargo_idCargo" => "required",
            "experienciaAspiranteEntrevista" => 'required|numeric|min:0',
            "TipoIdentificacion_idTipoIdentificacion" => "required",
            "experienciaAspiranteEntrevista" => 'required|numeric|min:0');
        

         for($i = 0; $i < $EntrevistaHijos; $i++)
        {
            if(trim($this->get('nombreEntrevistaHijo')[$i]) == '')
            {    
                $validacion['nombreEntrevistaHijo'.$i] =  'required';
            }
        }

        for($i = 0; $i < $RelacionFamiliar; $i++)
        {
            if(trim($this->get('parentescoEntrevistaRelacionFamiliar')[$i]) == '')
            {    
                $validacion['parentescoEntrevistaRelacionFamiliar'.$i] =  'required';
            }
        }
        
          for($i = 0; $i < $CompetenciaPregunta; $i++)
        {
            if(trim($this->get('valorEntrevistaCompetencia')[$i]) == '' or trim($this->get('valorEntrevistaCompetencia')[$i]) == 0)
            {    
                $validacion['valorEntrevistaCompetencia'.$i] =  'required';
            }
        }

        for($i = 0; $i < $EntrevistaFormacion; $i++)
        {
            if(trim($this->get('calificacionEntrevistaFormacion')[$i]) == '')
            {    
                $validacion['calificacionEntrevistaFormacion'.$i] =  'required';
            }
        }
          for($i = 0; $i < $EntrevistaEducacion; $i++)
        {
            if(trim($this->get('calificacionEntrevistaEducacion')[$i]) == '')
            {    
                $validacion['calificacionEntrevistaEducacion'.$i] =  'required';
            }

        }

        for($i = 0; $i < $EntrevistaHabilidad; $i++)
        {
            if(trim($this->get('calificacionEntrevistaHabilidad')[$i]) == '')
            {    
                $validacion['calificacionEntrevistaHabilidad'.$i] =  'required';
            }
        }

        return $validacion;


    }
         
         public function messages()
    {
        $EntrevistaEducacion = count($this->get('calificacionEntrevistaEducacion'));
        
        $validacion = array(    
        'TipoIdentificacion_idTipoIdentificacion.required'=> 'Debe seleccionar el tipo de identificaci&#243;n',
        'documentoAspiranteEntrevista.unique' => 'Este codigo ya se encuentra en uso.',
        'Cargo_idCargo.required'=> 'Debe seleccionar el  Cargo.',
        'nombre1AspiranteEntrevista.required'=> 'El campo primer Nombre es obligatorio.',
        'apellido1AspiranteEntrevista.required'=> 'El campo primer Apellido es obligatorio.',
        'fechaEntrevista.required'=> 'El campo fecha de la Entrevista es obligatorio.',
        'Tercero_idEntrevistador.required'=> 'Debe seleccionar el Entrevistador.');
    


        return $validacion;
        
    }
}
