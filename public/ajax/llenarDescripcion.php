<?php

$idElementoProteccion = $_POST['ElementoProteccion_idElementoProteccion'];

$elemento = DB::table('elementoproteccion')
->select(DB::raw('idElementoProteccion, descripcionElementoProteccion, nombreElementoProteccion'))
->where ('idElementoProteccion', "=", $idElementoProteccion)
->get();
//Convierto un array en string
$ElementoProteccion = get_object_vars($elemento[0]);
echo json_encode($ElementoProteccion); //envio la descripcion mediante JSON
?>