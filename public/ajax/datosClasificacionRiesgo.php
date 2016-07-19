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

    $clasificacionriesgo = \App\ClasificacionRiesgo::All();
    $row = array();

    foreach ($clasificacionriesgo as $key => $value) 
    {  
        $row[$key][] = '<a href="clasificacionriesgo/'.$value['idClasificacionRiesgo'].'/edit">'.
                            '<span class="glyphicon glyphicon-pencil" style = "display:'.$visibleM.'"></span>'.
                        '</a>&nbsp;'.
                        '<a href="clasificacionriesgo/'.$value['idClasificacionRiesgo'].'/edit?accion=eliminar">'.
                            '<span class="glyphicon glyphicon-trash" style = "display:'.$visibleE.'"></span>'.
                        '</a>';
        $row[$key][] = $value['idClasificacionRiesgo'];
        $row[$key][] = $value['codigoClasificacionRiesgo'];
        $row[$key][] = $value['nombreClasificacionRiesgo'];   
    }

    $output['aaData'] = $row;
    echo json_encode($output);
?>