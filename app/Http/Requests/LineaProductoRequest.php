<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class LineaProductoRequest extends Request
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
         // Se crean las variables que contengan el dato de la multiregistro
        $NombreSublinea = count($this->get('nombreSublineaProducto'));
        $CodigoSublinea = count($this->get('codigoSublineaProducto'));


        $validacion = array(
            "codigoLineaProducto" => "required|string|max:20|unique:lineaproducto,codigoLineaProducto,".$this->get('idLineaProducto') .",idLineaProducto,Compania_idCompania,".(\Session::get('idCompania')),
            "nombreLineaProducto" => "required|string|max:80");



          for($i = 0; $i < $NombreSublinea; $i++)
        {
            if(trim($this->get('nombreSublineaProducto')[$i]) == '')
            {    
                $validacion['nombreSublineaProducto'.$i] =  'required';
            }
        }

        for($i = 0; $i < $CodigoSublinea; $i++)
        {
            if(trim($this->get('codigoSublineaProducto')[$i]) == '')
            {    
                $validacion['codigoSublineaProducto'.$i] =  'required';
            }
        }

        return $validacion;
    }

    public function messages()
        {
            // Creamos una variable que es la que va a contrar los registros de esa multiregistro
            $NombreSublinea = count($this->get('nombreSublineaProducto'));

            $mensajes = array();
            $mensajes["codigoLineaProducto.unique"] = "[Encabezado] El Codigo ingresado ya existe";
            $mensajes["codigoLineaProducto.required"] = "[Encabezado] Debe ingresar el Codigo de la Linea";
            $mensajes["nombreLineaProducto.required"] = "[Encabezado] Debe ingresar el Nombre de la Linea";

            for($i = 0; $i < $NombreSublinea; $i++)
            {
                if(trim($this->get('nombreSublineaProducto')[$i]) == '' )
                {    
                    $mensajes["nombreSublineaProducto".$i.".required"] = "[Sublinea] Debe ingresar el nombre de la Sublinea ".($i+1);
                }
                if(trim($this->get('codigoSublineaProducto')[$i]) == '' )
                {    
                    $mensajes["codigoSublineaProducto".$i.".required"] = "[Sublinea] Debe ingresar el codigo de la Sublinea".($i+1);
                }
            }

        return $mensajes;

    }
}
