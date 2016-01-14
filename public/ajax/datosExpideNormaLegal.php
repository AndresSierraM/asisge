<?php


    $expidenormalegal = \App\ExpideNormaLegal::All();
    $row = array();

    foreach ($expidenormalegal as $key => $value) 
    {  
        $row[$key][] = '<a href="expidenormalegal/'.$value['idExpideNormaLegal'].'/edit">'.
                            '<span class="glyphicon glyphicon-pencil"></span>'.
                        '</a>&nbsp;'.
                        '<a href="expidenormalegal/'.$value['idExpideNormaLegal'].'/edit?accion=eliminar">'.
                            '<span class="glyphicon glyphicon-trash"></span>'.
                        '</a>';
        $row[$key][] = $value['idExpideNormaLegal'];
        $row[$key][] = $value['codigoExpideNormaLegal'];
        $row[$key][] = $value['nombreExpideNormaLegal'];   
    }

    $output['aaData'] = $row;
    echo json_encode($output);
?>