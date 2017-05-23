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

    $tipoproveedor = \App\TipoProveedor::All();
    $row = array();

    foreach ($tipoproveedor as $key => $value) 
    {  
        $row[$key][] = '<a href="tipoproveedor/'.$value['idTipoProveedor'].'/edit">'.
                            '<span class="glyphicon glyphicon-pencil" style="display: '.$visibleM.'"></span>'.
                        '</a>&nbsp;'.
                        '<a href="tipoproveedor/'.$value['idTipoProveedor'].'/edit?accion=eliminar">'.
                            '<span class="glyphicon glyphicon-trash" style="display: '.$visibleE.'"></span>'.
                        '</a>';
        $row[$key][] = $value['idTipoProveedor'];
        $row[$key][] = $value['codigoTipoProveedor'];
        $row[$key][] = $value['nombreTipoProveedor'];
    }

    $output['aaData'] = $row;
    echo json_encode($output);
?>