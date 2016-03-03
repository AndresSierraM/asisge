<?php
// Realizo una consulta trayendo el idTercero por post para poder mediante un ajax llenar el campo cargo
$idPlanCapacitacionTema = $_POST['idPlanCapacitacionTema'];

$tema = DB::table('plancapacitaciontema')
->select(DB::raw('nombrePlanCapacitacionTema'))
->where ('idPlanCapacitacionTema', "=", $idPlanCapacitacionTema)
->get();

//Convierto un array en string
$nombretema = get_object_vars($tema[0]); 
echo json_encode($nombretema['nombrePlanCapacitacionTema']); //envio el nombre del tema mediante JSON
?>