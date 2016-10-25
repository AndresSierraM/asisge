<?php
// Realizo una consulta trayendo el idTercero por post
$idTercero = $_POST['idTercero'];

$fecha = DB::Select('SELECT fechaNacimientoTerceroInformacion, fechaIngresoTerceroInformacion from terceroinformacion where Tercero_idTercero = '.$idTercero);

//Convierto un array en string
$fechas = get_object_vars($fecha[0]); 
echo json_encode($fechas); //envio las fechas mediante JSON
?>