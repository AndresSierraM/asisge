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


    $departamento = DB::table('departamento')
            ->leftJoin('pais', 'Pais_idPais', '=', 'idPais')
            ->select(DB::raw('idDepartamento, codigoDepartamento, nombreDepartamento, nombrePais'))
            ->get();

    $row = array();

    foreach ($departamento as $key => $value) 
    {  
        $row[$key][] = '<a href="departamento/'.$value->idDepartamento.'/edit">'.
                            '<span class="glyphicon glyphicon-pencil" style = "display:'.$visibleM.'"></span>'.
                        '</a>&nbsp;'.
                        '<a href="departamento/'.$value->idDepartamento.'/edit?accion=eliminar">'.
                            '<span class="glyphicon glyphicon-trash" style = "display:'.$visibleE.'"></span>'.
                        '</a>';
        $row[$key][] = $value->idDepartamento;
        $row[$key][] = $value->codigoDepartamento;
        $row[$key][] = $value->nombreDepartamento; 
        $row[$key][] = $value->nombrePais;    
    }

    $output['aaData'] = $row;
    echo json_encode($output);
?>