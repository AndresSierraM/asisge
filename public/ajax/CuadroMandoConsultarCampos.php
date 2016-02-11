<?php

$idModulo = $_POST['idModulo'];

$tabla = DB::table('modulo')
->select(DB::raw('tablaModulo'))
->where ('idModulo', "=", $idModulo)
->get();

//Convierto un array en string
$nombretabla = get_object_vars($tabla[0]);	

$camposBD = DB::table('information_schema.COLUMNS')
->select(DB::raw('TABLE_NAME, COLUMN_NAME, ORDINAL_POSITION, COLUMN_TYPE, COLUMN_COMMENT'))
->where('TABLE_NAME', "=", $nombretabla["tablaModulo"])
->where('TABLE_SCHEMA', "=", 'asisgedllo')
->get();

// devolvemos al ajax los registros de campos, con estos se creara una lista de seleccion
echo json_encode($camposBD);
?>