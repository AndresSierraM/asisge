<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\GrupoApoyoRequest;
use App\Http\Controllers\Controller;

class GrupoApoyoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('grupoapoyogrid');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('grupoapoyo');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(GrupoApoyoRequest $request)
    {
        \App\GrupoApoyo::create([
            'codigoGrupoApoyo' => $request['codigoGrupoApoyo'],
            'nombreGrupoApoyo' => $request['nombreGrupoApoyo'],
            'convocatoriaVotacionGrupoApoyo' => $request['convocatoriaVotacionGrupoApoyo'],
            'actaEscrutinioGrupoApoyo' => $request['actaEscrutinioGrupoApoyo'],
            'actaConstitucionGrupoApoyo' => $request['actaConstitucionGrupoApoyo']
            ]);

        return redirect('/grupoapoyo');
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
        $grupoApoyo = \App\GrupoApoyo::find($id);
        return view('grupoapoyo',['grupoApoyo'=>$grupoApoyo]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(GrupoApoyoRequest $request, $id)
    {
        $grupoApoyo = \App\GrupoApoyo::find($id);
        $grupoApoyo->fill($request->all());
        $grupoApoyo->save();

        return redirect('/grupoapoyo');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        \App\GrupoApoyo::destroy($id);
        return redirect('/grupoapoyo');
    }
}
