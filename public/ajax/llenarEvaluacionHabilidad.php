<?php 

$idCargo = $_POST['idCargo'];

$consulta = DB::Select('
	SELECT nombrePerfilCargo, pc.idPerfilCargo,porcentajeCargoHabilidad,porcentajeHabilidadCargo,pc.Compania_idCompania
	FROM cargo c
	LEFT JOIN  cargohabilidad ch
	ON c.idCargo = ch.Cargo_idCargo
	LEFT JOIN perfilcargo pc
	ON ch.PerfilCargo_idPerfilCargo = pc.idPerfilCargo
    WHERE idCargo = '.$idCargo);




echo json_encode($consulta);
?>


