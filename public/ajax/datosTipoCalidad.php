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

    
    $tipocalidad = \App\TipoCalidad::where("Compania_idCompania","=", \Session::get("idCompania"))->get();
    $row = array();

    foreach ($tipocalidad as $key => $value) 
    {  
        $row[$key][] = '<a href="tipocalidad/'.$value['idTipoCalidad'].'/edit">'.
                            '<span class="glyphicon glyphicon-pencil" style = "display:'.$visibleM.'"></span>'.
                        '</a>&nbsp;'.
                        '<a href="tipocalidad/'.$value['idTipoCalidad'].'/edit?accion=eliminar">'.
                            '<span class="glyphicon glyphicon-trash" style = "display:'.$visibleE.'"></span>'.
                        '</a>';
        $row[$key][] = $value['idTipoCalidad'];
        $row[$key][] = $value['codigoTipoCalidad'];
        $row[$key][] = $value['nombreTipoCalidad'];   
        $row[$key][] = $value['noConformeTipoCalidad'];   
        $row[$key][] = $value['alertaCorreoTipoCalidad'];   
    }

    $output['aaData'] = $row;
    echo json_encode($output);
?>