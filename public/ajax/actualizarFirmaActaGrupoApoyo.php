<?php 

$idActa = $_POST['idActa'];
$idParticipante = $_POST['idParticipante'];
$firma = $_POST['firma'];

$ruta = 'actagrupoapoyo/firmaactagrupoapoyo_'.$idActa.'_'.$idParticipante.'.png';
//----------------------------
// Guardamos la imagen de la firma como un archivo en disco
$data = $firma;

list($type, $data) = explode(';', $data);
list(, $data)      = explode(',', $data);
$data = base64_decode($data);

file_put_contents('imagenes/'.$ruta, $data);


$update = DB::update('Update actagrupoapoyotercero set firmaActaGrupoApoyoTercero = "'.$ruta.'" where idActaGrupoApoyoTercero = '.$idParticipante);

echo json_encode('Firma actualizada correctamente');

?>