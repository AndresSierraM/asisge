<?php

$idGrupo = $_GET['idGrupo'];
    
    $consulta = DB::Select('SELECT nombreCompletoTercero, idConformacionGrupoApoyo, idConformacionGrupoApoyoJurado from conformaciongrupoapoyojurado cgaj left join tercero t on t.idTercero = cgaj.Tercero_idJurado left join conformaciongrupoapoyo cga on cgaj.ConformacionGrupoApoyo_idConformacionGrupoApoyo = cga.idConformacionGrupoApoyo where ConformacionGrupoApoyo_idConformacionGrupoApoyo = '.$idGrupo);

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