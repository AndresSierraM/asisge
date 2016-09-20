<?php

$idInspeccion = $_GET['idInspeccion'];
    
    $consulta = DB::Select('SELECT nombreCompletoTercero, idInspeccion from inspeccion i left join tercero t on i.Tercero_idRealizadaPor = t.idTercero where idInspeccion = '.$idInspeccion);

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


