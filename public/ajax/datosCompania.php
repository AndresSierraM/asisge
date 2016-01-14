<?php


    $compania = \App\Compania::All();
    $row = array();

    foreach ($compania as $key => $value) 
    {  
        $row[$key][] = '<a href="compania/'.$value['idCompania'].'/edit">'.
                            '<span class="glyphicon glyphicon-pencil"></span>'.
                        '</a>&nbsp;'.
                        '<a href="compania/'.$value['idCompania'].'/edit?accion=eliminar">'.
                            '<span class="glyphicon glyphicon-trash"></span>'.
                        '</a>';
        $row[$key][] = $value['idCompania'];
        $row[$key][] = $value['codigoCompania'];
        $row[$key][] = $value['nombreCompania'];   
    }

    $output['aaData'] = $row;
    echo json_encode($output);
?>