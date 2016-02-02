<?php

$idCompaniaObjetivo = $_POST['CompaniaObjetivo_idCompaniaObjetivo'];

$objetivo = DB::table('companiaobjetivo')
->select(DB::raw('idCompaniaObjetivo, nombreCompaniaObjetivo'))
->where ('idCompaniaObjetivo', "=", $idCompaniaObjetivo)
->get();

//Convierto un array en string
$nombreobjetivo = get_object_vars($objetivo[0]); 
echo json_encode($nombreobjetivo['nombreCompaniaObjetivo']);
?>