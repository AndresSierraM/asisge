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
    $plantrabajo = DB::table('plantrabajo')
            ->select(DB::raw('idPlanTrabajo, numeroPlanTrabajo, asuntoPlanTrabajo, fechaPlanTrabajo'))
            ->where('Compania_idCompania','=', \Session::get('idCompania'))
            ->get();
    $row = array();

    foreach ($plantrabajo as $key => $value) 
    {  
        $row[$key][] = '<a href="plantrabajoformulario/'.$value->idPlanTrabajo.'/edit">'.
                            '<span class="glyphicon glyphicon-pencil" style = "display:'.$visibleM.'"></span>'.
                        '</a>&nbsp;'.
                        '<a href="plantrabajoformulario/'.$value->idPlanTrabajo.'/edit?accion=eliminar">'.
                            '<span class="glyphicon glyphicon-trash" style = "display:'.$visibleE.'"></span>'.
                        '</a>';
        $row[$key][] = $value->idPlanTrabajo;
        $row[$key][] = $value->numeroPlanTrabajo;
        $row[$key][] = $value->asuntoPlanTrabajo;   
        $row[$key][] = $value->fechaPlanTrabajo;   
    }

    $output['aaData'] = $row;
    echo json_encode($output);
?>