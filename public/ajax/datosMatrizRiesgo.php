<?php

    $matrizriesgo = DB::table('matrizriesgo')
            ->leftJoin('users', 'Users_id', '=', 'id')
            ->select(DB::raw('idMatrizRiesgo, nombreMatrizRiesgo, fechaElaboracionMatrizRiesgo, name'))
            ->get();

    $row = array();

    foreach ($matrizriesgo as $key => $value) 
    {  
        $row[$key][] = '<a href="matrizriesgo/'.$value->idMatrizRiesgo.'/edit">'.
                            '<span class="glyphicon glyphicon-pencil"></span>'.
                        '</a>&nbsp;'.
                        '<a href="matrizriesgo/'.$value->idMatrizRiesgo.'/edit?accion=eliminar">'.
                            '<span class="glyphicon glyphicon-trash"></span>'.
                        '</a>&nbsp;'.
                        '<a href="#" onclick="imprimirFormato('.$value->idMatrizRiesgo.');">'.
                            '<span class="glyphicon glyphicon-print"></span>'.
                        '</a>';
        $row[$key][] = $value->idMatrizRiesgo;
        $row[$key][] = $value->nombreMatrizRiesgo;
        $row[$key][] = $value->fechaElaboracionMatrizRiesgo; 
        $row[$key][] = $value->name;    
    }

    $output['aaData'] = $row;
    echo json_encode($output);
?>