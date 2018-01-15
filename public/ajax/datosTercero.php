<?php
    $modificar = $_GET['modificar'];
    $eliminar = $_GET['eliminar'];
    // Se pregunta por el tipo
    $tipo = $_GET['tipoTercero'];

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
            ->leftJoin('cargo', 'Cargo_idCargo', '=', 'idCargo') 
            ->leftJoin('terceroinformacion','Tercero_idTercero','=','idTercero')
            ->leftJoin('tipoidentificacion', 'TipoIdentificacion_idTipoIdentificacion', '=', 'idTipoIdentificacion')
            ->leftJoin('centrocosto', 'CentroCosto_idCentroCosto', '=', 'idCentroCosto')
            ->select(DB::raw('idTercero, nombreTipoIdentificacion , documentoTercero, nombreCompletoTercero, estadoTercero,nombreCargo,fechaIngresoTerceroInformacion,nombreCentroCosto'))
            ->where('tercero.Compania_idCompania','=', \Session::get('idCompania'))
            ->where('tipoTercero', '=', $tipo)
            // Se hace un grupby para que solo se filtre por id papa
            ->groupby('idTercero')
            ->get();

    $row = array();

    foreach ($tercero as $key => $value) 
    {  
        $row[$key][] = '<a href="tercero/'.$value->idTercero.'/edit?tipo='.$tipo.'">'.
                            '<span class="glyphicon glyphicon-pencil" style = "display:'.$visibleM.'"></span>'.
                        '</a>&nbsp;'.
                        '<a href="tercero/'.$value->idTercero.'/edit?accion=eliminar&tipo='.$tipo.'">'.
                            '<span class="glyphicon glyphicon-trash" style = "display:'.$visibleE.'"></span>'.
                        '</a>';
        $row[$key][] = $value->idTercero;
        $row[$key][] = $value->nombreTipoIdentificacion;
        $row[$key][] = $value->documentoTercero;
        $row[$key][] = $value->nombreCompletoTercero;  
        $row[$key][] = $value->estadoTercero;
        $row[$key][] = $value->nombreCargo;
        // En la salida de la informacion se hace una condicion de que si tiene en 000-000  o no esta diligenciado el campo ,la fecha de ingreso mostrara en la grid el campo vacio.
        $row[$key][] = ($value->fechaIngresoTerceroInformacion == "0000-00-00" ? "" : $value->fechaIngresoTerceroInformacion);
        $row[$key][] = $value->nombreCentroCosto;

        

        

        
    }

    $output['aaData'] = $row;
    echo json_encode($output);
?>