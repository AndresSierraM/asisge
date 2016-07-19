<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\ProcesoRequest;
use App\Http\Controllers\Controller;
use DB;
include public_path().'/ajax/consultarPermisos.php';

class ProcesoController extends Controller
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

        return view('procesogrid', compact('datos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('proceso');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(ProcesoRequest $request)
    {
        \App\Proceso::create([
            'codigoProceso' => $request['codigoProceso'],
            'nombreProceso' => $request['nombreProceso'],
            'Compania_idCompania' => \Session::get("idCompania")
            ]);

        return redirect('/proceso');
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
        $proceso = \App\Proceso::find($id);
        return view('proceso',['proceso'=>$proceso]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update($id,ProcesoRequest $request)
    {
        
        $proceso = \App\Proceso::find($id);
        $proceso->fill($request->all());
        $proceso->save();

        return redirect('/proceso');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    

    public function destroy($id)
    {
        \App\Proceso::destroy($id);
        return redirect('/proceso');
    }
}
