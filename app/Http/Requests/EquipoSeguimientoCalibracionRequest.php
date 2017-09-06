<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class EquipoSeguimientoCalibracionRequest extends Request
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
            "fechaEquipoSeguimientoCalibracion" => "required",
            "EquipoSeguimiento_idEquipoSeguimiento" => "required",
            "EquipoSeguimientoDetalle_idEquipoSeguimientoDetalle" => "required",
            "Tercero_idProveedor" => "required",
            "errorEncontradoEquipoSeguimientoCalibracion" => "required",     
        );


        return $validacion;
        
    }

    public function messages()
    {
          

        $mensajes = array();
        $mensajes["fechaEquipoSeguimientoCalibracion.required"] = "Debe ingresar la fecha de Elaboración";
        $mensajes["EquipoSeguimiento_idEquipoSeguimiento.required"] = "Debe Seleccionar  el Equipo";
        $mensajes["EquipoSeguimientoDetalle_idEquipoSeguimientoDetalle.required"] = "Debe Seleccionar el Código";
        $mensajes["Tercero_idProveedor.required"] = "Debe Seleccionar el Proveedor";
        $mensajes["errorEncontradoEquipoSeguimientoCalibracion.required"] = "Debe Ingresar el Error Encontrado";


    
        return $mensajes;

    }

}
