<?php


    $listageneral = \App\ListaGeneral::All();
    $row = array();

    foreach ($listageneral as $key => $value) 
    {  
        $row[$key][] = '<a href="listageneral/'.$value['idListaGeneral'].'/edit">'.
                            '<span class="glyphicon glyphicon-pencil"></span>'.
                        '</a>&nbsp;'.
                        '<a href="listageneral/'.$value['idListaGeneral'].'/edit?accion=eliminar">'.
                            '<span class="glyphicon glyphicon-trash"></span>'.
                        '</a>';
        $row[$key][] = $value['idListaGeneral'];
        $row[$key][] = $value['codigoListaGeneral'];
        $row[$key][] = $value['nombreListaGeneral'];   
        $row[$key][] = $value['tipoListaGeneral'];   
    }

    $output['aaData'] = $row;
    echo json_encode($output);
?>  