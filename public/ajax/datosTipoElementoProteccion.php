<?php


    $tipoelementoproteccion = \App\TipoElementoProteccion::where('Compania_idCompania','=', \Session::get('idCompania'))
->get();
    $row = array();

    foreach ($tipoelementoproteccion as $key => $value) 
    {  
        $row[$key][] = '<a href="tipoelementoproteccion/'.$value['idTipoElementoProteccion'].'/edit">'.
                            '<span class="glyphicon glyphicon-pencil"></span>'.
                        '</a>&nbsp;'.
                        '<a href="tipoelementoproteccion/'.$value['idTipoElementoProteccion'].'/edit?accion=eliminar">'.
                            '<span class="glyphicon glyphicon-trash"></span>'.
                        '</a>';
        $row[$key][] = $value['idTipoElementoProteccion'];
        $row[$key][] = $value['codigoTipoElementoProteccion'];
        $row[$key][] = $value['nombreTipoElementoProteccion'];   
    }

    $output['aaData'] = $row;
    echo json_encode($output);
?>