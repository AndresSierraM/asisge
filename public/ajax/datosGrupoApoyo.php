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
    $grupoapoyo = DB::table('grupoapoyo')
            ->leftJoin('frecuenciamedicion', 'FrecuenciaMedicion_idFrecuenciaMedicion', '=', 'idFrecuenciaMedicion')
            ->select(DB::raw('idGrupoApoyo, codigoGrupoApoyo, nombreGrupoApoyo, nombreFrecuenciaMedicion'))
            ->where('Compania_idCompania','=', \Session::get('idCompania'))
            ->get();


    // print_r($grupoapoyo);
    // exit;
    $row = array();

    foreach ($grupoapoyo as $key => $value) 
    {  
        $row[$key][] = '<a href="grupoapoyo/'.$value->idGrupoApoyo.'/edit">'.
                            '<span class="glyphicon glyphicon-pencil" style = "display:'.$visibleM.'"></span>'.
                        '</a>&nbsp;'.
                        '<a href="grupoapoyo/'.$value->idGrupoApoyo.'/edit?accion=eliminar">'.
                            '<span class="glyphicon glyphicon-trash" style = "display:'.$visibleE.'"></span>'.
                        '</a>';
        $row[$key][] = $value->idGrupoApoyo;
        $row[$key][] = $value->codigoGrupoApoyo;   
        $row[$key][] = $value->nombreGrupoApoyo;
        $row[$key][] = $value->nombreFrecuenciaMedicion;
    }

    $output['aaData'] = $row;
    echo json_encode($output);
?>