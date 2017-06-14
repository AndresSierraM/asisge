<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class OrdenCompraRequest extends Request
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
        $validacion = array(
            'sitioEntregaOrdenCompra' => "required|string|max:80",
            'fechaElaboracionOrdenCompra' => 'required|date',
            'fechaEstimadaOrdenCompra' => 'required|date|after:fechaElaboracionOrdenCompra',
            'Tercero_idProveedor' => 'required');
        
        return $validacion;
    }
}
