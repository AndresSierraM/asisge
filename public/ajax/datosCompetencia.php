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

    $competencia = DB::table('competencia')
            ->select(DB::raw('idCompetencia, nombreCompetencia, estadoCompetencia'))
            ->get();
            //->where('plantrabajoalerta.Compania_idCompania','=', \Session::get('idCompania'))

        $row = array();

    foreach ($competencia as $key => $value) 
    {  
        $row[$key][] = '<a href="competencia/'.$value->idCompetencia.'/edit">'.
                            '<span class="glyphicon glyphicon-pencil " style = "display:'.$visibleM.'"></span>'.
                        '</a>&nbsp;'.
                        '<a href="competencia/'.$value->idCompetencia.'/edit?accion=eliminar">'.
                            '<span class="glyphicon glyphicon-trash" style = "display:'.$visibleE.'"></span>'.
                        '</a>&nbsp;';
        $row[$key][] = $value->idCompetencia;
        $row[$key][] = $value->nombreCompetencia;
        $row[$key][] = $value->estadoCompetencia;
        
    }

    $output['aaData'] = $row;
    echo json_encode($output);
?>