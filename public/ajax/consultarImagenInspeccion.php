<?php 

$idInspeccionDetalle = $_POST['idInspeccionDetalle'];

 $imageInsp = DB::Select('SELECT fotoInspeccionDetalle from inspecciondetalle where idInspeccionDetalle = '.$idInspeccionDetalle);

 $img = get_object_vars($imageInsp[0]);

 echo json_encode($img);
?>