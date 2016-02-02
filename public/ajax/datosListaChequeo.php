<?php

    $listaChequeo = DB::table('listachequeo as lc')
            ->leftJoin('proceso as p', 'lc.Proceso_idProceso', '=', 'p.idProceso')
            ->leftJoin('planauditoria as pa', 'lc.PlanAuditoria_idPlanAuditoria', '=', 'pa.idPlanAuditoria')
            ->select(DB::raw('idListaChequeo, numeroListaChequeo, fechaElaboracionListaChequeo, numeroPlanAuditoria, nombreProceso'))
            ->get();
print_r($listachequeo);
return;
    $row = array();

    foreach($listaChequeo as $key => $value)
    {
        $row[$key][] = '<a href="listachequeo/'.$value->idListaChequeo.'/edit">'.
                            '<span class="glyphicon glyphicon-pencil"></span>'.
                        '</a>&nbsp;'.
                        '<a href="listachequeo/'.$value->idListaChequeo.'/edit?accion=eliminar">'.
                            '<span class="glyphicon glyphicon-trash"></span>'.
                        '</a>'.
                         '<a href="#" onclick="imprimirFormato('.$value->idListaChequeo.');s">'.
                            '<span class="glyphicon glyphicon-print"></span>'.
                        '</a>';
        $row[$key][] = $value->idListaChequeo;
        $row[$key][] = $value->numeroListaChequeo;
        $row[$key][] = $value->fechaElaboracionListaChequeo;
        $row[$key][] = $value->numeroPlanAuditoria;
        $row[$key][] = $value->nombreProceso;
    }

    $output['aaData'] = $row;
    echo json_encode($output);