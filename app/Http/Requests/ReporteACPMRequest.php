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
        $tipoReporte = count($this->get('tipoReporteACPMDetalle'));
        

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


        for($i = 0; $i < $tipoReporte; $i++)
        {
            if(trim($this->get('tipoReporteACPMDetalle')[$i]) == '' or trim($this->get('tipoReporteACPMDetalle')[$i]) == '') //se pone ' ' en vez de 0, Ya que es un select es con datos quemados.
            {    
                $validacion['tipoReporteACPMDetalle'.$i] =  'required';
            }
        }

  

        return $validacion;
    }
}
