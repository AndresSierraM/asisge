<?php 

$idCoordinador = $_POST['idCoordinador'];
$firma = $_POST['firma'];

$ruta = 'accidente/firmaaccidente_'.$idCoordinador.'.png';
//----------------------------
// Guardamos la imagen de la firma como un archivo en disco
$data = $firma;

list($type, $data) = explode(';', $data);
list(, $data)      = explode(',', $data);
$data = base64_decode($data);

file_put_contents('imagenes/'.$ruta, $data);


$update = DB::update('Update accidente set firmaCoordinadorAccidente = "'.$ruta.'" where idAccidente = '.$idCoordinador);

echo json_encode('Firma actualizada correctamente');

?>