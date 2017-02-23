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

    $evaluaciondesempenio = DB::table('evaluaciondesempenio')
            ->leftJoin('cargo', 'Cargo_idCargo', '=', 'idCargo')
            ->leftJoin('Tercero','Tercero_idEmpleado', '=','idTercero') 
            // ->leftJoin('Tercero','Tercero_idResponsable', '=','idTercero')
            ->select(DB::raw('idEvaluacionDesempenio, tercero.nombreCompletoTercero, nombreCargo,Tercero_idResponsable,fechaElaboracionEvaluacionDesempenio'))
           
         
            ->get();
        $row = array();

    foreach ($evaluaciondesempenio as $key => $value) 

    {  
        $row[$key][] = '<a href="evaluaciondesempenio/'.$value->idEvaluacionDesempenio.'/edit">'.
                            '<span class="glyphicon glyphicon-pencil " style = "display:'.$visibleM.'"></span>'.
                        '</a>&nbsp;'.
                        '<a href="evaluaciondesempenio/'.$value->idEvaluacionDesempenio.'/edit?accion=eliminar">'.
                            '<span class="glyphicon glyphicon-trash" style = "display:'.$visibleE.'"></span>'.
                        '</a>&nbsp;';
        $row[$key][] = $value->idEvaluacionDesempenio;
        $row[$key][] = $value->nombreCompletoTercero;
        $row[$key][] = $value->nombreCargo;
        $row[$key][] = $value->Tercero_idResponsable;
        $row[$key][] = $value->fechaElaboracionEvaluacionDesempenio;
        
    }

    $output['aaData'] = $row;
    echo json_encode($output);
?>