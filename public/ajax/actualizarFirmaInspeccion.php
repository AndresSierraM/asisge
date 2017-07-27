<?php 

$idRealizador = $_POST['idRealizador'];
$firma = $_POST['firma'];

$ruta = 'inspeccion/firmainspeccion_'.$idRealizador.'.png';
//----------------------------
// Guardamos la imagen de la firma como un archivo en disco
$data = $firma;

list($type, $data) = explode(';', $data);
list(, $data)      = explode(',', $data);
$data = base64_decode($data);

file_put_contents('imagenes/'.$ruta, $data);


$update = DB::update('Update inspeccion set firmaRealizadaPorInspeccion = "'.$ruta.'" where idInspeccion = '.$idRealizador);

echo json_encode('Firma actualizada correctamente');

?>