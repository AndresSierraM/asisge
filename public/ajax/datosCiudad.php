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

    $ciudad = DB::table('ciudad')
            ->leftJoin('departamento', 'Departamento_idDepartamento', '=', 'idDepartamento')
            ->select(DB::raw('idCiudad, codigoCiudad, nombreCiudad, nombreDepartamento'))
            ->get();

    $row = array();

    foreach ($ciudad as $key => $value) 
    {  
        $row[$key][] = '<a href="ciudad/'.$value->idCiudad.'/edit">'.
                            '<span class="glyphicon glyphicon-pencil" style = "display:'.$visibleM.'"></span>'.
                        '</a>&nbsp;'.
                        '<a href="ciudad/'.$value->idCiudad.'/edit?accion=eliminar">'.
                            '<span class="glyphicon glyphicon-trash" style = "display:'.$visibleE.'"></span>'.
                        '</a>';
        $row[$key][] = $value->idCiudad;
        $row[$key][] = $value->codigoCiudad;
        $row[$key][] = $value->nombreCiudad; 
        $row[$key][] = $value->nombreDepartamento;    
    }

    $output['aaData'] = $row;
    echo json_encode($output);
?>