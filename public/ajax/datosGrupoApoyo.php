<?php


    $grupoapoyo = \App\GrupoApoyo::All();
    // print_r($grupoapoyo);
    // exit;
    $row = array();

    foreach ($grupoapoyo as $key => $value) 
    {  
        $row[$key][] = '<a href="grupoapoyo/'.$value['idGrupoApoyo'].'/edit">'.
                            '<span class="glyphicon glyphicon-pencil"></span>'.
                        '</a>&nbsp;'.
                        '<a href="grupoapoyo/'.$value['idGrupoApoyo'].'/edit?accion=eliminar">'.
                            '<span class="glyphicon glyphicon-trash"></span>'.
                        '</a>';
        $row[$key][] = $value['idGrupoApoyo'];
        $row[$key][] = $value['codigoGrupoApoyo'];   
        $row[$key][] = $value['nombreGrupoApoyo'];
    }

    $output['aaData'] = $row;
    echo json_encode($output);
?>