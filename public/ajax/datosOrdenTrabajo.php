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

    
     $ordentrabajo = DB::table('ordentrabajo as OT')
        ->leftjoin('ordenproduccion as OP','OT.OrdenProduccion_idOrdenProduccion','=','OP.idOrdenProduccion')
        ->leftjoin('fichatecnica as F','OP.FichaTecnica_idFichaTecnica','=','F.idFichaTecnica')
        ->leftjoin('tercero as T','OP.Tercero_idCliente','=','T.idTercero')
        ->select(DB::raw('idOrdenTrabajo, numeroOrdenTrabajo, fechaElaboracionOrdenTrabajo, nombreCompletoTercero, numeroOrdenProduccion, numeroPedidoOrdenProduccion, referenciaFichaTecnica, especificacionOrdenProduccion, cantidadOrdenTrabajo, estadoOrdenTrabajo'))
        ->where('OP.Compania_idCompania','=', \Session::get('idCompania'))->get();

    $row = array();

    foreach ($ordentrabajo as $key => $value) 
    {  
        $row[$key][] = '<a href="ordentrabajo/'.$value->idOrdenTrabajo.'/edit">'.
                            '<span class="glyphicon glyphicon-pencil" style = "display:'.$visibleM.'"></span>'.
                        '</a>&nbsp;'.
                        '<a href="ordentrabajo/'.$value->idOrdenTrabajo.'/edit?accion=eliminar">'.
                            '<span class="glyphicon glyphicon-trash" style = "display:'.$visibleE.'"></span>'.
                        '</a>';
                        
        $row[$key][] = $value->idOrdenTrabajo;
        $row[$key][] = $value->numeroOrdenTrabajo;
        $row[$key][] = $value->fechaElaboracionOrdenTrabajo;   
        $row[$key][] = $value->nombreCompletoTercero; 
        $row[$key][] = $value->numeroOrdenProduccion ;
        $row[$key][] = $value->numeroPedidoOrdenProduccion;   
        $row[$key][] = $value->referenciaFichaTecnica;   
        $row[$key][] = $value->especificacionOrdenProduccion;   
        $row[$key][] = $value->cantidadOrdenTrabajo;   
        $row[$key][] = $value->estadoOrdenTrabajo;   

        
    }

    $output["aaData"] = $row;
    echo json_encode($output);
?>