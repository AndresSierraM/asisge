<?php
    $modificar = $_GET['modificar'];
    $eliminar = $_GET['eliminar'];
    $imprimir = $_GET['imprimir'];

    $visibleM = '';
    $visibleE = '';
    $visibleI = '';

    if ($modificar == 1) 
        $visibleM = 'inline-block;';
    else
        $visibleM = 'none;';

    if ($eliminar == 1) 
        $visibleE = 'inline-block;';
    else
        $visibleE = 'none;';

    if ($imprimir == 1) 
        $visibleI = 'inline-block;';
    else
        $visibleI = 'none;';
    
    $entregaelementoproteccion = DB::table('entregaelementoproteccion')
            ->leftJoin('tercero', 'Tercero_idTercero', '=', 'idTercero')
            ->select(DB::raw('idEntregaElementoProteccion,nombreCompletoTercero, fechaEntregaElementoProteccion'))
            ->where('entregaelementoproteccion.Compania_idCompania','=', \Session::get('idCompania'))
            ->get();

    $row = array();

    foreach ($entregaelementoproteccion as $key => $value) 
    {  
        $row[$key][] = '<a href="entregaelementoproteccion/'.$value->idEntregaElementoProteccion.'/edit">'.
                            '<span class="glyphicon glyphicon-pencil" style = "display:'.$visibleM.'"></span>'.
                        '</a>&nbsp;'.
                        '<a href="entregaelementoproteccion/'.$value->idEntregaElementoProteccion.'/edit?accion=eliminar">'.
                            '<span class="glyphicon glyphicon-trash"  style = "display:'.$visibleE.'"></span>'.
                        '</a>&nbsp;'.
                        '<a onclick="firmarEntregaElemento('.$value->idEntregaElementoProteccion.')">'.
                            '<span class="glyphicon glyphicon-edit" style = "cursor:pointer; display:'.$visibleM.'"></span>'.
                        '</a>&nbsp;'.
                        '<a href="#" onclick="imprimirFormato('.$value->idEntregaElementoProteccion.');">'.
                            '<span class="glyphicon glyphicon-print" style = "display:'.$visibleI.'"></span>'.
                        '</a>';

        $row[$key][] = $value->idEntregaElementoProteccion;
        $row[$key][] = $value->nombreCompletoTercero;
        $row[$key][] = $value->fechaEntregaElementoProteccion; 
    }

    $output['aaData'] = $row;
    echo json_encode($output);
?>