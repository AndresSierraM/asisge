<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Departamento;
use App\Http\Requests\CiudadRequest;

use Illuminate\Routing\Route;
use DB;
include public_path().'/ajax/consultarPermisos.php';

class CiudadController extends Controller
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
        $this->ciudad = \App\Ciudad::find($route->getParameter('ciudad'));
        return $this->ciudad;
    }

    public function index()
    {
        $vista = basename($_SERVER["PHP_SELF"]);
        $datos = consultarPermisos($vista);

        return view('ciudadgrid', compact('datos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $departamento = \App\Departamento::All()->lists('nombreDepartamento','idDepartamento');
       return view('ciudad',compact('departamento'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(CiudadRequest $request)
    {
        \App\Ciudad::create([
            'codigoCiudad' => $request['codigoCiudad'],
            'nombreCiudad' => $request['nombreCiudad'],
            'Departamento_idDepartamento' => $request['Departamento_idDepartamento'],
            ]);
        return redirect('/ciudad');
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
        $ciudad = \App\Ciudad::find($id);
        $departamento = \App\Departamento::All()->lists('nombreDepartamento','idDepartamento');
        return view('ciudad',compact('departamento'),['ciudad'=>$ciudad]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(CiudadRequest $request, $id)
    {
        $ciudad = \App\Ciudad::find($id);
        $ciudad->fill($request->all());
        $ciudad->save();

        return redirect('/ciudad');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        \App\Ciudad::destroy($id);
        return redirect('/ciudad');
    }
}
