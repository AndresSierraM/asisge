<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ConformacionGrupoApoyoRequest extends Request
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
        $jurado = count($this->get('Tercero_idJurado'));
       
        $validacion = array(
            'nombreConformacionGrupoApoyo' => "required|string|max:80",
            'GrupoApoyo_idGrupoApoyo' => 'required',
            'fechaConformacionGrupoApoyo' => 'required',
            'Tercero_idRepresentante' => 'required'
            );
        
        for($i = 0; $i < $jurado; $i++)
        {
            if(trim($this->get('Tercero_idJurado')[$i]) == '' or trim($this->get('Tercero_idJurado')[$i]) == 0)
            {    
                $validacion['Tercero_idJurado'.$i] =  'required';
            }
        }

         

        return $validacion;
    }
}
