<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class MatrizLegalRequest extends Request
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

        $tipoNorma = count($this->get('TipoNormaLegal_idTipoNormaLegal'));
        
        $validacion = array('nombreMatrizLegal' => 'required|max:200',
            'fechaElaboracionMatrizLegal' => 'required',
            'origenMatrizLegal' => 'required');

        for($i = 0; $i < $tipoNorma; $i++)
        {
            if(trim($this->get('TipoNormaLegal_idTipoNormaLegal')[$i]) == '')
            {    
                $validacion['TipoNormaLegal_idTipoNormaLegal'.$i] =  'required';
            }

            if(trim($this->get('ExpideNormaLegal_idExpideNormaLegal')[$i]) == '')
            {    
                $validacion['ExpideNormaLegal_idExpideNormaLegal'.$i] =  'required';
            }
            
        }

        return $validacion;

    }
}
