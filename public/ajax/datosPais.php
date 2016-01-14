<?php


    $pais = \App\Pais::All();
    $row = array();

    foreach ($pais as $key => $value) 
    {  
        $row[$key][] = '<a href="pais/'.$value['idPais'].'/edit">'.
                            '<span class="glyphicon glyphicon-pencil"></span>'.
                        '</a>&nbsp;'.
                        '<a href="pais/'.$value['idPais'].'/edit?accion=eliminar">'.
                            '<span class="glyphicon glyphicon-trash"></span>'.
                        '</a>';
        $row[$key][] = $value['idPais'];
        $row[$key][] = $value['codigoPais'];
        $row[$key][] = $value['nombrePais'];   
    }

    $output['aaData'] = $row;
    echo json_encode($output);
?>