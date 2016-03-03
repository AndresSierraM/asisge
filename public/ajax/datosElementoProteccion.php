<?php

    $elementoproteccion = DB::table('elementoproteccion')
    ->leftJoin('tipoelementoproteccion', 'TipoElementoProteccion_idTipoElementoProteccion', '=', 'idTipoElementoProteccion')
    ->select(DB::raw('idElementoProteccion, codigoElementoProteccion, nombreElementoProteccion, nombreTipoElementoProteccion, imagenElementoProteccion'))
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
        $row[$key][] = ($value->imagenElementoProteccion == '' 
                            ? '&nbsp;' 
                            : '<img width="80px" src="imagenes/'.$value->imagenElementoProteccion.'">');   
    }

    $output['aaData'] = $row;
    echo json_encode($output);
?>