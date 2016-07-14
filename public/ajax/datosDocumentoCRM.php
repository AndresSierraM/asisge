<?php

    $documentocrm = DB::table('documentocrm')
            ->select(DB::raw('idDocumentoCRM, codigoDocumentoCRM, nombreDocumentoCRM, numeracionDocumentoCRM, longitudDocumentoCRM, desdeDocumentoCRM, hastaDocumentoCRM, actualDocumentoCRM'))
            ->where('Compania_idCompania','=', \Session::get('idCompania'))
            ->get();

    $row = array();

    foreach ($documentocrm as $key => $value) 
    {  
        $row[$key][] = '<a href="documentocrm/'.$value->idDocumentoCRM.'/edit">'.
                            '<span class="glyphicon glyphicon-pencil"></span>'.
                        '</a>&nbsp;'.
                        '<a href="documentocrm/'.$value->idDocumentoCRM.'/edit?accion=eliminar">'.
                            '<span class="glyphicon glyphicon-trash"></span>'.
                        '</a>';
        $row[$key][] = $value->idDocumentoCRM;
        $row[$key][] = $value->nombreDocumentoCRM;
        $row[$key][] = $value->numeracionDocumentoCRM;
        $row[$key][] = $value->longitudDocumentoCRM;   
        $row[$key][] = $value->desdeDocumentoCRM;
        $row[$key][] = $value->hastaDocumentoCRM;
        $row[$key][] = $value->actualDocumentoCRM;
    }

    $output['aaData'] = $row;
    echo json_encode($output);
?>