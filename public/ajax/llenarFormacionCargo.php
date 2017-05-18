<?php 

$idCargo = $_POST['idCargo'];

$consulta = DB::Select('
	SELECT nombrePerfilCargo, idPerfilCargo, porcentajeCargoFormacion
	FROM cargoformacion cf
	LEFT JOIN perfilcargo pc
	ON cf.PerfilCargo_idPerfilCargo = pc.idPerfilCargo
	WHERE Cargo_idCargo = '.$idCargo.'
	AND idPerfilCargo IS NOT NULL'
	// SE AGREGA UN is not null , para validar si los id de perfil Cargo se estan utilizando  de no ser asi no muestre registros en Entrevista Pestaña Habilidades propias del cargo 
);



echo json_encode($consulta);
?>


