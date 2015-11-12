<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\ActaCapacitacionRequest;
use App\Http\Controllers\Controller;
use DB;

class ActaCapacitacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('actacapacitaciongrid');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {

        $planCapacitacion = DB::table('plancapacitacion as PC')
            ->leftJoin('plancapacitaciontema as PCT', 'PC.idPlanCapacitacion', '=', 'PCT.PlanCapacitacion_idPlanCapacitacion')
            ->where('dictadaPlanCapacitacionTema','=',0)
            ->groupBy('idPlanCapacitacion')
            ->lists('nombrePlanCapacitacion', 'idPlanCapacitacion');

//            print_r($planCapacitacion);
        $idTercero = \App\Tercero::All()->lists('idTercero');
        $nombreCompletoTercero = \App\Tercero::All()->lists('nombreCompletoTercero');
        return view('actacapacitacion',compact('planCapacitacion','idTercero','nombreCompletoTercero'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(ActaCapacitacionRequest $request)
    {
        if($request['respuesta'] != 'falso')
        {
            \App\ActaCapacitacion::create([
                'numeroActaCapacitacion' => $request['numeroActaCapacitacion'],
                'fechaElaboracionActaCapacitacion' => $request['fechaElaboracionActaCapacitacion'],
                'PlanCapacitacion_idPlanCapacitacion' => $request['PlanCapacitacion_idPlanCapacitacion'],
                'observacionesActaCapacitacion' => $request['observacionesActaCapacitacion']
                ]);

            $actaCapacitacion = \App\ActaCapacitacion::All()->last();
            $contadorDetalle = count($request['Tercero_idAsistente']);
            
            for($i = 0; $i < $contadorDetalle; $i++)
            {
                \App\ActaCapacitacionAsistente::create([

                    'ActaCapacitacion_idActaCapacitacion' => $actaCapacitacion->idActaCapacitacion,
                    'Tercero_idAsistente' => $request['Tercero_idAsistente'][$i]
                ]);
            }

            $contadorDetalle = count($request['nombrePlanCapacitacionTema']);
            for($i = 0; $i < $contadorDetalle; $i++)
            {
                $planCapacitacionTema = \App\PlanCapacitacionTema::find($request['idPlanCapacitacionTema'][$i]);
                
                $planCapacitacionTema->Tercero_idCapacitador = $request['Tercero_idCapacitador'][$i];
                $planCapacitacionTema->fechaPlanCapacitacionTema = $request['fechaPlanCapacitacionTema'][$i];
                $planCapacitacionTema->horaPlanCapacitacionTema = $request['horaPlanCapacitacionTema'][$i];
                $planCapacitacionTema->dictadaPlanCapacitacionTema = $request['dictadaPlanCapacitacionTema'][$i];
                
                $planCapacitacionTema->save();
            }
            return redirect('/actacapacitacion');
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
        $planCapacitacion = \App\PlanCapacitacion::find($request['idPlanCapacitacion']);
        $tercero = \App\Tercero::find($planCapacitacion->Tercero_idResponsable);
        if($request->ajax())
        {
            return response()->json([
                $planCapacitacion,
                $planCapacitacion->planCapacitacionTemas,
                $tercero
            ]);
        }  
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $planCapacitacion = \App\PlanCapacitacion::All()->lists('nombrePlanCapacitacion','idPlanCapacitacion');
        $idTercero = \App\Tercero::All()->lists('idTercero');
        $nombreCompletoTercero = \App\Tercero::All()->lists('nombreCompletoTercero');

        $actaCapacitacion = \App\ActaCapacitacion::find($id);
        return view('actacapacitacion',compact('planCapacitacion','idTercero','nombreCompletoTercero'),['actaCapacitacion'=>$actaCapacitacion]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(ActaCapacitacionRequest $request, $id)
    {
        if($request['respuesta'] != 'falso')
        {
            $actaCapacitacion = \App\ActaCapacitacion::find($id);
            $actaCapacitacion->fill($request->all());

            $actaCapacitacion->save();

            \App\ActaCapacitacionAsistente::where('ActaCapacitacion_idActaCapacitacion',$id)->delete();

            $contadorDetalle = count($request['Tercero_idAsistente']);
            
            for($i = 0; $i < $contadorDetalle; $i++)
            {
                \App\ActaCapacitacionAsistente::create([

                    'ActaCapacitacion_idActaCapacitacion' => $actaCapacitacion->idActaCapacitacion,
                    'Tercero_idAsistente' => $request['Tercero_idAsistente'][$i]
                ]);
            }

            $contadorDetalle = count($request['nombrePlanCapacitacionTema']);
            for($i = 0; $i < $contadorDetalle; $i++)
            {
                $planCapacitacionTema = \App\PlanCapacitacionTema::find($request['idPlanCapacitacionTema'][$i]);
                
                $planCapacitacionTema->Tercero_idCapacitador = $request['Tercero_idCapacitador'][$i];
                $planCapacitacionTema->fechaPlanCapacitacionTema = $request['fechaPlanCapacitacionTema'][$i];
                $planCapacitacionTema->horaPlanCapacitacionTema = $request['horaPlanCapacitacionTema'][$i];
                $planCapacitacionTema->dictadaPlanCapacitacionTema = $request['dictadaPlanCapacitacionTema'][$i];
                
                $planCapacitacionTema->save();
            }
            return redirect('/actacapacitacion');
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
        \App\ActaCapacitacion::destroy($id);
        return redirect('/actacapacitacion');
    }
}
