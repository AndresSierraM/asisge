<?php

$idActa = $_GET['idActa'];
    
    $consulta = DB::Select('SELECT nombreCompletoTercero, idActaGrupoApoyo, idActaGrupoApoyoTercero from actagrupoapoyotercero agat left join tercero t on t.idTercero = agat.Tercero_idParticipante left join actagrupoapoyo aga on agat.ActaGrupoApoyo_idActaGrupoApoyo = aga.idActaGrupoApoyo where ActaGrupoApoyo_idActaGrupoApoyo = '.$idActa);

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