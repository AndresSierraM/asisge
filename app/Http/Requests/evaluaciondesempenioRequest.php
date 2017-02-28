<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class evaluaciondesempenioRequest extends Request
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
 
    // Se crean las variables que contengan el dato de la multiregistro
        $EvaluacionResponsabilidad = count($this->get('respuestaEvaluacionResponsabilidad'));
        $EvaluacionEducacion = count($this->get('PerfilCargo_idAspirante_Educacion'));
        $EvaluacionFormacion = count($this->get('PerfilCargo_idAspirante_Formacion'));
        $EvaluacionHabilidad = count($this->get('PerfilCargo_idAspirante_Habilidad'));
        $EvaluacionPlanAccion = count($this->get('actividadEvaluacionAccion'));

    

        // Variables encabezado
        $validacion = array(
            "Tercero_idEmpleado" => "required",
            "Cargo_idCargo" => "required",
            "Tercero_idResponsable"  => "required",
            "fechaElaboracionEvaluacionDesempenio" => "required");






        for($i = 0; $i < $EvaluacionResponsabilidad; $i++)
        {
            if(trim($this->get('respuestaEvaluacionResponsabilidad')[$i]) == '')
            {    
                $validacion['respuestaEvaluacionResponsabilidad'.$i] =  'required';
            }
        }

         for($i = 0; $i < $EvaluacionEducacion; $i++)
        {
            if(trim($this->get('PerfilCargo_idAspirante_Educacion')[$i]) == '')
            {    
                $validacion['PerfilCargo_idAspirante_Educacion'.$i] =  'required';
            }
        }

        for($i = 0; $i < $EvaluacionFormacion; $i++)
        {
            if(trim($this->get('PerfilCargo_idAspirante_Formacion')[$i]) == '')
            {    
                $validacion['PerfilCargo_idAspirante_Formacion'.$i] =  'required';
            }
        }
        
          for($i = 0; $i < $EvaluacionHabilidad; $i++)
        {
            if(trim($this->get('PerfilCargo_idAspirante_Habilidad')[$i]) == '' or trim($this->get('PerfilCargo_idAspirante_Habilidad')[$i]) == 0)
            {    
                $validacion['PerfilCargo_idAspirante_Habilidad'.$i] =  'required';
            }
        }



          for($i = 0; $i < $EvaluacionPlanAccion; $i++)
        {
            if(trim($this->get('actividadEvaluacionAccion')[$i]) == '')
            {    
                $validacion['actividadEvaluacionAccion'.$i] =  'required';
            }
        }

    
        return $validacion;


    }
}
