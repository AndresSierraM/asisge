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
    
    $tipoelementoproteccion = \App\TipoElementoProteccion::where('Compania_idCompania','=', \Session::get('idCompania'))
->get();
    $row = array();

    foreach ($tipoelementoproteccion as $key => $value) 
    {  
        $row[$key][] = '<a href="tipoelementoproteccion/'.$value['idTipoElementoProteccion'].'/edit">'.
                            '<span class="glyphicon glyphicon-pencil" style = "display:'.$visibleM.'"></span>'.
                        '</a>&nbsp;'.
                        '<a href="tipoelementoproteccion/'.$value['idTipoElementoProteccion'].'/edit?accion=eliminar">'.
                            '<span class="glyphicon glyphicon-trash" style = "display:'.$visibleE.'"></span>'.
                        '</a>';
        $row[$key][] = $value['idTipoElementoProteccion'];
        $row[$key][] = $value['codigoTipoElementoProteccion'];
        $row[$key][] = $value['nombreTipoElementoProteccion'];   
    }

    $output['aaData'] = $row;
    echo json_encode($output);
?>