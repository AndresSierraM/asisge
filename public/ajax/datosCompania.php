<?php

    $adicionar = $_GET['adicionar'];
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

    if ($adicionar == 1) 
    {
        $compania = DB::table('compania')
            ->select(DB::raw('idCompania, codigoCompania, nombreCompania'))
            ->get();
    }
    else
    {
        $compania = DB::table('compania')
            ->select(DB::raw('idCompania, codigoCompania, nombreCompania'))
            ->where('idCompania','=', \Session::get('idCompania'))
            ->get();

    }

    // $compania = \App\Compania::All();
    $row = array();

    foreach ($compania as $key => $value) 
    {  
        $row[$key][] = '<a href="compania/'.$value->idCompania.'/edit">'.
                            '<span class="glyphicon glyphicon-pencil" style = "display:'.$visibleM.'"></span>'.
                        '</a>&nbsp;'.
                        '<a href="compania/'.$value->idCompania.'/edit?accion=eliminar">'.
                            '<span class="glyphicon glyphicon-trash"  style = "display:'.$visibleE.'"></span>'.
                        '</a>';
        $row[$key][] = $value->idCompania;
        $row[$key][] = $value->codigoCompania;
        $row[$key][] = $value->nombreCompania;   
    }

    $output['aaData'] = $row;
    echo json_encode($output);
?>