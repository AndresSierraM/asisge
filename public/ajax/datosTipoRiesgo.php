<?php

    $tiporiesgo = DB::table('tiporiesgo')
            ->leftJoin('clasificacionriesgo', 'ClasificacionRiesgo_idClasificacionRiesgo', '=', 'idClasificacionRiesgo')
            ->select(DB::raw('idTipoRiesgo, codigoTipoRiesgo, nombreTipoRiesgo, nombreClasificacionRiesgo'))
            ->get();

    $row = array();

    foreach ($tiporiesgo as $key => $value) 
    {  
        $row[$key][] = '<a href="tiporiesgo/'.$value->idTipoRiesgo.'/edit">'.
                            '<span class="glyphicon glyphicon-pencil"></span>'.
                        '</a>&nbsp;'.
                        '<a href="tiporiesgo/'.$value->idTipoRiesgo.'/edit?accion=eliminar">'.
                            '<span class="glyphicon glyphicon-trash"></span>'.
                        '</a>';
        $row[$key][] = $value->idTipoRiesgo;
        $row[$key][] = $value->codigoTipoRiesgo;
        $row[$key][] = $value->nombreTipoRiesgo; 
        $row[$key][] = $value->nombreClasificacionRiesgo;    
    }

    $output['aaData'] = $row;
    echo json_encode($output);
?>