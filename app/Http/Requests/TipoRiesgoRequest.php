<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class TipoRiesgoRequest extends Request
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

        $detalle = count($this->get('nombreTipoRiesgoDetalle'));
        $salud = count($this->get('nombreTipoRiesgoSalud'));
        
        $validacion = array(
             "codigoTipoRiesgo" => "required|string|max:20|unique:tiporiesgo,codigoTipoRiesgo,".$this->get('idTipoRiesgo') .",idTipoRiesgo",
            "nombreTipoRiesgo" => "required|string|max:80",
            "origenTipoRiesgo" => "required|string",
            "ClasificacionRiesgo_idClasificacionRiesgo" => "required|numeric");

        for($i = 0; $i < $detalle; $i++)
        {
            if(trim($this->get('nombreTipoRiesgoDetalle')[$i]) == '' )
            {    
                $validacion['nombreTipoRiesgoDetalle'.$i] =  'required';
            }
        }

        for($i = 0; $i < $salud; $i++)
        {
            if(trim($this->get('nombreTipoRiesgoSalud')[$i]) == '')
            {    
                $validacion['nombreTipoRiesgoSalud'.$i] =  'required';
            }
        }
        return $validacion;

    }
}
