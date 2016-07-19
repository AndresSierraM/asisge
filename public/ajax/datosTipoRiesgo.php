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

    $tiporiesgo = DB::table('tiporiesgo')
            ->leftJoin('clasificacionriesgo', 'ClasificacionRiesgo_idClasificacionRiesgo', '=', 'idClasificacionRiesgo')
            ->select(DB::raw('idTipoRiesgo, codigoTipoRiesgo, nombreTipoRiesgo, nombreClasificacionRiesgo'))
            ->get();

    $row = array();

    foreach ($tiporiesgo as $key => $value) 
    {  
        $row[$key][] = '<a href="tiporiesgo/'.$value->idTipoRiesgo.'/edit">'.
                            '<span class="glyphicon glyphicon-pencil" style = "display:'.$visibleM.'"></span>'.
                        '</a>&nbsp;'.
                        '<a href="tiporiesgo/'.$value->idTipoRiesgo.'/edit?accion=eliminar">'.
                            '<span class="glyphicon glyphicon-trash" style = "display:'.$visibleE.'"></span>'.
                        '</a>';
        $row[$key][] = $value->idTipoRiesgo;
        $row[$key][] = $value->codigoTipoRiesgo;
        $row[$key][] = $value->nombreTipoRiesgo; 
        $row[$key][] = $value->nombreClasificacionRiesgo;    
    }

    $output['aaData'] = $row;
    echo json_encode($output);
?>