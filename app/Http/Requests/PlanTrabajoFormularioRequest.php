<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class PlanTrabajoFormularioRequest extends Request
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
            'numeroPlanTrabajo' => "required|unique:plantrabajo,numeroPlanTrabajo,".$this->get('idPlanTrabajo') .",idPlanTrabajo,Compania_idCompania,".(\Session::get('idCompania')),
            'asuntoPlanTrabajo' => "required|string|max:80",
            'fechaPlanTrabajo' => "required|date",
            'Tercero_idAuditor' => "required"
        ];
    }
}
