<?php

    $programa = DB::table('programa')
            ->leftJoin('clasificacionriesgo', 'ClasificacionRiesgo_idClasificacionRiesgo', '=', 'idClasificacionRiesgo')
            ->select(DB::raw('idPrograma, nombrePrograma, fechaElaboracionPrograma, nombreClasificacionRiesgo'))
            ->get();

    $row = array();

    foreach ($programa as $key => $value) 
    {  
        $row[$key][] = '<a href="programa/'.$value->idPrograma.'/edit">'.
                            '<span class="glyphicon glyphicon-pencil"></span>'.
                        '</a>&nbsp;'.
                        '<a href="programa/'.$value->idPrograma.'/edit?accion=eliminar">'.
                            '<span class="glyphicon glyphicon-trash"></span>'.
                        '</a>';
        $row[$key][] = $value->idPrograma;
        $row[$key][] = $value->nombrePrograma;
        $row[$key][] = $value->fechaElaboracionPrograma; 
        $row[$key][] = $value->nombreClasificacionRiesgo;    
    }

    $output['aaData'] = $row;
    echo json_encode($output);
?>