<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class PerfilCargoRequest extends Request
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

        "nombrePerfilCargo" => "required|string|max:20|",
        "observacionPerfilCargo" => "required|string|max:20|",
         "tipoPerfilCargo" => "required"


            
        ];
    }
}
