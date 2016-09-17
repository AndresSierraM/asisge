<?php

$idActa = $_GET['idActa'];
    
    $consulta = DB::Select('SELECT nombreCompletoTercero, idActaCapacitacion, idActaCapacitacionAsistente from actacapacitacion ac left join actacapacitacionasistente aca on aca.ActaCapacitacion_idActaCapacitacion = ac.idActaCapacitacion left join tercero t on aca.Tercero_idAsistente = t.idTercero where idActaCapacitacion = '.$idActa);

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


