<?php 

$idPlan = $_POST['idPlanCapacitacion'];

$consulta = DB::Select('		
	SELECT cc.idCentroCosto,cc.nombreCentroCosto
	FROM plancapacitacion pc
  	LEFT JOIN centrocosto cc
 	ON cc.idCentroCosto = pc.CentroCosto_idCentroCosto
  	WHERE idPlancapacitacion  = '.$idPlan);


echo json_encode($consulta);
?>


