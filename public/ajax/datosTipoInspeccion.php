<?php

    $tipoinspeccion = DB::table('tipoinspeccion')
            ->leftJoin('frecuenciamedicion', 'FrecuenciaMedicion_idFrecuenciaMedicion', '=', 'idFrecuenciaMedicion')
            ->select(DB::raw('idTipoInspeccion, codigoTipoInspeccion, nombreTipoInspeccion, nombreFrecuenciaMedicion'))
            ->where('Compania_idCompania','=', \Session::get('idCompania'))
            ->get();

    $row = array();

    foreach ($tipoinspeccion as $key => $value) 
    {  
        $row[$key][] = '<a href="tipoinspeccion/'.$value->idTipoInspeccion.'/edit">'.
                            '<span class="glyphicon glyphicon-pencil"></span>'.
                        '</a>&nbsp;'.
                        '<a href="tipoinspeccion/'.$value->idTipoInspeccion.'/edit?accion=eliminar">'.
                            '<span class="glyphicon glyphicon-trash"></span>'.
                        '</a>';
        $row[$key][] = $value->idTipoInspeccion;
        $row[$key][] = $value->codigoTipoInspeccion;
        $row[$key][] = $value->nombreTipoInspeccion; 
        $row[$key][] = $value->nombreFrecuenciaMedicion;    
    }

    $output['aaData'] = $row;
    echo json_encode($output);
?>