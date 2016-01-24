<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class PlanAuditoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('planauditoriagrid');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $tercero = \App\Tercero::All()->lists('nombreCompletoTercero','idTercero');
        $idTercero = \App\Tercero::All()->lists('idTercero');
        $nombreCompletoTercero = \App\Tercero::All()->lists('nombreCompletoTercero');
        $idProceso = \App\Proceso::All()->lists('idProceso');
        $nombreProceso = \App\Proceso::All()->lists('nombreProceso');
        return view('planauditoria',compact('tercero','idTercero','nombreCompletoTercero','idProceso','nombreProceso'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {

            \App\PlanAuditoria::create([
                    'numeroPlanAuditoria' => $request['numeroPlanAuditoria'],
                    'fechaInicioPlanAuditoria' => $request['fechaInicioPlanAuditoria'],
                    'fechaFinPlanAuditoria' => $request['fechaFinPlanAuditoria'],
                    'organismoPlanAuditoria' => $request['organismoPlanAuditoria'],
                    'Tercero_AuditorLider' => $request['Tercero_AuditorLider'],
                    'objetivoPlanAuditoria' => $request['objetivoPlanAuditoria'],
                    'alcancePlanAuditoria' => $request['alcancePlanAuditoria'],
                    'criterioPlanAuditoria' => $request['criterioPlanAuditoria'],
                    'criterioPlanAuditoria' => $request['criterioPlanAuditoria'],
                    'recursosPlanAuditoria' => $request['recursosPlanAuditoria'],
                    'observacionesPlanAuditoria' => $request['observacionesPlanAuditoria'],
                    'aprobacionPlanAuditoria' => $request['aprobacionPlanAuditoria'],
                    'fechaEntregaPlanAuditoria' => $request['fechaEntregaPlanAuditoria']

                ]);

            $planAuditoria = \App\PlanAuditoria::All()->last();
            $contadorAcompanante = count($request['Tercero_idAcompanante']);
            for($i = 0; $i < $contadorAcompanante; $i++)
            {
                \App\PlanAuditoriaAcompanante::create([

                    'PlanAuditoria_idAuditoria' => $planAuditoria->idPlanAuditoria,
                    'Tercero_idAcompanante' => $request['Tercero_idAcompanante'][$i]
                ]);
            }

            $contadorNotificado = count($request['Tercero_idNotificado']);
            for($i = 0; $i < $contadorNotificado; $i++)
            {
                \App\PlanAuditoriaNotificado::create([

                    'PlanAuditoria_idAuditoria' => $planAuditoria->idPlanAuditoria,
                    'Tercero_idAcompanante' => $request['Tercero_idAcompanante'][$i]
                ]);
            }

            $contadorAgenda = count($request['Proceso_idProceso']);
            for($i = 0; $i < $contadorAgenda; $i++)
            {
                \App\PlanAuditoriaAgenda::create([

                    'PlanAuditoria_idAuditoria' => $planAuditoria->idPlanAuditoria,
                    'Proceso_idProceso' => $request['Proceso_idProceso'][$i],
                    'Tercero_Auditado' => $request['Tercero_Auditado'][$i],
                    'Tercero_Auditor' => $request['Tercero_Auditor'][$i],
                    'fechaPlanAuditoriaAgenda' => $request['fechaPlanAuditoriaAgenda'][$i],
                    'horaInicioPlanAuditoriaAgenda' => $request['horaInicioPlanAuditoriaAgenda'][$i],
                    'horaFinPlanAuditoriaAgenda' => $request['horaFinPlanAuditoriaAgenda'][$i],
                    'lugarPlanAuditoriaAgenda' => $request['lugarPlanAuditoriaAgenda'][$i]
                ]);
            }

            return redirect('/planauditoria');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $tercero = \App\Tercero::All()->lists('nombreCompletoTercero','idTercero');
        $idTercero = \App\Tercero::All()->lists('idTercero');
        $nombreCompletoTercero = \App\Tercero::All()->lists('nombreCompletoTercero');
        $idProceso = \App\Proceso::All()->lists('idProceso');
        $nombreProceso = \App\Proceso::All()->lists('nombreProceso');

        $planAuditoria = \App\PlanCapacitacion::find($id);
        return view('planauditoria',compact('tercero','idTercero','nombreCompletoTercero','idProceso','nombreProceso'),['planAuditoria'=>$planAuditoria]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {

            $planAuditoria = \App\PlanAuditoria::find($id);
            $planAuditoria->fill($request->all());

            $planAuditoria->save();

            \App\PlanCapacitacionAcompanante::where('PlanAuditoria_idPlanAuditoria',$id)->delete();
            \App\PlanCapacitacionNotificado::where('PlanAuditoria_idPlanAuditoria',$id)->delete();
            \App\PlanCapacitacionAgenda::where('PlanAuditoria_idPlanAuditoria',$id)->delete();

            $contadorAcompanante = count($request['Tercero_idAcompanante']);
            for($i = 0; $i < $contadorAcompanante; $i++)
            {
                \App\PlanAuditoriaAcompanante::create([

                    'PlanAuditoria_idAuditoria' => $id,
                    'Tercero_idAcompanante' => $request['Tercero_idAcompanante'][$i]
                ]);
            }

            $contadorNotificado = count($request['Tercero_idNotificado']);
            for($i = 0; $i < $contadorNotificado; $i++)
            {
                \App\PlanAuditoriaNotificado::create([

                    'PlanAuditoria_idAuditoria' => $id,
                    'Tercero_idAcompanante' => $request['Tercero_idAcompanante'][$i]
                ]);
            }

            $contadorAgenda = count($request['Proceso_idProceso']);
            for($i = 0; $i < $contadorAgenda; $i++)
            {
                \App\PlanAuditoriaAgenda::create([

                    'PlanAuditoria_idAuditoria' => $id,
                    'Proceso_idProceso' => $request['Proceso_idProceso'][$i],
                    'Tercero_Auditado' => $request['Tercero_Auditado'][$i],
                    'Tercero_Auditor' => $request['Tercero_Auditor'][$i],
                    'fechaPlanAuditoriaAgenda' => $request['fechaPlanAuditoriaAgenda'][$i],
                    'horaInicioPlanAuditoriaAgenda' => $request['horaInicioPlanAuditoriaAgenda'][$i],
                    'horaFinPlanAuditoriaAgenda' => $request['horaFinPlanAuditoriaAgenda'][$i],
                    'lugarPlanAuditoriaAgenda' => $request['lugarPlanAuditoriaAgenda'][$i]
                ]);
            }

            return redirect('/planauditoria');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        \App\PlanAuditoria::destroy($id);
        return redirect('/planauditoria');
    }
}
