<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class EquipoSeguimientoRequest extends Request
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
        $Identificacion = count($this->get('identificacionEquipoSeguimientoDetalle'));
        $Tipo = count($this->get('tipoEquipoSeguimientoDetalle'));
        $UnidadMedida = count($this->get('unidadMedidaCalibracionEquipoSeguimientoDetalle'));

        $validacion = array(
            "fechaEquipoSeguimiento" => "required",
            "nombreEquipoSeguimiento" => "required",
            "Tercero_idResponsable" => "required",
        );

        for($i = 0; $i < $Identificacion; $i++)
        {
            if(trim($this->get('identificacionEquipoSeguimientoDetalle')[$i]) == '')
            {    
                $validacion['identificacionEquipoSeguimientoDetalle'.$i] =  'required';
            }
        }
        for($i = 0; $i < $Tipo; $i++)
        {
            if(trim($this->get('tipoEquipoSeguimientoDetalle')[$i]) == '')
            {    
                $validacion['tipoEquipoSeguimientoDetalle'.$i] =  'required';
            }
        }
        for($i = 0; $i < $UnidadMedida; $i++)
        {
            if(trim($this->get('unidadMedidaCalibracionEquipoSeguimientoDetalle')[$i]) == '')
            {    
                $validacion['unidadMedidaCalibracionEquipoSeguimientoDetalle'.$i] =  'required';
            }
        }

        return $validacion;
        
    }

    public function messages()
    {
        $Identificacion = count($this->get('identificacionEquipoSeguimientoDetalle'));
        $Tipo = count($this->get('tipoEquipoSeguimientoDetalle'));
        $UnidadMedida = count($this->get('unidadMedidaCalibracionEquipoSeguimientoDetalle'));     

        $mensajes = array();
        $mensajes["fechaEquipoSeguimiento.required"] = "[Encabezado] Debe ingresar la fecha de Elaboración";
        $mensajes["nombreEquipoSeguimiento.required"] = "[Encabezado] Debe ingresar  el Equipo";
        $mensajes["Tercero_idResponsable.required"] = "[Encabezado] Debe Seleccionar el Responsable";

        for($i = 0; $i < $Identificacion; $i++)
        {
            if(trim($this->get('identificacionEquipoSeguimientoDetalle')[$i]) == '' )
            {    
                $mensajes["identificacionEquipoSeguimientoDetalle".$i.".required"] = "[Detalle] Debe ingresar la Identificación/Código en la línea ".($i+1);
            }           
        }
          for($i = 0; $i < $Tipo; $i++)
        {
            if(trim($this->get('tipoEquipoSeguimientoDetalle')[$i]) == '' )
            {    
                $mensajes["tipoEquipoSeguimientoDetalle".$i.".required"] = "[Detalle] Debe Seleccionar el Tipo en la línea ".($i+1);
            }           
        }
          for($i = 0; $i < $UnidadMedida; $i++)
        {
            if(trim($this->get('unidadMedidaCalibracionEquipoSeguimientoDetalle')[$i]) == '' )
            {    
                $mensajes["unidadMedidaCalibracionEquipoSeguimientoDetalle".$i.".required"] = "[Detalle] Debe ingresar la  unidad de medida  en la línea ".($i+1);
            }           
        }

        return $mensajes;

    }

}
