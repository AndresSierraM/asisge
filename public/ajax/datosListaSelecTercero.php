<?php

$campoTabla = $_GET['objeto'];
$valor = $_GET['valor'];

$sql=DB::Select('
    SELECT idTercero, nombreCompletoTercero, correoElectronicoTercero
    FROM tercero
    WHERE nombreCompletoTercero LIKE "%'.$valor.'%"');

    $row = array();

    foreach ($sql as $key => $value) 
    { 
        $row[$key][] = $value->nombreCompletoTercero; 
        $row[$key][] = $value->correoElectronicoTercero;
        $row[$key][] = $value->idTercero;
        $row[$key][] = $campoTabla;
    }

    $output['aaData'] = $row;
    echo json_encode($output);

?>