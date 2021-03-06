<?php

    $modificar = $_GET['modificar'];
    $eliminar = $_GET['eliminar'];
    $imprimir = $_GET['imprimir'];

    $visibleM = '';
    $visibleE = '';
    $visibleI = '';

    if ($modificar == 1) 
        $visibleM = 'inline-block;';
    else
        $visibleM = 'none;';

    if ($eliminar == 1) 
        $visibleE = 'inline-block;';
    else
        $visibleE = 'none;';

    if ($imprimir == 1) 
        $visibleI = 'inline-block;';
    else
        $visibleI = 'none;';

    $matrizlegal = DB::table('matrizlegal')
            ->leftJoin('users', 'Users_id', '=', 'id')
            ->select(DB::raw('idMatrizLegal, nombreMatrizLegal, fechaElaboracionMatrizLegal, origenMatrizLegal, name'))
            ->where('matrizlegal.Compania_idCompania','=', \Session::get('idCompania'))
            ->get();

    $row = array();

    foreach ($matrizlegal as $key => $value) 
    {  
        $row[$key][] = '<a href="matrizlegal/'.$value->idMatrizLegal.'/edit">'.
                            '<span class="glyphicon glyphicon-pencil" style = "display:'.$visibleM.'"></span>'.
                        '</a>&nbsp;'.
                        '<a href="matrizlegal/'.$value->idMatrizLegal.'/edit?accion=eliminar">'.
                            '<span class="glyphicon glyphicon-trash" style = "display:'.$visibleE.'"></span>'.
                        '</a>&nbsp;'.
                        '<a href="#" onclick="imprimirFormato('.$value->idMatrizLegal.');">'.
                            '<span class="glyphicon glyphicon-print" style = "display:'.$visibleI.'"></span>'.
                        '</a>';
        $row[$key][] = $value->idMatrizLegal;
        $row[$key][] = $value->nombreMatrizLegal;
        $row[$key][] = $value->fechaElaboracionMatrizLegal; 
        $row[$key][] = $value->origenMatrizLegal;    
        $row[$key][] = $value->name;  
    }


    $output['aaData'] = $row;
    echo json_encode($output);
?>  