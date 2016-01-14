<?php


    $rol = \App\Rol::All();
    $row = array();

    foreach ($rol as $key => $value) 
    {  
        $row[$key][] = '<a href="rol/'.$value['idRol'].'/edit">'.
                            '<span class="glyphicon glyphicon-pencil"></span>'.
                        '</a>&nbsp;'.
                        '<a href="rol/'.$value['idRol'].'/edit?accion=eliminar">'.
                            '<span class="glyphicon glyphicon-trash"></span>'.
                        '</a>';
        $row[$key][] = $value['idRol'];
        $row[$key][] = $value['codigoRol'];
        $row[$key][] = $value['nombreRol'];   
    }

    $output['aaData'] = $row;
    echo json_encode($output);
?>