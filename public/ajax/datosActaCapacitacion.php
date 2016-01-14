<?php

    $actacapacitacion = DB::table('actacapacitacion')
            ->leftJoin('plancapacitacion', 'PlanCapacitacion_idPlanCapacitacion', '=', 'idPlanCapacitacion')
            ->select(DB::raw('idActaCapacitacion, numeroActaCapacitacion, fechaElaboracionActaCapacitacion, nombrePlanCapacitacion'))
            ->get();

    $row = array();

    foreach ($actacapacitacion as $key => $value) 
    {  
        $row[$key][] = '<a href="actacapacitacion/'.$value->idActaCapacitacion.'/edit">'.
                            '<span class="glyphicon glyphicon-pencil"></span>'.
                        '</a>&nbsp;'.
                        '<a href="actacapacitacion/'.$value->idActaCapacitacion.'/edit?accion=eliminar">'.
                            '<span class="glyphicon glyphicon-trash"></span>'.
                        '</a>';
        $row[$key][] = $value->idActaCapacitacion;
        $row[$key][] = $value->numeroActaCapacitacion;
        $row[$key][] = $value->fechaElaboracionActaCapacitacion; 
        $row[$key][] = $value->nombrePlanCapacitacion;    
    }

    $output['aaData'] = $row;
    echo json_encode($output);
?>