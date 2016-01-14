<?php


    $tipoidentificacion = \App\TipoIdentificacion::All();
    $row = array();

    foreach ($tipoidentificacion as $key => $value) 
    {  
        $row[$key][] = '<a href="tipoidentificacion/'.$value['idTipoIdentificacion'].'/edit">'.
                            '<span class="glyphicon glyphicon-pencil"></span>'.
                        '</a>&nbsp;'.
                        '<a href="tipoidentificacion/'.$value['idTipoIdentificacion'].'/edit?accion=eliminar">'.
                            '<span class="glyphicon glyphicon-trash"></span>'.
                        '</a>';
        $row[$key][] = $value['idTipoIdentificacion'];
        $row[$key][] = $value['codigoTipoIdentificacion'];
        $row[$key][] = $value['nombreTipoIdentificacion'];   
    }

    $output['aaData'] = $row;
    echo json_encode($output);
?>