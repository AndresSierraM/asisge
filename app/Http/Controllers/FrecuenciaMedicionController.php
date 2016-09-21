<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\FrecuenciaMedicionRequest;
use App\Http\Controllers\Controller;
use DB;
include public_path().'/ajax/consultarPermisos.php';

class FrecuenciaMedicionController extends Controller
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
            return view('frecuenciamediciongrid', compact('datos'));
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
        return view('frecuenciamedicion');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(FrecuenciaMedicionRequest $request)
    {
        \App\FrecuenciaMedicion::create([
            'codigoFrecuenciaMedicion' => $request['codigoFrecuenciaMedicion'],
            'nombreFrecuenciaMedicion' => $request['nombreFrecuenciaMedicion'],
            'valorFrecuenciaMedicion' => $request['valorFrecuenciaMedicion'],
            'unidadFrecuenciaMedicion' => $request['unidadFrecuenciaMedicion']
            ]);

        return redirect('/frecuenciamedicion');
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
        $frecuenciamedicion = \App\FrecuenciaMedicion::find($id);
        return view('frecuenciamedicion',['frecuenciamedicion'=>$frecuenciamedicion]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update($id,FrecuenciaMedicionRequest $request)
    {
        
        $frecuenciamedicion = \App\FrecuenciaMedicion::find($id);
        $frecuenciamedicion->fill($request->all());
        $frecuenciamedicion->save();

        return redirect('/frecuenciamedicion');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    

    public function destroy($id)
    {
        \App\FrecuenciaMedicion::destroy($id);
        return redirect('/frecuenciamedicion');
    }
}
