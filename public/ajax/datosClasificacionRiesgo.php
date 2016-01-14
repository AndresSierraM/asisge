<?php


    $clasificacionriesgo = \App\ClasificacionRiesgo::All();
    $row = array();

    foreach ($clasificacionriesgo as $key => $value) 
    {  
        $row[$key][] = '<a href="clasificacionriesgo/'.$value['idClasificacionRiesgo'].'/edit">'.
                            '<span class="glyphicon glyphicon-pencil"></span>'.
                        '</a>&nbsp;'.
                        '<a href="clasificacionriesgo/'.$value['idClasificacionRiesgo'].'/edit?accion=eliminar">'.
                            '<span class="glyphicon glyphicon-trash"></span>'.
                        '</a>';
        $row[$key][] = $value['idClasificacionRiesgo'];
        $row[$key][] = $value['codigoClasificacionRiesgo'];
        $row[$key][] = $value['nombreClasificacionRiesgo'];   
    }

    $output['aaData'] = $row;
    echo json_encode($output);
?>