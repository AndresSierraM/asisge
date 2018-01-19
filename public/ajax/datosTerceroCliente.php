<?php
    $modificar = $_GET['modificar'];
    $eliminar = $_GET['eliminar'];
    // Se pregunta por el tipo
    // Como el nuevo cambio va a tener cada tipo de tercero en su propia Grid, se hace lo mismo con los ajax
    // $tipo = $_GET['tipoTercero'];

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
            // ->leftJoin('cargo', 'Cargo_idCargo', '=', 'idCargo')
            ->leftJoin('sectorempresa','SectorEmpresa_idSectorEmpresa','=','idSectorEmpresa')
            ->leftJoin('terceroinformacion','Tercero_idTercero','=','idTercero')
            ->leftJoin('tipoidentificacion', 'TipoIdentificacion_idTipoIdentificacion', '=', 'idTipoIdentificacion')
            ->leftJoin('centrocosto', 'CentroCosto_idCentroCosto', '=', 'idCentroCosto')
            ->select(DB::raw('idTercero, nombreTipoIdentificacion , documentoTercero, nombreCompletoTercero, estadoTercero,nombreSectorEmpresa,fechaIngresoTerceroInformacion,nombreCentroCosto'))
            ->where('tercero.Compania_idCompania','=', \Session::get('idCompania'))
            ->where('tipoTercero', '=', '*03*')
            // Se hace un grupby para que solo se filtre por id papa
            ->groupby('idTercero')
            ->get();

    $row = array();

    foreach ($tercero as $key => $value) 
    {  
        $row[$key][] = '<a href="tercero/'.$value->idTercero.'/edit?tipo='.'*03*'.'">'.
                            '<span class="glyphicon glyphicon-pencil" style = "display:'.$visibleM.'"></span>'.
                        '</a>&nbsp;'.
                        '<a href="tercero/'.$value->idTercero.'/edit?accion=eliminar&tipo='.'*03*'.'">'.
                            '<span class="glyphicon glyphicon-trash" style = "display:'.$visibleE.'"></span>'.
                        '</a>';
        $row[$key][] = $value->idTercero;
        $row[$key][] = $value->nombreTipoIdentificacion;
        $row[$key][] = $value->documentoTercero;
        $row[$key][] = $value->nombreCompletoTercero;  
        $row[$key][] = $value->estadoTercero;
        $row[$key][] = $value->nombreSectorEmpresa;
        // En la salida de la informacion se hace una condicion de que si tiene en 000-000  o no esta diligenciado el campo ,la fecha de ingreso mostrara en la grid el campo vacio.
        $row[$key][] = ($value->fechaIngresoTerceroInformacion == "0000-00-00" ? "" : $value->fechaIngresoTerceroInformacion);
        $row[$key][] = $value->nombreCentroCosto;

    }

    $output['aaData'] = $row;
    echo json_encode($output)

?>