<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class AccidenteRequest extends Request
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
        
        // return[
        //     "Tercero_idCoordinador" => "required|integer",
        //     "nombreAccidente" => "required|string|max:80",
        //     "fechaOcurrenciaAccidente" => "required|date",
        //     "clasificacionAccidente" => "required|string"
        // ];

        $responsable = count($this->get('Proceso_idResponsable'));
        $investigador = count($this->get('Tercero_idInvestigador'));

        $validacion = array(
            "Tercero_idCoordinador" => "required|integer",
            "nombreAccidente" => "required|string|max:80",
            "fechaOcurrenciaAccidente" => "required|date",
            "clasificacionAccidente" => "required|string",
            "Tercero_idEmpleado" => "required",
            "Ausentismo_idAusentismo" => "required",
            "Proceso_idProceso" => "required");
        
        for($i = 0; $i < $responsable; $i++)
        {
            if(trim($this->get('Proceso_idResponsable')[$i]) == '' or trim($this->get('Proceso_idResponsable')[$i]) == 0)
            {    
                $validacion['Proceso_idResponsable'.$i] =  'required';
            }
        }

        for($i = 0; $i < $investigador; $i++)
        {
            if(trim($this->get('Tercero_idInvestigador')[$i]) == '' or trim($this->get('Tercero_idInvestigador')[$i]) == 0)
            {    
                $validacion['Tercero_idInvestigador'.$i] =  'required';
            }
        }

        return $validacion;
    }

    public function messages()
        {
        
            $validacion = array(    
            'nombreAccidente.required'=> 'Debe Ingresar una Descripci&#243;n del Accidente.',
            'clasificacionAccidente.required'=> 'Debe Seleccionar la clase del Accidente.',
            'Tercero_idCoordinador.required'=> 'Debe Seleccionar el Coordinador del equipo de Investigaci&#243;n.',
            'Ausentismo_idAusentismo.required'=> 'Debe Seleccionar el Ausentismo Relacionado al Accidente.',
            'Proceso_idProceso.required'=> 'Debe Seleccionar el &#225;rea o secci&#243;n del empleado.',


          );
        

            return $validacion;
            
        }
}