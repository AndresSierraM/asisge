<?php 

$idCargo = $_POST['idCargo'];

$consulta = DB::Select('
	SELECT nombrePerfilCargo, idPerfilCargo,porcentajeCargoEducacion,porcentajeEducacionCargo,c.Compania_idCompania
	FROM cargo c
	LEFT JOIN  cargoeducacion ce
	ON c.idCargo = ce.Cargo_idCargo
	LEFT JOIN perfilcargo pc
	ON ce.PerfilCargo_idPerfilCargo = pc.idPerfilCargo
	WHERE idCargo = '.$idCargo);


echo json_encode($consulta);
?>


