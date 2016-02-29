<?php


    $actagrupoapoyo = DB::table('actagrupoapoyo')
            ->leftJoin('grupoapoyo', 'GrupoApoyo_idGrupoApoyo', '=', 'idGrupoApoyo')
            ->select(DB::raw('idActaGrupoApoyo, nombreGrupoApoyo, fechaActaGrupoApoyo, horaInicioActaGrupoApoyo, horaFinActaGrupoApoyo'))
            ->get();

    $row = array();

    foreach ($actagrupoapoyo as $key => $value) 
    {  
        $row[$key][] = '<a href="actagrupoapoyo/'.$value->idActaGrupoApoyo.'/edit">'.
                            '<span class="glyphicon glyphicon-pencil"></span>'.
                        '</a>&nbsp;'.
                        '<a href="actagrupoapoyo/'.$value->idActaGrupoApoyo.'/edit?accion=eliminar">'.
                            '<span class="glyphicon glyphicon-trash"></span>'.
                        '</a>';
                         
        $row[$key][] = $value->idActaGrupoApoyo;
        $row[$key][] = $value->nombreGrupoApoyo;
        $row[$key][] = $value->fechaActaGrupoApoyo;   
        $row[$key][] = $value->horaInicioActaGrupoApoyo;
        $row[$key][] = $value->horaFinActaGrupoApoyo;
    }

    $output['aaData'] = $row;
    echo json_encode($output);
?>