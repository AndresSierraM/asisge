<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class Diagnostico2Request extends Request
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
       
        // $puntuacion = count($this->get('puntuacionDiagnosticoDetalle'));
        
        $validacion = array('codigoDiagnostico2' => "required|string|max:20|unique:diagnostico2,codigoDiagnostico2,".$this->get('idDiagnostico2') .",idDiagnostico2,Compania_idCompania,".(\Session::get('idCompania')),
                            'nombreDiagnostico2' => 'required|string|max:80',
                            'fechaElaboracionDiagnostico2' => 'required|date');

        /*for($i = 0; $i < $puntuacion; $i++)
        {
            //if(trim($this->get('puntuacionDiagnosticoDetalle')[$i]) <= 0 or trim($this->get('puntuacionDiagnosticoDetalle')[$i]) >= 5)
            {    
                $validacion['puntuacionDiagnosticoDetalle'.$i] = 'integer';
            }
        }
*/
        return $validacion;
    }
}
