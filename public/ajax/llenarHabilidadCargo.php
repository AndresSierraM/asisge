<?php 

$idCargo = $_POST['idCargo'];

$consulta = DB::Select('
	SELECT nombrePerfilCargo, idPerfilCargo,porcentajeCargoHabilidad
	FROM cargo c
	LEFT JOIN  cargohabilidad ch
	ON c.idCargo = ch.Cargo_idCargo
	LEFT JOIN perfilcargo pc
	ON ch.PerfilCargo_idPerfilCargo = pc.idPerfilCargo
	WHERE idCargo = '.$idCargo.'
	AND idPerfilCargo IS NOT NULL');
// SE AGREGA UN is not null , para validar si los id de perfil Cargo se estan utilizando  de no ser asi no muestre registros en Entrevista Pestaña Habilidades propias del cargo 
//print_r($consulta);

echo json_encode($consulta);
?>


