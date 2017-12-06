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
        $Nombradopor = count($this->get('nombradoPorConformacionGrupoApoyoComite'));
        $TerceroInscrito = count($this->get('Tercero_idInscrito'));

       
        $validacion = array(
            'nombreConformacionGrupoApoyo' => "required|string|max:80",
            'GrupoApoyo_idGrupoApoyo' => 'required',
            'fechaConformacionGrupoApoyo' => 'required',
            'Tercero_idRepresentante' => 'required',
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

        for($i = 0; $i < $Nombradopor; $i++)
        {
            if(trim($this->get('nombradoPorConformacionGrupoApoyoComite')[$i]) == '')
            {    
                $validacion['nombradoPorConformacionGrupoApoyoComite'.$i] =  'required';
            }
        }

        for($i = 0; $i < $TerceroInscrito; $i++)
        {
            if(trim($this->get('Tercero_idInscrito')[$i]) == '')
            {    
                $validacion['Tercero_idInscrito'.$i] =  'required';
            }
        }



        return $validacion;
    }

     public function messages()
    {
        $jurado = count($this->get('Tercero_idJurado'));
        $candidato = count($this->get('Tercero_idCandidato'));
        $Nombradopor = count($this->get('nombradoPorConformacionGrupoApoyoComite'));
        $TerceroInscrito = count($this->get('Tercero_idInscrito'));


        $mensajes = array();
        $mensajes["GrupoApoyo_idGrupoApoyo.required"] = "[Encabezado] Debe seleccionar el grupo de apoyo";
        $mensajes["nombreConformacionGrupoApoyo.required"] = "[Encabezado] Debe ingresar la descripción";
        $mensajes["fechaConformacionGrupoApoyo.required"] = "[Encabezado] Debe ingresar la fecha de elaboración";
        $mensajes["Tercero_idRepresentante.required"] = "[Detalle Convocatoria] Debe Seleccionar el representante";
        $mensajes["Tercero_idGerente.required"] = "[Detalle Convocatoria] Debe Seleccionar el Gerente General";

        for($i = 0; $i < $jurado; $i++)
        {
            if(trim($this->get('Tercero_idJurado')[$i]) == '' )
            {    
                $mensajes["Tercero_idJurado".$i.".required"] = "[Detalle Actas de votación] Debe seleccionar el jurado  en la línea ".($i+1);
            }           
        }
         for($i = 0; $i < $candidato; $i++)
        {
            if(trim($this->get('Tercero_idCandidato')[$i]) == '' )
            {    
                $mensajes["Tercero_idCandidato".$i.".required"] = "[Detalle Actas de votación] Debe seleccionar el nombre del candidato en la línea ".($i+1);
            }           
        }
         for($i = 0; $i < $Nombradopor; $i++)
        {
            if(trim($this->get('nombradoPorConformacionGrupoApoyoComite')[$i]) == '' )
            {    
                $mensajes["nombradoPorConformacionGrupoApoyoComite".$i.".required"] = "[Detalle Constitución] Debe seleccionar por quién fue nombrado  en la línea ".($i+1);
            }           
        }

        for($i = 0; $i < $TerceroInscrito; $i++)
        {
            if(trim($this->get('Tercero_idInscrito')[$i]) == '' )
            {    
                $mensajes["Tercero_idInscrito".$i.".required"] = "[Detalle Candidatos Inscritos] Debe seleccionar el candidato inscrito en la línea ".($i+1);
            }           
        }

        return $mensajes;

    }
}
