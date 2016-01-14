<?php


    $tiponormalegal = \App\TipoNormaLegal::All();
 
    $row = array();

    foreach ($tiponormalegal as $key => $value) 
    {  
        $row[$key][] = '<a href="tiponormalegal/'.$value['idTipoNormaLegal'].'/edit">'.
                            '<span class="glyphicon glyphicon-pencil"></span>'.
                        '</a>&nbsp;'.
                        '<a href="tiponormalegal/'.$value['idTipoNormaLegal'].'/edit?accion=eliminar">'.
                            '<span class="glyphicon glyphicon-trash"></span>'.
                        '</a>';
        $row[$key][] = $value['idTipoNormaLegal'];
        $row[$key][] = $value['codigoTipoNormaLegal'];
        $row[$key][] = $value['nombreTipoNormaLegal'];   
    }

    $output['aaData'] = $row;
    echo json_encode($output);
?>