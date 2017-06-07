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

    $tipoproveedor = DB::Select('
        SELECT 
            idTipoProveedor, codigoTipoProveedor, nombreTipoProveedor
        FROM 
            tipoproveedor tp
                LEFT JOIN 
            compania c ON tp.Compania_idCompania = c.idCompania
        WHERE idCompania = '.\Session::get('idCompania'));
    $row = array();

    foreach ($tipoproveedor as $key => $value) 
    {  
        $tp = get_object_vars($value);
        $row[$key][] = '<a href="tipoproveedor/'.$tp['idTipoProveedor'].'/edit">'.
                            '<span class="glyphicon glyphicon-pencil" style="display: '.$visibleM.'"></span>'.
                        '</a>&nbsp;'.
                        '<a href="tipoproveedor/'.$tp['idTipoProveedor'].'/edit?accion=eliminar">'.
                            '<span class="glyphicon glyphicon-trash" style="display: '.$visibleE.'"></span>'.
                        '</a>';
        $row[$key][] = $tp['idTipoProveedor'];
        $row[$key][] = $tp['codigoTipoProveedor'];
        $row[$key][] = $tp['nombreTipoProveedor'];
    }

    $output['aaData'] = $row;
    echo json_encode($output);
?>