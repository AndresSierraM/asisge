<?php 

$idCargo = $_POST['idCargo'];

$consulta = DB::Select('
	SELECT nombrePerfilCargo, idPerfilCargo
	FROM cargoformacion cf
	LEFT JOIN perfilcargo pc
	ON cf.PerfilCargo_idPerfilCargo = pc.idPerfilCargo
	WHERE Cargo_idCargo = '.$idCargo);



echo json_encode($consulta);
?>