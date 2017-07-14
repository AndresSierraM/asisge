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

     $ejecuciontrabajo = DB::table('ejecuciontrabajo as ET')
        ->leftjoin('ordentrabajo as OT','ET.OrdenTrabajo_idOrdenTrabajo','=','OT.idOrdenTrabajo')
        ->leftjoin('ordenproduccion as OP','OT.OrdenProduccion_idOrdenProduccion','=','OP.idOrdenProduccion')
        ->leftjoin('fichatecnica as F','OP.FichaTecnica_idFichaTecnica','=','F.idFichaTecnica')
        ->leftjoin('tercero as T','OP.Tercero_idCliente','=','T.idTercero')
        ->leftjoin('proceso as P','OT.Proceso_idProceso','=','P.idProceso')
        ->select(DB::raw('idEjecucionTrabajo, numeroEjecucionTrabajo, fechaElaboracionEjecucionTrabajo, 
                        nombreCompletoTercero, numeroOrdenTrabajo, numeroOrdenProduccion, numeroPedidoOrdenProduccion, 
                        referenciaFichaTecnica, especificacionOrdenProduccion, cantidadEjecucionTrabajo, 
                        estadoEjecucionTrabajo, nombreProceso'))
        ->where('ET.Compania_idCompania','=', \Session::get('idCompania'))->get();

    $row = array();

    foreach ($ejecuciontrabajo as $key => $value) 
    {  
        $row[$key][] = '<a href="ejecuciontrabajo/'.$value->idEjecucionTrabajo.'/edit">'.
                            '<span class="glyphicon glyphicon-pencil" style = "display:'.$visibleM.'"></span>'.
                        '</a>&nbsp;'.
                        '<a href="ejecuciontrabajo/'.$value->idEjecucionTrabajo.'/edit?accion=eliminar">'.
                            '<span class="glyphicon glyphicon-trash" style = "display:'.$visibleE.'"></span>'.
                        '</a>';
                        
        $row[$key][] = $value->idEjecucionTrabajo;
        $row[$key][] = $value->numeroEjecucionTrabajo;
        $row[$key][] = $value->fechaElaboracionEjecucionTrabajo;   
        $row[$key][] = $value->nombreCompletoTercero; 
        $row[$key][] = $value->numeroOrdenProduccion ;
        $row[$key][] = $value->numeroOrdenTrabajo ;
        $row[$key][] = $value->nombreProceso ;
        $row[$key][] = $value->numeroPedidoOrdenProduccion;   
        $row[$key][] = $value->referenciaFichaTecnica;   
        $row[$key][] = $value->especificacionOrdenProduccion;   
        $row[$key][] = $value->cantidadEjecucionTrabajo;   
        $row[$key][] = $value->estadoEjecucionTrabajo;   

        
    }

    $output["aaData"] = $row;
    echo json_encode($output);
?>