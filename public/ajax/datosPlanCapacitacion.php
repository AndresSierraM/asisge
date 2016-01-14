<?php

    $plancapacitacion = DB::table('plancapacitacion')
            ->leftJoin('tercero', 'Tercero_idResponsable', '=', 'idTercero')
            ->select(DB::raw('idPlanCapacitacion, nombrePlanCapacitacion, nombreCompletoTercero'))
            ->get();

    $row = array();

    foreach ($plancapacitacion as $key => $value) 
    {  
        $row[$key][] = '<a href="plancapacitacion/'.$value->idPlanCapacitacion.'/edit">'.
                            '<span class="glyphicon glyphicon-pencil"></span>'.
                        '</a>&nbsp;'.
                        '<a href="plancapacitacion/'.$value->idPlanCapacitacion.'/edit?accion=eliminar">'.
                            '<span class="glyphicon glyphicon-trash"></span>'.
                        '</a>';
        $row[$key][] = $value->idPlanCapacitacion;
        $row[$key][] = $value->nombrePlanCapacitacion;
        $row[$key][] = $value->nombreCompletoTercero;   
    }

    $output['aaData'] = $row;
    echo json_encode($output);
?>