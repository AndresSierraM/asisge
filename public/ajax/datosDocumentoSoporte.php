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

    $documentosoporte = \App\DocumentoSoporte::All();
    $row = array();

    foreach ($documentosoporte as $key => $value) 
    {  
        $row[$key][] = '<a href="documentosoporte/'.$value['idDocumentoSoporte'].'/edit">'.
                            '<span class="glyphicon glyphicon-pencil" style = "display:'.$visibleM.'"></span>'.
                        '</a>&nbsp;'.
                        '<a href="documentosoporte/'.$value['idDocumentoSoporte'].'/edit?accion=eliminar">'.
                            '<span class="glyphicon glyphicon-trash"  style = "display:'.$visibleE.'"></span>'.
                        '</a>';
        $row[$key][] = $value['idDocumentoSoporte'];
        $row[$key][] = $value['codigoDocumentoSoporte'];
        $row[$key][] = $value['nombreDocumentoSoporte'];   
    }

    $output['aaData'] = $row;
    echo json_encode($output);
?>