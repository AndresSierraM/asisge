<?php 

$idGrupoApoyo = $_POST['idGrupoApoyo'];
$idJurado = $_POST['idJurado'];
$firma = $_POST['firma'];

$ruta = 'conformaciongrupoapoyo/firmaconformaciongrupoapoyo'.$idGrupoApoyo.'_'.$idJurado.'.png';
//----------------------------
// Guardamos la imagen de la firma como un archivo en disco
$data = $firma;

list($type, $data) = explode(';', $data);
list(, $data)      = explode(',', $data);
$data = base64_decode($data);

file_put_contents('imagenes/'.$ruta, $data);


$update = DB::update('Update conformaciongrupoapoyojurado set firmaActaConformacionGrupoApoyoTercero = "'.$ruta.'" where idConformacionGrupoApoyoJurado = '.$idJurado);

echo json_encode('Firma actualizada correctamente');

?>