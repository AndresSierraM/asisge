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

    $tipoidentificacion = \App\TipoIdentificacion::All();
    $row = array();

    foreach ($tipoidentificacion as $key => $value) 
    {  
        $row[$key][] = '<a href="tipoidentificacion/'.$value['idTipoIdentificacion'].'/edit">'.
                            '<span class="glyphicon glyphicon-pencil" style = "display:'.$visibleM.'"></span>'.
                        '</a>&nbsp;'.
                        '<a href="tipoidentificacion/'.$value['idTipoIdentificacion'].'/edit?accion=eliminar">'.
                            '<span class="glyphicon glyphicon-trash" style = "display:'.$visibleE.'"></span>'.
                        '</a>';
        $row[$key][] = $value['idTipoIdentificacion'];
        $row[$key][] = $value['codigoTipoIdentificacion'];
        $row[$key][] = $value['nombreTipoIdentificacion'];   
    }

    $output['aaData'] = $row;
    echo json_encode($output);
?>