<?php 

$idDocumentoCRM = $_GET['idDocumentoCRM'];
$modificar = $_GET['modificar'];
$eliminar = $_GET['eliminar'];
$consultar = $_GET['consultar'];
$aprobar = $_GET['aprobar'];
$estado = $_GET['estado'];

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

    if ($consultar == 1) 
        $visibleC = 'inline-block;';
    else
        $visibleC = 'none;';

    if ($aprobar == 1) 
        $visibleA = 'inline-block;';
    else
        $visibleA = 'none;';

$ordencompra = DB::Select('
    SELECT 
        idOrdenCompra,
        numeroOrdenCompra,
        requerimientoOrdenCompra,
        sitioEntregaOrdenCompra,
        fechaElaboracionOrdenCompra,
        fechaVencimientoOrdenCompra,
        tp.nombreCompletoTercero as nombreProveedor,
        ts.nombreCompletoTercero as nombreSolicitante, 
        ta.nombreCompletoTercero as nombreAutorizador,
        estadoOrdenCompra
    FROM
        ordencompra oc
            left join
        tercero tp ON oc.Tercero_idProveedor = tp.idTercero
            left join
        tercero ts ON oc.Tercero_idSolicitante = ts.idTercero
            left join
        tercero ta ON oc.Tercero_idAutorizador = ta.idTercero
    WHERE
        DocumentoCRM_idDocumentoCRM = '.$idDocumentoCRM.'
            AND oc.Compania_idCompania = '.\Session::get('idCompania').'
            AND estadoOrdenCompra = "'.$estado.'"');

$row = array();

    foreach ($ordencompra as $key => $value) 
    {  
    	$oc = get_object_vars($value);
        $row[$key][] = '<a href="ordencompra/'.$oc['idOrdenCompra'].'/edit?idDocumentoCRM='.$idDocumentoCRM.'">'.
                            '<span class="glyphicon glyphicon-pencil" style="display:'.$visibleM.'"></span>'.
                        '</a>&nbsp;'.
                        '<a href="ordencompra/'.$oc['idOrdenCompra'].'/edit?accion=eliminar&idDocumentoCRM='.$idDocumentoCRM.'">'.
                            '<span class="glyphicon glyphicon-trash" style="display:'.$visibleE.'"></span>'.
                        '</a>&nbsp;'.
                        '<a href="javascript:mostrarModalAutorizador('.$oc["idOrdenCompra"].');">'.
                            '<span class="glyphicon glyphicon-check" style = "display:'.$visibleA.'" ></span>'.
                        '</a>&nbsp;'.
                        '<a href="#" onclick="imprimirFormato('.$oc["idOrdenCompra"].','.$idDocumentoCRM.');">'.
                            '<span class="glyphicon glyphicon-print" style = "display:'.$visibleC.'" ></span>'.
                        '</a>';

        $row[$key][] = $oc['idOrdenCompra'];
        $row[$key][] = $oc['numeroOrdenCompra']; 
        $row[$key][] = $oc['requerimientoOrdenCompra']; 
        $row[$key][] = $oc['sitioEntregaOrdenCompra']; 
        $row[$key][] = $oc['fechaElaboracionOrdenCompra']; 
        $row[$key][] = $oc['fechaVencimientoOrdenCompra']; 
        $row[$key][] = $oc['nombreProveedor']; 
        $row[$key][] = $oc['nombreSolicitante']; 
        $row[$key][] = $oc['nombreAutorizador']; 
        $row[$key][] = $oc['estadoOrdenCompra']; 
    }

    $output["aaData"] = $row;
    echo json_encode($output);

?>