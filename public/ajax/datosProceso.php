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

    // si se recibe por get el parametro Tipo, lo enviamos a la vista
    // de lo contrario es tipo G (G=General,  P=Produccion)
    if(isset($_GET["tipo"]) and $_GET["tipo"] != "")
        $tipo = $_GET["tipo"];
    else
        $tipo = 'G';
        
    $proceso = \App\Proceso::where("Compania_idCompania","=", \Session::get("idCompania"))->get();
    $row = array();

    foreach ($proceso as $key => $value) 
    {  
        $row[$key][] = '<a href="proceso/'.$value['idProceso'].'/edit?tipo='.$tipo.'">'.
                            '<span class="glyphicon glyphicon-pencil" style = "display:'.$visibleM.'"></span>'.
                        '</a>&nbsp;'.
                        '<a href="proceso/'.$value['idProceso'].'/edit?accion=eliminar&tipo='.$tipo.'">'.
                            '<span class="glyphicon glyphicon-trash" style = "display:'.$visibleE.'"></span>'.
                        '</a>';
        $row[$key][] = $value['idProceso'];
        $row[$key][] = $value['codigoProceso'];
        $row[$key][] = $value['nombreProceso'];   
    }

    $output['aaData'] = $row;
    echo json_encode($output);
?>