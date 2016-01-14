<?php

    $inspeccion = DB::table('inspeccion')
            ->leftJoin('tipoinspeccion', 'TipoInspeccion_idTipoInspeccion', '=', 'idTipoInspeccion')
            ->leftJoin('tercero', 'Tercero_idRealizadaPor', '=', 'idTercero')
            ->select(DB::raw('idInspeccion, fechaElaboracionInspeccion, nombreTipoInspeccion, nombreCompletoTercero'))
            ->get();

    $row = array();

    foreach ($inspeccion as $key => $value) 
    {  
        $row[$key][] = '<a href="inspeccion/'.$value->idInspeccion.'/edit">'.
                            '<span class="glyphicon glyphicon-pencil"></span>'.
                        '</a>&nbsp;'.
                        '<a href="inspeccion/'.$value->idInspeccion.'/edit?accion=eliminar">'.
                            '<span class="glyphicon glyphicon-trash"></span>'.
                        '</a>';
        $row[$key][] = $value->idInspeccion;
        $row[$key][] = $value->fechaElaboracionInspeccion;
        $row[$key][] = $value->nombreTipoInspeccion; 
        $row[$key][] = $value->nombreCompletoTercero;    
    }

    $output['aaData'] = $row;
    echo json_encode($output);
?>