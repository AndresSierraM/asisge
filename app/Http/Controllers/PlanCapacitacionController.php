<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\PlanCapacitacionRequest;
use App\Http\Controllers\Controller;

class PlanCapacitacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('plancapacitaciongrid');
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
        return view('plancapacitacion',compact('tercero','idTercero','nombreCompletoTercero'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(PlanCapacitacionRequest $request)
    {
        if($request['respuesta'] != 'falso')
        {
            \App\PlanCapacitacion::create([
                'tipoPlanCapacitacion' => $request['tipoPlanCapacitacion'],
                'nombrePlanCapacitacion' => $request['nombrePlanCapacitacion'],
                'objetivoPlanCapacitacion' => $request['objetivoPlanCapacitacion'],
                'Tercero_idResponsable' => $request['Tercero_idResponsable'],
                'personalInvolucradoPlanCapacitacion' => $request['personalInvolucradoPlanCapacitacion'],
                'fechaInicioPlanCapacitacion' => $request['fechaInicioPlanCapacitacion'],
                'fechaFinPlanCapacitacion' => $request['fechaFinPlanCapacitacion'],
                'metodoEficaciaPlanCapacitacion' => $request['metodoEficaciaPlanCapacitacion']
                ]);

            $planCapacitacion = \App\PlanCapacitacion::All()->last();
            $contadorDetalle = count($request['nombrePlanCapacitacionTema']);
            for($i = 0; $i < $contadorDetalle; $i++)
            {
                \App\PlanCapacitacionTema::create([

                    'PlanCapacitacion_idPlanCapacitacion' => $planCapacitacion->idPlanCapacitacion,
                    'nombrePlanCapacitacionTema' => $request['nombrePlanCapacitacionTema'][$i],
                    'Tercero_idCapacitador' => $request['Tercero_idCapacitador'][$i],
                    'fechaPlanCapacitacionTema' => $request['fechaPlanCapacitacionTema'][$i],
                    'horaPlanCapacitacionTema' => $request['horaPlanCapacitacionTema'][$i],
                    'dictadaPlanCapacitacionTema' => 0,
                    'cumpleObjetivoPlanCapacitacionTema' =>0
                ]);
            }

            return redirect('/plancapacitacion');
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

        $planCapacitacion = \App\PlanCapacitacion::find($id);
        return view('plancapacitacion',compact('tercero','idTercero','nombreCompletoTercero'),['planCapacitacion'=>$planCapacitacion]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(PlanCapacitacionRequest $request, $id)
    {
        if($request['respuesta'] != 'falso')
        {
            $planCapacitacion = \App\PlanCapacitacion::find($id);
            $planCapacitacion->fill($request->all());

            $planCapacitacion->save();

            \App\PlanCapacitacionTema::where('PlanCapacitacion_idPlanCapacitacion',$id)->delete();

           $contadorDetalle = count($request['nombrePlanCapacitacionTema']);
            for($i = 0; $i < $contadorDetalle; $i++)
            {
                \App\PlanCapacitacionTema::create([

                    'PlanCapacitacion_idPlanCapacitacion' => $planCapacitacion->idPlanCapacitacion,
                    'nombrePlanCapacitacionTema' => $request['nombrePlanCapacitacionTema'][$i],
                    'Tercero_idCapacitador' => $request['Tercero_idCapacitador'][$i],
                    'fechaPlanCapacitacionTema' => $request['fechaPlanCapacitacionTema'][$i],
                    'horaPlanCapacitacionTema' => $request['horaPlanCapacitacionTema'][$i],
                    'dictadaPlanCapacitacionTema' => 0,
                    'cumpleObjetivoPlanCapacitacionTema' => 0
                ]);
            }

            return redirect('/plancapacitacion');
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
        \App\PlanCapacitacion::destroy($id);
        return redirect('/plancapacitacion');
    }
}
