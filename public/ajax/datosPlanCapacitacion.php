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
    $plancapacitacion = DB::table('plancapacitacion')
            ->leftJoin('tercero', 'Tercero_idResponsable', '=', 'idTercero')
            ->select(DB::raw('idPlanCapacitacion, nombrePlanCapacitacion, nombreCompletoTercero'))
            ->where('plancapacitacion.Compania_idCompania','=', \Session::get('idCompania'))
            ->get();

    $row = array();

    foreach ($plancapacitacion as $key => $value) 
    {  
        $row[$key][] = '<a href="plancapacitacion/'.$value->idPlanCapacitacion.'/edit">'.
                            '<span class="glyphicon glyphicon-pencil" style = "display:'.$visibleM.'"></span>'.
                        '</a>&nbsp;'.
                        '<a href="plancapacitacion/'.$value->idPlanCapacitacion.'/edit?accion=eliminar">'.
                            '<span class="glyphicon glyphicon-trash" style = "display:'.$visibleE.'"></span>'.
                        '</a>';
        $row[$key][] = $value->idPlanCapacitacion;
        $row[$key][] = $value->nombrePlanCapacitacion;
        $row[$key][] = $value->nombreCompletoTercero;   
    }

    $output['aaData'] = $row;
    echo json_encode($output);
