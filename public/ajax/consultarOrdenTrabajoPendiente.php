<?php 

$idOP = $_GET['idOrdenProduccion'];
$idPRO = $_GET['idProceso'];
$idPrimProc = $idPRO;

//Consultamos el primer proceso de la OP
$PrimerProceso = DB::select(
            'SELECT Proceso_idProceso
            FROM   ordenproduccionproceso
            WHERE  OrdenProduccion_idOrdenProduccion = '.$idOP.'
            ORDER BY ordenOrdenProduccionProceso
            LIMIT 0,1');

// guardamos el primer proceso
if(count($PrimerProceso) > 0)
    $idPrimProc = get_object_vars($PrimerProceso[0])["Proceso_idProceso"];

// verificamos si es orden de trabajo al primer proceso o a los siguientes
if($idPRO == $idPrimProc)
{
    // cuando es al primer proceso, consultamos la cantidad de la orden de produccion menos lo remisionado al proceso
    $detalle = DB::select(
            'SELECT TipoCalidad_idTipoCalidad, nombreTipoCalidad, 
                    cantidadOrdenProduccion - IFNULL(cantidadTrabajo ,0) as cantidadPendiente
            FROM ordenproduccion OP
            LEFT JOIN 
            (
                SELECT OT.OrdenProduccion_idOrdenProduccion, OTD.TipoCalidad_idTipoCalidad,
                        TC.nombreTipoCalidad, 
                        SUM(OTD.cantidadOrdenTrabajoDetalle) as cantidadTrabajo
                FROM ordentrabajo OT
                LEFT JOIN ordentrabajodetalle OTD
                ON OT.idOrdenTrabajo  = OTD.OrdenTrabajo_idOrdenTrabajo
                LEFT JOIN tipocalidad TC
                ON OTD.TipoCalidad_idTipoCalidad = TC.idTipoCalidad
                WHERE OT.OrdenProduccion_idOrdenProduccion  = '.$idOP.' and Proceso_idProceso = '.$idPRO.'
                GROUP BY OTD.TipoCalidad_idTipoCalidad
            ) OT
            ON OP.idOrdenProduccion = OT.OrdenProduccion_idOrdenProduccion
            WHERE idOrdenProduccion = '.$idOP);
    }
    else
    {
        // cuando es a otros procesos, consultamos lo ejecutado en el proceso anterior menos lo enviado al siguiente

        $detalle = DB::select(
            'SELECT ETD.TipoCalidad_idTipoCalidad, nombreTipoCalidad,
                        SUM(ETD.cantidadEjecucionTrabajoDetalle - IFNULL(cantidadTrabajo,0)) as cantidadPendiente
                    FROM ordentrabajo OT
                    LEFT JOIN ejecuciontrabajo ET
                    ON OT.idOrdenTrabajo = ET.OrdenTrabajo_idOrdenTrabajo
                    LEFT JOIN ejecuciontrabajodetalle ETD
                    ON ET.idEjecucionTrabajo = ETD.EjecucionTrabajo_idEjecucionTrabajo 
                    LEFT JOIN tipocalidad TC
                    ON ETD.TipoCalidad_idTipoCalidad = TC.idTipoCalidad
                    LEFT JOIN 
                    (
                        SELECT OTD.TipoCalidad_idTipoCalidad,
                        SUM(OTD.cantidadOrdenTrabajoDetalle) as cantidadTrabajo
                        FROM ordentrabajo OT
                        LEFT JOIN ordentrabajodetalle OTD
                        ON OT.idOrdenTrabajo  = OTD.OrdenTrabajo_idOrdenTrabajo
                        WHERE OT.OrdenProduccion_idOrdenProduccion  = '.$idOP.' and Proceso_idProceso = '.$idPRO.'
                        GROUP BY OTD.TipoCalidad_idTipoCalidad
                    ) OTD 
                    ON ETD.TipoCalidad_idTipoCalidad = OTD.TipoCalidad_idTipoCalidad
                    WHERE OT.OrdenProduccion_idOrdenProduccion  = '.$idOP.' and 
                          OT.Proceso_idProceso = 
                          (SELECT Proceso_idProceso
                            FROM   ordenproduccionproceso
                            WHERE  OrdenProduccion_idOrdenProduccion = '.$idOP.' AND ordenOrdenProduccionProceso  = (SELECT (ordenOrdenProduccionProceso-1) as numero
                                                                                FROM   ordenproduccionproceso
                                                                                WHERE  OrdenProduccion_idOrdenProduccion = '.$idOP.' AND Proceso_idProceso = '.$idPRO.'))
                    GROUP BY ETD.TipoCalidad_idTipoCalidad ');
    }


//print_r($consulta);

echo json_encode($detalle);
?>


