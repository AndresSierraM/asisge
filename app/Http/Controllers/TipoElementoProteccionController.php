<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\TipoElementoProteccionRequest;
use DB;
include public_path().'/ajax/consultarPermisos.php';

class TipoElementoProteccionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vista = basename($_SERVER["PHP_SELF"]);
        $datos = consultarPermisos($vista);

        if($datos != null)
            return view('tipoelementoprotecciongrid', compact('datos'));
        else
            return view('accesodenegado');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tipoelementoproteccion');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TipoElementoProteccionRequest $request)
    {
        \App\TipoElementoProteccion::create([
            'codigoTipoElementoProteccion' => $request['codigoTipoElementoProteccion'],
            'nombreTipoElementoProteccion' => $request['nombreTipoElementoProteccion'],
            'observacionTipoElementoProteccion' => $request['observacionTipoElementoProteccion'],
            'Compania_idCompania' => \Session::get('idCompania')
            ]);

        return redirect('/tipoelementoproteccion');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tipoelementoproteccion = \App\TipoElementoProteccion::find($id);
        return view ('tipoelementoproteccion',['tipoelementoproteccion'=>$tipoelementoproteccion]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TipoElementoProteccionRequest $request, $id)
    {
        $tipoelementoproteccion = \App\TipoElementoProteccion::find($id);
        $tipoelementoproteccion->fill($request->all());
        $tipoelementoproteccion->save();

        return redirect('/tipoelementoproteccion');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        \App\TipoElementoProteccion::destroy($id);
        return redirect('/tipoelementoproteccion');
    }
}
