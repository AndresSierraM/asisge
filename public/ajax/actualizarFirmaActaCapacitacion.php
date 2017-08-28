<?php 

$idActa = $_POST['idActa'];
$idAsistente = $_POST['idAsistente'];
$firma = $_POST['firma'];

$ruta = 'actacapacitacion/firmaactacapacitacion_'.$idActa.'_'.$idAsistente.'.png';
//----------------------------
// Guardamos la imagen de la firma como un archivo en disco
$data = $firma;

list($type, $data) = explode(';', $data);
list(, $data)      = explode(',', $data);
$data = base64_decode($data);

file_put_contents('imagenes/'.$ruta, $data);


$update = DB::update('Update actacapacitacionasistente set firmaActaCapacitacionAsistente = "'.$ruta.'" where idActaCapacitacionAsistente = '.$idAsistente);

echo json_encode('Firma actualizada correctamente');

?>