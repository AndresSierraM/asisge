<?php 

$idMovimientoCRM = (isset($_POST['idMovimientoCRM']) ?  $_POST['idMovimientoCRM'] : '');

if ($idMovimientoCRM != '') 
{
	$producto = DB::Select('
    SELECT
        MovimientoCRM_idMovimientoCRM, idFichaTecnica, referenciaFichaTecnica, nombreFichaTecnica, cantidadMovimientoCRMProducto, valorUnitarioMovimientoCRMProducto, cantidadMovimientoCRMProducto * valorUnitarioMovimientoCRMProducto as valorTotalMovimientoCRMProducto
    FROM
        movimientocrmproducto mcrmp
            LEFT JOIN 
        fichatecnica ft ON mcrmp.FichaTecnica_idFichaTecnica = ft.idFichaTecnica
    where
        MovimientoCRM_idMovimientoCRM = '.$idMovimientoCRM);
}
else
{
	$producto = DB::Select('
	SELECT
		idFichaTecnica, referenciaFichaTecnica, nombreFichaTecnica, cantidadOrdenCompraProducto, valorUnitarioOrdenCompraProducto
	FROM
		ordencompraproducto ocp
			LEFT JOIN
		fichatecnica ft ON ocp.FichaTecnica_idFichaTecnica = ft.idFichaTecnica
	WHERE
		OrdenCompra_idOrdenCompra = '.$_POST['idOrdenCompra']);
}


echo json_encode($producto)


?>