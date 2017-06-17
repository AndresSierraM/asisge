<?php 

$oc = DB::Select('
    Select 
        idOrdenCompra, numeroOrdenCompra, fechaEstimadaOrdenCompra, nombreCompletoTercero, idTercero
    from
        ordencompra oc
    left join tercero t on oc.Tercero_idProveedor = t.idTercero');

$row = array();

    foreach ($oc as $key => $value) 
    {  
    	$mov = get_object_vars($value);
        $row[$key][] = $mov['idOrdenCompra'];
        $row[$key][] = $mov['numeroOrdenCompra']; 
        $row[$key][] = $mov['fechaEstimadaOrdenCompra']; 
        $row[$key][] = $mov['idTercero']; 
        $row[$key][] = $mov['nombreCompletoTercero']; 
    }

    $output["aaData"] = $row;
    echo json_encode($output);

?>