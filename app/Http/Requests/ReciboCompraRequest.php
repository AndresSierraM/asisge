<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ReciboCompraRequest extends Request
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
        $tipocalidad = count($this->get('TipoCalidad_idTipoCalidad'));

        $validacion = array(
            'fechaRealReciboCompra' => "required|date");

        for($i = 0; $i < $tipocalidad; $i++)
        {
            if(trim($this->get('TipoCalidad_idTipoCalidad')[$i]) == '' or trim($this->get('TipoCalidad_idTipoCalidad')[$i]) == 0)
            {    
                $validacion['TipoCalidad_idTipoCalidad'.$i] =  'required';
            }
        }
        
        return $validacion;
    }

        public function messages()
    {
        $tipocalidad = count($this->get('TipoCalidad_idTipoCalidad'));  


        $mensajes = array();
        $mensajes["fechaRealReciboCompra.required"] = "[Encabezado] Debe ingresar la fecha de Entrega";


        for($i = 0; $i < $tipocalidad; $i++)
        {
            if(trim($this->get('TipoCalidad_idTipoCalidad')[$i]) == '' )
            {    
                $mensajes["TipoCalidad_idTipoCalidad".$i.".required"] = "[Recibos] Debe Seleccionar el Tipo Calidad en la línea ".($i+1);
            }           
        }
        return $mensajes;

    }
}
