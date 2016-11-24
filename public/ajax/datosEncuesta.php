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

    $encuesta = \App\Encuesta::where('Compania_idCompania','=', \Session::get('idCompania'))->get();
    $row = array();

    foreach ($encuesta as $key => $value) 
    {  
        $row[$key][] = '<a href="encuesta/'.$value['idEncuesta'].'/edit">'.
                            '<span class="glyphicon glyphicon-pencil" style = "display:'.$visibleM.'"></span>'.
                        '</a>&nbsp;'.
                        '<a href="encuesta/'.$value['idEncuesta'].'/edit?accion=eliminar">'.
                            '<span class="glyphicon glyphicon-trash" style = "display:'.$visibleE.'"></span>'.
                        '</a>';
        $row[$key][] = $value['idEncuesta'];
        $row[$key][] = $value['tituloEncuesta'];
        $row[$key][] = $value['descripcionEncuesta'];   
    }

    $output['aaData'] = $row;
    echo json_encode($output);
?>