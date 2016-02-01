<?php

    $cuadromando = DB::table('cuadromando')
            ->leftJoin('companiaobjetivo', 'CompaniaObjetivo_idCompaniaObjetivo', '=', 'idCompaniaObjetivo')
            ->leftJoin('proceso', 'Proceso_idProceso', '=', 'idProceso')
            ->leftJoin('frecuenciamedicion', 'FrecuenciaMedicion_idFrecuenciaMedicion', '=', 'idFrecuenciaMedicion')
            ->leftJoin('tercero', 'Tercero_idResponsable', '=', 'idTercero')
            ->select(DB::raw('idCuadroMando, numeroCuadroMando , nombreCompaniaObjetivo, 
            objetivoEspecificoCuadroMando, indicadorCuadroMando, nombreProceso, formulaCuadroMando, 
            visualizacionCuadroMando, tipoMetaCuadroMando, nombreFrecuenciaMedicion, nombreCompletoTercero'))
            ->get();

    $row = array();

    foreach ($cuadromando as $key => $value) 
    {  
        $row[$key][] = '<a href="cuadromando/'.$value->idCuadroMando.'/edit">'.
                            '<span class="glyphicon glyphicon-pencil"></span>'.
                        '</a>&nbsp;'.
                        '<a href="cuadromando/'.$value->idCuadroMando.'/edit?accion=eliminar">'.
                            '<span class="glyphicon glyphicon-trash"></span>'.
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