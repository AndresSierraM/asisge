<?php
    $modificar = $_GET['modificar'];
    $eliminar = $_GET['eliminar'];

    $visibleM = '';
    $visibleE = '';
    if ($modificar == 1) 
        $visibleM = 'inline-block;';
    else
        $visibleM = 'none;';

    if ($eliminar == 1) 
        $visibleE = 'inline-block;';
    else
        $visibleE = 'none;';

    
     $ordenproduccion = DB::select(
         '  SELECT  OP.idOrdenProduccion,numeroOrdenProduccion, fechaElaboracionOrdenProduccion, OP.numeroPedidoOrdenProduccion,  
            nombreCompletoTercero as nombreCliente, referenciaFichaTecnica, especificacionOrdenProduccion, ordenOrdenProduccionProceso, P.nombreProceso, 
            TC.nombreTipoCalidad, OP.cantidadOrdenProduccion, OT.cantidadTrabajo, OT.cantidadEjecucion,
                    IFNULL(OT.cantidadTrabajo - OT.cantidadEjecucion,0) as cantidadDiferencia, estadoOrdenProduccion
            FROM ordenproduccion OP
            LEFT JOIN 
            (
                SELECT OT.OrdenProduccion_idOrdenProduccion,  OT.Proceso_idProceso, OTD.TipoCalidad_idTipoCalidad,
                        SUM(OTD.cantidadOrdenTrabajoDetalle) as cantidadTrabajo,
                        ET.cantidadEjecucion
                FROM ordentrabajo OT
                LEFT JOIN ordentrabajodetalle OTD
                ON OT.idOrdenTrabajo  = OTD.OrdenTrabajo_idOrdenTrabajo
                
                LEFT JOIN 
                (
                    SELECT OT.OrdenProduccion_idOrdenProduccion,  OT.Proceso_idProceso, ETD.TipoCalidad_idTipoCalidad, 
                        SUM(ETD.cantidadEjecucionTrabajoDetalle) as cantidadEjecucion
                    FROM ordentrabajo OT
                    LEFT JOIN ejecuciontrabajo ET
                    ON OT.idOrdenTrabajo = ET.OrdenTrabajo_idOrdenTrabajo
                    LEFT JOIN ejecuciontrabajodetalle ETD
                    ON ET.idEjecucionTrabajo = ETD.EjecucionTrabajo_idEjecucionTrabajo 
                    LEFT JOIN ordentrabajodetalle OTD
                    ON OT.idOrdenTrabajo  = OTD.OrdenTrabajo_idOrdenTrabajo and ETD.TipoCalidad_idTipoCalidad = OTD.TipoCalidad_idTipoCalidad 
                    WHERE OT.OrdenProduccion_idOrdenProduccion  = 3 
                    GROUP BY OT.OrdenProduccion_idOrdenProduccion, OT.Proceso_idProceso, ETD.TipoCalidad_idTipoCalidad
                ) ET
                ON OT.OrdenProduccion_idOrdenProduccion = ET.OrdenProduccion_idOrdenProduccion and OT.Proceso_idProceso = ET.Proceso_idProceso and OTD.TipoCalidad_idTipoCalidad = ET.TipoCalidad_idTipoCalidad
                WHERE ET.OrdenProduccion_idOrdenProduccion IS NOT NULL
                GROUP BY OT.OrdenProduccion_idOrdenProduccion, OT.Proceso_idProceso, OTD.TipoCalidad_idTipoCalidad
                
                UNION 
                
                SELECT ET.OrdenProduccion_idOrdenProduccion,  ET.Proceso_idProceso, ET.TipoCalidad_idTipoCalidad,
                        SUM(OTD.cantidadOrdenTrabajoDetalle) as cantidadTrabajo,
                        ET.cantidadEjecucion
                FROM ordentrabajo OT
                LEFT JOIN ordentrabajodetalle OTD
                ON OT.idOrdenTrabajo  = OTD.OrdenTrabajo_idOrdenTrabajo
                
                RIGHT JOIN 
                (
                    SELECT OT.OrdenProduccion_idOrdenProduccion,  OT.Proceso_idProceso, ETD.TipoCalidad_idTipoCalidad, 
                        SUM(ETD.cantidadEjecucionTrabajoDetalle) as cantidadEjecucion
                    FROM ejecuciontrabajo ET
                    LEFT JOIN ordentrabajo OT
                    ON  ET.OrdenTrabajo_idOrdenTrabajo = OT.idOrdenTrabajo
                    LEFT JOIN ejecuciontrabajodetalle ETD
                    ON ET.idEjecucionTrabajo = ETD.EjecucionTrabajo_idEjecucionTrabajo 
                    LEFT JOIN ordentrabajodetalle OTD
                    ON OT.idOrdenTrabajo  = OTD.OrdenTrabajo_idOrdenTrabajo and ETD.TipoCalidad_idTipoCalidad = OTD.TipoCalidad_idTipoCalidad 
                    WHERE OT.OrdenProduccion_idOrdenProduccion  = 3 
                    GROUP BY OT.OrdenProduccion_idOrdenProduccion, OT.Proceso_idProceso, ETD.TipoCalidad_idTipoCalidad
                ) ET
                ON OT.OrdenProduccion_idOrdenProduccion = ET.OrdenProduccion_idOrdenProduccion and OT.Proceso_idProceso = ET.Proceso_idProceso and OTD.TipoCalidad_idTipoCalidad = ET.TipoCalidad_idTipoCalidad
                WHERE OT.idOrdenTrabajo IS NULL
                GROUP BY OT.OrdenProduccion_idOrdenProduccion, OT.Proceso_idProceso, OTD.TipoCalidad_idTipoCalidad
            ) OT
            ON OP.idOrdenProduccion = OT.OrdenProduccion_idOrdenProduccion 
            LEFT JOIN tipocalidad TC
            ON OT.TipoCalidad_idTipoCalidad = TC.idTipoCalidad
            LEFT JOIN Proceso P
            ON OT.Proceso_idProceso = P.idProceso
            LEFT JOIN ordenproduccionproceso OPP
            ON OP.idOrdenProduccion = OPP.OrdenProduccion_idOrdenProduccion and OT.Proceso_idProceso = OPP.Proceso_idProceso
            LEFT JOIN Tercero C
            ON OP.Tercero_idCliente = C.idTercero
            LEFT JOIN fichatecnica FT
            ON OP.FichaTecnica_idFichaTecnica = FT.idFichaTecnica
            ORDER BY numeroOrdenProduccion, ordenOrdenProduccionProceso;');

    $row = array();

    foreach ($ordenproduccion as $key => $valor) 
    { 
        $value = get_object_vars($valor); 
        $row[$key][] = $value['idOrdenProduccion'];
        $row[$key][] = $value['numeroOrdenProduccion'];
        $row[$key][] = $value['fechaElaboracionOrdenProduccion'];   
        $row[$key][] = $value['nombreCliente'];   
        $row[$key][] = $value['numeroPedidoOrdenProduccion'];   
        $row[$key][] = $value['referenciaFichaTecnica'];   
        $row[$key][] = $value['especificacionOrdenProduccion'];   
        $row[$key][] = $value['ordenOrdenProduccionProceso'];   
        $row[$key][] = $value['nombreProceso'];   
        $row[$key][] = $value['nombreTipoCalidad'];   
        $row[$key][] = '<div style="text-align: right;">'.$value['cantidadOrdenProduccion'].'</div>';   
        $row[$key][] = '<div style="text-align: right;">'.$value['cantidadTrabajo'].'</div>'; 
        $row[$key][] = '<div style="text-align: right;">'.$value['cantidadEjecucion'].'</div>'; 
        $row[$key][] = '<div style="text-align: right;">'.$value['cantidadDiferencia'].'</div>'; 
        $row[$key][] = $value['estadoOrdenProduccion'];   

    }

    $output["aaData"] = $row;
    echo json_encode($output);
?>