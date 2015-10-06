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
            'fechaElaboracionMatrizRiesgo' => 'required');

        for($i = 0; $i < $proceso; $i++)
        {
            if(trim($this->get('Proceso_idProceso')[$i]) == '')
            {    
                $validacion['Proceso_idProceso'.$i] =  'required';
            }

            if(trim($this->get('ClasificacionRiesgo_idClasificacionRiesgo')[$i]) == '')
            {    
                $validacion['ClasificacionRiesgo_idClasificacionRiesgo'.$i] =  'required';
            }

            if(trim($this->get('TipoRiesgo_idTipoRiesgo')[$i]) == '')
            {    
                $validacion['TipoRiesgo_idTipoRiesgo'.$i] =  'required';
            }

            if(trim($this->get('TipoRiesgoDetalle_idTipoRiesgoDetalle')[$i]) == '')
            {    
                $validacion['TipoRiesgoDetalle_idTipoRiesgoDetalle'.$i] =  'required';
            }

            if(trim($this->get('TipoRiesgoSalud_idTipoRiesgoSalud')[$i]) == '')
            {    
                $validacion['TipoRiesgoSalud_idTipoRiesgoSalud'.$i] =  'required';
            }

            if(trim($this->get('ListaGeneral_idEliminacionRiesgo')[$i]) == '')
            {    
                $validacion['ListaGeneral_idEliminacionRiesgo'.$i] =  'required';
            }

            if(trim($this->get('ListaGeneral_idSustitucionRiesgo')[$i]) == '')
            {    
                $validacion['ListaGeneral_idSustitucionRiesgo'.$i] =  'required';
            }

            if(trim($this->get('ListaGeneral_idControlAdministrativo')[$i]) == '')
            {    
                $validacion['ListaGeneral_idControlAdministrativo'.$i] =  'required';
            }

            if(trim($this->get('ListaGeneral_idElementoProteccion')[$i]) == '')
            {    
                $validacion['ListaGeneral_idElementoProteccion'.$i] =  'required';
            }
            
        }

        return $validacion;
    }
}
