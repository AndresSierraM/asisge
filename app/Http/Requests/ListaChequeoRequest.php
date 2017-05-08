<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ListaChequeoRequest extends Request
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
        $dirigido = count($this->get('Tercero_idTercero'));

        $validacion = array( 
            "numeroListaChequeo" => "required|integer",
            "fechaElaboracionListaChequeo" => "required|date",
            "PlanAuditoria_idPlanAuditoria" => "required",
            "Proceso_idProceso" => "required");
        
        for($i = 0; $i < $dirigido; $i++)
        {
            if(trim($this->get('Tercero_idTercero')[$i]) == '' or trim($this->get('Tercero_idTercero')[$i]) == 0)
            {    
                $validacion['Tercero_idTercero'.$i] =  'required';
            }
        }

        return $validacion;
    }

     public function messages()
            {
                return[
                'numeroListaChequeo.required' => 'Debe Digitar el N&#250;mero.',
                'fechaElaboracionListaChequeo.required'=> 'Debe Seleccionar la Fecha de Inicio',
                'PlanAuditoria_idPlanAuditoria.required'=> 'Debe Seleccionar  el plan  de Auditor&#237;a.',
                'Proceso_idProceso.required'=> 'Debe Seleccionar el Proceso.'
                ];
            }
}   