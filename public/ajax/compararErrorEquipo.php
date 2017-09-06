<?php 

$idEquipoSeguimientoDetalle = $_POST['idEquipoSeguimientoDetalle'];


// $consulta = DB::Select('	
// SELECT esv.EquipoSeguimientoDetalle_idEquipoSeguimientoDetalle,esv.errorEncontradoEquipoSeguimientoVerificacion,esd.errorPermitidoCalibracionEquipoSeguimientoDetalle
// FROM equiposeguimientoverificacion esv
// LEFT JOIN equiposeguimientodetalle esd
// ON esv.EquipoSeguimientoDetalle_idEquipoSeguimientoDetalle = esd.idEquipoSeguimientoDetalle
// where esv.EquipoSeguimientoDetalle_idEquipoSeguimientoDetalle ='.$idEquipoSeguimientoDetalle);
$consulta = DB::Select('
SELECT esd.errorPermitidoCalibracionEquipoSeguimientoDetalle
FROM equiposeguimientodetalle esd   
where esd.idEquipoSeguimientoDetalle = '.$idEquipoSeguimientoDetalle);


// 	$datosconsulta = null;
// 	$respuesta = '';
// // ya que solo devuelve un solo registro se devuelve en la posicion 0

// 	$datosconsulta = get_object_vars($consulta[0]);

// 	if($datosconsulta["errorEncontradoEquipoSeguimientoVerificacion"] == null or $datosconsulta["errorEncontradoEquipoSeguimientoVerificacion"] == '') 
// 	{
// 		$respuesta = 'Debe ingresar el Error Encontrado';
// 	}
// 	else if($datosconsulta["errorPermitidoCalibracionEquipoSeguimientoDetalle"] == null or $datosconsulta["errorPermitidoCalibracionEquipoSeguimientoDetalle"] == '') 
// 	{
// 		$respuesta = 'Debe ingresar el Error permitido en el Módulo Equipo De Seguimiento';
// 	}

// 	else if ($datosconsulta["errorEncontradoEquipoSeguimientoVerificacion"] > $datosconsulta["errorPermitidoCalibracionEquipoSeguimientoDetalle"]) 
// 	{
// 		$respuesta = "No Apto";
// 	}
// 	else
// 	{
// 		$respuesta = "Apto";
// 	}

echo json_encode($consulta);
?>


