<?php

    $tipo = $_GET['tipo'];

    $consulta = DB::Select(
        'SELECT idCampoCRM, descripcionCampoCRM ,  gridCampoCRM, obligatorioCampoCRM
        FROM campocrm
        WHERE formularioCampoCRM = "'.$tipo.'"');

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