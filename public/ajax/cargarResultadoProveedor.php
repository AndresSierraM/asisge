<?php 

$idProveedor = $_POST['idProveedor'];
$fechaInicial = $_POST['fechaInicial'];
$fechaFinal = $_POST['fechaFinal'];

$AND = ($fechaInicial != '' ? 'AND fechaRealReciboCompra >= '.$fechaFinal.' AND fechaRealReciboCompra <= '.$fechaFinal : '');

$resultado = DB::Select(
    "SELECT 
        descripcionReciboCompraResultado,
        AVG(porcentajeReciboCompraResultado) AS porcentajeReciboCompraResultado,
        pesoReciboCompraResultado,
        AVG(porcentajeReciboCompraResultado) * pesoReciboCompraResultado / 100 AS resultadoReciboCompraResultado
    FROM
        recibocompraresultado rcr
            LEFT JOIN
        recibocompra rc ON rcr.ReciboCompra_idReciboCompra = rc.idReciboCompra
            LEFT JOIN
        ordencompra oc ON rc.OrdenCompra_idOrdenCompra = oc.idOrdenCompra
            LEFT JOIN
        tercero t ON oc.Tercero_idProveedor = t.idTercero
    WHERE idTercero = ".$idProveedor."
    $AND
    GROUP BY idReciboCompraResultado");


echo json_encode($resultado)


?>