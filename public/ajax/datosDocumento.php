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

    $documento = \App\Documento::All();
    $row = array();

    foreach ($documento as $key => $value) 
    {  
        $row[$key][] = '<a href="documento/'.$value['idDocumento'].'/edit">'.
                            '<span class="glyphicon glyphicon-pencil" style = "display:'.$visibleM.'"></span>'.
                        '</a>&nbsp;'.
                        '<a href="documento/'.$value['idDocumento'].'/edit?accion=eliminar">'.
                            '<span class="glyphicon glyphicon-trash"  style = "display:'.$visibleE.'"></span>'.
                        '</a>';
        $row[$key][] = $value['idDocumento'];
        $row[$key][] = $value['codigoDocumento'];
        $row[$key][] = $value['nombreDocumento'];   
    }

    $output['aaData'] = $row;
    echo json_encode($output);
?>