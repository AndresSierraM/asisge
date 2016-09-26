<?php

$idElemento = $_GET['idElemento'];
    
    $consulta = DB::Select('SELECT nombreCompletoTercero, idEntregaElementoProteccion from entregaelementoproteccion ep left join tercero t on ep.Tercero_idTercero = t.idTercero where idEntregaElementoProteccion = '.$idElemento);

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


