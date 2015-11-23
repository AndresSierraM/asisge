<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class CargoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('cargogrid');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $idListaTarea = \App\ListaGeneral::All()->lists('idListaGeneral');
        $nombreListaTarea = \App\ListaGeneral::All()->lists('nombreListaGeneral');
        return view('cargo',compact('idListaTarea','nombreListaTarea'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        \App\Cargo::create([
            'codigoCargo' => $request['codigoCargo'],
            'nombreCargo' => $request['nombreCargo'],
            'salarioBaseCargo' => $request['salarioBaseCargo'],
            'nivelRiesgoCargo' => $request['nivelRiesgoCargo'],
            'objetivoCargo' => $request['objetivoCargo'],
            'educacionCargo' => $request['educacionCargo'],
            'experienciaCargo' => $request['experienciaCargo'],
            'formacionCargo' => $request['formacionCargo'],
            'posicionPredominanteCargo' => $request['posicionPredominanteCargo'],
            'restriccionesCargo' => $request['restriccionesCargo'],
            'habilidadesCargo' => $request['habilidadesCargo'],
            'responsabilidadesCargo' => $request['responsabilidadesCargo'],
            'autoridadesCargo' => $request['autoridadesCargo']
            ]);
        return redirect('/cargo');

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
        $cargo = \App\Cargo::find($id);
        return view('cargo',['cargo'=>$cargo]);
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
        $cargo = \App\Cargo::find($id);
        $cargo->fill($request->all());

        $cargo->save();

        return redirect('/cargo');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        \App\Cargo::destroy($id);
        return redirect('/cargo');
    }
}
