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

    $accidente = DB::table('accidente')
            ->leftJoin('tercero', 'Tercero_idEmpleado', '=', 'idTercero')
            ->select(DB::raw('idAccidente, numeroAccidente, nombreCompletoTercero, descripcionAccidente, fechaOcurrenciaAccidente, clasificacionAccidente'))
            ->where('accidente.Compania_idCompania','=', \Session::get('idCompania'))
            ->get();

    // $accidente = \App\Accidente::where('accidente.Compania_idCompania','=', \Session::get('idCompania'))->get();
    $row = array();

    foreach ($accidente as $key => $value) 
    {  
        $row[$key][] = '<a href="accidente/'.$value->idAccidente.'/edit">'.
                            '<span class="glyphicon glyphicon-pencil " style = "display:'.$visibleM.'"></span>'.
                        '</a>&nbsp;'.
                        '<a href="accidente/'.$value->idAccidente.'/edit?accion=eliminar">'.
                            '<span class="glyphicon glyphicon-trash" style = "display:'.$visibleE.'"></span>'.
                        '</a>&nbsp;'.
                        '<a onclick="firmarAccidente('.$value->idAccidente.')">'.
                            '<span class="glyphicon glyphicon-edit" style = "cursor:pointer; display:'.$visibleM.'"></span>'.
                        '</a>';
        $row[$key][] = $value->idAccidente;
        $row[$key][] = $value->numeroAccidente;
        $row[$key][] = $value->nombreCompletoTercero;
        $row[$key][] = $value->descripcionAccidente;   
        $row[$key][] = $value->fechaOcurrenciaAccidente;
        $row[$key][] = $value->clasificacionAccidente;
    }

    $output['aaData'] = $row;
    echo json_encode($output);
?>