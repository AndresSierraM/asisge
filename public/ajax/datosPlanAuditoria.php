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
    $planAuditoria = DB::table('planauditoria')
            ->leftJoin('tercero', 'Tercero_AuditorLider', '=', 'idTercero')
            ->select(DB::raw('idPlanAuditoria, numeroPlanAuditoria,fechaInicioPlanAuditoria,fechaFinPlanAuditoria,organismoPlanAuditoria,nombreCompletoTercero'))
            ->where('planauditoria.Compania_idCompania','=', \Session::get('idCompania'))
            ->get();

    $row = array();

    foreach($planAuditoria as $key => $value) 
    {
        $row[$key][] = '<a href="planauditoria/'.$value->idPlanAuditoria.'/edit">'.
                            '<span class="glyphicon glyphicon-pencil" style = "display:'.$visibleM.'"></span>'.
                        '</a>&nbsp;'.
                        '<a href="planauditoria/'.$value->idPlanAuditoria.'/edit?accion=eliminar">'.
                            '<span class="glyphicon glyphicon-trash" style = "display:'.$visibleE.'"></span>'.
                        '</a>&nbsp;&nbsp;'.
                        '<a onclick="imprimirplanauditoria('.$value->idPlanAuditoria.');">'.
                            '<span class="glyphicon glyphicon-print" style = "cursor:pointer; display:'.$visibleI.'"></span>'.
                        '</a>';
        $row[$key][] = $value->idPlanAuditoria;
        $row[$key][] = $value->numeroPlanAuditoria;
        $row[$key][] = $value->fechaInicioPlanAuditoria;
        $row[$key][] = $value->fechaFinPlanAuditoria;
        $row[$key][] = $value->organismoPlanAuditoria;
        $row[$key][] = $value->nombreCompletoTercero;
    }

    $output['aaData'] = $row;
    echo json_encode($output);