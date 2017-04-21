<?php

    $consulta = DB::Select(
        'SELECT idProceso, codigoProceso, nombreProceso 
        FROM proceso
        WHERE Compania_idCompania = '.\Session::get('idCompania'));

    $row = array();

    foreach ($consulta as $key => $value) 
    {  
        foreach ($value as $datoscampo => $campo) 
        {
            $row[$key][] = $campo;
        }                        
    }

    $output['aaData'] = $row;
    echo json_encode($output);
?>