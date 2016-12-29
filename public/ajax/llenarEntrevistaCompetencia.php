<?php 

$idCargo = $_POST['idCargo'];

$consulta = DB::Select('
	SELECT Cargo_idCargo, idCompetenciaPregunta, cc.Competencia_idCompetencia,preguntaCompetenciaPregunta
	FROM cargocompetencia cc
	LEFT JOIN competenciapregunta cp
	ON cc.Competencia_idCompetencia = cp.Competencia_idCompetencia
	WHERE Cargo_idCargo = '.$idCargo);



echo json_encode($consulta);
?>