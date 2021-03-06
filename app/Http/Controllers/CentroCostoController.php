<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\CentroCostoRequest;
use App\Http\Controllers\Controller;
use DB;
include public_path().'/ajax/consultarPermisos.php';

class CentroCostoController extends Controller
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
            return view('centrocostogrid', compact('datos'));
        else
            return view('accesodenegado');
        // return view('centrocosto.blade');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('centrocosto');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(CentroCostoRequest $request)
    {
        \App\CentroCosto::create([
            'codigoCentroCosto' => $request['codigoCentroCosto'],
            'nombreCentroCosto' => $request['nombreCentroCosto'],
            'Compania_idCompania' => \Session::get("idCompania")

            ]);



        return redirect('/centrocosto');
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
        $centrocosto = \App\CentroCosto::find($id);
        return view('centrocosto',['centrocosto'=>$centrocosto]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update($id,CentroCostoRequest $request)
    {
        
        $centrocosto = \App\CentroCosto::find($id);
        $centrocosto->fill($request->all());
        $centrocosto->save();

        return redirect('/centrocosto');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    

    public function destroy($id)
    {
         \App\CentroCosto::destroy($id);
        return redirect('/centrocosto');
    }
}
