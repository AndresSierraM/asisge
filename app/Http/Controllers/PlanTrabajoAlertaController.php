<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PlanTrabajoAlertaRequest;
use App\Http\Controllers\Controller;
use DB;


include public_path().'/ajax/consultarPermisos.php';

class PlanTrabajoAlertaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vista = basename($_SERVER["PHP_SELF"]);
        $datos = consultarPermisos($vista);

        if($datos != null)
            return view('plantrabajoalertagrid', compact('datos'));
        else
            return view('accesodenegado');
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         $idModulo= \App\Modulo::All()->lists('idModulo');
         $nombreModulo= \App\Modulo::All()->lists('nombreModulo');
        return view ('plantrabajoalerta', compact('idModulo','nombreModulo'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PlanTrabajoAlertaRequest $request)
    {
        return;
        // se agrega un if para la condicion de que el usuario ingresa el primer campo tareaFechaInicioPlanTrabajoAlerta para saber en que calendario esta trabajando
        if($request ['tareaFechaInicioPlanTrabajoAlertaDia'] != '')
        {
          \App\PlanTrabajoAlerta::create([
            'nombrePlanTrabajoAlerta' => $request['nombrePlanTrabajoAlerta'],
            'correoParaPlanTrabajoAlerta' => $request['correoParaPlanTrabajoAlerta'],
            'correoCopiaPlanTrabajoAlerta' => $request['correoCopiaPlanTrabajoAlerta'],
            'correoCopiaOcultaPlanTrabajoAlerta' => $request['correoCopiaOcultaPlanTrabajoAlerta'],
            'correoAsuntoPlanTrabajoAlerta' => $request ['correoAsuntoPlanTrabajoAlerta'],
            'correoMensajePlanTrabajoAlerta' => $request ['correoMensajePlanTrabajoAlerta'],
            'tareaFechaInicioPlanTrabajoAlerta' => $request ['tareaFechaInicioPlanTrabajoAlertaDia'],
            'tareaHoraPlanTrabajoAlerta' => $request ['tareaHoraPlanTrabajoAlertaDia'],
            'tareaIntervaloPlanTrabajoAlerta' => $request ['tareaIntervaloPlanTrabajoAlertaDia'],
            'tareaDiaLaboralPlanTrabajoAlerta' => $request ['tareaDiaLaboralPlanTrabajoAlerta'],
            'filtroMesesPasadosPlanTrabajoAlerta' => $request ['filtroMesesPasadosPlanTrabajoAlerta'],
            'filtroMesesFuturosPlanTrabajoAlerta' => $request ['filtroMesesFuturosPlanTrabajoAlerta'],
            'filtroEstadosPlanTrabajoAlerta' => $request ['filtroEstadosPlanTrabajoAlerta'],
            ]);
        }
        else
        {
            if($request ['tareaFechaInicioPlanTrabajoAlertaSemana'] != '')
            {

                \App\PlanTrabajoAlerta::create([
                'nombrePlanTrabajoAlerta' => $request['nombrePlanTrabajoAlerta'],
                'correoParaPlanTrabajoAlerta' => $request['correoParaPlanTrabajoAlerta'],
                'correoCopiaPlanTrabajoAlerta' => $request['correoCopiaPlanTrabajoAlerta'],
                'correoCopiaOcultaPlanTrabajoAlerta' => $request['correoCopiaOcultaPlanTrabajoAlerta'],
                'correoAsuntoPlanTrabajoAlerta' => $request ['correoAsuntoPlanTrabajoAlerta'],
                'correoMensajePlanTrabajoAlerta' => $request ['correoMensajePlanTrabajoAlerta'],
                'tareaFechaInicioPlanTrabajoAlerta' => $request ['tareaFechaInicioPlanTrabajoAlertaSemana'],
                'tareaHoraPlanTrabajoAlerta' => $request ['tareaHoraPlanTrabajoAlertaSemana'],
                'tareaIntervaloPlanTrabajoAlerta' => $request ['tareaIntervaloPlanTrabajoAlertaSemana'],
                'tareaDiasPlanTrabajoAlerta' => $request ['tareaDiasPlanTrabajoAlerta'],
                'filtroMesesPasadosPlanTrabajoAlerta' => $request ['filtroMesesPasadosPlanTrabajoAlerta'],
                'filtroMesesFuturosPlanTrabajoAlerta' => $request ['filtroMesesFuturosPlanTrabajoAlerta'],
                'filtroEstadosPlanTrabajoAlerta' => $request ['filtroEstadosPlanTrabajoAlerta'],

                ]);
            }
            else
            {

              \App\PlanTrabajoAlerta::create([
                'nombrePlanTrabajoAlerta' => $request['nombrePlanTrabajoAlerta'],
                'correoParaPlanTrabajoAlerta' => $request['correoParaPlanTrabajoAlerta'],
                'correoCopiaPlanTrabajoAlerta' => $request['correoCopiaPlanTrabajoAlerta'],
                'correoCopiaOcultaPlanTrabajoAlerta' => $request['correoCopiaOcultaPlanTrabajoAlerta'],
                'correoAsuntoPlanTrabajoAlerta' => $request ['correoAsuntoPlanTrabajoAlerta'],
                'correoMensajePlanTrabajoAlerta' => $request ['correoMensajePlanTrabajoAlerta'],
                'tareaFechaInicioPlanTrabajoAlerta' => $request ['tareaFechaInicioPlanTrabajoAlertaMes'],
                'tareaHoraPlanTrabajoAlerta' => $request ['tareaHoraPlanTrabajoAlertaMes'],
                'tareaMesesPlanTrabajoAlerta' => $request ['tareaMesesPlanTrabajoAlerta'],
                'filtroMesesPasadosPlanTrabajoAlerta' => $request ['filtroMesesPasadosPlanTrabajoAlerta'],
                'filtroMesesFuturosPlanTrabajoAlerta' => $request ['filtroMesesFuturosPlanTrabajoAlerta'],
                'filtroEstadosPlanTrabajoAlerta' => $request ['filtroEstadosPlanTrabajoAlerta'],
                ]);
            }
        }

        // consultar el id del plantrabajoalerta para llenarlo en el detalle 
        $id = \App\PlanTrabajoAlerta::All()->last();


        // Guardamos el detalle de los modulos
        for($i = 0; $i < count($request['Modulo_idModulo']); $i++)
        {
            \App\PlanTrabajoAlertaModulo::create([
                'PlanTrabajoAlerta_idPlanTrabajoAlerta' => $id->idPlanTrabajoAlerta,
                'Modulo_idModulo' => $request['Modulo_idModulo'][$i]
               ]); 
        }

        return redirect('/plantrabajoalerta');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        if(isset($request['accion']) and $request['accion'] == 'imprimir')
        {
            $plantrabajo = DB::Select('
                SELECT *
                FROM plantrabajoalerta pta
                LEFT JOIN plantrabajoalertamodulo ptam
                ON pta.idPlanTrabajoAlerta = ptam.PlanTrabajoAlerta_idPlanTrabajoAlerta
                WHERE idPlanTrabajoAlerta = '.$id);

            return view('formatos.plantrabajoalertaimpresion',compact('plantrabajo'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $plantrabajoalerta = \App\PlanTrabajoAlerta::find($id);
        $idModulo= \App\Modulo::All()->lists('idModulo');
        $nombreModulo= \App\Modulo::All()->lists('nombreModulo');
        return view ('plantrabajoalerta',['plantrabajoalerta'=>$plantrabajoalerta], compact('idModulo','nombreModulo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PlanTrabajoAlertaRequest $request, $id)
    {
        return;
        $plantrabajoalerta = \App\PlanTrabajoAlerta::find($id);
        $plantrabajoalerta->fill($request->all());
        $plantrabajoalerta->save();

        // Guardamos el detalle de los modulos
        for($i = 0; $i < count($request['Modulo_idModulo']); $i++)
        {
            \App\PlanTrabajoAlertaModulo::create([
                'PlanTrabajoAlerta_idPlanTrabajoAlerta' => $id,
                'Modulo_idModulo' => $request['Modulo_idModulo'][$i]
               ]); 
        }

        return redirect('plantrabajoalerta');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         \App\PlanTrabajoAlerta::destroy($id);
        return redirect('/plantrabajoalerta');
    }
}
