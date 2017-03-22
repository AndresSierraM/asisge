<?php
    $idDocumento = $_GET['idDocumento'];
    $idTercero = $_GET['idTercero'];

    // $movimiento = DB::table('movimientocrm as m')
    //         ->leftJoin('documentocrm as d', 'm.DocumentoCRM_idDocumentoCRM ', '=', 'd.idDocumentoCRM ')
    //         ->select(DB::raw('numeroMovimientoCRM, asuntoMovimientoCRM , fechaSolicitudMovimientoCRM'))
    //         ->where('Tercero_idSolicitante','=', $idTercero)
    //         ->where('DocumentoCRM_idDocumentoCRM ','=', $idDocumento)
    //         ->get();

    $movimiento = DB::Select('
        SELECT 
            numeroMovimientoCRM, 
            asuntoMovimientoCRM, 
            fechaSolicitudMovimientoCRM 
        from 
            movimientocrm m 
            left join documentocrm d on m.DocumentoCRM_idDocumentoCRM = d.idDocumentoCRM 
        where 
            Tercero_idSolicitante = '.$idTercero.'  
            and idDocumentoCRM = '.$idDocumento);

    $row = array();

    foreach ($movimiento as $key => $value) 
    {  
        $value = get_object_vars($movimiento[$key]);

        $row[$key][] = $value['asuntoMovimientoCRM'];
        $row[$key][] = $value['numeroMovimientoCRM'];
        $row[$key][] = $value['fechaSolicitudMovimientoCRM'];
    }

    $output['aaData'] = $row;
    echo json_encode($output);
?>