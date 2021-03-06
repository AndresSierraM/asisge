<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\ClasificacionRiesgoRequest;
use App\Http\Controllers\Controller;
use DB;
include public_path().'/ajax/consultarPermisos.php';

class ClasificacionRiesgoController extends Controller
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
            return view('clasificacionriesgogrid', compact('datos'));
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
        return view('clasificacionriesgo');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(ClasificacionRiesgoRequest $request)
    {
        \App\ClasificacionRiesgo::create([
            'codigoClasificacionRiesgo' => $request['codigoClasificacionRiesgo'],
            'nombreClasificacionRiesgo' => $request['nombreClasificacionRiesgo'],
            ]);

        return redirect('/clasificacionriesgo');
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
        $clasificacionRiesgo = \App\ClasificacionRiesgo::find($id);
        return view('clasificacionriesgo',['clasificacionRiesgo'=>$clasificacionRiesgo]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(ClasificacionRiesgoRequest $request, $id)
    {
        $clasificacionRiesgo = \App\ClasificacionRiesgo::find($id);
        $clasificacionRiesgo->fill($request->all());
        $clasificacionRiesgo->save();

        return redirect('/clasificacionriesgo');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        \App\ClasificacionRiesgo::destroy($id);
        return redirect('/clasificacionriesgo');
    }
}
