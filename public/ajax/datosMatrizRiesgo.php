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
        $visibleI = 'none';

    $matrizriesgo = DB::table('matrizriesgo')
            ->leftJoin('users', 'Users_id', '=', 'id')
            ->select(DB::raw('idMatrizRiesgo, nombreMatrizRiesgo, fechaElaboracionMatrizRiesgo, name'))
            ->where('matrizriesgo.Compania_idCompania','=', \Session::get('idCompania'))
            ->get();

    $row = array();

    foreach ($matrizriesgo as $key => $value) 
    {  
        $row[$key][] = '<a href="matrizriesgo/'.$value->idMatrizRiesgo.'/edit">'.
                            '<span class="glyphicon glyphicon-pencil" style = "display:'.$visibleM.'"></span>'.
                        '</a>&nbsp;'.
                        '<a href="matrizriesgo/'.$value->idMatrizRiesgo.'/edit?accion=eliminar">'.
                            '<span class="glyphicon glyphicon-trash" style = "display:'.$visibleE.'"></span>'.
                        '</a>&nbsp;'.
                        '<a href="#" onclick="imprimirFormato('.$value->idMatrizRiesgo.');">'.
                            '<span class="glyphicon glyphicon-print" style = "display:'.$visibleI.'"></span>'.
                        '</a>';
        $row[$key][] = $value->idMatrizRiesgo;
        $row[$key][] = $value->nombreMatrizRiesgo;
        $row[$key][] = $value->fechaElaboracionMatrizRiesgo; 
        $row[$key][] = $value->name;    
    }

    $output['aaData'] = $row;
    echo json_encode($output);
?>