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
    $elementoproteccion = DB::table('elementoproteccion')
    ->leftJoin('tipoelementoproteccion', 'TipoElementoProteccion_idTipoElementoProteccion', '=', 'idTipoElementoProteccion')
    ->select(DB::raw('idElementoProteccion, codigoElementoProteccion, nombreElementoProteccion, nombreTipoElementoProteccion, imagenElementoProteccion'))
    ->where('elementoproteccion.Compania_idCompania','=', \Session::get('idCompania'))
    ->get();

    $row = array();

  foreach ($elementoproteccion as $key => $value) 
    {  
        $row[$key][] = '<a href="elementoproteccion/'.$value->idElementoProteccion.'/edit">'.
                            '<span class="glyphicon glyphicon-pencil" style = "display:'.$visibleM.'"></span>'.
                        '</a>&nbsp;'.
                        '<a href="elementoproteccion/'.$value->idElementoProteccion.'/edit?accion=eliminar">'.
                            '<span class="glyphicon glyphicon-trash"  style = "display:'.$visibleE.'"></span>'.
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