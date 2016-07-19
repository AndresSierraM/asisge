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

    $cuadromando = DB::table('cuadromando')
            ->leftJoin('companiaobjetivo', 'CompaniaObjetivo_idCompaniaObjetivo', '=', 'idCompaniaObjetivo')
            ->leftJoin('proceso', 'Proceso_idProceso', '=', 'idProceso')
            ->leftJoin('frecuenciamedicion', 'FrecuenciaMedicion_idFrecuenciaMedicion', '=', 'idFrecuenciaMedicion')
            ->leftJoin('tercero', 'Tercero_idResponsable', '=', 'idTercero')
            ->select(DB::raw('idCuadroMando, numeroCuadroMando , nombreCompaniaObjetivo, 
            objetivoEspecificoCuadroMando, indicadorCuadroMando, nombreProceso, formulaCuadroMando, 
            visualizacionCuadroMando, concat(operadorMetaCuadroMando, valorMetaCuadroMando, tipoMetaCuadroMando) as tipoMetaCuadroMando, nombreFrecuenciaMedicion, nombreCompletoTercero'))
            ->where('cuadromando.Compania_idCompania','=', \Session::get('idCompania'))
            ->get();

    $row = array();

    foreach ($cuadromando as $key => $value) 
    {  
        $row[$key][] = '<a href="cuadromando/'.$value->idCuadroMando.'/edit">'.
                            '<span class="glyphicon glyphicon-pencil" style = "display:'.$visibleM.'"></span>'.
                        '</a>&nbsp;'.
                        '<a href="cuadromando/'.$value->idCuadroMando.'/edit?accion=eliminar">'.
                            '<span class="glyphicon glyphicon-trash" style = "display:'.$visibleE.'"></span>'.
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
    }

    $output['aaData'] = $row;
    echo json_encode($output);
?>