<?php
    $modificar = $_GET['modificar'];
    $eliminar = $_GET['eliminar'];

    $visibleM = '';
    $visibleE = '';
    if ($modificar == 1) 
        $visibleM = 'inline-block;';
    else
        $visibleM = 'none;';

    if ($eliminar == 1) 
        $visibleE = 'inline-block;';
    else
        $visibleE = 'none;';

    $actacapacitacion = DB::table('actacapacitacion')
            ->leftJoin('plancapacitacion', 'PlanCapacitacion_idPlanCapacitacion', '=', 'idPlanCapacitacion')
            ->select(DB::raw('idActaCapacitacion, numeroActaCapacitacion, fechaElaboracionActaCapacitacion, nombrePlanCapacitacion'))
            ->get();

    $row = array();

    foreach ($actacapacitacion as $key => $value) 
    {  
        $row[$key][] = '<a href="actacapacitacion/'.$value->idActaCapacitacion.'/edit">'.
                            '<span class="glyphicon glyphicon-pencil" style = "display:'.$visibleM.'"></span>'.
                        '</a>&nbsp;'.
                        '<a href="actacapacitacion/'.$value->idActaCapacitacion.'/edit?accion=eliminar">'.
                            '<span class="glyphicon glyphicon-trash" style = "display:'.$visibleE.'"></span>'.
                        '</a>';
        $row[$key][] = $value->idActaCapacitacion;
        $row[$key][] = $value->numeroActaCapacitacion;
        $row[$key][] = $value->fechaElaboracionActaCapacitacion; 
        $row[$key][] = $value->nombrePlanCapacitacion;    
    }

    $output['aaData'] = $row;
    echo json_encode($output);
?>