<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\AccidenteRequest;

use Illuminate\Routing\Route;

class AccidenteController extends Controller
{
    public function _construct(){
        $this->beforeFilter('@find',['only'=>['edit','update','destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function find(Route $route){
        $this->accidente = \App\Accidente::find($route->getParameter('accidente'));
        return $this->accidente;
    }

    public function index()
    {
        return view('accidentegrid');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $tercero = \App\Tercero::All()->lists('nombreCompletoTercero','idTercero');
        return view('accidente',compact('tercero'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(AccidenteRequest $request)
    {

        \App\Accidente::create([

            'numeroAccidente' => $request['numeroAccidente'],
            'nombreAccidente' => $request['nombreAccidente'],
            'clasificacionAccidente' => $request['clasificacionAccidente'],
            'Tercero_idCoordinador' => $request['Tercero_idCoordinador'],
            'enSuLaborAccidente' => (isset($request['enSuLaborAccidente']) ? 1 : 0),
            'enLaEmpresaAccidente' => (isset($request['enLaEmpresaAccidente']) ? 1 : 0),
            'lugarAccidente' => $request['lugarAccidente'],
            'fechaOcurrenciaAccidente' => $request['fechaOcurrenciaAccidente'],
            'tiempoEnLaborAccidente' => $request['tiempoEnLaborAccidente'],
            'tareaDesarrolladaAccidente' => $request['tareaDesarrolladaAccidente'],
            'descripcionAccidente' => $request['descripcionAccidente'],
            'observacionTrabajadorAccidente' => $request['observacionTrabajadorAccidente'],
            'observacionEmpresaAccidente' => $request['observacionEmpresaAccidente'],
            'agenteYMecanismoAccidente' => $request['agenteYMecanismoAccidente'],
            'naturalezaLesionAccidente' => $request['naturalezaLesionAccidente'],
            'parteCuerpoAfectadaAccidente' => $request['parteCuerpoAfectadaAccidente'],
            'tipoAccidente' => $request['tipoAccidente'],
            'observacionAccidente'  => $request['observacionAccidente']

            ]);

        return redirect('/accidente');
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
        $accidente = \App\Accidente::find($id);
        $tercero = \App\Tercero::All()->lists('nombreCompletoTercero','idTercero');
        return view('accidente',compact('tercero'),['accidente'=>$accidente]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(AccidenteRequest $request, $id)
    {
        $accidente = \App\Accidente::find($id);
        $accidente->fill($request->all());
        
        $accidente->save();

       return redirect('/accidente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        \App\Accidente::destroy($id);
        return redirect('/accidente');
    }
}
