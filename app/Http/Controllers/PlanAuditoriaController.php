<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\PlanAuditoriaRequest;
use App\Http\Controllers\Controller;
use DB;
include public_path().'/ajax/consultarPermisos.php';

class PlanAuditoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $vista = basename($_SERVER["PHP_SELF"]);
        $datos = consultarPermisos($vista);

        if($datos != null)
            return view('planauditoriagrid', compact('datos'));
        else
            return view('accesodenegado');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $centrocosto = \App\CentroCosto::where('Compania_idCompania', "=", \Session::get('idCompania'))->lists('nombreCentroCosto','idCentroCosto'); 
        $tercero = \App\Tercero::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('nombreCompletoTercero','idTercero');
        $idTercero = \App\Tercero::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('idTercero');
        $nombreCompletoTercero = \App\Tercero::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('nombreCompletoTercero');
        $idProceso = \App\Proceso::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('idProceso');
        $nombreProceso = \App\Proceso::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('nombreProceso');
        return view('planauditoria',compact('centrocosto','tercero','idTercero','nombreCompletoTercero','idProceso','nombreProceso'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(PlanAuditoriaRequest $request)
    {
        if($request['respuesta'] != 'falso')
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
                    'recursosPlanAuditoria' => $request['recursosPlanAuditoria'],
                    'observacionesPlanAuditoria' => $request['observacionesPlanAuditoria'],
                    'aprobacionPlanAuditoria' => $request['aprobacionPlanAuditoria'],
                    'fechaEntregaPlanAuditoria' => $request['fechaEntregaPlanAuditoria'],
                    'Compania_idCompania' => \Session::get('idCompania'),
                    'CentroCosto_idCentroCosto' => (($request['CentroCosto_idCentroCosto'] == '' or $request['CentroCosto_idCentroCosto'] == 0) ? null : $request['CentroCosto_idCentroCosto'])
                ]);

            $planAuditoria = \App\PlanAuditoria::All()->last();
            $contadorAcompanante = count($request['Tercero_idAcompanante']);
            for($i = 0; $i < $contadorAcompanante; $i++)
            {
                \App\PlanAuditoriaAcompanante::create([

                    'PlanAuditoria_idPlanAuditoria' => $planAuditoria->idPlanAuditoria,
                    'Tercero_idAcompanante' => $request['Tercero_idAcompanante'][$i]
                ]);
            }

            $contadorNotificado = count($request['Tercero_idNotificado']);
            for($i = 0; $i < $contadorNotificado; $i++)
            {
                \App\PlanAuditoriaNotificado::create([

                    'PlanAuditoria_idPlanAuditoria' => $planAuditoria->idPlanAuditoria,
                    'Tercero_idNotificado' => $request['Tercero_idNotificado'][$i]
                ]);
            }

            $contadorAgenda = count($request['Proceso_idProceso']);
            for($i = 0; $i < $contadorAgenda; $i++)
            {
                \App\PlanAuditoriaAgenda::create([

                    'PlanAuditoria_idPlanAuditoria' => $planAuditoria->idPlanAuditoria,
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
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id, Request $request)
    {
        
        $planAuditoriaS = DB::SELECT("
        SELECT pa.numeroPlanAuditoria,pa.fechaInicioPlanAuditoria,pa.fechaFinPlanAuditoria,
        pa.organismoPlanAuditoria,pa.Tercero_AuditorLider,pa.objetivoPlanAuditoria,pa.alcancePlanAuditoria,pa.criterioPlanAuditoria,pa.recursosPlanAuditoria,pa.observacionesPlanAuditoria,pa.aprobacionPlanAuditoria,pa.fechaEntregaPlanAuditoria,t.nombreCompletoTercero
        FROM planauditoria pa
        LEFT JOIN tercero t
        ON pa.Tercero_AuditorLider = t.idTercero
        where idPlanAuditoria =".$id);

        $PlanAuditoriaAcompananteS = DB::SELECT("
        SELECT t.nombreCompletoTercero
        FROM planauditoria pa
        LEFT JOIN planauditoriaacompanante paac
        ON pa.idPlanAuditoria = paac.PlanAuditoria_idPlanAuditoria
        LEFT JOIN tercero t
        ON paac.Tercero_idAcompanante = t.idTercero
        WHERE paac.PlanAuditoria_idPlanAuditoria =".$id);


        $PlanAuditoriaNotificadoS = DB::SELECT("
        SELECT tn.nombreCompletoTercero
        FROM planauditoria pa
        LEFT JOIN planauditorianotificado pan
        ON pa.idPlanAuditoria = pan.PlanAuditoria_idPlanAuditoria
        LEFT JOIN tercero tn
        ON pan.Tercero_idNotificado = tn.idTercero
        WHERE pan.PlanAuditoria_idPlanAuditoria =".$id);


        $planauditoriaagendaS = DB::SELECT("
        SELECT p.nombreProceso,ta.nombreCompletoTercero as auditado,paa.Tercero_Auditor,paa.fechaPlanAuditoriaAgenda,
        paa.horaInicioPlanAuditoriaAgenda,paa.horaFinPlanAuditoriaAgenda,paa.lugarPlanAuditoriaAgenda,tau.nombreCompletoTercero as auditor
        FROM
        planauditoria pa
        LEFT JOIN planauditoriaagenda paa
        ON paa.PlanAuditoria_idPlanAuditoria = pa.idPlanAuditoria
        LEFT JOIN proceso p 
        ON paa.Proceso_idProceso = p.idProceso
        LEFT JOIN tercero ta
        ON paa.Tercero_Auditado = ta.idTercero
        LEFT JOIN tercero tau
        ON paa.Tercero_Auditor = tau.idTercero
        WHERE paa.PlanAuditoria_idPlanAuditoria = ".$id);

        return view('formatos.planauditoriaimpresion',compact('planAuditoriaS','PlanAuditoriaAcompananteS','PlanAuditoriaNotificadoS','planauditoriaagendaS'));
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $centrocosto = \App\CentroCosto::where('Compania_idCompania', "=", \Session::get('idCompania'))->lists('nombreCentroCosto','idCentroCosto'); 
        $tercero = \App\Tercero::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('nombreCompletoTercero','idTercero');
        $idTercero = \App\Tercero::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('idTercero');
        $nombreCompletoTercero = \App\Tercero::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('nombreCompletoTercero');
        $idProceso = \App\Proceso::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('idProceso');
        $nombreProceso = \App\Proceso::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('nombreProceso');

        $planAuditoria = \App\PlanAuditoria::find($id);
        
        return view('planauditoria',compact('centrocosto','tercero','idTercero','nombreCompletoTercero','idProceso','nombreProceso'),['planAuditoria'=>$planAuditoria]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(PlanAuditoriaRequest $request, $id)
    {
        if($request['respuesta'] != 'falso')
        { 

            $planAuditoria = \App\PlanAuditoria::find($id);
            $planAuditoria->fill($request->all());
            $planAuditoria->CentroCosto_idCentroCosto = (($request['CentroCosto_idCentroCosto'] == '' or $request['CentroCosto_idCentroCosto'] == 0) ? null : $request['CentroCosto_idCentroCosto']);

            $planAuditoria->save();

            \App\PlanAuditoriaAcompanante::where('PlanAuditoria_idPlanAuditoria',$id)->delete();
            \App\PlanAuditoriaNotificado::where('PlanAuditoria_idPlanAuditoria',$id)->delete();
            \App\PlanAuditoriaAgenda::where('PlanAuditoria_idPlanAuditoria',$id)->delete();

            $contadorAcompanante = count($request['Tercero_idAcompanante']);
            for($i = 0; $i < $contadorAcompanante; $i++)
            {
                \App\PlanAuditoriaAcompanante::create([

                    'PlanAuditoria_idPlanAuditoria' => $id,
                    'Tercero_idAcompanante' => $request['Tercero_idAcompanante'][$i]
                ]);
            }

            $contadorNotificado = count($request['Tercero_idNotificado']);
            for($i = 0; $i < $contadorNotificado; $i++)
            {
                \App\PlanAuditoriaNotificado::create([

                    'PlanAuditoria_idPlanAuditoria' => $id,
                    'Tercero_idNotificado' => $request['Tercero_idNotificado'][$i]
                ]);
            }

            $contadorAgenda = count($request['Proceso_idProceso']);
            for($i = 0; $i < $contadorAgenda; $i++)
            {
                \App\PlanAuditoriaAgenda::create([

                    'PlanAuditoria_idPlanAuditoria' => $id,
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
