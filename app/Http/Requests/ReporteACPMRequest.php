<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ReporteACPMRequest extends Request
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
        $proceso = count($this->get('Proceso_idProceso'));
        $modulo = count($this->get('Modulo_idModulo'));
        $responsableC = count($this->get('Tercero_idResponsableCorrecion'));
        $responsableA = count($this->get('Tercero_idResponsablePlanAccion'));

        $validacion = array(
            'fechaElaboracionReporteACPM' => 'required|date',
            'numeroReporteACPM' => 'required|integer');

        for($i = 0; $i < $proceso; $i++)
        {
            if(trim($this->get('Proceso_idProceso')[$i]) == '' or trim($this->get('Proceso_idProceso')[$i]) == 0)
            {    
                $validacion['Proceso_idProceso'.$i] =  'required';
            }
        }

        for($i = 0; $i < $modulo; $i++)
        {
            if(trim($this->get('Modulo_idModulo')[$i]) == '' or trim($this->get('Modulo_idModulo')[$i]) == 0)
            {    
                $validacion['Modulo_idModulo'.$i] =  'required';
            }
        }

        for($i = 0; $i < $responsableC; $i++)
        {
            if(trim($this->get('Tercero_idResponsableCorrecion')[$i]) == '' or trim($this->get('Tercero_idResponsableCorrecion')[$i]) == 0)
            {    
                $validacion['Tercero_idResponsableCorrecion'.$i] =  'required';
            }
        }

        for($i = 0; $i < $responsableA; $i++)
        {
            if(trim($this->get('Tercero_idResponsablePlanAccion')[$i]) == '' or trim($this->get('Tercero_idResponsablePlanAccion')[$i]) == 0)
            {    
                $validacion['Tercero_idResponsablePlanAccion'.$i] =  'required';
            }
        }

        return $validacion;
    }
}
