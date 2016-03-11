<?php

    $matrizlegal = DB::table('matrizlegal')
            ->leftJoin('users', 'Users_id', '=', 'id')
            ->select(DB::raw('idMatrizLegal, nombreMatrizLegal, fechaElaboracionMatrizLegal, origenMatrizLegal, name'))
            ->where('matrizlegal.Compania_idCompania','=', \Session::get('idCompania'))
            ->get();

    $row = array();

    foreach ($matrizlegal as $key => $value) 
    {  
        $row[$key][] = '<a href="matrizlegal/'.$value->idMatrizLegal.'/edit">'.
                            '<span class="glyphicon glyphicon-pencil"></span>'.
                        '</a>&nbsp;'.
                        '<a href="matrizlegal/'.$value->idMatrizLegal.'/edit?accion=eliminar">'.
                            '<span class="glyphicon glyphicon-trash"></span>'.
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