<?php 

$idDocumentoCRM = $_GET['idDocumentoCRM'];

$movimiento = DB::Select('
    Select 
    idMovimientoCRM, asuntoMovimientoCRM
from
    movimientocrm
where
    DocumentoCRM_idDocumentoCRM = '.$idDocumentoCRM);

$row = array();

    foreach ($movimiento as $key => $value) 
    {  
    	$mov = get_object_vars($value);
        $row[$key][] = $mov['idMovimientoCRM'];
        $row[$key][] = $mov['asuntoMovimientoCRM']; 
    }

    $output["aaData"] = $row;
    echo json_encode($output);

?>