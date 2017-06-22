<?php 

$idTipoCalidad = $_POST['idTipoCalidad'];

$noconforme = DB::SELECT('SELECT noConformeTipoCalidad FROM tipocalidad WHERE idTipoCalidad = '.$idTipoCalidad);

echo json_encode($noconforme);

?>