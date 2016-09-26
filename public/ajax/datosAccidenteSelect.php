<?php

$idAccidente = $_GET['idAccidente'];
    
    $consulta = DB::Select('SELECT nombreCompletoTercero, idAccidente from accidente a left join tercero t on a.Tercero_idEmpleado = t.idTercero where idAccidente = '.$idAccidente);

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


