<?php 

$letra = $_POST['letra'];

$examenHTML = '';
$idCompania = \Session::get('idCompania');

// -------------------------------------------
//  E X A M E N E S   M E D I C O S
// -------------------------------------------
$examen = DB::select(
    "SELECT nombreTipoExamenMedico, descripcionTarea, 
                SUM(IF((MONTH(fechaIngresoTerceroInformacion) = 1 AND YEAR(fechaIngresoTerceroInformacion) >= date_format(NOW(), '%Y') AND ING =1) OR
                (MONTH(fechaRetiroTerceroInformacion) = 1 AND YEAR(fechaRetiroTerceroInformacion) >= date_format(NOW(), '%Y') AND RET = 1) OR 
                (MOD(1,valorFrecuenciaMedicion) = 0 and unidadFrecuenciaMedicion IN ('Meses')) OR 
                (unidadFrecuenciaMedicion IN ('Años')) AND MONTH(fechaIngresoTerceroInformacion) = 1, 1 , 0) ) as EneroT,
                SUM(IF(MONTH(fechaExamenMedico) = 1 AND YEAR(fechaExamenMedico) =  date_format(NOW(), '%Y'), 1, 0 )) as EneroC,
                
                SUM(IF((MONTH(fechaIngresoTerceroInformacion) = 2 AND YEAR(fechaIngresoTerceroInformacion) >= date_format(NOW(), '%Y') AND ING =1) OR
                (MONTH(fechaRetiroTerceroInformacion) = 2 AND YEAR(fechaRetiroTerceroInformacion) >= date_format(NOW(), '%Y') AND RET = 1) OR 
                (MOD(2,valorFrecuenciaMedicion) = 0 and unidadFrecuenciaMedicion IN ('Meses')) OR 
                (unidadFrecuenciaMedicion IN ('Años')) AND MONTH(fechaIngresoTerceroInformacion) = 2, 1 , 0)) as FebreroT,
                SUM(IF(MONTH(fechaExamenMedico) = 2 AND YEAR(fechaExamenMedico) =  date_format(NOW(), '%Y'), 1, 0 )) as FebreroC,
                
                
                SUM(IF((MONTH(fechaIngresoTerceroInformacion) = 3 AND YEAR(fechaIngresoTerceroInformacion) >= date_format(NOW(), '%Y') AND ING =1) OR 
                (MONTH(fechaRetiroTerceroInformacion) = 3 AND YEAR(fechaRetiroTerceroInformacion) >= date_format(NOW(), '%Y') AND RET = 1) OR 
                (MOD(3,valorFrecuenciaMedicion) = 0 and unidadFrecuenciaMedicion IN ('Meses')) OR 
                (unidadFrecuenciaMedicion IN ('Años')) AND MONTH(fechaIngresoTerceroInformacion) = 3, 1 , 0)) as MarzoT,
                SUM(IF(MONTH(fechaExamenMedico) = 3 AND YEAR(fechaExamenMedico) =  date_format(NOW(), '%Y'), 1, 0 )) as MarzoC,
                
                SUM(IF((MONTH(fechaIngresoTerceroInformacion) = 4 AND YEAR(fechaIngresoTerceroInformacion) >= date_format(NOW(), '%Y') AND ING =1) OR 
                (MONTH(fechaRetiroTerceroInformacion) = 4 AND YEAR(fechaRetiroTerceroInformacion) >= date_format(NOW(), '%Y') AND RET = 1) OR 
                (MOD(4,valorFrecuenciaMedicion) = 0 and unidadFrecuenciaMedicion IN ('Meses')) OR 
                (unidadFrecuenciaMedicion IN ('Años')) AND MONTH(fechaIngresoTerceroInformacion) = 4, 1 , 0)) as AbrilT,
                SUM(IF(MONTH(fechaExamenMedico) = 4 AND YEAR(fechaExamenMedico) =  date_format(NOW(), '%Y'), 1, 0 )) as AbrilC,
                
                SUM(IF((MONTH(fechaIngresoTerceroInformacion) = 5 AND YEAR(fechaIngresoTerceroInformacion) >= date_format(NOW(), '%Y') AND ING =1) OR 
                (MONTH(fechaRetiroTerceroInformacion) = 5 AND YEAR(fechaRetiroTerceroInformacion) >= date_format(NOW(), '%Y') AND RET = 1) OR 
                (MOD(5,valorFrecuenciaMedicion) = 0 and unidadFrecuenciaMedicion IN ('Meses')) OR 
                (unidadFrecuenciaMedicion IN ('Años')) AND MONTH(fechaIngresoTerceroInformacion) = 5, 1 , 0)) as MayoT,
                SUM(IF(MONTH(fechaExamenMedico) = 5 AND YEAR(fechaExamenMedico) =  date_format(NOW(), '%Y'), 1, 0 )) as MayoC,
                
                SUM(IF((MONTH(fechaIngresoTerceroInformacion) = 6 AND YEAR(fechaIngresoTerceroInformacion) >= date_format(NOW(), '%Y') AND ING =1) OR 
                (MONTH(fechaRetiroTerceroInformacion) = 6 AND YEAR(fechaRetiroTerceroInformacion) >= date_format(NOW(), '%Y') AND RET = 1) OR 
                (MOD(6,valorFrecuenciaMedicion) = 0 and unidadFrecuenciaMedicion IN ('Meses')) OR 
                (unidadFrecuenciaMedicion IN ('Años')) AND MONTH(fechaIngresoTerceroInformacion) = 6, 1 , 0)) as JunioT,
                SUM(IF(MONTH(fechaExamenMedico) = 6 AND YEAR(fechaExamenMedico) =  date_format(NOW(), '%Y'), 1, 0 )) as JunioC,
                
                SUM(IF((MONTH(fechaIngresoTerceroInformacion) = 7 AND YEAR(fechaIngresoTerceroInformacion) >= date_format(NOW(), '%Y') AND ING =1) OR 
                (MONTH(fechaRetiroTerceroInformacion) = 7 AND YEAR(fechaRetiroTerceroInformacion) >= date_format(NOW(), '%Y') AND RET = 1) OR 
                (MOD(7,valorFrecuenciaMedicion) = 0 and unidadFrecuenciaMedicion IN ('Meses')) OR 
                (unidadFrecuenciaMedicion IN ('Años')) AND MONTH(fechaIngresoTerceroInformacion) = 7, 1 , 0)) as JulioT,
                SUM(IF(MONTH(fechaExamenMedico) = 7 AND YEAR(fechaExamenMedico) =  date_format(NOW(), '%Y'), 1, 0 )) as JulioC,
                
                SUM(IF((MONTH(fechaIngresoTerceroInformacion) = 8 AND YEAR(fechaIngresoTerceroInformacion) >= date_format(NOW(), '%Y') AND ING =1) OR 
                (MONTH(fechaRetiroTerceroInformacion) = 8 AND YEAR(fechaRetiroTerceroInformacion) >= date_format(NOW(), '%Y') AND RET = 1) OR 
                (MOD(8,valorFrecuenciaMedicion) = 0 and unidadFrecuenciaMedicion IN ('Meses')) OR 
                (unidadFrecuenciaMedicion IN ('Años')) AND MONTH(fechaIngresoTerceroInformacion) = 8, 1 , 0)) as AgostoT,
                SUM(IF(MONTH(fechaExamenMedico) = 8 AND YEAR(fechaExamenMedico) =  date_format(NOW(), '%Y'), 1, 0 )) as AgostoC,
                
                SUM(IF((MONTH(fechaIngresoTerceroInformacion) = 9 AND YEAR(fechaIngresoTerceroInformacion) >= date_format(NOW(), '%Y') AND ING =1) OR 
                (MONTH(fechaRetiroTerceroInformacion) = 9 AND YEAR(fechaRetiroTerceroInformacion) >= date_format(NOW(), '%Y') AND RET = 1) OR 
                (MOD(9,valorFrecuenciaMedicion) = 0 and unidadFrecuenciaMedicion IN ('Meses')) OR 
                (unidadFrecuenciaMedicion IN ('Años')) AND MONTH(fechaIngresoTerceroInformacion) = 9, 1 , 0)) as SeptiembreT,
                SUM(IF(MONTH(fechaExamenMedico) = 9 AND YEAR(fechaExamenMedico) =  date_format(NOW(), '%Y'), 1, 0 )) as SeptiembreC,
                
                SUM(IF((MONTH(fechaIngresoTerceroInformacion) = 10 AND YEAR(fechaIngresoTerceroInformacion) >= date_format(NOW(), '%Y') AND ING =1) OR 
                (MONTH(fechaRetiroTerceroInformacion) = 10 AND YEAR(fechaRetiroTerceroInformacion) >= date_format(NOW(), '%Y') AND RET = 1) OR 
                (MOD(10,valorFrecuenciaMedicion) = 0 and unidadFrecuenciaMedicion IN ('Meses')) OR 
                (unidadFrecuenciaMedicion IN ('Años')) AND MONTH(fechaIngresoTerceroInformacion) = 10, 1 , 0)) as OctubreT,
                SUM(IF(MONTH(fechaExamenMedico) = 10 AND YEAR(fechaExamenMedico) =  date_format(NOW(), '%Y'), 1, 0 )) as OctubreC,
                
                SUM(IF((MONTH(fechaIngresoTerceroInformacion) = 11 AND YEAR(fechaIngresoTerceroInformacion) >= date_format(NOW(), '%Y') AND ING =1) 
                OR (MONTH(fechaRetiroTerceroInformacion) = 11 AND YEAR(fechaRetiroTerceroInformacion) >= date_format(NOW(), '%Y') AND RET = 1) OR 
                (MOD(11,valorFrecuenciaMedicion) = 0 and unidadFrecuenciaMedicion IN ('Meses')) OR 
                (unidadFrecuenciaMedicion IN ('Años')) AND MONTH(fechaIngresoTerceroInformacion) = 11, 1 , 0)) as NoviembreT,
                SUM(IF(MONTH(fechaExamenMedico) = 11 AND YEAR(fechaExamenMedico) =  date_format(NOW(), '%Y'), 1, 0 )) as NoviembreC,
                
                SUM(IF((MONTH(fechaIngresoTerceroInformacion) = 12 AND YEAR(fechaIngresoTerceroInformacion) >= date_format(NOW(), '%Y') AND ING =1) 
                OR (MONTH(fechaRetiroTerceroInformacion) = 12 AND YEAR(fechaRetiroTerceroInformacion) >= date_format(NOW(), '%Y') AND RET = 1) OR 
                (MOD(12,valorFrecuenciaMedicion) = 0 and unidadFrecuenciaMedicion IN ('Meses')) OR 
                (unidadFrecuenciaMedicion IN ('Años')) AND MONTH(fechaIngresoTerceroInformacion) = 12, 1 , 0)) as DiciembreT,
                SUM(IF(MONTH(fechaExamenMedico) = 12 AND YEAR(fechaExamenMedico) =  date_format(NOW(), '%Y'), 1, 0 )) as DiciembreC
            FROM
            (
                SELECT valorFrecuenciaMedicion, unidadFrecuenciaMedicion, idTercero, idTipoExamenMedico, concat(nombreCompletoTercero , ' (', nombreCargo, ')') as descripcionTarea,  TET.nombreTipoExamenMedico, 
                    fechaIngresoTerceroInformacion, fechaRetiroTerceroInformacion, ingresoTerceroExamenMedico as ING, retiroTerceroExamenMedico as RET,
                    IF(EMD.ExamenMedico_idExamenMedico IS NULL , '0000-00-00', EM.fechaExamenMedico) as fechaExamenMedico, idFrecuenciaMedicion, idExamenMedico, nombreCompletoTercero
                FROM tercero T
                left join terceroinformacion TI
                on T.idTercero = TI.Tercero_idTercero
                left join cargo C
                on T.Cargo_idCargo = C.idCargo
                left join terceroexamenmedico TEM
                on T.idTercero = TEM.Tercero_idTercero
                left join frecuenciamedicion FM
                on TEM.FrecuenciaMedicion_idFrecuenciaMedicion = FM.idFrecuenciaMedicion
                left join tipoexamenmedico TET
                on TEM.TipoExamenMedico_idTipoExamenMedico = TET.idTipoExamenMedico
                left join examenmedico EM 
                on T.idTercero = EM.Tercero_idTercero
                left join examenmedicodetalle EMD
                on EM.idExamenMedico = EMD.ExamenMedico_idExamenMedico and EMD.TipoExamenMedico_idTipoExamenMedico = TEM.TipoExamenMedico_idTipoExamenMedico
                where tipoTercero like '%01%' and idTipoExamenMedico IS NOT NULL and 
                    T.Compania_idCompania = $idCompania
                group by idTercero
             
            UNION

                SELECT valorFrecuenciaMedicion, unidadFrecuenciaMedicion, idTercero, idTipoExamenMedico, concat(nombreCompletoTercero , ' (', nombreCargo, ')') as descripcionTarea,  TEC.nombreTipoExamenMedico, 
                    fechaIngresoTerceroInformacion, fechaRetiroTerceroInformacion, ingresoCargoExamenMedico as ING, retiroCargoExamenMedico as RET,
                    IF(EMD.ExamenMedico_idExamenMedico IS NULL , '0000-00-00', EM.fechaExamenMedico) as fechaExamenMedico, idFrecuenciaMedicion, idExamenMedico, nombreCompletoTercero
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
                where tipoTercero like '%01%' and idTipoExamenMedico IS NOT NULL  and 
                    T.Compania_idCompania = $idCompania
                group by idTercero
            ) Examen
            where nombreCompletoTercero like '".$letra."%'
            group by idTercero
            order by nombreCompletoTercero");


function colorTarea($valorTarea, $valorCumplido)
{

    $icono = '';    
    $tool = 'Tareas Pendientes : '.number_format($valorTarea,0,'.',',')."\n".
            'Tareas Realizadas : '.number_format($valorCumplido,0,'.',','); 
    $etiqueta = '';
    if($valorTarea != $valorCumplido and $valorCumplido != 0)
    {
        $icono = 'Amarillo.png';
        $etiqueta = '<label>'.number_format(($valorCumplido / ($valorTarea == 0 ? 1: $valorTarea) *100),1,'.',',').'%</label>';
    }elseif($valorTarea == $valorCumplido and $valorTarea != 0)
    {
        $icono = 'Verde.png';
    }
    elseif($valorTarea > 0 and $valorCumplido == 0)
    {
        $icono = 'Rojo.png';        
    }

    if($valorTarea != 0 or $valorCumplido != 0)
    {
        $icono =    '<a href="#" data-toggle="tooltip" data-placement="right" title="'.$tool.'">
                            <img src="images/iconosmenu/'.$icono.'"  width="30">
                        </a>'.$etiqueta;    
    }
    //$valorTarea .' '. $valorCumplido. 
    return $icono;
}

$examenHTML .=    
        '<div class="panel panel-primary">
            <div class="panel-heading">
              <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion" href="#examen">Exámenes Médicos</a>
              </h4>
            </div>';
            $examenHTML .= 
                '<button class="btn btn-primary" onclick="consultarExamenPlanTrabajo(this.value)" value="" type="button">Todos</button>';
            for($i=65; $i<=90; $i++) 
            {  
                $letra = chr($i);  
                $examenHTML .= 
                '<button class="btn btn-primary" onclick="consultarExamenPlanTrabajo(this.value)" value="'.$letra.'" type="button">'.$letra.'</button>';
            }
            $examenHTML .=    
            '<div id="examen" class="panel-collapse">
              <div class="panel-body" style="overflow:auto;">
                    <table  class="table table-striped table-bordered table-hover" style="width:100%;" >
                        <thead class="thead-inverse">
                            <tr class="table-info">
                                <th scope="col" width="30%">&nbsp;</th>
                                <th >Enero</th>
                                <th >Febrero</th>
                                <th >Marzo</th>
                                <th >Abril</th>
                                <th >Mayo</th>
                                <th >Junio</th>
                                <th >Julio</th>
                                <th >Agosto</th>
                                <th >Septiembre</th>
                                <th >Octubre</th>
                                <th >Noviembre</th>
                                <th >Diciembre</th>
                                <th >Presupuesto</th>
                                <th >Costo Real</th>
                                <th >Cumplimiento</th>
                                <th >Responsable</th>
                            </tr>
                        </thead>
                        <tbody>';

                            foreach($examen as $dato)
                            {
                                $examenHTML.= 
                                '<tr align="center">
                                    <th scope="row">'.$dato->descripcionTarea.'</th>
                                    <td>'.colorTarea($dato->EneroT, $dato->EneroC).'</td>
                                    <td>'.colorTarea($dato->FebreroT, $dato->FebreroC).'</td>
                                    <td>'.colorTarea($dato->MarzoT, $dato->MarzoC).'</td>
                                    <td>'.colorTarea($dato->AbrilT, $dato->AbrilC).'</td>
                                    <td>'.colorTarea($dato->MayoT, $dato->MayoC).'</td>
                                    <td>'.colorTarea($dato->JunioT, $dato->JunioC).'</td>
                                    <td>'.colorTarea($dato->JulioT, $dato->JulioC).'</td>
                                    <td>'.colorTarea($dato->AgostoT, $dato->AgostoC).'</td>
                                    <td>'.colorTarea($dato->SeptiembreT, $dato->SeptiembreC).'</td>
                                    <td>'.colorTarea($dato->OctubreT, $dato->OctubreC).'</td>
                                    <td>'.colorTarea($dato->NoviembreT, $dato->NoviembreC).'</td>
                                    <td>'.colorTarea($dato->DiciembreT, $dato->DiciembreC).'</td>
                                    <td>'.(isset($dato->PresupuestoT) ? $dato->PresupuestoT : '&nbsp;').'</td>
                                    <td>'.(isset($dato->PresupuestoC) ? $dato->PresupuestoC : '&nbsp;').'</td>
                                    <td>'; 
                                    $mesesC = ((int)$dato->EneroC + 
                                            (int)$dato->FebreroC + 
                                            (int)$dato->MarzoC + 
                                            (int)$dato->AbrilC + 
                                            (int)$dato->MayoC + 
                                            (int)$dato->JunioC + 
                                            (int)$dato->JulioC + 
                                            (int)$dato->AgostoC + 
                                            (int)$dato->SeptiembreC + 
                                            (int)$dato->OctubreC + 
                                            (int)$dato->NoviembreC + 
                                            (int)$dato->DiciembreC);

                                    $mesesT = (((int)$dato->EneroT + 
                                            (int)$dato->FebreroT + 
                                            (int)$dato->MarzoT + 
                                            (int)$dato->AbrilT + 
                                            (int)$dato->MayoT + 
                                            (int)$dato->JunioT + 
                                            (int)$dato->JulioT + 
                                            (int)$dato->AgostoT + 
                                            (int)$dato->SeptiembreT + 
                                            (int)$dato->OctubreT + 
                                            (int)$dato->NoviembreT + 
                                            (int)$dato->DiciembreT));

                                    $examenHTML .= 
                                    number_format(($mesesC / ($mesesT == 0 ? 1: $mesesT) *100),1,'.',',');
                                    $examenHTML .=
                                    '</td>
                                    <td>&nbsp;</td>
                                </tr>';
                            }
                        
                        $examenHTML .= 
                        '</tbody>
                    </table>
                  </div> 
                </div>
              </div>';

echo json_encode($examenHTML);
