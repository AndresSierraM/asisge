<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class AgendaPermisoRequest extends Request
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
        $usuario = count($this->get('Users_idPropietario'));
        $categoria = count($this->get('CategoriaAgenda_idCategoriaAgenda'));

        $validacion = array(
            'Users_idAutorizado' => 'required');
        
        for($i = 0; $i < $usuario; $i++)
        {
            if(trim($this->get('Users_idPropietario')[$i]) == '' or trim($this->get('Users_idPropietario')[$i]) == 0)
            {    
                $validacion['Users_idPropietario'.$i] =  'required';
            }
        }

        for($i = 0; $i < $categoria; $i++)
        {
            if(trim($this->get('CategoriaAgenda_idCategoriaAgenda')[$i]) == '' or trim($this->get('CategoriaAgenda_idCategoriaAgenda')[$i]) == 0)
            {    
                $validacion['CategoriaAgenda_idCategoriaAgenda'.$i] =  'required';
            }
        }

        return $validacion;
    }
}
