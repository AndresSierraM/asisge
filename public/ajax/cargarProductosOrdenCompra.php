<?php 

$idMovimientoCRM = $_POST['idMovimientoCRM'];

$producto = DB::Select('
    SELECT
        MovimientoCRM_idMovimientoCRM, idFichaTecnica, referenciaFichaTecnica, nombreFichaTecnica, cantidadMovimientoCRMProducto, valorUnitarioMovimientoCRMProducto, cantidadMovimientoCRMProducto * valorUnitarioMovimientoCRMProducto as valorTotalMovimientoCRMProducto
    FROM
        movimientocrmproducto mcrmp
            LEFT JOIN 
        fichatecnica ft ON mcrmp.FichaTecnica_idFichaTecnica = ft.idFichaTecnica
    where
        MovimientoCRM_idMovimientoCRM = '.$idMovimientoCRM);

echo json_encode($producto)


?>