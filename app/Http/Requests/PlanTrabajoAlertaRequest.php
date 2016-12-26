<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class PlanTrabajoAlertaRequest extends Request
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
        return [
    
         "nombrePlanTrabajoAlerta" => "required|string",
         "correoParaPlanTrabajoAlerta" => "required|string",
         "correoAsuntoPlanTrabajoAlerta" => "required|string",
         "correoMensajePlanTrabajoAlerta" => "required|string",
          "correoMensajePlanTrabajoAlerta" => "required|string",
          "filtroMesesPasadosPlanTrabajoAlerta" => "required|int|min:0",
          "filtroMesesFuturosPlanTrabajoAlerta" => "required|int|min:0"




         ];


    }
}
