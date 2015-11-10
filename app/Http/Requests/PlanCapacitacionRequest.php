<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class PlanCapacitacionRequest extends Request
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
        $tema = count($this->get('Tercero_idCapacitador'));
        
        $validacion = array('tipoPlanCapacitacion' => 'required',
            'nombrePlanCapacitacion' => 'required',
            'Tercero_idResponsable' => 'required');

        for($i = 0; $i < $tema; $i++)
        {
            if(trim($this->get('nombrePlanCapacitacionTema')[$i]) == '' )
            {    
                $validacion['nombrePlanCapacitacionTema'.$i] =  'required';
            }

            if(trim($this->get('Tercero_idCapacitador')[$i]) == '' or trim($this->get('Tercero_idCapacitador')[$i]) == 0)
            {    
                $validacion['Tercero_idCapacitador'.$i] =  'required';
            }

            if(trim($this->get('fechaPlanCapacitacionTema')[$i]) == '' or trim($this->get('fechaPlanCapacitacionTema')[$i]) == '0000-00-00')
            {    
                $validacion['fechaPlanCapacitacionTema'.$i] =  'required';
            }

            if(trim($this->get('horaPlanCapacitacionTema')[$i]) == '' or trim($this->get('horaPlanCapacitacionTema')[$i]) == '00:00')
            {    
                $validacion['horaPlanCapacitacionTema'.$i] =  'required';
            }
        }
        return $validacion;
    }
}
