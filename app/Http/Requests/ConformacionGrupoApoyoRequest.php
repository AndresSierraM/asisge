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
        $candidato = count($this->get('Tercero_idCandidato'));
        $principal = count($this->get('Tercero_idPrincipal'));
        $suplente = count($this->get('Tercero_idSuplente'));
       
        $validacion = array(
            'nombreConformacionGrupoApoyo' => "required|string|max:80",
            'GrupoApoyo_idGrupoApoyo' => 'required',
            'fechaConformacionGrupoApoyo' => 'required',
            'Tercero_idRepresentante' => 'required',
            'Tercero_idPresidente' => 'required',
            'Tercero_idSecretario' => 'required',
            'Tercero_idGerente' => 'required',
            );
        
        for($i = 0; $i < $jurado; $i++)
        {
            if(trim($this->get('Tercero_idJurado')[$i]) == '' or trim($this->get('Tercero_idJurado')[$i]) == 0)
            {    
                $validacion['Tercero_idJurado'.$i] =  'required';
            }
        }

        for($i = 0; $i < $candidato; $i++)
        {
            if(trim($this->get('Tercero_idCandidato')[$i]) == '' or trim($this->get('Tercero_idCandidato')[$i]) == 0)
            {    
                $validacion['Tercero_idCandidato'.$i] =  'required';
            }
        }

        for($i = 0; $i < $principal; $i++)
        {
            if(trim($this->get('Tercero_idPrincipal')[$i]) == '' or trim($this->get('Tercero_idPrincipal')[$i]) == 0)
            {    
                $validacion['Tercero_idPrincipal'.$i] =  'required';
            }
        }

        for($i = 0; $i < $suplente; $i++)
        {
            if(trim($this->get('Tercero_idSuplente')[$i]) == '' or trim($this->get('Tercero_idSuplente')[$i]) == 0)
            {    
                $validacion['Tercero_idSuplente'.$i] =  'required';
            }
        }

        return $validacion;
    }
}
