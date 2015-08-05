<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\TipoIdentificacionRequest;
use App\Http\Controllers\Controller;

class TipoIdentificacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $tipoidentificacion = \App\TipoIdentificacion::All();
        return view('tipoidentificaciongrid',compact('tipoidentificacion'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('tipoidentificacion');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(TipoIdentificacionRequest $request)
    {
        \App\TipoIdentificacion::create([
            'codigoTipoIdentificacion' => $request['codigoTipoIdentificacion'],
            'nombreTipoIdentificacion' => $request['nombreTipoIdentificacion'],
            ]);

        return redirect('/tipoidentificacion');
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
        $tipoidentificacion = \App\TipoIdentificacion::find($id);
        return view('tipoidentificacion',['tipoidentificacion'=>$tipoidentificacion]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update($id,TipoIdentificacionRequest $request)
    {
        
        $tipoidentificacion = \App\TipoIdentificacion::find($id);
        $tipoidentificacion->fill($request->all());
        $tipoidentificacion->save();

        return redirect('/tipoidentificacion');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    

    public function destroy($id)
    {
        \App\TipoIdentificacion::destroy($id);
        return redirect('/tipoidentificacion');
    }
}
