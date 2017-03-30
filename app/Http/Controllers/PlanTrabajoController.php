<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
class PlanTrabajoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {

        $idCompania = \Session::get("idCompania");


        $examen = DB::Select(
            '
                SELECT valorFrecuenciaMedicion, unidadFrecuenciaMedicion, idTercero, idTipoExamenMedico, concat(nombreCompletoTercero , " (", nombreCargo, ")") as descripcionTarea,  TEC.nombreTipoExamenMedico, 
                    fechaIngresoTerceroInformacion, fechaRetiroTerceroInformacion, fechaCreacionCompania, 
                    ingresoCargoExamenMedico as ING, 
                    retiroCargoExamenMedico as RET,
                    periodicoCargoExamenMedico as PER,
                    IF(EMD.ExamenMedico_idExamenMedico IS NULL , "0000-00-00", EM.fechaExamenMedico) as fechaExamenMedico, idFrecuenciaMedicion, nombreCompletoTercero
                FROM tercero T
                left join terceroinformacion TI
                on T.idTercero = TI.Tercero_idTercero
                left join cargo C
                on T.Cargo_idCargo = C.idCargo
                left join cargoexamenmedico CE
                on C.idCargo = CE.Cargo_idCargo
                left join frecuenciamedicion FM
                on CE.FrecuenciaMedicion_idFrecuenciaMedicion = FM.idFrecuenciaMedicion
                left join tipoexamenmedico TEC
                on CE.TipoExamenMedico_idTipoExamenMedico = TEC.idTipoExamenMedico
                left join examenmedico EM 
                on T.idTercero = EM.Tercero_idTercero
                left join examenmedicodetalle EMD
                on EM.idExamenMedico = EMD.ExamenMedico_idExamenMedico and EMD.TipoExamenMedico_idTipoExamenMedico = CE.TipoExamenMedico_idTipoExamenMedico
                left join compania COM
                on T.Compania_idCompania = COM.idCompania
                where tipoTercero like "%01%" and idTipoExamenMedico IS NOT NULL   and 
                    T.Compania_idCompania = '.$idCompania .' 
                group by idTercero, idTipoExamenMedico 
                order by nombreCompletoTercero
           ');

        $datos = array();

      

        //and nombreCompletoTercero like "'.$letra.'%"
        for($i= 0; $i < count($examen); $i++)
        {
            $registro = get_object_vars($examen[$i]);
            $pos = $this->buscarTerceroExamen($registro["idTercero"], $registro["idTipoExamenMedico"], $datos);
            $pos = ($pos == '' ? count($datos) : $pos);
            $datos[$pos]['idTercero'] = $registro["idTercero"];
            $datos[$pos]['idTipoExamenMedico'] = $registro["idTipoExamenMedico"];
            $datos[$pos]['Nombre'] = $registro["descripcionTarea"];

            for($mes = 1; $mes <= 12; $mes++)
            {
                $datos[$pos][str_pad($mes, 2, '0', STR_PAD_LEFT)] = 0;
            }

            if($registro["fechaIngresoTerceroInformacion"] != '0000-00-00' and $registro["ING"] == 1 and date("Y",strtotime($registro["fechaIngresoTerceroInformacion"])) == date("Y"))
                $datos[$pos][date("m",strtotime($registro["fechaIngresoTerceroInformacion"]))] += 1;

            if($registro["fechaRetiroTerceroInformacion"] != '0000-00-00' and $registro["RET"] == 1 and date("Y",strtotime($registro["fechaRetiroTerceroInformacion"])) == date("Y"))
                $datos[$pos][date("m",strtotime($registro["fechaRetiroTerceroInformacion"]))] += 1;

            if($registro["PER"] == 1)
            {
                $periodicidad = $registro['valorFrecuenciaMedicion'] * ($registro['unidadFrecuenciaMedicion'] == 'Años' ? 12 : 1);
                $ingreso = (int)date("m",strtotime($registro["fechaIngresoTerceroInformacion"]));


                for($mes = 1; $mes <= 12; $mes++)
                {
                    $ingreso += $periodicidad;
                    if ($ingreso <= 12) 
                    {
                        $datos[$pos][str_pad($ingreso, 2, '0', STR_PAD_LEFT)] += 1;    
                    }
                }
            }

        }
        
        foreach ($datos as $r => $registros) 
        {
            foreach ($registros as $c => $columnas) 
            {   
                echo $columnas."\t";
            }
            echo '<br>';
        }

    }

    public function buscarTerceroExamen($idTercero, $idExamen, $datos)
    {
        $pos = '';

        for ($i=0; $i < count($datos); $i++) 
        { 
            if ($datos[$i]['idTercero'] == $idTercero && $datos[$i]['idTipoExamenMedico'] == $idExamen) 
            {
                $pos = $i;
                $i = count($datos);
            }
        }

        return $pos;
    }


}
