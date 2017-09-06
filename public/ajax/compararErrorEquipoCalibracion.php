<?php 

$idEquipoSeguimientoDetalle = $_POST['idEquipoSeguimientoDetalle'];


$consulta = DB::Select('
SELECT esd.errorPermitidoCalibracionEquipoSeguimientoDetalle
FROM equiposeguimientodetalle esd   
where esd.idEquipoSeguimientoDetalle = '.$idEquipoSeguimientoDetalle);

echo json_encode($consulta);
?>


