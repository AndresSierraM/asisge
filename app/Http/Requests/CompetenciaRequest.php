<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class CompetenciaRequest extends Request
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
      //   return [

      // "nombreCompetencia" => "required|string|max:100|",
      // "estadoCompetencia" => "required|"
     
      //   ];
         // Se crean las variables que contengan el dato de la multiregistro
        $CompetenciaDetalle = count($this->get('preguntaCompetenciaPregunta'));
        $CompetenciaTipo = count($this->get('respuestaCompetenciaPregunta'));
        $CompetenciaTipoPregunta = count($this->get('estadoCompetenciaPregunta'));
        $CompetenciaOrden = count($this->get('ordenCompetenciaPregunta'));


        
        
 
    

        // Variables encabezado
        $validacion = array(
            "nombreCompetencia" => "required",
            "estadoCompetencia" => "required");

        for($i = 0; $i < $CompetenciaDetalle; $i++)
        {
            if(trim($this->get('preguntaCompetenciaPregunta')[$i]) == '')
            {    
                $validacion['preguntaCompetenciaPregunta'.$i] =  'required';
            }
        }
            for($i = 0; $i < $CompetenciaTipo; $i++)
        {
            if(trim($this->get('respuestaCompetenciaPregunta')[$i]) == '')
            {    
                $validacion['respuestaCompetenciaPregunta'.$i] =  'required';
            }
        }

           for($i = 0; $i < $CompetenciaTipoPregunta; $i++)
        {
            if(trim($this->get('estadoCompetenciaPregunta')[$i]) == '')
            {    
                $validacion['estadoCompetenciaPregunta'.$i] =  'required';
            }
        }


        for($i = 0; $i < $CompetenciaOrden; $i++)
        {
            if(trim($this->get('ordenCompetenciaPregunta')[$i]) == 0)
            {    
                $validacion['ordenCompetenciaPregunta'.$i]  =  'required|min:1';
            }
        }




    
        return $validacion;


    }
}
