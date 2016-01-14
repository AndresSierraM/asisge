<?php
// Realizo una consulta trayendo ElementoProteccion_idElementoProteccion por post para poder mediante un ajax llenar el campo descripcion
$idElementoProteccion = $_POST['ElementoProteccion_idElementoProteccion'];

$descripcion = DB::table('elementoproteccion')
->select(DB::raw('idElementoProteccion, descripcionElementoProteccion'))
->where ('idElementoProteccion', "=", $idElementoProteccion)
->get();
//Convierto un array en string
$descripcionElementoProteccion = get_object_vars($descripcion[0]);
echo json_encode($descripcionElementoProteccion['descripcionElementoProteccion']); //envio la descripcion mediante JSON
?>