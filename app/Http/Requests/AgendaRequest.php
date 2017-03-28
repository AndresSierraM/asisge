<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Support\Facades\DB;
class AgendaRequest extends Request
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
        $id = $this->get('CategoriaAgenda_idCategoriaAgenda'); 
        $tercero = count($this->get('nombreAgendaAsistente'));
        $seguimiento = count($this->get('fechaHoraInicioAgenda'));

        $campos = DB::Select('
            SELECT 
                formularioCampoCRM, nombreCampoCRM
            FROM 
                categoriaagendacampo cac
            LEFT JOIN
                categoriaagenda ca ON cac.CategoriaAgenda_idCategoriaAgenda = ca.idCategoriaAgenda
            LEFT JOIN 
                campocrm ccrm ON cac.CampoCRM_idCampoCRM = ccrm.idCampoCRM
            WHERE idCategoriaAgenda = '.$id.' 
            AND obligatorioCategoriaAgendaCampo = 1
            AND formularioCampoCRM = "categoriaagenda"');


        $validacion = array('CategoriaAgenda_idCategoriaAgenda' => "required",
            'asuntoAgenda' => "required",
            'fechaHoraInicioAgenda' => 'required',
            'fechaHoraFinAgenda' => 'required',
            'Tercero_idSupervisor' => 'required');

        for($i = 0; $i < count($campos); $i++)
        {
            $datos = get_object_vars($campos[$i]); 
            $validacion[$datos["nombreCampoCRM"]] = "required";

            if ($datos['nombreCampoCRM'] == 'Tercero_idAsistente') 
            {
                for($j = 0; $j < $tercero; $j++)
                {
                    if(trim($this->get('nombreAgendaAsistente')[$j]) == '' or trim($this->get('nombreAgendaAsistente')[$j]) == 0)
                    {    
                        $validacion['nombreAgendaAsistente'.$j] =  'required';
                    }
                }

                for($j = 0; $j < $tercero; $j++)
                {
                    if(trim($this->get('correoElectronicoAgendaAsistente')[$j]) == '' or trim($this->get('correoElectronicoAgendaAsistente')[$j]) == 0)
                    {    
                        $validacion['correoElectronicoAgendaAsistente'.$j] =  'required';
                    }
                }
            }

            if ($datos['nombreCampoCRM'] == 'seguimientoAgenda') 
            {
                for($j = 0; $j < $seguimiento; $j++)
                {
                    if(trim($this->get('fechaHoraAgendaSeguimiento')[$j]) == '' or trim($this->get('fechaHoraAgendaSeguimiento')[$j]) == 0)
                    {    
                        $validacion['fechaHoraAgendaSeguimiento'.$j] =  'required';
                    }
                }

                for($j = 0; $j < $seguimiento; $j++)
                {
                    if(trim($this->get('detallesAgendaSeguimiento')[$j]) == '' or trim($this->get('detallesAgendaSeguimiento')[$j]) == 0)
                    {    
                        $validacion['detallesAgendaSeguimiento'.$j] =  'required';
                    }
                }
            }
        }

        return $validacion;
    }
}
