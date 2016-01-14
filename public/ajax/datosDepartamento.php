<?php

    $departamento = DB::table('departamento')
            ->leftJoin('pais', 'Pais_idPais', '=', 'idPais')
            ->select(DB::raw('idDepartamento, codigoDepartamento, nombreDepartamento, nombrePais'))
            ->get();

    $row = array();

    foreach ($departamento as $key => $value) 
    {  
        $row[$key][] = '<a href="departamento/'.$value->idDepartamento.'/edit">'.
                            '<span class="glyphicon glyphicon-pencil"></span>'.
                        '</a>&nbsp;'.
                        '<a href="departamento/'.$value->idDepartamento.'/edit?accion=eliminar">'.
                            '<span class="glyphicon glyphicon-trash"></span>'.
                        '</a>';
        $row[$key][] = $value->idDepartamento;
        $row[$key][] = $value->codigoDepartamento;
        $row[$key][] = $value->nombreDepartamento; 
        $row[$key][] = $value->nombrePais;    
    }

    $output['aaData'] = $row;
    echo json_encode($output);
?>