<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class EntregaElementoProteccionRequest extends Request
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
        $elemento = count($this->get('ElementoProteccion_idElementoProteccion'));
        $cantidad = count($this->get('cantidadEntregaElementoProteccionDetalle'));


        $validacion = array( 
            "Tercero_idTercero" => "required",
            "fechaEntregaElementoProteccion" => "required|date");
        
        for($i = 0; $i < $elemento; $i++)
        {
            if(trim($this->get('ElementoProteccion_idElementoProteccion')[$i]) == '' or trim($this->get('ElementoProteccion_idElementoProteccion')[$i]) == 0)
            {    
                $validacion['ElementoProteccion_idElementoProteccion'.$i] =  'required';
            }
        }

        for($i = 0; $i < $cantidad; $i++)
        {
            if(trim($this->get('cantidadEntregaElementoProteccionDetalle')[$i]) == '' or trim($this->get('cantidadEntregaElementoProteccionDetalle')[$i]) == 0)
            {    
                $validacion['cantidadEntregaElementoProteccionDetalle'.$i] =  'required';
            }
        }

        return $validacion;
    }
}