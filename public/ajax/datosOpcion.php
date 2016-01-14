<?php


    $opcion = DB::table('opcion')
            ->leftJoin('paquete', 'Paquete_idPaquete', '=', 'idPaquete')
            ->select(DB::raw('idOpcion, ordenOpcion, nombreOpcion, rutaOpcion, nombrePaquete'))
            ->get();

 //   print_r($opcion);
 // exit;
    $row = array();

    foreach ($opcion as $key => $value) 
    {  
        $row[$key][] = '<a href="opcion/'.$value->idOpcion.'/edit">'.
                            '<span class="glyphicon glyphicon-pencil"></span>'.
                        '</a>&nbsp;'.
                        '<a href="opcion/'.$value->idOpcion.'/edit?accion=eliminar">'.
                            '<span class="glyphicon glyphicon-trash"></span>'.
                        '</a>';
        $row[$key][] = $value->idOpcion;
        $row[$key][] = $value->ordenOpcion;
        $row[$key][] = $value->nombreOpcion; 
        $row[$key][] = $value->rutaOpcion;    
        $row[$key][] = $value->nombrePaquete;
    }
    //  print_r($row);
    // exit;
    $output['aaData'] = $row;
    echo json_encode($output);
?>