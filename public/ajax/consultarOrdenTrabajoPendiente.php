<?php 

$idOP = $_GET['idOrdenProduccion'];
$idPRO = $_GET['idProceso'];

$detalle = DB::select(
            'SELECT TipoCalidad_idTipoCalidad, nombreTipoCalidad, 
                    cantidadOrdenProduccion - IFNULL(cantidadTrabajo - cantidadEjecucion,0) as cantidadPendiente
            FROM ordenproduccion OP
            LEFT JOIN 
            (
                SELECT OT.OrdenProduccion_idOrdenProduccion, OTD.TipoCalidad_idTipoCalidad,
                        TC.nombreTipoCalidad, 
                        SUM(OTD.cantidadOrdenTrabajoDetalle) as cantidadTrabajo,
                        ET.cantidadEjecucion
                FROM ordentrabajo OT
                LEFT JOIN ordentrabajodetalle OTD
                ON OT.idOrdenTrabajo  = OTD.OrdenTrabajo_idOrdenTrabajo
                LEFT JOIN tipocalidad TC
                ON OTD.TipoCalidad_idTipoCalidad = TC.idTipoCalidad
                LEFT JOIN 
                (
                    SELECT OT.OrdenProduccion_idOrdenProduccion, ETD.TipoCalidad_idTipoCalidad, 
                        SUM(ETD.cantidadEjecucionTrabajoDetalle) as cantidadEjecucion
                    FROM ordentrabajo OT
                    LEFT JOIN ordentrabajodetalle OTD
                    ON OT.idOrdenTrabajo  = OTD.OrdenTrabajo_idOrdenTrabajo
                    LEFT JOIN ejecuciontrabajo ET
                    ON OT.idOrdenTrabajo = ET.OrdenTrabajo_idOrdenTrabajo
                    LEFT JOIN ejecuciontrabajodetalle ETD
                    ON ET.idEjecucionTrabajo = ETD.EjecucionTrabajo_idEjecucionTrabajo and OTD.TipoCalidad_idTipoCalidad = ETD.TipoCalidad_idTipoCalidad
                    WHERE OT.OrdenProduccion_idOrdenProduccion  = '.$idOP.' and OT.Proceso_idProceso = '.$idPRO.' 
                    GROUP BY ETD.TipoCalidad_idTipoCalidad
                ) ET
                ON OTD.TipoCalidad_idTipoCalidad = ET.TipoCalidad_idTipoCalidad
                WHERE OT.OrdenProduccion_idOrdenProduccion  = '.$idOP.' and Proceso_idProceso = '.$idPRO.'
                GROUP BY OTD.TipoCalidad_idTipoCalidad
            ) OT
            ON OP.idOrdenProduccion = OT.OrdenProduccion_idOrdenProduccion
            WHERE idOrdenProduccion = '.$idOP);

//print_r($consulta);

echo json_encode($detalle);
?>


