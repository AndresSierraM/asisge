<?php 

$idOP = $_GET['idOrdenProduccion'];

$detalle = DB::select(
            'SELECT referenciaFichaTecnica, nombreFichaTecnica, especificacionOrdenProduccion, nombreCompletoTercero,
                numeroPedidoOrdenProduccion, Proceso_idProceso, nombreProceso
            FROM ordenproduccion OP
            LEFT JOIN ordenproduccionproceso OPP
            ON OP.idOrdenProduccion = OPP.OrdenProduccion_idOrdenProduccion
            LEFT JOIN proceso P
            ON OPP.Proceso_idProceso = P.idProceso
            LEFT JOIN fichatecnica FT
            On OP.FichaTecnica_idFichaTecnica = FT.idFichaTecnica
            LEFT JOIN tercero T
            ON OP.Tercero_idCliente = T.idTercero
            WHERE OrdenProduccion_idOrdenProduccion = '.$idOP);

//print_r($consulta);

echo json_encode($detalle);
?>


