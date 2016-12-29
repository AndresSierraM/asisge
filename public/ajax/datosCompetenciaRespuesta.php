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

    $competenciarespuesta = DB::table('competenciarespuesta')
            ->select(DB::raw('idCompetenciaRespuesta,respuestaCompetenciaRespuesta,porcentajeNormalCompetenciaRespuesta,porcentajeInversoCompetenciaRespuesta'))
            ->get();
            //->where('plantrabajoalerta.Compania_idCompania','=', \Session::get('idCompania'))

        $row = array();

    foreach ($competenciarespuesta as $key => $value) 
    {  
        $row[$key][] = '<a href="competenciarespuesta/'.$value->idCompetenciaRespuesta.'/edit">'.
                            '<span class="glyphicon glyphicon-pencil " style = "display:'.$visibleM.'"></span>'.
                        '</a>&nbsp;'.
                        '<a href="competenciarespuesta/'.$value->idCompetenciaRespuesta.'/edit?accion=eliminar">'.
                            '<span class="glyphicon glyphicon-trash" style = "display:'.$visibleE.'"></span>'.
                        '</a>&nbsp;';
        $row[$key][] = $value->idCompetenciaRespuesta;
        $row[$key][] = $value->respuestaCompetenciaRespuesta;
        $row[$key][] = $value->porcentajeNormalCompetenciaRespuesta;
        $row[$key][] = $value->porcentajeInversoCompetenciaRespuesta;
        
    }

    $output['aaData'] = $row;
    echo json_encode($output);
?>