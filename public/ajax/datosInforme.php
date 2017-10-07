<?php

    $modificar = $_GET['modificar'];
    $eliminar = $_GET['eliminar'];
    $consultar = $_GET['consultar'];
    //$consultar = $_GET['consultar'];

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

    if ($consultar == 1) 
        $visibleC = 'inline-block;';
    else
        $visibleC = 'none;';

    if ($consultar == 1) 
        $visibleEst = 'inline-block;';
    else
        $visibleEst = 'none;';

    $data = DB::table('informe')
                ->leftjoin('categoriainforme', 'CategoriaInforme_idCategoriaInforme', '=', 'idCategoriaInforme')
                ->select(DB::raw('idInforme, nombreInforme, descripcionInforme, nombreCategoriaInforme '))
                ->get();
    
    $row = array();

    foreach ($data as $key => $value) 
    {  
        $row[$key][] = '<a href="informe/'.$value->idInforme.'/edit">'.
                            '<span class="glyphicon glyphicon-pencil" style="display: '.$visibleM.'"></span>'.
                        '</a>&nbsp;'.
                        '<a href="informe/'.$value->idInforme.'/edit?accion=eliminar">'.
                            '<span class="glyphicon glyphicon-trash" style="display: '.$visibleE.'"></span>'.
                        '</a>';
        $row[$key][] = $value->idInforme;
        $row[$key][] = $value->nombreInforme;
        $row[$key][] = $value->descripcionInforme;   
        $row[$key][] = $value->nombreCategoriaInforme; 
    }

    $output['aaData'] = $row;
    echo json_encode($output);
?>