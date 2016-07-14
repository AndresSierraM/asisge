<?php

    $lineanegocio = DB::table('lineanegocio')
            ->select(DB::raw('idLineaNegocio, codigoLineaNegocio, nombreLineaNegocio'))
            ->get();

    $row = array();

    foreach ($lineanegocio as $key => $value) 
    {  
        $row[$key][] = '<a href="lineanegocio/'.$value->idLineaNegocio.'/edit">'.
                            '<span class="glyphicon glyphicon-pencil"></span>'.
                        '</a>&nbsp;'.
                        '<a href="lineanegocio/'.$value->idLineaNegocio.'/edit?accion=eliminar">'.
                            '<span class="glyphicon glyphicon-trash"></span>'.
                        '</a>';
        $row[$key][] = $value->idLineaNegocio;
        $row[$key][] = $value->codigoLineaNegocio;
        $row[$key][] = $value->nombreLineaNegocio; 
    }

    $output['aaData'] = $row;
    echo json_encode($output);
?>