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

    $frecuenciamedicion = \App\FrecuenciaMedicion::All();
    $row = array();

    foreach ($frecuenciamedicion as $key => $value) 
    {  
        $row[$key][] = '<a href="frecuenciamedicion/'.$value['idFrecuenciaMedicion'].'/edit">'.
                            '<span class="glyphicon glyphicon-pencil" style = "display:'.$visibleM.'"></span>'.
                        '</a>&nbsp;'.
                        '<a href="frecuenciamedicion/'.$value['idFrecuenciaMedicion'].'/edit?accion=eliminar">'.
                            '<span class="glyphicon glyphicon-trash" style = "display:'.$visibleE.'"></span>'.
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