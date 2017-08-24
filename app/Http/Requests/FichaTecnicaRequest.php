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
        $color = count($this->get('Color_idColor'));
        $cantidad = count($this->get('cantidadFichaTecnicaColor'));
        $talla = count($this->get('Talla_idTalla'));
        $curva = count($this->get('curvaFichaTecnicaTalla'));

        $validacion = array('referenciaBaseFichaTecnica' => "required",
            'pesoNetoFichaTecnica' => 'required',
            'cantidadContenidaFichaTecnica' => 'required',
            'nombreLargoFichaTecnica' => 'required',
            'GrupoTalla_idGrupoTalla' => 'required|numeric|min:1',
            'TipoProducto_idTipoProducto' => 'required|numeric|min:1',
            'TipoNegocio_idTipoNegocio' => 'required|numeric|min:1'
            );

        for($i = 0; $i < $color; $i++)
        {
            if(trim($this->get('Color_idColor')[$i]) == '' or trim($this->get('Color_idColor')[$i]) == 0)
            {    
                $validacion['Color_idColor'.$i] =  'required';
            }
        }

        for($i = 0; $i < $cantidad; $i++)
        {
            if(trim($this->get('cantidadFichaTecnicaColor')[$i]) == '' or trim($this->get('cantidadFichaTecnicaColor')[$i]) == 0)
            {    
                $validacion['cantidadFichaTecnicaColor'.$i] =  'required';
            }
        }

        for($i = 0; $i < $talla; $i++)
        {
            if(trim($this->get('Talla_idTalla')[$i]) == '' or trim($this->get('Talla_idTalla')[$i]) == 0)
            {    
                $validacion['Talla_idTalla'.$i] =  'required';
            }
        }

        for($i = 0; $i < $curva; $i++)
        {
            if(trim($this->get('curvaFichaTecnicaTalla')[$i]) == '' or trim($this->get('curvaFichaTecnicaTalla')[$i]) == 0)
            {    
                $validacion['curvaFichaTecnicaTalla'.$i] =  'required';
            }
        }
    
        return $validacion;
    }

    public function messages()
    {
        $color = count($this->get('Color_idColor'));
        $cantidad = count($this->get('cantidadFichaTecnicaColor'));
        $talla = count($this->get('Talla_idTalla'));
        $curva = count($this->get('curvaFichaTecnicaTalla'));

        $mensajes = array();
        $mensajes["pesoNetoFichaTecnica.required"] = "[Encabezado] Debe digitar el peso de la ficha";
        $mensajes["cantidadContenidaFichaTecnica.required"] = "[Encabezado] Debe digitar la cantidad de la ficha";
        $mensajes["referenciaBaseFichaTecnica.required"] = "[Encabezado] Debe digitar la referencia de la ficha";
        $mensajes["nombreLargoFichaTecnica.required"] = "[Encabezado] Debe digitar la descripción de la ficha";
        $mensajes["GrupoTalla_idGrupoTalla.min"] = "[Clasificación] Debe seleccionar un grupo de talla";
        $mensajes["TipoProducto_idTipoProducto.min"] = "[Clasificación] Debe seleccionar un tipo de producto";
        $mensajes["TipoNegocio_idTipoNegocio.min"] = "[Clasificación] Debe seleccionar un tipo de negocio";

        for($i = 0; $i < $color; $i++)
        {
            if(trim($this->get('Color_idColor')[$i]) == '')
            {    
                $mensajes["Color_idColor".$i.".required"] = "[Variantes] Debe seleccionar el color ".($i+1);
            }           
        }

        for($i = 0; $i < $cantidad; $i++)
        {
            if(trim($this->get('cantidadFichaTecnicaColor')[$i]) == '')
            {    
                $mensajes["cantidadFichaTecnicaColor".$i.".required"] = "[Variantes] Debe ingresar la cantidad ".($i+1);
            }           
        }

        for($i = 0; $i < $talla; $i++)
        {
            if(trim($this->get('Talla_idTalla')[$i]) == '')
            {    
                $mensajes["Talla_idTalla".$i.".required"] = "[Variantes] Debe seleccionar la talla ".($i+1);
            }           
        }

        for($i = 0; $i < $curva; $i++)
        {
            if(trim($this->get('curvaFichaTecnicaTalla')[$i]) == '')
            {    
                $mensajes["curvaFichaTecnicaTalla".$i.".required"] = "[Variantes] Debe ingresar la curva ".($i+1);
            }           
        }

        return $mensajes;
    }
}
