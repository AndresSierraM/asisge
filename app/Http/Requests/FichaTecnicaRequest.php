<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class FichaTecnicaRequest extends Request
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
        
        $proc = count($this->get('nombreProceso'));
        $nota = count($this->get('observacionFichaTecnicaNota'));

        $validacion = array(
            "referenciaFichaTecnica" => "required|unique:fichatecnica,referenciaFichaTecnica,".$this->get('idFichaTecnica') .",idFichaTecnica,Compania_idCompania,".(\Session::get('idCompania')),
            "nombreFichaTecnica" => "required|string|max:80",
            "LineaProducto_idLineaProducto" => "required"
        );

        for($i = 0; $i < $proc; $i++)
        {
            if(trim($this->get('ordenFichaTecnicaProceso')[$i]) == '' )
            {    
                $validacion['ordenFichaTecnicaProceso'.$i] =  'required';
            }
            if(trim($this->get('nombreProceso')[$i]) == '' )
            {    
                $validacion['nombreProceso'.$i] =  'required';
            }
        }

        for($i = 0; $i < $nota; $i++)
        {
            if(trim($this->get('observacionFichaTecnicaNota')[$i]) == '')
            {    
                $validacion['observacionFichaTecnicaNota'.$i] =  'required';
            }
        }

        return $validacion;
        
    }

    public function messages()
    {
        $proc = count($this->get('nombreProceso'));
        $nota = count($this->get('observacionFichaTecnicaNota'));

        $mensajes = array();
        $mensajes["referenciaFichaTecnica.required"] = "[Encabezado] Debe ingresar la referencia del producto";
        $mensajes["referenciaFichaTecnica.unique"] = "[Encabezado] La referencia ingresada ya existe";
        $mensajes["nombreFichaTecnica.required"] = "[Encabezado] Debe ingresar el nombre del Producto";
        $mensajes["LineaProducto_idLineaProducto.required"] = "[Encabezado] Debe Seleccionar la línea de Producto";

        for($i = 0; $i < $proc; $i++)
        {
            if(trim($this->get('ordenFichaTecnicaProceso')[$i]) == '' )
            {    
                $mensajes["ordenFichaTecnicaProceso".$i.".required"] = "[Ruta de Procesos] Debe ingresar el orden del proceso de la línea ".($i+1);
            }
            if(trim($this->get('nombreProceso')[$i]) == '' )
            {    
                $mensajes["nombreProceso".$i.".required"] = "[Ruta de Procesos] Debe seleccionar un proceso de la lista en la línea ".($i+1);
            }
        }

        for($i = 0; $i < $nota; $i++)
        {
            if(trim($this->get('observacionFichaTecnicaNota')[$i]) == '')
            {    
                $mensajes["observacionFichaTecnicaNota".$i.".required"] = "[Notas] Debe ingresar la Nota en la  línea ".($i+1);
            }
        }


        return $mensajes;

    }

}
