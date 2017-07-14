<?php 

$idOT = $_GET['idOrdenTrabajo'];

$detalle = DB::select(
            'SELECT numeroOrdenProduccion, nombreProceso, nombreCompletoTercero, referenciaFichaTecnica, 
                    nombreFichaTecnica, especificacionOrdenProduccion, numeroPedidoOrdenProduccion, cantidadOrdenTrabajo
            FROM ordentrabajo OT
            LEFT JOIN ordenproduccion OP
            ON OT.OrdenProduccion_idOrdenProduccion
            LEFT JOIN proceso P
            ON OT.Proceso_idProceso = P.idProceso
            LEFT JOIN fichatecnica FT
            On OP.FichaTecnica_idFichaTecnica = FT.idFichaTecnica
            LEFT JOIN tercero T
            ON OP.Tercero_idCliente = T.idTercero
            WHERE OT.idOrdenTrabajo = '.$idOT);

//print_r($consulta);

echo json_encode($detalle);
?>


