<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class PaqueteRequest extends Request
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
            "ordenPaquete" => "required|integer",
            "nombrePaquete" => "required|string"
        ];
    }
}
// ,            "iconoPaquete" => "required|mimes:jpg, jpeg, png, bmp, gif|max:3000"
