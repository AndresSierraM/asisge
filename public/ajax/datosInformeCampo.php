<?php

//se consulta todos los datos de la tabla incluyendo el where para que traiga solo los de la compania que se encuentra en la sesion
$bd = isset($_GET["basedatos"]) ? $_GET["basedatos"] : '';
$tabla = isset($_GET["tabla"]) ? $_GET["tabla"] : '';

$data = DB::select(
          'SELECT  COLUMN_NAME, COLUMN_COMMENT, DATA_TYPE, CHARACTER_MAXIMUM_LENGTH 
          FROM information_schema.COLUMNS
          WHERE TABLE_NAME = "'.$tabla.'" and TABLE_SCHEMA = 
                (SELECT bdSistemaInformacion FROM sistemainformacion Where idSistemaInformacion = '.$bd.')');

$row = array();

foreach ($data as $key => $value)
{
  
  $row[$key][] = $value->COLUMN_COMMENT;
  $row[$key][] = $value->COLUMN_NAME;
  $row[$key][] = $value->DATA_TYPE;
  $row[$key][] = $value->CHARACTER_MAXIMUM_LENGTH;
}

$output['aaData'] = $row;
echo json_encode($output);
?>
