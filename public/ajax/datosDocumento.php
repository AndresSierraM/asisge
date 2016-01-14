<?php


    $documento = \App\Documento::All();
    $row = array();

    foreach ($documento as $key => $value) 
    {  
        $row[$key][] = '<a href="documento/'.$value['idDocumento'].'/edit">'.
                            '<span class="glyphicon glyphicon-pencil"></span>'.
                        '</a>&nbsp;'.
                        '<a href="documento/'.$value['idDocumento'].'/edit?accion=eliminar">'.
                            '<span class="glyphicon glyphicon-trash"></span>'.
                        '</a>';
        $row[$key][] = $value['idDocumento'];
        $row[$key][] = $value['codigoDocumento'];
        $row[$key][] = $value['nombreDocumento'];   
    }

    $output['aaData'] = $row;
    echo json_encode($output);
?>