<?php 

// Recibo el id del rol
$idRol = $_POST['idRol'];

// Consulto el nombre del rol 
$consulta = DB::Select('
	SELECT nombreRol
	FROM  rol
	WHERE idRol = '.$idRol);


echo json_encode($consulta);
?>


