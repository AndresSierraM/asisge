<?php


    $paquete = \App\Paquete::All();
    // print_r($paquete);
    // exit;
    $row = array();

    foreach ($paquete as $key => $value) 
    {  
        $row[$key][] = '<a href="paquete/'.$value['idPaquete'].'/edit">'.
                            '<span class="glyphicon glyphicon-pencil"></span>'.
                        '</a>&nbsp;'.
                        '<a href="paquete/'.$value['idPaquete'].'/edit?accion=eliminar">'.
                            '<span class="glyphicon glyphicon-trash"></span>'.
                        '</a>';
        $row[$key][] = $value['idPaquete'];
        $row[$key][] = $value['ordenPaquete'];
        $row[$key][] = $value['nombrePaquete'];   
        $row[$key][] = '<img src="'.$value['iconoPaquete'].'">';
    }

    $output['aaData'] = $row;
    echo json_encode($output);
?>