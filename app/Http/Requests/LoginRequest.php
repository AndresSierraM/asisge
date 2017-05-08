<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class LoginRequest extends Request
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
            'email' => 'required|email|unique:users',
            'password' => 'required|min:4',
            'Compania_idCompania' => 'required',
        ];
    }


    //   public function messages()
    // {
    //     return[
    //     'email.required' => 'Debe Ingresar su Correo Sisoft.',
    //     'password.required'=> 'Debe Ingresar la Contraseña.',
    //     'Compania_idCompania.required'=> 'Debe Seleccionar la Compañia.' 

    //     ];
    // }
}
