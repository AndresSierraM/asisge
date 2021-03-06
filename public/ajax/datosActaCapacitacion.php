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

    $actacapacitacion = DB::table('actacapacitacion')
            ->leftJoin('plancapacitacion', 'PlanCapacitacion_idPlanCapacitacion', '=', 'idPlanCapacitacion')
            ->select(DB::raw('idActaCapacitacion, numeroActaCapacitacion, fechaElaboracionActaCapacitacion, nombrePlanCapacitacion'))
            ->where('actacapacitacion.Compania_idCompania','=', \Session::get('idCompania'))
            ->get();

    $row = array();

    foreach ($actacapacitacion as $key => $value) 
    {  
        $row[$key][] = '<a href="actacapacitacion/'.$value->idActaCapacitacion.'/edit">'.
                            '<span class="glyphicon glyphicon-pencil" style = "display:'.$visibleM.'"></span>'.
                        '</a>&nbsp;'.
                        '<a href="actacapacitacion/'.$value->idActaCapacitacion.'/edit?accion=eliminar">'.
                            '<span class="glyphicon glyphicon-trash" style = "display:'.$visibleE.'"></span>'.
                        '</a>&nbsp;'.
                        '<a onclick="firmarActaCapacitacion('.$value->idActaCapacitacion.')">'.
                            '<span class="glyphicon glyphicon-edit" style = "cursor:pointer; display:'.$visibleM.'"></span>'.
                        '</a>&nbsp;'.
                        '<a href="#" onclick="imprimirFormato('.$value->idActaCapacitacion.');">'.
                            '<span class="glyphicon glyphicon-print" style = "display:'.$visibleI.'"></span>'.
                        '</a>';
        $row[$key][] = $value->idActaCapacitacion;
        $row[$key][] = $value->numeroActaCapacitacion;
        $row[$key][] = $value->fechaElaboracionActaCapacitacion; 
        $row[$key][] = $value->nombrePlanCapacitacion;    
    }

    $output['aaData'] = $row;
    echo json_encode($output);
?>