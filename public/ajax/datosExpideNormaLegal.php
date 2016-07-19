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

    $expidenormalegal = \App\ExpideNormaLegal::All();
    $row = array();

    foreach ($expidenormalegal as $key => $value) 
    {  
        $row[$key][] = '<a href="expidenormalegal/'.$value['idExpideNormaLegal'].'/edit">'.
                            '<span class="glyphicon glyphicon-pencil" style = "display:'.$visibleM.'"></span>'.
                        '</a>&nbsp;'.
                        '<a href="expidenormalegal/'.$value['idExpideNormaLegal'].'/edit?accion=eliminar">'.
                            '<span class="glyphicon glyphicon-trash" style = "display:'.$visibleE.'"></span>'.
                        '</a>';
        $row[$key][] = $value['idExpideNormaLegal'];
        $row[$key][] = $value['codigoExpideNormaLegal'];
        $row[$key][] = $value['nombreExpideNormaLegal'];   
    }

    $output['aaData'] = $row;
    echo json_encode($output);
?>