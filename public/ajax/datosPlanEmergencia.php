<?php

    $modificar = $_GET['modificar'];
    $eliminar = $_GET['eliminar'];
    $imprimir = $_GET['imprimir'];

    $visibleM = '';
    $visibleE = '';
    $visibleI = '';
    if ($modificar == 1) 
            $visibleM = 'inline-block;';
    else
            $visibleM = 'none;';

    if ($eliminar == 1) 
            $visibleE = 'inline-block;';
    else
            $visibleE = 'none;';
    if ($imprimir == 1) 
        $visibleI = 'inline-block;';
    else
        $visibleI = 'none';

    $planemergencia = DB::select('
        SELECT pe.idPlanEmergencia,pe.nombrePlanEmergencia,cc.nombreCentroCosto,pe.fechaElaboracionPlanEmergencia,t.nombreCompletoTercero
        FROM planemergencia pe
        LEFT JOIN centrocosto cc
        ON pe.CentroCosto_idCentroCosto = cc.idCentroCosto
        LEFT JOIN tercero t
        ON pe.Tercero_idRepresentanteLegal = t.idTercero
        WHERE pe.Compania_idCompania = '.\Session::get('idCompania'));

    $row = array();

    foreach ($planemergencia as $key => $value) 
    {  
        $row[$key][] = '<a href="planemergencia/'.$value->idPlanEmergencia.'/edit">'.
                            '<span class="glyphicon glyphicon-pencil" style = "display:'.$visibleM.'"></span>'.
                        '</a>&nbsp;'.
                        '<a href="planemergencia/'.$value->idPlanEmergencia.'/edit?accion=eliminar">'.
                            '<span class="glyphicon glyphicon-trash" style = "display:'.$visibleE.'"></span>'.
                        '</a>&nbsp;'.
                        '<a href="#" onclick="imprimirFormato('.$value->idPlanEmergencia.');">'.
                            '<span class="glyphicon glyphicon-print" style = "display:'.$visibleI.'"></span>'.
                        '</a>';
        $row[$key][] = $value->idPlanEmergencia;
        $row[$key][] = $value->nombrePlanEmergencia;
        $row[$key][] = $value->nombreCentroCosto;
        $row[$key][] = $value->fechaElaboracionPlanEmergencia;   
        $row[$key][] = $value->nombreCompletoTercero;       
    }

    $output['aaData'] = $row;
    echo json_encode($output);
?>