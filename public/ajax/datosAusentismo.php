<?php

    $ausentismo = DB::table('ausentismo')
            ->leftJoin('tercero', 'Tercero_idTercero', '=', 'idTercero')
            ->leftJoin('accidente', 'Ausentismo_idAusentismo', '=', 'idAusentismo')
            ->select(DB::raw('idAusentismo, nombreCompletoTercero, fechaElaboracionAusentismo, tipoAusentismo, fechaInicioAusentismo, fechaFinAusentismo, nombreAccidente, diasAusentismo'))
            ->get();

    $row = array();

    foreach ($ausentismo as $key => $value) 
    {  
        $row[$key][] = '<a href="ausentismo/'.$value->idAusentismo.'/edit">'.
                            '<span class="glyphicon glyphicon-pencil"></span>'.
                        '</a>&nbsp;'.
                        '<a href="ausentismo/'.$value->idAusentismo.'/edit?accion=eliminar">'.
                            '<span class="glyphicon glyphicon-trash"></span>'.
                        '</a>';
        $row[$key][] = $value->idAusentismo;
        $row[$key][] = $value->nombreCompletoTercero;
        $row[$key][] = $value->fechaElaboracionAusentismo; 
        $row[$key][] = $value->fechaInicioAusentismo;
        $row[$key][] = $value->fechaFinAusentismo;    
        $row[$key][] = $value->diasAusentismo;    
        $row[$key][] = $value->tipoAusentismo;
        $row[$key][] = $value->nombreAccidente;
    }

    $output['aaData'] = $row;
    echo json_encode($output);
?>