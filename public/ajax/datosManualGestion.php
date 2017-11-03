<?php

    $modificar = $_GET['modificar'];
    $eliminar = $_GET['eliminar'];
    $imprimir = $_GET['imprimir'];

    $visibleM = '';
    $visibleE = '';
    $visibleI = '';
    if ($modificar == 1) 
            $visibleM = 'inline-block;';
    else
            $visibleM = 'none;';

    if ($eliminar == 1) 
            $visibleE = 'inline-block;';
    else
            $visibleE = 'none;';
    if ($imprimir == 1) 
        $visibleI = 'inline-block;';
    else
        $visibleI = 'none';


    $manualgestion = DB::select('
    SELECT mg.idManualGestion,mg.codigoManualGestion,mg.nombreManualGestion,mg.fechaManualGestion
    FROM manualgestion mg
    LEFT JOIN tercero t
    ON mg.Tercero_idEmpleador = t.idTercero
    WHERE mg.Compania_idCompania = '.\Session::get('idCompania'));
    

    $row = array();

    foreach ($manualgestion as $key => $value) 
    {  
        $row[$key][] = '<a href="manualgestion/'.$value->idManualGestion.'/edit">'.
                            '<span class="glyphicon glyphicon-pencil" style = "display:'.$visibleM.'"></span>'.
                        '</a>&nbsp;'.
                        '<a href="manualgestion/'.$value->idManualGestion.'/edit?accion=eliminar">'.
                            '<span class="glyphicon glyphicon-trash" style = "display:'.$visibleE.'"></span>'.
                        '</a>&nbsp;&nbsp;'.
                        '<a href="#" onclick="imprimirFormato('.$value->idManualGestion.');">'.
                            '<span class="glyphicon glyphicon-print" style = "display:'.$visibleI.'"></span>'.
                        '</a>';
        $row[$key][] = $value->idManualGestion;
        $row[$key][] = $value->codigoManualGestion;
        $row[$key][] = $value->nombreManualGestion;
        $row[$key][] = $value->fechaManualGestion;         
    }

    $output['aaData'] = $row;
    echo json_encode($output);
?>