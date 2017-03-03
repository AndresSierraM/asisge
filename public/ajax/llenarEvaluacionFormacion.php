<?php 

$idCargo = $_POST['idCargo'];

$consulta = DB::Select('
	SELECT nombrePerfilCargo, idPerfilCargo,porcentajeCargoFormacion,porcentajeFormacionCargo,c.Compania_idCompania
	FROM cargo c
	LEFT JOIN  cargoformacion cf
	ON c.idCargo = cf.Cargo_idCargo
	LEFT JOIN perfilcargo pc
	ON cf.PerfilCargo_idPerfilCargo = pc.idPerfilCargo
	WHERE idCargo = '.$idCargo);

//print_r($consulta);

echo json_encode($consulta);
?>


