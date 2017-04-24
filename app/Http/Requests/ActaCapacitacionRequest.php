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

        $validacion = array('numeroActaCapacitacion' => 'required|max:200|unique:actacapacitacion,numeroActaCapacitacion,'.$this->get('idActaCapacitacion').',idActaCapacitacion,Compania_idCompania,'.(\Session::get('idCompania')),
            'fechaElaboracionActaCapacitacion' => 'required',
            'PlanCapacitacion_idPlanCapacitacion' => 'required');

        for($i = 0; $i < $tema; $i++)
        {
            if(trim($this->get('Tercero_idCapacitador')[$i]) == '' or trim($this->get('Tercero_idCapacitador')[$i]) == 0)
            {    
                $validacion['Tercero_idCapacitador'.$i] =  'required';
            }

            if(trim($this->get('fechaActaCapacitacionTema')[$i]) == '')
            {    
                $validacion['fechaActaCapacitacionTema'.$i] =  'required';
            }

            if(trim($this->get('horaActaCapacitacionTema')[$i]) == '' or trim($this->get('horaActaCapacitacionTema')[$i]) == 0)
            {    
                $validacion['horaActaCapacitacionTema'.$i] =  'required';
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

    public function messages()
    {
      
        
        $validacion = array(    
        'PlanCapacitacion_idPlanCapacitacion.required'=> 'Debe Seleccionar el de Plan de Capacitaci&#243;n'
      );
    


        return $validacion;
        
    }
}
