<?php
    $idDoc = (isset($_GET["idDocumentoCRM"]) ? $_GET["idDocumentoCRM"] : 0 );
    $data = \App\MovimientoCRM::select(DB::raw('idMovimientoCRM, numeroMovimientoCRM, asuntoMovimientoCRM, fechaSolicitudMovimientoCRM, fechaRealSolucionMovimientoCRM'))
                            ->where('DocumentoCRM_idDocumentoCRM','=',$idDoc)
                            ->get();

    $row = array();

    
    foreach ($data as $key => $value) 
    {  
        $row[$key][] = $value['idMovimientoCRM'];
        $row[$key][] = $value['numeroMovimientoCRM'];   
        $row[$key][] = $value['asuntoMovimientoCRM'];   
        $row[$key][] = $value['fechaSolicitudMovimientoCRM']; 
        $row[$key][] = $value['fechaRealSolucionMovimientoCRM']; 
    }

    $output['aaData'] = $row;
    echo json_encode($output);
?>