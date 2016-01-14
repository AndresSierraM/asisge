<?php

    $conformaciongrupoapoyo = DB::table('conformaciongrupoapoyo')
            ->leftJoin('grupoapoyo', 'GrupoApoyo_idGrupoApoyo', '=', 'idGrupoApoyo')
            ->select(DB::raw('idConformacionGrupoApoyo, nombreGrupoApoyo, nombreConformacionGrupoApoyo, fechaConformacionGrupoApoyo'))
            ->get();

    // print_r($conformaciongrupoapoyo);
    // exit;
    $row = array();

    foreach ($conformaciongrupoapoyo as $key => $value) 
    {  
        $row[$key][] = '<a href="conformaciongrupoapoyo/'.$value['idConformacionGrupoApoyo'].'/edit">'.
                            '<span class="glyphicon glyphicon-pencil"></span>'.
                        '</a>&nbsp;'.
                        '<a href="conformaciongrupoapoyo/'.$value['idConformacionGrupoApoyo'].'/edit?accion=eliminar">'.
                            '<span class="glyphicon glyphicon-trash"></span>'.
                        '</a>';
        $row[$key][] = $value['idConformacionGrupoApoyo'];
        $row[$key][] = $value['nombreGrupoApoyo'];   
        $row[$key][] = $value['nombreConformacionGrupoApoyo'];
        $row[$key][] = $value['fechaConformacionGrupoApoyo'];
    }

    $output['aaData'] = $row;
    echo json_encode($output);
?>