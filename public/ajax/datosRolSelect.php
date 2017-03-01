<?php

    $consulta = DB::Select(
        'SELECT idRol, nombreRol 
        FROM rol
        where Compania_idCompania = '.(\Session::get("idCompania")));

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