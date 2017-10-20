<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class InformeRequest extends Request
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
        $col = count($this->get('idInformeColumna'));
        
        $validacion = array(
            "nombreInforme" => "required",
            "CategoriaInforme_idCategoriaInforme" => "required",
            "SistemaInformacion_idSistemaInformacion"=>"required",
            "vistaInforme"=>"required",
        );

            
        for($i = 0; $i < $col; $i++)
        {
            if(trim($this->get('campoInformeColumna')[$i]) == '' )
                $validacion['campoInformeColumna'.$i] =  'required';

            if(trim($this->get('tituloInformeColumna')[$i]) == '' )
                $validacion['tituloInformeColumna'.$i] =  'required';
            
            if(trim($this->get('alineacionHInformeColumna')[$i]) == '' )
                $validacion['alineacionHInformeColumna'.$i] =  'required';
            
            if(trim($this->get('alineacionVInformeColumna')[$i]) == '' )
                $validacion['alineacionVInformeColumna'.$i] =  'required';
            
            if(trim($this->get('formatoInformeColumna')[$i]) == '' )
                $validacion['formatoInformeColumna'.$i] =  'required';
        }

        return $validacion;
       
    }

    public function messages()
    {
        $col = count($this->get('idInformeColumna'));

        $mensajes = array();
        $mensajes["CategoriaInforme_idCategoriaInforme.required"] = "[Encabezado] Debe Seleccionar la Categoría";
        $mensajes["nombreInforme.required"] = "[Encabezado] Debe digitar el Nombre del Informe";
        $mensajes["SistemaInformacion_idSistemaInformacion.required"] = "[Encabezado] Debe Seleccionar el Sistema ";
        $mensajes["vistaInforme.required"] = "[Encabezado] Debe Seleccionar la Tabla o Vista";
       
        for($i = 0; $i < $col; $i++)
        {
            if(trim($this->get('campoInformeColumna')[$i]) == '' )
                $mensajes["campoInformeColumna".$i.".required"] = "[Columnas] Debe ingresar el Campo (Línea ".($i+1).")";

            if(trim($this->get('tituloInformeColumna')[$i]) == '' )
                $mensajes["tituloInformeColumna".$i.".required"] = "[Columnas] Debe ingresar el Título (Línea ".($i+1).")";

            if(trim($this->get('alineacionHInformeColumna')[$i]) == '' )
                $mensajes["alineacionHInformeColumna".$i.".required"] = "[Columnas] Debe Seleccionar Alineación Horizontal (Línea ".($i+1).")";
            
            if(trim($this->get('alineacionVInformeColumna')[$i]) == '' )
                $mensajes["alineacionVInformeColumna".$i.".required"] = "[Columnas] Debe Seleccionar Alineación Vertical (Línea ".($i+1).")";

            if(trim($this->get('formatoInformeColumna')[$i]) == '' )
                $mensajes["formatoInformeColumna".$i.".required"] = "[Columnas] Debe Seleccionar el Formato de Campo (Línea ".($i+1).")";
            
        }

        return $mensajes;
    
    }

}
