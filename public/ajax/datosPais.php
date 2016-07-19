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
    $pais = \App\Pais::All();
    $row = array();

    foreach ($pais as $key => $value) 
    {  
        $row[$key][] = '<a href="pais/'.$value['idPais'].'/edit">'.
                            '<span class="glyphicon glyphicon-pencil" style = "display:'.$visibleM.'"></span>'.
                        '</a>&nbsp;'.
                        '<a href="pais/'.$value['idPais'].'/edit?accion=eliminar">'.
                            '<span class="glyphicon glyphicon-trash" style = "display:'.$visibleE.'"></span>'.
                        '</a>';
        $row[$key][] = $value['idPais'];
        $row[$key][] = $value['codigoPais'];
        $row[$key][] = $value['nombrePais'];   
    }

    $output['aaData'] = $row;
    echo json_encode($output);
?>