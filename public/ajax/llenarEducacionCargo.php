<?php 

$idCargo = $_POST['idCargo'];

$consulta = DB::Select('
	SELECT nombrePerfilCargo, idPerfilCargo,porcentajeCargoEducacion
	FROM cargoeducacion ce
	LEFT JOIN perfilcargo pc
	ON ce.PerfilCargo_idPerfilCargo = pc.idPerfilCargo
	WHERE Cargo_idCargo = '.$idCargo);



echo json_encode($consulta);
?>