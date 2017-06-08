<?php

    $modificar = $_GET['modificar'];
    $eliminar = $_GET['eliminar'];
    $adicionar = $_GET['adicionar'];
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
        $visibleI = 'none';

     if ($adicionar == 1) 
    {
    $cuadromando = DB::table('cuadromando')
            ->leftJoin('companiaobjetivo', 'CompaniaObjetivo_idCompaniaObjetivo', '=', 'idCompaniaObjetivo')
            ->leftJoin('proceso', 'Proceso_idProceso', '=', 'idProceso')
            ->leftJoin('frecuenciamedicion', 'FrecuenciaMedicion_idFrecuenciaMedicion', '=', 'idFrecuenciaMedicion')
            ->leftJoin('tercero', 'Tercero_idResponsable', '=', 'idTercero')
            ->leftJoin('compania', 'cuadromando.Compania_idCompania', '=', 'compania.idCompania')
            ->select(DB::raw('idCuadroMando, numeroCuadroMando , nombreCompaniaObjetivo, 
            objetivoEspecificoCuadroMando, indicadorCuadroMando, nombreProceso, formulaCuadroMando, 
            visualizacionCuadroMando, concat(operadorMetaCuadroMando, valorMetaCuadroMando, tipoMetaCuadroMando) as tipoMetaCuadroMando, nombreFrecuenciaMedicion, nombreCompletoTercero,compania.nombreCompania'))
            // ->where('cuadromando.Compania_idCompania','=', \Session::get('idCompania')) NO SE APLICA YA QUE TIENE ADICIONAR  Permiso para adiconar
            ->get();
    }
    else 
    {
        // Como no tiene opcion de adicionar se aplica el where de las compañias para que muestre solo los registros de la compañia en la que esta lgoueada 
         $cuadromando = DB::table('cuadromando')
             ->leftJoin('companiaobjetivo', 'CompaniaObjetivo_idCompaniaObjetivo', '=', 'idCompaniaObjetivo')
            ->leftJoin('proceso', 'Proceso_idProceso', '=', 'idProceso')
            ->leftJoin('frecuenciamedicion', 'FrecuenciaMedicion_idFrecuenciaMedicion', '=', 'idFrecuenciaMedicion')
            ->leftJoin('tercero', 'Tercero_idResponsable', '=', 'idTercero')
            ->leftJoin('compania', 'cuadromando.Compania_idCompania', '=', 'compania.idCompania')
            ->select(DB::raw('idCuadroMando, numeroCuadroMando , nombreCompaniaObjetivo, 
            objetivoEspecificoCuadroMando, indicadorCuadroMando, nombreProceso, formulaCuadroMando, 
            visualizacionCuadroMando, concat(operadorMetaCuadroMando, valorMetaCuadroMando, tipoMetaCuadroMando) as tipoMetaCuadroMando, nombreFrecuenciaMedicion, nombreCompletoTercero,compania.nombreCompania'))
            ->where('cuadromando.Compania_idCompania','=', \Session::get('idCompania')) 
            ->get();
    }

    $row = array();

    foreach ($cuadromando as $key => $value) 
    {  
        $row[$key][] = '<a href="cuadromando/'.$value->idCuadroMando.'/edit">'.
                            '<span class="glyphicon glyphicon-pencil" style = "display:'.$visibleM.'"></span>'.
                        '</a>&nbsp;'.
                        '<a href="cuadromando/'.$value->idCuadroMando.'/edit?accion=eliminar">'.
                            '<span class="glyphicon glyphicon-trash" style = "display:'.$visibleE.'"></span>'.
                        '</a>'. 
                        '<a onclick="imprimirCuadroMando('.$value->idCuadroMando.');">'.
                            '<span class="glyphicon glyphicon-print" style = "cursor:pointer; display:'.$visibleI.'"></span>'.
                        '</a>';
        $row[$key][] = $value->numeroCuadroMando;
        $row[$key][] = $value->nombreCompaniaObjetivo;
        $row[$key][] = $value->objetivoEspecificoCuadroMando;
        $row[$key][] = $value->indicadorCuadroMando;  
        $row[$key][] = $value->nombreProceso;    
        $row[$key][] = $value->formulaCuadroMando;
        $row[$key][] = $value->visualizacionCuadroMando;
        $row[$key][] = $value->tipoMetaCuadroMando;
        $row[$key][] = $value->nombreFrecuenciaMedicion;
        $row[$key][] = $value->nombreCompletoTercero;
        $row[$key][] = $value->nombreCompania;
    }

    $output['aaData'] = $row;
    echo json_encode($output);
?>