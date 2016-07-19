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

    
    $proceso = \App\Proceso::where("Compania_idCompania","=", \Session::get("idCompania"))->get();
    $row = array();

    foreach ($proceso as $key => $value) 
    {  
        $row[$key][] = '<a href="proceso/'.$value['idProceso'].'/edit">'.
                            '<span class="glyphicon glyphicon-pencil" style = "display:'.$visibleM.'"></span>'.
                        '</a>&nbsp;'.
                        '<a href="proceso/'.$value['idProceso'].'/edit?accion=eliminar">'.
                            '<span class="glyphicon glyphicon-trash" style = "display:'.$visibleE.'"></span>'.
                        '</a>';
        $row[$key][] = $value['idProceso'];
        $row[$key][] = $value['codigoProceso'];
        $row[$key][] = $value['nombreProceso'];   
    }

    $output['aaData'] = $row;
    echo json_encode($output);
?>