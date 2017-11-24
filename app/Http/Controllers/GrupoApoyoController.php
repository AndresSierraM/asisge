<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\GrupoApoyoRequest;
use App\Http\Controllers\Controller;
use DB;
include public_path().'/ajax/consultarPermisos.php';

class GrupoApoyoController extends Controller
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
            return view('grupoapoyogrid', compact('datos'));
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
        $frecuenciaMedicion = \App\FrecuenciaMedicion::All()->lists('nombreFrecuenciaMedicion','idFrecuenciaMedicion');

        return view('grupoapoyo', compact('frecuenciaMedicion'));
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
            'fechaConformacionGrupoApoyo' => $request['fechaConformacionGrupoApoyo'],
            'fechaVencimientoGrupoApoyo' => $request['fechaVencimientoGrupoApoyo'],
            // 'convocatoriaVotacionGrupoApoyo' => $request['convocatoriaVotacionGrupoApoyo'],
            // 'actaEscrutinioGrupoApoyo' => $request['actaEscrutinioGrupoApoyo'],
            // 'actaConstitucionGrupoApoyo' => $request['actaConstitucionGrupoApoyo'],
            'FrecuenciaMedicion_idFrecuenciaMedicion' => $request['FrecuenciaMedicion_idFrecuenciaMedicion'],
            'Compania_idCompania' => \Session::get('idCompania')
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
        $frecuenciaMedicion = \App\FrecuenciaMedicion::All()->lists('nombreFrecuenciaMedicion','idFrecuenciaMedicion');

        return view('grupoapoyo', compact('frecuenciaMedicion'), ['grupoApoyo'=>$grupoApoyo]);
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
        $grupoApoyo->FrecuenciaMedicion_idFrecuenciaMedicion = (($request['FrecuenciaMedicion_idFrecuenciaMedicion'] == '' or $request['FrecuenciaMedicion_idFrecuenciaMedicion'] == 0) ? null : $request['FrecuenciaMedicion_idFrecuenciaMedicion'
                    ]);

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
