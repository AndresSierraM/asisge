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
    $inspeccion = DB::table('inspeccion')
            ->leftJoin('tipoinspeccion', 'TipoInspeccion_idTipoInspeccion', '=', 'idTipoInspeccion')
            ->leftJoin('tercero', 'Tercero_idRealizadaPor', '=', 'idTercero')
            ->select(DB::raw('idInspeccion, fechaElaboracionInspeccion, nombreTipoInspeccion, nombreCompletoTercero'))
            ->where('inspeccion.Compania_idCompania','=', \Session::get('idCompania'))
            ->get();

    $row = array();

    foreach ($inspeccion as $key => $value) 
    {  
        $row[$key][] = '<a href="inspeccion/'.$value->idInspeccion.'/edit">'.
                            '<span class="glyphicon glyphicon-pencil" style = "display:'.$visibleM.'"></span>'.
                        '</a>&nbsp;'.
                        '<a href="inspeccion/'.$value->idInspeccion.'/edit?accion=eliminar">'.
                            '<span class="glyphicon glyphicon-trash" style = "display:'.$visibleE.'"></span>'.
                        '</a>';
        $row[$key][] = $value->idInspeccion;
        $row[$key][] = $value->fechaElaboracionInspeccion;
        $row[$key][] = $value->nombreTipoInspeccion; 
        $row[$key][] = $value->nombreCompletoTercero;    
    }

    $output['aaData'] = $row;
    echo json_encode($output);
?>