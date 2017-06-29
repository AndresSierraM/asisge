<?php

    $modificar = $_GET['modificar'];
    $eliminar = $_GET['eliminar'];
    $imprimir = $_GET['imprimir'];

    $visibleM = '';
    $visibleE = '';
    $visibleI = '';
    if ($modificar == 1) 
        $visibleM = 'inline-block;';
    else
        $visibleM = 'none;';

    if ($eliminar == 1) 
        $visibleE = 'inline-block;';
    else
        $visibleE = 'none;';

    if ($imprimir == 1) 
        $visibleI = 'inline-block;';
    else
        $visibleI = 'none;';

    $recibocompra = DB::Select(
        'SELECT idReciboCompra, numeroReciboCompra, numeroOrdenCompra, fechaElaboracionReciboCompra, fechaEstimadaOrdenCompra, fechaRealReciboCompra, estadoReciboCompra, name
        FROM recibocompra rc
        LEFT JOIN ordencompra oc ON rc.OrdenCompra_idOrdenCompra = oc.idOrdenCompra
        LEFT JOIN users u ON rc.Users_idCrea = u.id');
    $row = array();

    foreach ($recibocompra as $key => $value) 
    {  
        $rc = get_object_vars($value);
        $row[$key][] = '<a href="recibocompra/'.$rc['idReciboCompra'].'/edit">'.
                            '<span class="glyphicon glyphicon-pencil" style="display: '.$visibleM.'"></span>'.
                        '</a>&nbsp;'.
                        '<a href="recibocompra/'.$rc['idReciboCompra'].'/edit?accion=eliminar">'.
                            '<span class="glyphicon glyphicon-trash" style="display: '.$visibleE.'"></span>'.
                        '</a>&nbsp;'.
                        '<a href="#" onclick="imprimirFormato('.$rc['idReciboCompra'].');">'.
                            '<span class="glyphicon glyphicon-print" style = "display:'.$visibleI.'"></span>'.
                        '</a>';
        $row[$key][] = $rc['idReciboCompra'];
        $row[$key][] = $rc['numeroReciboCompra'];
        $row[$key][] = $rc['numeroOrdenCompra'];
        $row[$key][] = $rc['fechaElaboracionReciboCompra'];    
        $row[$key][] = $rc['fechaEstimadaOrdenCompra'];    
        $row[$key][] = $rc['fechaRealReciboCompra'];    
        $row[$key][] = $rc['estadoReciboCompra'];    
        $row[$key][] = $rc['name'];    
    }

    $output['aaData'] = $row;
    echo json_encode($output);
?>