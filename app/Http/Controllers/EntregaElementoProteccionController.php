<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\EntregaElementoProteccionRequest;
use DB;

class EntregaElementoProteccionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('entregaelementoprotecciongrid');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tercero = \App\Tercero::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('nombreCompletoTercero','idTercero');
        $idElementoProteccion = \App\ElementoProteccion::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('idElementoProteccion');
        $nombreElementoProteccion = \App\ElementoProteccion::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('nombreElementoProteccion');
        return view('entregaelementoproteccion',compact('tercero','idElementoProteccion','nombreElementoProteccion'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        \App\EntregaElementoProteccion::create([
        'Tercero_idTercero' => $request['Tercero_idTercero'],
        'fechaEntregaElementoProteccion' => $request['fechaEntregaElementoProteccion'],
        'Compania_idCompania' => \Session::get('idCompania')
        ]);

        $entregaelementoproteccion = \App\EntregaElementoProteccion::All()->last();
        $contadorelementoproteccion = count($request['cantidadEntregaElementoProteccionDetalle']);
        for($i = 0; $i < $contadorelementoproteccion; $i++)
        {
            \App\EntregaElementoProteccionDetalle::create([
            'EntregaElementoProteccion_idEntregaElementoProteccion' => $entregaelementoproteccion->idEntregaElementoProteccion,
            'ElementoProteccion_idElementoProteccion' => $request['ElementoProteccion_idElementoProteccion'][$i],
            'cantidadEntregaElementoProteccionDetalle' => $request['cantidadEntregaElementoProteccionDetalle'][$i],
            ]);
        }
        return redirect('/entregaelementoproteccion');    
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
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
        $entregaelementoproteccion = \App\EntregaElementoProteccion::find($id);
        $tercero = \App\Tercero::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('nombreCompletoTercero','idTercero');
        $idElementoProteccion = \App\ElementoProteccion::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('idElementoProteccion');
        $nombreElementoProteccion = \App\ElementoProteccion::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('nombreElementoProteccion');
        return view('entregaelementoproteccion',compact('tercero','idElementoProteccion','nombreElementoProteccion'),['entregaelementoproteccion'=>$entregaelementoproteccion]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $entregaelementoproteccion = \App\EntregaElementoProteccion::find($id);
        $entregaelementoproteccion->fill($request->all());
        $entregaelementoproteccion->save();

        \App\EntregaElementoProteccionDetalle::where('EntregaElementoProteccion_idEntregaElementoProteccion',$id)->delete();

        $contadorelementoproteccion = count($request['cantidadEntregaElementoProteccionDetalle']);
        for($i = 0; $i < $contadorelementoproteccion; $i++)
        {
            \App\EntregaElementoProteccionDetalle::create([
            'EntregaElementoProteccion_idEntregaElementoProteccion' => $id,
            'cantidadEntregaElementoProteccionDetalle' => $request['cantidadEntregaElementoProteccionDetalle'][$i],
            'ElementoProteccion_idElementoProteccion' => $request['ElementoProteccion_idElementoProteccion'][$i],
            ]);
        }

        return redirect('/entregaelementoproteccion');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        \App\EntregaElementoProteccion::destroy($id);
        return redirect('/entregaelementoproteccion');
    }
}
