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

    
    $centrocosto = \App\CentroCosto::where("Compania_idCompania","=", \Session::get("idCompania"))->get();
    $row = array();

    foreach ($centrocosto as $key => $value) 
    {  
        $row[$key][] = '<a href="centrocosto/'.$value['idCentroCosto'].'/edit">'.
                            '<span class="glyphicon glyphicon-pencil" style = "display:'.$visibleM.'"></span>'.
                        '</a>&nbsp;'.
                        '<a href="centrocosto/'.$value['idCentroCosto'].'/edit?accion=eliminar">'.
                            '<span class="glyphicon glyphicon-trash" style = "display:'.$visibleE.'"></span>'.
                        '</a>';
        $row[$key][] = $value['idCentroCosto'];
        $row[$key][] = $value['codigoCentroCosto'];
        $row[$key][] = $value['nombreCentroCosto'];   
    }

    $output['aaData'] = $row;
    echo json_encode($output);
?>
