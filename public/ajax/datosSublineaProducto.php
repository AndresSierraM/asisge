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

    
    $sublineaproducto = \App\SublineaProducto::where("Compania_idCompania","=", \Session::get("idCompania"))->get();
    $row = array();

    foreach ($sublineaproducto as $key => $value) 
    {  
        $row[$key][] = '<a href="sublineaproducto/'.$value['idSublineaProducto'].'/edit">'.
                            '<span class="glyphicon glyphicon-pencil" style = "display:'.$visibleM.'"></span>'.
                        '</a>&nbsp;'.
                        '<a href="sublineaproducto/'.$value['idSublineaProducto'].'/edit?accion=eliminar">'.
                            '<span class="glyphicon glyphicon-trash" style = "display:'.$visibleE.'"></span>'.
                        '</a>';
        $row[$key][] = $value['idSublineaProducto'];
        $row[$key][] = $value['codigoSublineaProducto'];
        $row[$key][] = $value['nombreSublineaProducto'];   
    }

    $output['aaData'] = $row;
    echo json_encode($output);
?>