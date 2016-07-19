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

    $ausentismo = DB::table('ausentismo')
            ->leftJoin('tercero', 'Tercero_idTercero', '=', 'idTercero')
            ->leftJoin('accidente', 'Ausentismo_idAusentismo', '=', 'idAusentismo')
            ->select(DB::raw('idAusentismo, nombreAusentismo, nombreCompletoTercero, fechaElaboracionAusentismo, tipoAusentismo, fechaInicioAusentismo, fechaFinAusentismo, nombreAccidente, diasAusentismo'))
            ->where('ausentismo.Compania_idCompania','=', \Session::get('idCompania'))
            ->get();

    $row = array();

    foreach ($ausentismo as $key => $value) 
    {  
        $row[$key][] = '<a href="ausentismo/'.$value->idAusentismo.'/edit">'.
                            '<span class="glyphicon glyphicon-pencil" style = "display:'.$visibleM.'"></span>'.
                        '</a>&nbsp;'.
                        '<a href="ausentismo/'.$value->idAusentismo.'/edit?accion=eliminar">'.
                            '<span class="glyphicon glyphicon-trash" style = "display:'.$visibleE.'"></span>'.
                        '</a>';
        $row[$key][] = $value->idAusentismo;
        $row[$key][] = $value->nombreAusentismo;
        $row[$key][] = $value->nombreCompletoTercero;
        $row[$key][] = $value->fechaElaboracionAusentismo; 
        $row[$key][] = $value->fechaInicioAusentismo;
        $row[$key][] = $value->fechaFinAusentismo;    
        $row[$key][] = $value->diasAusentismo;    
        $row[$key][] = $value->tipoAusentismo;
        $row[$key][] = $value->nombreAccidente;
    }

    $output['aaData'] = $row;
    echo json_encode($output);
?>