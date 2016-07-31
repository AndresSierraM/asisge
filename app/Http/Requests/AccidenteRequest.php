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
}