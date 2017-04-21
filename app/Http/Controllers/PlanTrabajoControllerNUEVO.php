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
            '   SELECT valorFrecuenciaMedicion, unidadFrecuenciaMedicion, idTercero, idTipoExamenMedico, concat(nombreCompletoTercero , " (", nombreCargo, ")", " - ", TEC.nombreTipoExamenMedico) as descripcionTarea,   
                    fechaIngresoTerceroInformacion, fechaRetiroTerceroInformacion, fechaCreacionCompania, 
                    ingresoCargoExamenMedico as ING, 
                    retiroCargoExamenMedico as RET,
                    periodicoCargoExamenMedico as PER,
                    idFrecuenciaMedicion, nombreCompletoTercero
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
                left join compania COM
                on T.Compania_idCompania = COM.idCompania
                where tipoTercero like "%01%" and idTipoExamenMedico IS NOT NULL   and 
                    (DATE_FORMAT(CURDATE(),"%Y") >= DATE_FORMAT(fechaIngresoTerceroInformacion,"%Y") and DATE_FORMAT(CURDATE(),"%Y") <= DATE_FORMAT(fechaIngresoTerceroInformacion,"%Y") OR DATE_FORMAT(CURDATE(),"%Y") >= DATE_FORMAT(fechaRetiroTerceroInformacion,"%Y") and DATE_FORMAT(CURDATE(),"%Y") <= DATE_FORMAT(fechaRetiroTerceroInformacion,"%Y") OR
                        fechaRetiroTerceroInformacion = "0000-00-00") AND
                        fechaIngresoTerceroInformacion != "0000-00-00" AND
                        idTercero = 4646 and 
                    estadoTercero = "ACTIVO" AND 
                    T.Compania_idCompania = '.$idCompania .' 
                order by nombreCompletoTercero, idTercero
           ');

        $datos = array();
          

        //and nombreCompletoTercero like "'.$letra.'%"
        for($i= 0; $i < count($examen); $i++)
        {
            $registro = get_object_vars($examen[$i]);
            $pos = $this->buscarTerceroExamen($registro["idTercero"], $registro["idTipoExamenMedico"], $datos);

            if($pos == -1)
            {
                $pos = count($datos);
                for($mes = 1; $mes <= 12; $mes++)
                {
                    $datos[$pos][str_pad($mes, 2, '0', STR_PAD_LEFT).'T'] = 0;
                    $datos[$pos][str_pad($mes, 2, '0', STR_PAD_LEFT).'C'] = 0;
                }
            }
            $datos[$pos]['idTercero'] = $registro["idTercero"];
            $datos[$pos]['idTipoExamenMedico'] = $registro["idTipoExamenMedico"];
            $datos[$pos]['Nombre'] = $registro["descripcionTarea"];

            

            // las tareas semanales o diarias deben crear 4 o 30 tareas en cada periodo respectivamente
            // las tareas expresadas en meses o años, solo deben poner una tarea en el periodo
            $frecuencia = ($registro['valorFrecuenciaMedicion'] == 0 ? 1 : $registro['valorFrecuenciaMedicion']);
            $multiplo = ((  $registro['unidadFrecuenciaMedicion'] == 'Años' or 
                            $registro['unidadFrecuenciaMedicion'] == 'Meses') 
                        ? 1 
                        : (($registro['unidadFrecuenciaMedicion'] == 'Semanas' ? 4 : 30) / $frecuencia)) ;

            // INGRESO
            if($registro["fechaIngresoTerceroInformacion"] != '0000-00-00' and $registro["ING"] == 1 and date("Y",strtotime($registro["fechaIngresoTerceroInformacion"])) == date("Y") and 
                $registro["fechaIngresoTerceroInformacion"] >= $registro["fechaCreacionCompania"])
                $datos[$pos][date("m",strtotime($registro["fechaIngresoTerceroInformacion"])).'T'] += 1;

            // RETIRO
            if($registro["fechaRetiroTerceroInformacion"] != '0000-00-00' and $registro["RET"] == 1 and date("Y",strtotime($registro["fechaRetiroTerceroInformacion"])) == date("Y"))
                $datos[$pos][date("m",strtotime($registro["fechaRetiroTerceroInformacion"])).'T'] += 1;


            $periodicidad = $registro['valorFrecuenciaMedicion'] * ($registro['unidadFrecuenciaMedicion'] == 'Años' ? 12 : 1);
            
            // PERIODICIDAD
            if($registro["fechaIngresoTerceroInformacion"] != '0000-00-00' and $registro["PER"] == 1 and $periodicidad > 0)
            {
                
                $ingreso = date("Y-m-d",strtotime($registro["fechaIngresoTerceroInformacion"]));
                $ingreso = date("Y-m-d",strtotime("+ ".$periodicidad." MONTH", strtotime($ingreso)));
                $retiro = $registro["fechaRetiroTerceroInformacion"] == '0000-00-00' ? date("Y-12-31") : $registro["fechaRetiroTerceroInformacion"];

                while($ingreso <= date("Y-12-31") and $ingreso < $retiro)
                {
                    
                    if (date("Y", strtotime($ingreso)) == date("Y") and $ingreso >= $registro["fechaCreacionCompania"]) 
                    {
                        $datos[$pos][str_pad(date("m",strtotime($ingreso)), 2, '0', STR_PAD_LEFT).'T'] += (1*$multiplo);    
                    }

                    $ingreso = date("Y-m-d",strtotime("+ ".$periodicidad." MONTH", strtotime($ingreso)));
                }
            }

            

        }


        $examen = DB::Select(
            '   SELECT idTercero, idTipoExamenMedico,  fechaCreacionCompania, 
                       EM.fechaExamenMedico
                FROM tercero T
                left join terceroinformacion TI
                on T.idTercero = TI.Tercero_idTercero
                left join cargo C
                on T.Cargo_idCargo = C.idCargo
                left join cargoexamenmedico CE
                on C.idCargo = CE.Cargo_idCargo
                left join tipoexamenmedico TEC
                on CE.TipoExamenMedico_idTipoExamenMedico = TEC.idTipoExamenMedico
                left join examenmedico EM 
                on T.idTercero = EM.Tercero_idTercero
                left join examenmedicodetalle EMD
                on EM.idExamenMedico = EMD.ExamenMedico_idExamenMedico and EMD.TipoExamenMedico_idTipoExamenMedico = CE.TipoExamenMedico_idTipoExamenMedico
                left join compania COM
                on T.Compania_idCompania = COM.idCompania
                where tipoTercero like "%01%" and idTipoExamenMedico IS NOT NULL   and 
                    (DATE_FORMAT(CURDATE(),"%Y") >= DATE_FORMAT(fechaIngresoTerceroInformacion,"%Y") and DATE_FORMAT(CURDATE(),"%Y") <= DATE_FORMAT(fechaIngresoTerceroInformacion,"%Y") OR DATE_FORMAT(CURDATE(),"%Y") >= DATE_FORMAT(fechaRetiroTerceroInformacion,"%Y") and DATE_FORMAT(CURDATE(),"%Y") <= DATE_FORMAT(fechaRetiroTerceroInformacion,"%Y") OR
                        fechaRetiroTerceroInformacion = "0000-00-00") AND
                        fechaIngresoTerceroInformacion != "0000-00-00" AND
                        idTercero = 4646 and 
                    estadoTercero = "ACTIVO" AND 
                    EMD.ExamenMedico_idExamenMedico IS NOT NULL AND
                    T.Compania_idCompania = '.$idCompania .' 
                order by nombreCompletoTercero, idTercero
           ');

        
        for($i= 0; $i < count($examen); $i++)
        {
            $registro = get_object_vars($examen[$i]);
            $pos = $this->buscarTerceroExamen($registro["idTercero"], $registro["idTipoExamenMedico"], $datos);

            // CUMPLIMIENTO
           if($registro["fechaExamenMedico"] != '0000-00-00' and 
                date("Y",strtotime($registro["fechaExamenMedico"])) == date("Y") and 
                $registro["fechaExamenMedico"] >= $registro["fechaCreacionCompania"])
            {
                    $datos[$pos][date("m",strtotime($registro["fechaExamenMedico"])).'C'] += 1;
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

    // IMPRIMIMOSLA TABLA
    $tabla = '';

        $tabla .= '        
                    <div class="panel panel-primary" style="border:1px solid">
                        <div class="panel-heading">
                          <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#'.$idtabla.'">'.$titulo.'</a>
                          </h4>
                        </div>';
                        $tabla .= 
                        '<button class="btn btn-primary" onclick="consultarPlanTrabajo('.$año.',this.value)" value="" type="button">Todos</button>';
                        for($i=65; $i<=90; $i++) 
                        {  
                            $letra = chr($i);  
                            $tabla .= 
                            '<button class="btn btn-primary" onclick="consultarPlanTrabajo('.$año.',this.value)" value="'.$letra.'" type="button">'.$letra.'</button>';
                        }

                        $tabla .= 
                        '<div id="'.$idtabla.'" class="panel-collapse"> 
                            <div class="panel-body" style="overflow:auto;">
                                <table  class="table table-striped table-bordered table-hover">
                                    <thead class="thead-inverse">
                                        <tr class="table-info">
                                            <th scope="col" width="30%">&nbsp;</th>';
                                               
                                            $inicio = $fechaInicial;
                                            $anioAnt = date("Y", strtotime($inicio));
                                            while($inicio < $fechaFinal)
                                            {
                                                // adicionamos la columna del mes
                                                $tabla .= '<th >'. nombreMes($inicio).'</th>';
                                                //Avanzamos al siguiente mes
                                                $inicio = date("Y-m-d", strtotime("+1 MONTH", strtotime($inicio)));
                                            }

                                
                                        $tabla .= '
                                            <th>Presupuesto</th>
                                            <th>Costo Real</th>
                                            <th>Cumplimiento</th>
                                        </tr>
                                        </thead>
                                        <tbody>';

                                            $mesesC = 0;
                                            $mesesT = 0;

                                            foreach($informacion as $dato)
                                            {
                                                $tabla .='<tr align="center">
                                                    <th scope="row">'.$dato->descripcionTarea.'</th>';
                                               
                                                $inicio = $fechaInicial;
                                                $anioAnt = date("Y", strtotime($inicio));
                                                while($inicio < $fechaFinal)
                                                {
                                                    $tarea = $datos[$i][date("m",strtotime($inicio)).'T'];
                                                    $cumplido = $datos[$i][date("m",strtotime($inicio)).'C'];

                                                    $mesesT += $tarea;

                                                    $mesesC += $cumplido;

                                                    // adicionamos la columna del mes
                                                    $tabla .= '<td >'. colorTarea($tarea, $cumplido).'</td>';
                                                    //Avanzamos al siguiente mes
                                                    $inicio = date("Y-m-d", strtotime("+1 MONTH", strtotime($inicio)));
                                                }

                                                $tabla.=
                                                '<td>'.(isset($dato->PresupuestoT) ? $dato->PresupuestoT : '&nbsp;').'</td>
                                                <td>'.(isset($dato->PresupuestoC) ? $dato->PresupuestoC : '&nbsp;').'</td>';

                                            $total = number_format(($mesesC / ($mesesT == 0 ? 1: $mesesT) *100),1,'.',',');

                                        $tabla.= '<td>'.$total.'</td>';
                                
                                        $tabla .= '</tr>';
                                            }


                            $tabla.='   </tbody>
                                    </table>
                                  </div> 
                                </div>
                              </div>';

        return $tabla;

    }

    public function buscarTerceroExamen($idTercero, $idExamen, $datos)
    {
        $pos = -1;

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
