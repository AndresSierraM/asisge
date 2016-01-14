<?php


    $cargo = \App\Cargo::All();
    $row = array();

    foreach ($cargo as $key => $value) 
    {  
        $row[$key][] = '<a href="cargo/'.$value['idCargo'].'/edit">'.
                            '<span class="glyphicon glyphicon-pencil"></span>'.
                        '</a>&nbsp;'.
                        '<a href="cargo/'.$value['idCargo'].'/edit?accion=eliminar">'.
                            '<span class="glyphicon glyphicon-trash"></span>'.
                        '</a>';
        $row[$key][] = $value['idCargo'];
        $row[$key][] = $value['codigoCargo'];
        $row[$key][] = $value['nombreCargo'];   
        $row[$key][] = $value['salarioBaseCargo'];
    }

    $output['aaData'] = $row;
    echo json_encode($output);
?>