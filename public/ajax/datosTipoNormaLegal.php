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

    $tiponormalegal = \App\TipoNormaLegal::All();
 
    $row = array();

    foreach ($tiponormalegal as $key => $value) 
    {  
        $row[$key][] = '<a href="tiponormalegal/'.$value['idTipoNormaLegal'].'/edit">'.
                            '<span class="glyphicon glyphicon-pencil" style = "display:'.$visibleM.'"></span>'.
                        '</a>&nbsp;'.
                        '<a href="tiponormalegal/'.$value['idTipoNormaLegal'].'/edit?accion=eliminar">'.
                            '<span class="glyphicon glyphicon-trash" style = "display:'.$visibleE.'"></span>'.
                        '</a>';
        $row[$key][] = $value['idTipoNormaLegal'];
        $row[$key][] = $value['codigoTipoNormaLegal'];
        $row[$key][] = $value['nombreTipoNormaLegal'];   
    }

    $output['aaData'] = $row;
    echo json_encode($output);
?>