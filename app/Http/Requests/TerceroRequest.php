<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class TerceroRequest extends Request
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
        //required_if:tipoTercero,==,*01* para validar solamente cuando el tipo de tercero sea EJ 01
        
        $validacion = array('TipoIdentificacion_idTipoIdentificacion' => 'required',
            "documentoTercero" => "required|string|max:30|unique:tercero,documentoTercero,".$this->get('idTercero') .",idTercero,Compania_idCompania,".(\Session::get('idCompania')),
            'nombre1Tercero' => 'required_if:tipoTercero,==,*01*|string|max:20',
            'apellido1Tercero' => 'required_if:tipoTercero,==,*01*|string|max:20',
            'nombre2Tercero' => 'string|max:20',
            'apellido2Tercero' => 'string|max:20',
            'fechaCreacionTercero' => 'required',
            // 'tipoTercero' => 'required',
            'direccionTercero' => 'required|max:200',
            'Ciudad_idCiudad' => 'required',
            'telefonoTercero' => 'required|max:20');
    
    
        return $validacion;                    
    }



    public function messages()
    {

        $mensajes = array();             
        $mensajes["nombre1Tercero.required"] = "Debe ingresar  el primer nombre";
        $mensajes["apellido1Tercero.required_if:tipoTercero,==,*01*"] = "Debe ingresar  el primer apellido";         
        return $mensajes;

    }
}
