<?php 

$idCargo = $_POST['idCargo'];

$consulta = DB::Select('
	SELECT idCargoResponsabilidad, descripcionCargoResponsabilidad, porcentajeResponsabilidadCargo
	FROM cargo c
	LEFT JOIN cargoresponsabilidad cr
	ON cr.Cargo_idCargo = c.idCargo
	WHERE Cargo_idCargo = '.$idCargo);



echo json_encode($consulta);
?>