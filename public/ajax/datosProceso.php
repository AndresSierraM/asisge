<?php


    $proceso = \App\Proceso::All();
    $row = array();

    foreach ($proceso as $key => $value) 
    {  
        $row[$key][] = '<a href="proceso/'.$value['idProceso'].'/edit">'.
                            '<span class="glyphicon glyphicon-pencil"></span>'.
                        '</a>&nbsp;'.
                        '<a href="proceso/'.$value['idProceso'].'/edit?accion=eliminar">'.
                            '<span class="glyphicon glyphicon-trash"></span>'.
                        '</a>';
        $row[$key][] = $value['idProceso'];
        $row[$key][] = $value['codigoProceso'];
        $row[$key][] = $value['nombreProceso'];   
    }

    $output['aaData'] = $row;
    echo json_encode($output);
?>