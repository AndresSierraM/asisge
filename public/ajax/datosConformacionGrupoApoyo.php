<?php
    $modificar = $_GET['modificar'];
    $eliminar = $_GET['eliminar'];
    $imprimir = $_GET['imprimir'];

    $visibleM = '';
    $visibleE = '';
    $visibleI = '';
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

    // $conformaciongrupoapoyo = DB::table('conformaciongrupoapoyo')
    //         ->leftJoin('grupoapoyo', 'GrupoApoyo_idGrupoApoyo', '=', 'idGrupoApoyo')
    //         ->select(DB::raw('idConformacionGrupoApoyo, nombreGrupoApoyo, nombreConformacionGrupoApoyo, fechaConformacionGrupoApoyo'))
    //         ->where('conformaciongrupoapoyo.Compania_idCompania','=', \Session::get('idCompania'))
    //         ->get();
    $conformaciongrupoapoyo = DB::select('
        SELECT cga.idConformacionGrupoApoyo,ga.nombreGrupoApoyo,
        cga.nombreConformacionGrupoApoyo,cga.fechaConformacionGrupoApoyo
        FROM conformaciongrupoapoyo cga
        LEFT JOIN grupoapoyo ga
        ON cga.GrupoApoyo_idGrupoApoyo = ga.idGrupoApoyo
        WHERE cga.Compania_idCompania = '.\Session::get('idCompania'));

    // print_r($conformaciongrupoapoyo);
    // exit;
    $row = array();

    foreach ($conformaciongrupoapoyo as $key => $value) 
    {  
        $row[$key][] = '<a href="conformaciongrupoapoyo/'.$value->idConformacionGrupoApoyo.'/edit">'.
                            '<span class="glyphicon glyphicon-pencil"  style = "display:'.$visibleM.'"></span>'.
                        '</a>&nbsp;'.
                        '<a href="conformaciongrupoapoyo/'.$value->idConformacionGrupoApoyo.'/edit?accion=eliminar">'.
                            '<span class="glyphicon glyphicon-trash" style = "display:'.$visibleE.'"></span>'.
                        '</a>&nbsp;&nbsp;'.
                        '<a onclick="firmarGrupoApoyo('.$value->idConformacionGrupoApoyo.')">'.
                            '<span class="glyphicon glyphicon-edit" style = "cursor:pointer; display:'.$visibleM.'"></span>'.
                        '</a>&nbsp;&nbsp;'.
                         '<a onclick="imprimirConformacionGrupoApoyo('.$value->idConformacionGrupoApoyo.');">'.
                            '<span class="glyphicon glyphicon-print" style = "cursor:pointer; display:'.$visibleI.'"></span>'.
                        '</a>';
        $row[$key][] = $value->idConformacionGrupoApoyo;
        $row[$key][] = $value->nombreGrupoApoyo;   
        $row[$key][] = $value->nombreConformacionGrupoApoyo;
        $row[$key][] = $value->fechaConformacionGrupoApoyo;
    }

    $output['aaData'] = $row;
    echo json_encode($output);
?>