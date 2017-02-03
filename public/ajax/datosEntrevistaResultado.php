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

    $informeEntrevista = DB::table('entrevistaresultado')

            ->leftJoin('cargo', 'Cargo_idCargo', '=', 'idcargo')
            // ->leftJoin('tercero', 'Tercero_idEntrevistador', '=', 'idTercero')
            ->select(DB::raw('idEntrevistaResultado,nombreCargo,fechaInicialEntrevistaResultado,fechaFinalEntrevistaResultado,Users_idCrea,fechaElaboracionEntrevistaResultado'))
            ->get();
            //->where('plantrabajoalerta.Compania_idCompania','=', \Session::get('idCompania'))

        $row = array();

    foreach ($informeEntrevista as $key => $value) 
    {  
        $row[$key][] = '<a href="entrevistaresultado/'.$value->idEntrevistaResultado.'/edit">'.
                            '<span class="glyphicon glyphicon-pencil " style = "display:'.$visibleM.'"></span>'.
                        '</a>&nbsp;'.
                        '<a href="entrevistaresultado/'.$value->idEntrevistaResultado.'/edit?accion=eliminar">'.
                            '<span class="glyphicon glyphicon-trash" style = "display:'.$visibleE.'"></span>'.
                        '</a>&nbsp;';
        $row[$key][] = $value->idEntrevistaResultado;
        $row[$key][] = $value->nombreCargo;
        $row[$key][] = $value->fechaInicialEntrevistaResultado;
        $row[$key][] = $value->fechaFinalEntrevistaResultado;
        $row[$key][] = $value->Users_idCrea;
        $row[$key][] = $value->fechaElaboracionEntrevistaResultado;
        
    }

    $output['aaData'] = $row;
    echo json_encode($output);
?>