<?php

    $planAuditoria = DB::table('planAuditoria')
            ->leftJoin('tercero', 'Tercero_AuditorLider', '=', 'idTercero')
            ->select(DB::raw('idPlanAuditoria, numeroPlanAuditoria,fechaInicioPlanAuditoria,fechaFinPlanAuditoria,organismoPlanAuditoria,nombreCompletoTercero'))
            ->get();

    $row = array();

    foreach($planAuditoria as $key => $value) 
    {
        $row[$key][] = '<a href="planauditoria/'.$value->idPlanAuditoria.'/edit">'.
                            '<span class="glyphicon glyphicon-pencil"></span>'.
                        '</a>&nbsp;'.
                        '<a href="planauditoria/'.$value->idPlanAuditoria.'/edit?accion=eliminar">'.
                            '<span class="glyphicon glyphicon-trash"></span>'.
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