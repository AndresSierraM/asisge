<?php 

$idEmpleado = $_POST['idEmpleado'];
$firma = $_POST['firma'];

$ruta = 'entregaepp/firmaentregaepp_'.$idEmpleado.'.png';
//----------------------------
// Guardamos la imagen de la firma como un archivo en disco
$data = $firma;

list($type, $data) = explode(';', $data);
list(, $data)      = explode(',', $data);
$data = base64_decode($data);

file_put_contents('imagenes/'.$ruta, $data);


$update = DB::update('Update entregaelementoproteccion set firmaTerceroEntregaElementoProteccion = "'.$ruta.'" where idEntregaElementoProteccion = '.$idEmpleado);

echo json_encode('Firma actualizada correctamente');

?>