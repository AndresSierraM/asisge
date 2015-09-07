<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\TipoRiesgoRequest;
use App\Http\Controllers\Controller;

class TipoRiesgoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('tiporiesgogrid');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $clasificacionRiesgo = \App\clasificacionRiesgo::All()->lists('nombreClasificacionRiesgo','idClasificacionRiesgo');
        return view('tiporiesgo',compact('clasificacionRiesgo'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(TipoRiesgoRequest $request)
    {
        \App\TipoRiesgo::create([
            'codigoTipoRiesgo' => $request['codigoTipoRiesgo'],
            'nombreTipoRiesgo' => $request['nombreTipoRiesgo'],
            'origenTipoRiesgo' => $request['origenTipoRiesgo'],
            'ClasificacionRiesgo_idClasificacionRiesgo' => $request['ClasificacionRiesgo_idClasificacionRiesgo'],
            ]);

        $tipoRiesgo = \App\TipoRiesgo::All()->last();
        $contadorDetalle = count($request['nombreTipoRiesgoDetalle']);
        for($i = 0; $i < $contadorDetalle; $i++)
        {
            \App\TipoRiesgoDetalle::create([
            'TipoRiesgo_idTipoRiesgo' => $tipoRiesgo->idTipoRiesgo,
            'nombreTipoRiesgoDetalle' => $request['nombreTipoRiesgoDetalle'][$i]
           ]);
        }
        
        $contadorSalud = count($request['nombreTipoRiesgoSalud']);
        for($i = 0; $i < $contadorSalud; $i++)
        {
            \App\TipoRiesgoSalud::create([
            'TipoRiesgo_idTipoRiesgo' => $tipoRiesgo->idTipoRiesgo,
            'nombreTipoRiesgoSalud' => $request['nombreTipoRiesgoSalud'][$i]
           ]);
        }

        return redirect('/tiporiesgo');
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
        $clasificacionRiesgo = \App\clasificacionRiesgo::All()->lists('nombreClasificacionRiesgo','idClasificacionRiesgo');
        $tipoRiesgo = \App\TipoRiesgo::find($id);
        return view('tiporiesgo',compact('clasificacionRiesgo'),['tipoRiesgo'=>$tipoRiesgo]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(TipoRiesgoRequest $request, $id)
    {
        $tipoRiesgo = \App\TipoRiesgo::find($id);
        $tipoRiesgo->fill($request->all());
        $tipoRiesgo->save();

        \App\TipoRiesgoDetalle::where('TipoRiesgo_idTipoRiesgo',$id)->delete();
        \App\TipoRiesgoSalud::where('TipoRiesgo_idTipoRiesgo',$id)->delete();
        
        $contadorDetalle = count($request['nombreTipoRiesgoDetalle']);
        for($i = 0; $i < $contadorDetalle; $i++)
        {
            \App\TipoRiesgoDetalle::create([
            'TipoRiesgo_idTipoRiesgo' => $id,
            'nombreTipoRiesgoDetalle' => $request['nombreTipoRiesgoDetalle'][$i]
           ]);
        }
        
        $contadorSalud = count($request['nombreTipoRiesgoSalud']);
        for($i = 0; $i < $contadorSalud; $i++)
        {
            \App\TipoRiesgoSalud::create([
            'TipoRiesgo_idTipoRiesgo' => $id,
            'nombreTipoRiesgoSalud' => $request['nombreTipoRiesgoSalud'][$i]
           ]);
        }

        return redirect('/tiporiesgo');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        \App\TipoRiesgo::destroy($id);
        return redirect('/tiporiesgo');
    }
}
