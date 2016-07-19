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

    $tipoinspeccion = DB::table('tipoinspeccion')
            ->leftJoin('frecuenciamedicion', 'FrecuenciaMedicion_idFrecuenciaMedicion', '=', 'idFrecuenciaMedicion')
            ->select(DB::raw('idTipoInspeccion, codigoTipoInspeccion, nombreTipoInspeccion, nombreFrecuenciaMedicion'))
            ->where('Compania_idCompania','=', \Session::get('idCompania'))
            ->get();

    $row = array();

    foreach ($tipoinspeccion as $key => $value) 
    {  
        $row[$key][] = '<a href="tipoinspeccion/'.$value->idTipoInspeccion.'/edit">'.
                            '<span class="glyphicon glyphicon-pencil" style = "display:'.$visibleM.'"></span>'.
                        '</a>&nbsp;'.
                        '<a href="tipoinspeccion/'.$value->idTipoInspeccion.'/edit?accion=eliminar">'.
                            '<span class="glyphicon glyphicon-trash" style = "display:'.$visibleE.'"></span>'.
                        '</a>';
        $row[$key][] = $value->idTipoInspeccion;
        $row[$key][] = $value->codigoTipoInspeccion;
        $row[$key][] = $value->nombreTipoInspeccion; 
        $row[$key][] = $value->nombreFrecuenciaMedicion;    
    }

    $output['aaData'] = $row;
    echo json_encode($output);
?>