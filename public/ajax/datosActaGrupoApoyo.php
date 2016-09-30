<?php
    $modificar = $_GET['modificar'];
    $eliminar = $_GET['eliminar'];
    $imprimir = $_GET['imprimir'];

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
    if ($imprimir == 1) 
            $visibleI = 'inline-block;';
        else
            $visibleI = 'none';


    $actagrupoapoyo = DB::table('actagrupoapoyo')
            ->leftJoin('grupoapoyo', 'GrupoApoyo_idGrupoApoyo', '=', 'idGrupoApoyo')
            ->select(DB::raw('idActaGrupoApoyo, nombreGrupoApoyo, fechaActaGrupoApoyo, horaInicioActaGrupoApoyo, horaFinActaGrupoApoyo'))
            ->where('actagrupoapoyo.Compania_idCompania','=', \Session::get('idCompania'))
            ->get();

    $row = array();

    foreach ($actagrupoapoyo as $key => $value) 
    {  
        $row[$key][] = '<a href="actagrupoapoyo/'.$value->idActaGrupoApoyo.'/edit">'.
                            '<span class="glyphicon glyphicon-pencil" style = "display:'.$visibleM.'"></span>'.
                        '</a>&nbsp;'.
                        '<a href="actagrupoapoyo/'.$value->idActaGrupoApoyo.'/edit?accion=eliminar">'.
                            '<span class="glyphicon glyphicon-trash" style = "display:'.$visibleE.'"></span>'.
                        '</a>&nbsp;'.
                        '<a onclick="firmarGrupoApoyo('.$value->idActaGrupoApoyo.')">'.
                            '<span class="glyphicon glyphicon-edit" style = "cursor:pointer; display:'.$visibleM.'"></span>'.
                        '</a>&nbsp'.
                         '<a href="actagrupoapoyo" onclick="imprimirFormato('.$value->idActaGrupoApoyo.');s">'.
                            '<span class="glyphicon glyphicon-print" style = "display:'.$visibleI.'"></span>'.
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