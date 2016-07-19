<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\ExpideNormaLegalRequest;
use App\Http\Controllers\Controller;
use DB;
include public_path().'/ajax/consultarPermisos.php';

class ExpideNormaLegalController extends Controller
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

        return view('expidenormalegalgrid', compact('datos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('expidenormalegal');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(ExpideNormaLegalRequest $request)
    {
        \App\ExpideNormaLegal::create([
            'codigoExpideNormaLegal' => $request['codigoExpideNormaLegal'],
            'nombreExpideNormaLegal' => $request['nombreExpideNormaLegal'],
            ]);

        return redirect('/expidenormalegal');
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
        $expidenormalegal = \App\ExpideNormaLegal::find($id);
        return view('expidenormalegal',['expidenormalegal'=>$expidenormalegal]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update($id,ExpideNormaLegalRequest $request)
    {
        
        $expidenormalegal = \App\ExpideNormaLegal::find($id);
        $expidenormalegal->fill($request->all());
        $expidenormalegal->save();

        return redirect('/expidenormalegal');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    

    public function destroy($id)
    {
        \App\ExpideNormaLegal::destroy($id);
        return redirect('/expidenormalegal');
    }
}
