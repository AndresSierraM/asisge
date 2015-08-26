<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class OpcionRequest extends Request
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
            "ordenOpcion" => "required|integer",
            "nombreOpcion" => "required|string"
        ];
    }
}
// ,            "iconoOpcion" => "required|mimes:jpg, jpeg, png, bmp, gif|max:3000"