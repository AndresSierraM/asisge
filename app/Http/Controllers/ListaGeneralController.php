<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
include public_path().'/ajax/consultarPermisos.php';

class ListaGeneralController extends Controller
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
            return view('listageneralgrid', compact('datos'));
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
        return view('listageneral');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        \App\ListaGeneral::create([
            'codigoListaGeneral' => $request['codigoListaGeneral'],
            'nombreListaGeneral' => $request['nombreListaGeneral'],
            'tipoListaGeneral' => $request['tipoListaGeneral'],
            'observacionListaGeneral' => $request['observacionListaGeneral'],
            ]);

        return redirect('/listageneral');
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
        $listaGeneral = \App\ListaGeneral::find($id);
        return view('listageneral',['listaGeneral'=>$listaGeneral]);
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
        $listaGeneral = \App\ListaGeneral::find($id);
        $listaGeneral->fill($request->all());
        $listaGeneral->save();

        return redirect('/listageneral');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        \App\ListaGeneral::destroy($id);
        return redirect('/listageneral');
    }
}
