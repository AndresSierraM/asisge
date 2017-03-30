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

    
    $lineaproducto = \App\LineaProducto::where("Compania_idCompania","=", \Session::get("idCompania"))->get();
    $row = array();

    foreach ($lineaproducto as $key => $value) 
    {  
        $row[$key][] = '<a href="lineaproducto/'.$value['idLineaProducto'].'/edit">'.
                            '<span class="glyphicon glyphicon-pencil" style = "display:'.$visibleM.'"></span>'.
                        '</a>&nbsp;'.
                        '<a href="lineaproducto/'.$value['idLineaProducto'].'/edit?accion=eliminar">'.
                            '<span class="glyphicon glyphicon-trash" style = "display:'.$visibleE.'"></span>'.
                        '</a>';
        $row[$key][] = $value['idLineaProducto'];
        $row[$key][] = $value['codigoLineaProducto'];
        $row[$key][] = $value['nombreLineaProducto'];   
    }

    $output['aaData'] = $row;
    echo json_encode($output);
?>