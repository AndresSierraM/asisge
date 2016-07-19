<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\TipoNormaLegalRequest;
use App\Http\Controllers\Controller;
use DB;
include public_path().'/ajax/consultarPermisos.php';

class TipoNormaLegalController extends Controller
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

        return view('tiponormalegalgrid', compact('datos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('tiponormalegal');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(TipoNormaLegalRequest $request)
    {
        \App\TipoNormaLegal::create([
            'codigoTipoNormaLegal' => $request['codigoTipoNormaLegal'],
            'nombreTipoNormaLegal' => $request['nombreTipoNormaLegal'],
            ]);

        return redirect('/tiponormalegal');
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
        $tiponormalegal = \App\TipoNormaLegal::find($id);
        return view('tiponormalegal',['tiponormalegal'=>$tiponormalegal]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update($id,TipoNormaLegalRequest $request)
    {
        
        $tiponormalegal = \App\TipoNormaLegal::find($id);
        $tiponormalegal->fill($request->all());
        $tiponormalegal->save();

        return redirect('/tiponormalegal');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    

    public function destroy($id)
    {
        \App\TipoNormaLegal::destroy($id);
        return redirect('/tiponormalegal');
    }
}
