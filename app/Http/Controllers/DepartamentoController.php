<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\DepartamentoRequest;

use App\Http\Controllers\PaisController;

class DepartamentoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */

    public function index()
    {
        return view('departamentogrid');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $pais = \App\Pais::All()->lists('nombrePais','idPais');
        return view('departamento',compact('pais','selected'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(DepartamentoRequest $request)
    {

        \App\Departamento::create([
            'codigoDepartamento' => $request['codigoDepartamento'],
            'nombreDepartamento' => $request['nombreDepartamento'],
            'Pais_idPais' => $request['Pais_idPais'],
            ]);

        return redirect('/departamento');
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
        $departamento = \App\Departamento::find($id);
        $pais = \App\Pais::All()->lists('nombrePais','idPais');
        return view('departamento',compact('pais'),['departamento'=>$departamento]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(DepartamentoRequest $request, $id)
    {
        $departamento = \App\Departamento::find($id);
        $departamento->fill($request->all());
        $departamento->save();

        return redirect('/departamento');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        \App\Departamento::destroy($id);
        return redirect('/departamento');
    }
}
