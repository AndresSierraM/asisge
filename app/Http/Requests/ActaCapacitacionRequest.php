<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ActaCapacitacionRequest extends Request
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
        $asistente = count($this->get('Tercero_idAsistente'));

        $validacion = array('numeroActaCapacitacion' => 'required|max:200|unique:actacapacitacion,numeroActaCapacitacion,'.$this->get('idActaCapacitacion').',idActaCapacitacion',
            'fechaElaboracionActaCapacitacion' => 'required',
            'PlanCapacitacion_idPlanCapacitacion' => 'required');

        for($i = 0; $i < $tema; $i++)
        {
            if(trim($this->get('Tercero_idCapacitador')[$i]) == '' or trim($this->get('Tercero_idCapacitador')[$i]) == 0)
            {    
                $validacion['Tercero_idCapacitador'.$i] =  'required';
            }

            if(trim($this->get('fechaPlanCapacitacionTema')[$i]) == '' or trim($this->get('fechaPlanCapacitacionTema')[$i]) == 0)
            {    
                $validacion['fechaPlanCapacitacionTema'.$i] =  'required';
            }

            if(trim($this->get('horaPlanCapacitacionTema')[$i]) == '' or trim($this->get('horaPlanCapacitacionTema')[$i]) == 0)
            {    
                $validacion['horaPlanCapacitacionTema'.$i] =  'required';
            }
        }

        for($i = 0; $i < $asistente; $i++)
        {
            if(trim($this->get('Tercero_idAsistente')[$i]) == '' or trim($this->get('Tercero_idAsistente')[$i]) == 0)
            {    
                $validacion['Tercero_idAsistente'.$i] =  'required';
            }
        }

        return $validacion;
    }
}
