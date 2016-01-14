<?php

    $tercero = DB::table('tercero')
            ->leftJoin('tipoidentificacion', 'TipoIdentificacion_idTipoIdentificacion', '=', 'idTipoIdentificacion')
            ->select(DB::raw('idTercero, nombreTipoIdentificacion , documentoTercero, nombreCompletoTercero, estadoTercero'))
            ->get();

    $row = array();

    foreach ($tercero as $key => $value) 
    {  
        $row[$key][] = '<a href="tercero/'.$value->idTercero.'/edit">'.
                            '<span class="glyphicon glyphicon-pencil"></span>'.
                        '</a>&nbsp;'.
                        '<a href="tercero/'.$value->idTercero.'/edit?accion=eliminar">'.
                            '<span class="glyphicon glyphicon-trash"></span>'.
                        '</a>';
        $row[$key][] = $value->idTercero;
        $row[$key][] = $value->nombreTipoIdentificacion;
        $row[$key][] = $value->documentoTercero;
        $row[$key][] = $value->nombreCompletoTercero;  
        $row[$key][] = $value->estadoTercero;    
    }

    $output['aaData'] = $row;
    echo json_encode($output);
?>