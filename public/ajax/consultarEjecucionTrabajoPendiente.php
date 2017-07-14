<?php 

$idOT = $_GET['idOrdenTrabajo'];

$detalle = DB::select(
            'SELECT OTD.TipoCalidad_idTipoCalidad,
                    SUM(cantidadOrdenTrabajoDetalle - IFNULL(cantidadEjecucion,0)) as cantidadPendiente
            FROM ordentrabajo OT
            LEFT JOIN ordentrabajodetalle OTD
            ON OT.idOrdenTrabajo  = OTD.OrdenTrabajo_idOrdenTrabajo
            LEFT JOIN 
            (
                SELECT OT.idOrdenTrabajo, ETD.TipoCalidad_idTipoCalidad, 
                    SUM(ETD.cantidadEjecucionTrabajoDetalle) as cantidadEjecucion
                FROM ordentrabajo OT
                LEFT JOIN ordentrabajodetalle OTD
                ON OT.idOrdenTrabajo  = OTD.OrdenTrabajo_idOrdenTrabajo
                LEFT JOIN ejecuciontrabajo ET
                ON OT.idOrdenTrabajo = ET.OrdenTrabajo_idOrdenTrabajo
                LEFT JOIN ejecuciontrabajodetalle ETD
                ON ET.idEjecucionTrabajo = ETD.EjecucionTrabajo_idEjecucionTrabajo and OTD.TipoCalidad_idTipoCalidad = ETD.TipoCalidad_idTipoCalidad
                WHERE OT.idOrdenTrabajo  = '.$idOT.'  
                GROUP BY ETD.TipoCalidad_idTipoCalidad
            ) ET
            ON OT.idOrdenTrabajo = ET.idOrdenTrabajo and OTD.TipoCalidad_idTipoCalidad = ET.TipoCalidad_idTipoCalidad
            WHERE OT.idOrdenTrabajo = '.$idOT.'
            GROUP BY OTD.TipoCalidad_idTipoCalidad
            HAVING cantidadPendiente > 0');

//print_r($consulta);

echo json_encode($detalle);
?>


