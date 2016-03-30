<?php


    $frecuenciamedicion = \App\FrecuenciaMedicion::All();
    $row = array();

    foreach ($frecuenciamedicion as $key => $value) 
    {  
        $row[$key][] = '<a href="frecuenciamedicion/'.$value['idFrecuenciaMedicion'].'/edit">'.
                            '<span class="glyphicon glyphicon-pencil"></span>'.
                        '</a>&nbsp;'.
                        '<a href="frecuenciamedicion/'.$value['idFrecuenciaMedicion'].'/edit?accion=eliminar">'.
                            '<span class="glyphicon glyphicon-trash"></span>'.
                        '</a>';
        $row[$key][] = $value['idFrecuenciaMedicion'];
        $row[$key][] = $value['codigoFrecuenciaMedicion'];
        $row[$key][] = $value['nombreFrecuenciaMedicion'];   
        $row[$key][] = $value['valorFrecuenciaMedicion'];
        $row[$key][] = $value['unidadFrecuenciaMedicion'];
    }

    $output['aaData'] = $row;
    echo json_encode($output);
?>