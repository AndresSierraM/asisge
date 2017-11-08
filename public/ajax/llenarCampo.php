<?php
// Realizo una consulta trayendo el idCampoCRM por post para poder mediante un ajax llenar el campo 
$idCampoCRM = $_POST['idCampoCRM'];

$campo = DB::table('campocrm')
->select(DB::raw('descripcionCampoCRM, gridCampoCRM, obligatorioCampoCRM'))
->where ('idCampoCRM', "=", $idCampoCRM)
->get();

$campos = array();
//Convierto un array en string
for($i = 0; $i < count($campo); $i++)
{
    $campos[] = get_object_vars($campo[0]);
} 
echo json_encode($campo); //envio el nombre del campo mediante JSON
?>