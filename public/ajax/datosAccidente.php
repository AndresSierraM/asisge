<?php


    $accidente = \App\accidente::where('Compania_idCompania','=', \Session::get('idCompania'))->get();
    $row = array();

    foreach ($accidente as $key => $value) 
    {  
        $row[$key][] = '<a href="accidente/'.$value['idAccidente'].'/edit">'.
                            '<span class="glyphicon glyphicon-pencil"></span>'.
                        '</a>&nbsp;'.
                        '<a href="accidente/'.$value['idAccidente'].'/edit?accion=eliminar">'.
                            '<span class="glyphicon glyphicon-trash"></span>'.
                        '</a>';
        $row[$key][] = $value['idAccidente'];
        $row[$key][] = $value['numeroAccidente'];
        $row[$key][] = $value['descripcionAccidente'];   
        $row[$key][] = $value['fechaOcurrenciaAccidente'];
        $row[$key][] = $value['clasificacionAccidente'];
    }

    $output['aaData'] = $row;
    echo json_encode($output);
?>