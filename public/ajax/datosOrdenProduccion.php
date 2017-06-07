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

    
     $ordenproduccion = DB::table('ordenproduccion as OP')
        ->leftjoin('fichatecnica as F','OP.FichaTecnica_idFichaTecnica','=','F.idFichaTecnica')
        ->leftjoin('tercero as T','OP.Tercero_idCliente','=','T.idTercero')
        ->select(DB::raw('idOrdenProduccion, numeroOrdenProduccion, fechaElaboracionOrdenProduccion, nombreCompletoTercero, 
            numeroPedidoOrdenProduccion, referenciaFichaTecnica, especificacionOrdenProduccion, cantidadOrdenProduccion, estadoOrdenProduccion'))
        ->where('OP.Compania_idCompania','=', \Session::get('idCompania'))->get();

    $row = array();

    foreach ($ordenproduccion as $key => $value) 
    {  
        $row[$key][] = '<a href="ordenproduccion/'.$value->idOrdenProduccion.'/edit">'.
                            '<span class="glyphicon glyphicon-pencil" style = "display:'.$visibleM.'"></span>'.
                        '</a>&nbsp;'.
                        '<a href="ordenproduccion/'.$value->idOrdenProduccion.'/edit?accion=eliminar">'.
                            '<span class="glyphicon glyphicon-trash" style = "display:'.$visibleE.'"></span>'.
                        '</a>';
        $row[$key][] = $value->idOrdenProduccion;
        $row[$key][] = $value->numeroOrdenProduccion;
        $row[$key][] = $value->fechaElaboracionOrdenProduccion;   
        $row[$key][] = $value->nombreCompletoTercero;   
        $row[$key][] = $value->numeroPedidoOrdenProduccion;   
        $row[$key][] = $value->referenciaFichaTecnica;   
        $row[$key][] = $value->especificacionOrdenProduccion;   
        $row[$key][] = $value->cantidadOrdenProduccion;   
        $row[$key][] = $value->estadoOrdenProduccion;   
    }

    $output["aaData"] = $row;
    echo json_encode($output);
?>