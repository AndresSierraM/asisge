<?php
// Realizo una consulta trayendo el idTercero por post para poder mediante un ajax llenar el campo cargo
$idTercero = $_POST['idTercero'];

$elemento = DB::Select('
	SELECT 
		idElementoProteccion, nombreElementoProteccion 
	FROM 
		cargoelementoproteccion cep 
		left join elementoproteccion ep on ep.idElementoProteccion = cep.ElementoProteccion_idElementoProteccion 
		left join cargo c on c.idCargo = cep.Cargo_idCargo 
		left join tercero t on c.idCargo = t.Cargo_idCargo 
	WHERE 
		idTercero = '.$idTercero);
//Convierto un array en string
// $nombrecargo = get_object_vars($cargo[0]); 
echo json_encode($elemento);
?>