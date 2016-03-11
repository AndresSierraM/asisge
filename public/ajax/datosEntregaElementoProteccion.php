<?php

    $entregaelementoproteccion = DB::table('entregaelementoproteccion')
            ->leftJoin('tercero', 'Tercero_idTercero', '=', 'idTercero')
            ->select(DB::raw('idEntregaElementoProteccion,nombreCompletoTercero, fechaEntregaElementoProteccion'))
            ->where('entregaelementoproteccion.Compania_idCompania','=', \Session::get('idCompania'))
            ->get();

    $row = array();

    foreach ($entregaelementoproteccion as $key => $value) 
    {  
        $row[$key][] = '<a href="entregaelementoproteccion/'.$value->idEntregaElementoProteccion.'/edit">'.
                            '<span class="glyphicon glyphicon-pencil"></span>'.
                        '</a>&nbsp;'.
                        '<a href="entregaelementoproteccion/'.$value->idEntregaElementoProteccion.'/edit?accion=eliminar">'.
                            '<span class="glyphicon glyphicon-trash"></span>'.
                        '</a>';
        $row[$key][] = $value->idEntregaElementoProteccion;
        $row[$key][] = $value->nombreCompletoTercero;
        $row[$key][] = $value->fechaEntregaElementoProteccion; 
    }

    $output['aaData'] = $row;
    echo json_encode($output);
?>