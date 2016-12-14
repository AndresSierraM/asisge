<?php 

// Recibo el id del rol
$idPlanTrabajoAlertaModulo = $_POST['idPlanTrabajoAlertaModulo'];

// Consulto el nombre del rol 
$consulta = DB::Select('
	SELECT Modulo_idModulo
	FROM  PlanTrabajoAlerta
	WHERE idPlanTrabajoAlertaModulo = '.$idPlanTrabajoAlertaModulo);


echo json_encode($consulta);
?>


