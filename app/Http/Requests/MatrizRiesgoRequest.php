<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class MatrizRiesgoRequest extends Request
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
        $validacion = array('nombreMatrizRiesgo' => 'required|max:200',
            'fechaElaboracionMatrizRiesgo' => 'required',
            'FrecuenciaMedicion_idFrecuenciaMedicion' => 'required'
            );

        for($i = 0; $i < $proceso; $i++)
        {
            if(trim($this->get('Proceso_idProceso')[$i]) == '' or trim($this->get('Proceso_idProceso')[$i]) == 0)
            {    
                $validacion['Proceso_idProceso'.$i] =  'required';
            }

            if(trim($this->get('ClasificacionRiesgo_idClasificacionRiesgo')[$i]) == '' or trim($this->get('ClasificacionRiesgo_idClasificacionRiesgo')[$i]) == 0)
            {    
                $validacion['ClasificacionRiesgo_idClasificacionRiesgo'.$i] =  'required';
            }

            if(trim($this->get('TipoRiesgo_idTipoRiesgo')[$i]) == '' or trim($this->get('TipoRiesgo_idTipoRiesgo')[$i]) == 0)
            {    
                $validacion['TipoRiesgo_idTipoRiesgo'.$i] =  'required';
            }

            if(trim($this->get('TipoRiesgoDetalle_idTipoRiesgoDetalle')[$i]) == '' or trim($this->get('TipoRiesgoDetalle_idTipoRiesgoDetalle')[$i]) == 0)
            {    
                $validacion['TipoRiesgoDetalle_idTipoRiesgoDetalle'.$i] =  'required';
            }

            if(trim($this->get('TipoRiesgoSalud_idTipoRiesgoSalud')[$i]) == '' or trim($this->get('TipoRiesgoSalud_idTipoRiesgoSalud')[$i]) == 0)
            {    
                $validacion['TipoRiesgoSalud_idTipoRiesgoSalud'.$i] =  'required';
            }

            // if(trim($this->get('eliminacionMatrizRiesgoDetalle')[$i]) == '' )
            // {    
            //     $validacion['eliminacionMatrizRiesgoDetalle'.$i] =  'required';
            // }

            // if(trim($this->get('sustitucionMatrizRiesgoDetalle')[$i]) == '' )
            // {    
            //     $validacion['sustitucionMatrizRiesgoDetalle'.$i] =  'required';
            // }

            // if(trim($this->get('controlMatrizRiesgoDetalle')[$i]) == '' )
            // {    
            //     $validacion['controlMatrizRiesgoDetalle'.$i] =  'required';
            // }

            // if(trim($this->get('elementoProteccionMatrizRiesgoDetalle')[$i]) == '' )
            // {    
            //     $validacion['elementoProteccionMatrizRiesgoDetalle'.$i] =  'required';
            // }

            if(trim($this->get('nivelDeficienciaMatrizRiesgoDetalle')[$i]) == '' )
            {    
                $validacion['nivelDeficienciaMatrizRiesgoDetalle'.$i] =  'required';
            }

            if(trim($this->get('nivelExposicionMatrizRiesgoDetalle')[$i]) == '')
            {    
                $validacion['nivelExposicionMatrizRiesgoDetalle'.$i] =  'required';
            }

            if(trim($this->get('nivelConsecuenciaMatrizRiesgoDetalle')[$i]) == '')
            {    
                $validacion['nivelConsecuenciaMatrizRiesgoDetalle'.$i] =  'required';
            }
            
            
        }

        return $validacion;
    }
}
