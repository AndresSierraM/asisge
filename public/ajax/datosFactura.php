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

    
     $factura = 
        DB::table('factura as F')
        ->leftjoin('cliente','F.cliente_In_Idcliente','=','cliente.In_Idcliente')
        ->select(DB::raw('In_IdeFactura,Da_Fecha_Factura, Nv_Nota, Nv_Nombre_Cliente'))
        ->get();

    $row = array();

    foreach ($factura as $key => $value) 
    {  
        $row[$key][] = '<a href="factura/'.$value->In_IdeFactura.'/edit">'.
                            '<span class="glyphicon glyphicon-pencil" style = "display:'.$visibleM.'"></span>'.
                        '</a>&nbsp;'.
                        '<a href="factura/'.$value->In_IdeFactura.'/edit?accion=eliminar">'.
                            '<span class="glyphicon glyphicon-trash" style = "display:'.$visibleE.'"></span>'.
                        '</a>';
        $row[$key][] = $value->In_IdeFactura;
        $row[$key][] = $value->Da_Fecha_Factura;
        $row[$key][] = $value->Nv_Nota;   
        $row[$key][] = $value->Nv_Nombre_Cliente;
     
    }

    $output["aaData"] = $row;
    echo json_encode($output);
?>