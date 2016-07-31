<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ProgramaRequest extends Request
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
        // validacion (where) para que no permita el mimso proceso pero por cada compania
        //, Compania_idCompania = ".$this->get('Compania_idCompania')
        // return [
        //     "nombrePrograma" => "required|String",
        //     "fechaElaboracionPrograma" => "required|date",
        //     "ClasificacionRiesgo_idClasificacionRiesgo" => "required",
        //     "CompaniaObjetivo_idCompaniaObjetivo" => "required",
        //     "Tercero_idElabora" => "required"
        // ];

        $responsable = count($this->get('Tercero_idResponsable'));
        $documento = count($this->get('Documento_idDocumento'));

        $validacion = array(
            "nombrePrograma" => "required|String",
            "fechaElaboracionPrograma" => "required|date",
            "ClasificacionRiesgo_idClasificacionRiesgo" => "required",
            "CompaniaObjetivo_idCompaniaObjetivo" => "required",
            "Tercero_idElabora" => "required");
        
        // for($i = 0; $i < $responsable; $i++)
        // {
        //     if(trim($this->get('Tercero_idResponsable')[$i]) == '' or trim($this->get('Tercero_idResponsable')[$i]) == 0)
        //     {    
        //         $validacion['Tercero_idResponsable'.$i] =  'required';
        //     }
        // }

        // for($i = 0; $i < $documento; $i++)
        // {
        //     if(trim($this->get('Documento_idDocumento')[$i]) == '' or trim($this->get('Documento_idDocumento')[$i]) == 0)
        //     {    
        //         $validacion['Documento_idDocumento'.$i] =  'required';
        //     }
        // }

        return $validacion;
    }
}
