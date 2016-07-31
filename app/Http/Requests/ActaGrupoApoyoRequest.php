<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ActaGrupoApoyoRequest extends Request
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
        // return[
        //     "GrupoApoyo_idGrupoApoyo" => "required|integer",
        //     "fechaActaGrupoApoyo" => "required|date",
        //     "horaInicioActaGrupoApoyo" => "required",
        //     "horaFinActaGrupoApoyo" => "required"
        // ];

        $participante = count($this->get('Tercero_idParticipante'));
        $responsabletema = count($this->get('Tercero_idResponsable'));
        $responsableactividad = count($this->get('Tercero_idResponsableDetalle'));
        $documento = count($this->get('Documento_idDocumento'));

        $validacion = array( 
            "GrupoApoyo_idGrupoApoyo" => "required|integer",
            "fechaActaGrupoApoyo" => "required|date",
            "horaInicioActaGrupoApoyo" => "required",
            "horaFinActaGrupoApoyo" => "required");
        
        for($i = 0; $i < $participante; $i++)
        {
            if(trim($this->get('Tercero_idParticipante')[$i]) == '' or trim($this->get('Tercero_idParticipante')[$i]) == 0)
            {    
                $validacion['Tercero_idParticipante'.$i] =  'required';
            }
        }

        for($i = 0; $i < $responsabletema; $i++)
        {
            if(trim($this->get('Tercero_idResponsable')[$i]) == '' or trim($this->get('Tercero_idResponsable')[$i]) == 0)
            {    
                $validacion['Tercero_idResponsable'.$i] =  'required';
            }
        }

        for($i = 0; $i < $responsableactividad; $i++)
        {
            if(trim($this->get('Tercero_idResponsableDetalle')[$i]) == '' or trim($this->get('Tercero_idResponsableDetalle')[$i]) == 0)
            {    
                $validacion['Tercero_idResponsableDetalle'.$i] =  'required';
            }
        }

        for($i = 0; $i < $documento; $i++)
        {
            if(trim($this->get('Documento_idDocumento')[$i]) == '' or trim($this->get('Documento_idDocumento')[$i]) == 0)
            {    
                $validacion['Documento_idDocumento'.$i] =  'required';
            }
        }

        return $validacion;
    }
}