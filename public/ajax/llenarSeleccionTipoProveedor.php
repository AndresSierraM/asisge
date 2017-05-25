<?php

$idTipoProveedor = $_POST['idTipoProveedor'];

$seleccion = DB::Select('
	SELECT 
		idTipoProveedorSeleccion,
		descripcionTipoProveedorSeleccion
	FROM
		tipoproveedorseleccion
	WHERE TipoProveedor_idTipoProveedor = '.$idTipoProveedor);

echo json_encode($seleccion);
?>