<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class AgendaRequest extends Request
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
        $validacion = array('CategoriaAgenda_idCategoriaAgenda' => "required",
            'asuntoAgenda' => "required",
            'fechaHoraInicioAgenda' => 'required',
            'fechaHoraFinAgenda' => 'required',
            'Tercero_idSupervisor' => 'required',
            'detallesAgenda' => 'required');

        return $validacion;
    }
}
