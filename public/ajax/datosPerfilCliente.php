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

    $tercero = DB::table('tercero')
            ->leftJoin('tipoidentificacion', 'TipoIdentificacion_idTipoIdentificacion', '=', 'idTipoIdentificacion')
            ->select(DB::raw('idTercero, nombreTipoIdentificacion , documentoTercero, nombreCompletoTercero, estadoTercero'))
            ->where('Compania_idCompania','=', \Session::get('idCompania'))
            ->where('tipoTercero','like','%*03*%')
            ->get();

    $row = array();

    foreach ($tercero as $key => $value) 
    {  
        $row[$key][] = '<a href="perfilcliente/create?idTercero='.$value->idTercero.'">'.
                            '<span class="glyphicon glyphicon-pencil" style = "display:'.$visibleM.'"></span>'.
                        '</a>&nbsp;';
        $row[$key][] = $value->idTercero;
        $row[$key][] = $value->nombreTipoIdentificacion;
        $row[$key][] = $value->documentoTercero;
        $row[$key][] = $value->nombreCompletoTercero;  
        $row[$key][] = $value->estadoTercero;    
    }

    $output['aaData'] = $row;
    echo json_encode($output);
?>