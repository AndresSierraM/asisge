<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

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
        $planCapacitacion = \App\PlanCapacitacion::All()->lists('nombrePlanCapacitacion','idPlanCapacitacion');
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
    public function store(Request $request)
    {
            \App\ActaCapacitacion::create([
                'numeroActaCapacitacion' => $request['numeroActaCapacitacion'],
                'fechaElaboracionActaCapacitacion' => $request['fechaElaboracionActaCapacitacion'],
                'PlanCapacitacion_idPlanCapacitacion' => $request['PlanCapacitacion_idPlanCapacitacion'],
                'observacionesActaCapacitacion' => $request['observacionesActaCapacitacion']
                ]);

            $actaCapacitacion = \App\ActaCapacitacion::All()->last();
            $contadorDetalle = count($request['ActaCapacitacion_idActaCapacitacion']);
            
            for($i = 0; $i < $contadorDetalle; $i++)
            {
                \App\ActaCapacitacionAsistente::create([

                    'ActaCapacitacion_idActaCapacitacion' => $actaCapacitacion->idActaCapacitacion,
                    'Tercero_idAsistente' => $request['Tercero_idAsistente'][$i]
                ]);
            }

            return redirect('/actacapacitacion');
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
    public function update(Request $request, $id)
    {
            $actaCapacitacion = \App\ActaCapacitacion::find($id);
            $actaCapacitacion->fill($request->all());

            $actaCapacitacion->save();

            \App\ActaCapacitacionAsistente::where('ActaCapacitacion_idActaCapacitacion',$id)->delete();

            $contadorDetalle = count($request['ActaCapacitacion_idActaCapacitacion']);
            
            for($i = 0; $i < $contadorDetalle; $i++)
            {
                \App\ActaCapacitacionAsistente::create([

                    'ActaCapacitacion_idActaCapacitacion' => $actaCapacitacion->idActaCapacitacion,
                    'Tercero_idAsistente' => $request['Tercero_idAsistente'][$i]
                ]);
            }

            return redirect('/actacapacitacion');
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
