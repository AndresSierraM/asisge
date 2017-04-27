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
            ->leftJoin('cargo', 'Cargo_idCargo', '=', 'idCargo') 
            ->leftJoin('terceroinformacion','Tercero_idTercero','=','idTercero')
            ->leftJoin('tipoidentificacion', 'TipoIdentificacion_idTipoIdentificacion', '=', 'idTipoIdentificacion')
            ->select(DB::raw('idTercero, nombreTipoIdentificacion , documentoTercero, nombreCompletoTercero, estadoTercero,nombreCargo,fechaIngresoTerceroInformacion'))
            ->where('tercero.Compania_idCompania','=', \Session::get('idCompania'))
            ->get();

    $row = array();

    foreach ($tercero as $key => $value) 
    {  
        $row[$key][] = '<a href="tercero/'.$value->idTercero.'/edit?idTercero='.$value->idTercero.'&accion=editar">'.
                            '<span class="glyphicon glyphicon-pencil" style = "display:'.$visibleM.'"></span>'.
                        '</a>&nbsp;'.
                        '<a href="tercero/'.$value->idTercero.'/edit?idTercero='.$value->idTercero.'&accion=eliminar">'.
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

        

        

        
    }

    $output['aaData'] = $row;
    echo json_encode($output);
?>