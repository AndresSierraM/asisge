<?php

    $consulta = DB::Select(
        'SELECT idCompania, nombreCompania 
        FROM compania');

    $row = array();

    foreach ($consulta as $key => $value) 
    {  
        //$datoscampo = get_object_vars($value);
        
        foreach ($value as $datoscampo => $campo) 
        {
            $row[$key][] = $campo;
        }                        
    }

    $output['aaData'] = $row;
    echo json_encode($output);
?>