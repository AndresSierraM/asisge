<?php

    $modificar = $_GET['modificar'];
    $eliminar = $_GET['eliminar'];

    $visibleM = '';
    $visibleE = '';
    if ($modificar == 1) 
        $visibleM = 'inline-block;';
    else
        $visibleM = 'none;';

    if ($eliminar == 1) 
        $visibleE = 'inline-block;';
    else
        $visibleE = 'none;';
    $listageneral = \App\ListaGeneral::All();
    $row = array();

    foreach ($listageneral as $key => $value) 
    {  
        $row[$key][] = '<a href="listageneral/'.$value['idListaGeneral'].'/edit">'.
                            '<span class="glyphicon glyphicon-pencil" style = "display:'.$visibleM.'"></span>'.
                        '</a>&nbsp;'.
                        '<a href="listageneral/'.$value['idListaGeneral'].'/edit?accion=eliminar">'.
                            '<span class="glyphicon glyphicon-trash" style = "display:'.$visibleE.'"></span>'.
                        '</a>';
        $row[$key][] = $value['idListaGeneral'];
        $row[$key][] = $value['codigoListaGeneral'];
        $row[$key][] = $value['nombreListaGeneral'];   
        $row[$key][] = $value['tipoListaGeneral'];   
    }

    $output['aaData'] = $row;
    echo json_encode($output);
?>  