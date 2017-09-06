<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class EquipoSeguimientoVerificacionRequest extends Request
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
       

        $validacion = array(
            "fechaEquipoSeguimientoVerificacion" => "required",
            "EquipoSeguimiento_idEquipoSeguimiento" => "required",
            "EquipoSeguimientoDetalle_idEquipoSeguimientoDetalle" => "required",
            "errorEncontradoEquipoSeguimientoVerificacion" => "required",

            
        );


        return $validacion;
        
    }

    public function messages()
    {
          

        $mensajes = array();
        $mensajes["fechaEquipoSeguimientoVerificacion.required"] = "Debe ingresar la fecha de Elaboración";
        $mensajes["EquipoSeguimiento_idEquipoSeguimiento.required"] = "Debe Seleccionar  el Equipo";
        $mensajes["EquipoSeguimientoDetalle_idEquipoSeguimientoDetalle.required"] = "Debe Seleccionar el Código";
        $mensajes["errorEncontradoEquipoSeguimientoVerificacion.required"] = "Debe Ingresar el Error Encontrado";


    
        return $mensajes;

    }

}
