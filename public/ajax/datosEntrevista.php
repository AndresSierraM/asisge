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

    $entrevista = DB::table('entrevista')

            ->leftJoin('cargo', 'Cargo_idCargo', '=', 'idcargo')
            ->leftJoin('tercero', 'Tercero_idEntrevistador', '=', 'idTercero')
            ->select(DB::raw('idEntrevista,fechaEntrevista,documentoAspiranteEntrevista,nombre1AspiranteEntrevista,nombreCargo,nombreCompletoTercero,estadoEntrevista'))
            ->get();
            //->where('plantrabajoalerta.Compania_idCompania','=', \Session::get('idCompania'))

        $row = array();

    foreach ($entrevista as $key => $value) 
    {  
        $row[$key][] = '<a href="entrevista/'.$value->idEntrevista.'/edit">'.
                            '<span class="glyphicon glyphicon-pencil " style = "display:'.$visibleM.'"></span>'.
                        '</a>&nbsp;'.
                        '<a href="entrevista/'.$value->idEntrevista.'/edit?accion=eliminar">'.
                            '<span class="glyphicon glyphicon-trash" style = "display:'.$visibleE.'"></span>'.
                        '</a>&nbsp;';
        $row[$key][] = $value->idEntrevista;
        $row[$key][] = $value->fechaEntrevista;
        $row[$key][] = $value->documentoAspiranteEntrevista;
        $row[$key][] = $value->nombre1AspiranteEntrevista;
        $row[$key][] = $value->nombreCargo;
        $row[$key][] = $value->nombreCompletoTercero;
        $row[$key][] = $value->estadoEntrevista;
        
    }

    $output['aaData'] = $row;
    echo json_encode($output);
?>