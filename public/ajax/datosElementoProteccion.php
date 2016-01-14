<?php

    $elementoproteccion = DB::table('elementoproteccion')
    ->leftJoin('tipoelementoproteccion', 'TipoElementoProteccion_idTipoElementoProteccion', '=', 'idTipoElementoProteccion')
    ->select(DB::raw('idElementoProteccion, codigoElementoProteccion, nombreElementoProteccion, nombreTipoElementoProteccion'))
    ->get();

    $row = array();

  foreach ($elementoproteccion as $key => $value) 
    {  
        $row[$key][] = '<a href="elementoproteccion/'.$value->idElementoProteccion.'/edit">'.
                            '<span class="glyphicon glyphicon-pencil"></span>'.
                        '</a>&nbsp;'.
                        '<a href="elementoproteccion/'.$value->idElementoProteccion.'/edit?accion=eliminar">'.
                            '<span class="glyphicon glyphicon-trash"></span>'.
                        '</a>';
        $row[$key][] = $value->idElementoProteccion;
        $row[$key][] = $value->codigoElementoProteccion;
        $row[$key][] = $value->nombreElementoProteccion; 
        $row[$key][] = $value->nombreTipoElementoProteccion;    
    }

    $output['aaData'] = $row;
    echo json_encode($output);
?>