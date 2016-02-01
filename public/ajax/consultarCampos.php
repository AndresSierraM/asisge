<?php

// $idModulo = $_POST['Modulo_idModulo'];

$tabla = DB::table('modulo')
->select(DB::raw('tablaModulo'))
->where ('idModulo', "=", 1)
->get();


//Convierto un array en string
$nombretabla = get_object_vars($tabla[0]);	

$calculoFormula = DB::table('information_schema.COLUMNS')
->select(DB::raw('TABLE_NAME, COLUMN_NAME, ORDINAL_POSITION, COLUMN_TYPE, COLUMN_COMMENT'))
->where('TABLE_NAME', "=", $nombretabla["tablaModulo"])
->where('TABLE_SCHEMA', "=", 'asisgedllo')
->get();

$campostabla = array();
foreach ($calculoFormula as $pos => $valor) {
	$campostabla[] = get_object_vars($valor); 
}
// devolvemos al ajax los registros de campos, con estos se creara una lista de seleccion
echo json_encode($campostabla);
?>