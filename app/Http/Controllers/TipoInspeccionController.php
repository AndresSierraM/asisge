<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\TipoInspeccionRequest;
use App\Http\Controllers\Controller;

class TipoInspeccionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('tipoinspecciongrid');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $frecuenciaMedicion = \App\frecuenciaMedicion::All()->lists('nombreFrecuenciaMedicion','idFrecuenciaMedicion');
        return view('tipoinspeccion',compact('frecuenciaMedicion'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(TipoInspeccionRequest $request)
    {
        \App\TipoInspeccion::create([
            'codigoTipoInspeccion' => $request['codigoTipoInspeccion'],
            'nombreTipoInspeccion' => $request['nombreTipoInspeccion'],
            'FrecuenciaMedicion_idFrecuenciaMedicion' => $request['FrecuenciaMedicion_idFrecuenciaMedicion'],
            'Compania_idCompania' => \Session::get('idCompania')
            ]);

        $tipoInspeccion = \App\TipoInspeccion::All()->last();
        $contadorDetalle = count($request['numeroTipoInspeccionPregunta']);
        for($i = 0; $i < $contadorDetalle; $i++)
        {
            \App\tipoInspeccionPregunta::create([
            'TipoInspeccion_idTipoInspeccion' => $tipoInspeccion->idTipoInspeccion,
            'numeroTipoInspeccionPregunta' => $request['numeroTipoInspeccionPregunta'][$i],
            'contenidoTipoInspeccionPregunta' => $request['contenidoTipoInspeccionPregunta'][$i]
           ]);
        }
        
        return redirect('/tipoinspeccion');
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
        $frecuenciaMedicion = \App\frecuenciaMedicion::All()->lists('nombreFrecuenciaMedicion','idFrecuenciaMedicion');
        $tipoInspeccion = \App\TipoInspeccion::find($id);
        return view('tipoinspeccion',compact('frecuenciaMedicion'),['tipoInspeccion'=>$tipoInspeccion]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(TipoInspeccionRequest $request, $id)
    {
        $tipoInspeccion = \App\TipoInspeccion::find($id);
        $tipoInspeccion->fill($request->all());
        $tipoInspeccion->save();

        \App\tipoInspeccionPregunta::where('TipoInspeccion_idTipoInspeccion',$id)->delete();
        
        $contadorDetalle = count($request['numeroTipoInspeccionPregunta']);
        for($i = 0; $i < $contadorDetalle; $i++)
        {
            \App\tipoInspeccionPregunta::create([
            'TipoInspeccion_idTipoInspeccion' => $id,
            'numeroTipoInspeccionPregunta' => $request['numeroTipoInspeccionPregunta'][$i],
            'contenidoTipoInspeccionPregunta' => $request['contenidoTipoInspeccionPregunta'][$i]
           ]);
        }

        return redirect('/tipoinspeccion');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        \App\TipoInspeccion::destroy($id);
        return redirect('/tipoinspeccion');
    }
}
