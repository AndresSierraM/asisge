<?php 

$idOP = $_GET['idOrdenProduccion'];
$idPRO = $_GET['idProceso'];

$detalle = DB::select(
            'SELECT ordenFichaTecnicaOperacion, nombreFichaTecnicaOperacion, SUM(samFichaTecnicaOperacion) as samFichaTecnicaOperacion
            FROM ordenproduccion OP
            LEFT JOIN fichatecnicaoperacion FTO
            on OP.FichaTecnica_idFichaTecnica = FTO.FichaTecnica_idFichaTecnica             
            WHERE OP.idOrdenProduccion = '.$idOP.' and FTO.Proceso_idProceso = '.$idPRO);

//print_r($consulta);

echo json_encode($detalle);
?>


