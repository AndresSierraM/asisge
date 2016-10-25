<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class PlanAuditoriaRequest extends Request
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

        $acompañante = count($this->get('Tercero_idAcompanante'));
        $notificado = count($this->get('Tercero_idNotificado'));
        $proceso = count($this->get("Proceso_idProceso"));
        $auditado = count($this->get('Tercero_Auditado'));
        $auditor = count($this->get('Tercero_Auditor'));

        $validacion = array( 
            "numeroPlanAuditoria" => "required|integer",
            "fechaInicioPlanAuditoria" => "required|date",
            "fechaFinPlanAuditoria" => "required|date",
            "Tercero_AuditorLider" => "required");
        
        for($i = 0; $i < $acompañante; $i++)
        {
            if(trim($this->get('Tercero_idAcompanante')[$i]) == '' or trim($this->get('Tercero_idAcompanante')[$i]) == 0)
            {    
                $validacion['Tercero_idAcompanante'.$i] =  'required';
            }
        }

        for($i = 0; $i < $notificado; $i++)
        {
            if(trim($this->get('Tercero_idNotificado')[$i]) == '' or trim($this->get('Tercero_idNotificado')[$i]) == 0)
            {    
                $validacion['Tercero_idNotificado'.$i] =  'required';
            }
        }

        for($i = 0; $i < $proceso; $i++)
        {
            if(trim($this->get('Proceso_idProceso')[$i]) == '' or trim($this->get('Proceso_idProceso')[$i]) == 0)
            {    
                $validacion['Proceso_idProceso'.$i] =  'required';
            }
        }

        for($i = 0; $i < $auditado; $i++)
        {
            if(trim($this->get('Tercero_Auditado')[$i]) == '' or trim($this->get('Tercero_Auditado')[$i]) == 0)
            {    
                $validacion['Tercero_Auditado'.$i] =  'required';
            }
        }

        for($i = 0; $i < $auditor; $i++)
        {
            if(trim($this->get('Tercero_Auditor')[$i]) == '' or trim($this->get('Tercero_Auditor')[$i]) == 0)
            {    
                $validacion['Tercero_Auditor'.$i] =  'required';
            }
        }

        return $validacion;
    }
}