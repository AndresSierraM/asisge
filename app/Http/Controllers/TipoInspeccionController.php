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
        $frecuenciaMedicion = \App\FrecuenciaMedicion::All()->lists('nombreFrecuenciaMedicion','idFrecuenciaMedicion');
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
        if($request['respuesta'] != 'falso')
        {
            \App\TipoInspeccion::create([
            'codigoTipoInspeccion' => $request['codigoTipoInspeccion'],
            'nombreTipoInspeccion' => $request['nombreTipoInspeccion'],
            'FrecuenciaMedicion_idFrecuenciaMedicion' => $request['FrecuenciaMedicion_idFrecuenciaMedicion'],
            'Compania_idCompania' => \Session::get('idCompania')
            ]);

            $tipoInspeccion = \App\TipoInspeccion::All()->last();
            
            //---------------------------------
            // guardamos las tablas de detalle
            //---------------------------------
            $this->grabarDetalle($tipoInspeccion->idTipoInspeccion, $request);
            
             return redirect('/tipoinspeccion');
         }
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
        $frecuenciaMedicion = \App\FrecuenciaMedicion::All()->lists('nombreFrecuenciaMedicion','idFrecuenciaMedicion');
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
        if($request['respuesta'] != 'falso')
        {
            $tipoInspeccion = \App\TipoInspeccion::find($id);
            $tipoInspeccion->fill($request->all());
            $tipoInspeccion->save();

            //---------------------------------
            // guardamos las tablas de detalle
            //---------------------------------
            $this->grabarDetalle($tipoInspeccion->idTipoInspeccion, $request);
            
            return redirect('/tipoinspeccion');
        }
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

    protected function grabarDetalle($id, $request)
    {

        // en el formulario hay un campo oculto en el que almacenamos los id que se eliminan separados por coma
        // en este proceso lo convertimos en array y eliminamos dichos id de la tabla de detalle
        $idsEliminar = explode(',', $request['eliminarDetalle']);
        \App\TipoInspeccionPregunta::whereIn('idTipoInspeccionPregunta',$idsEliminar)->delete();

        $contadorDetalle = count($request['numeroTipoInspeccionPregunta']);
        for($i = 0; $i < $contadorDetalle; $i++)
        {
            $indice = array(
             'idTipoInspeccionPregunta' => $request['idTipoInspeccionPregunta'][$i]);

            $data = array(
             'TipoInspeccion_idTipoInspeccion' => $id,
            'numeroTipoInspeccionPregunta' => $request['numeroTipoInspeccionPregunta'][$i],
            'contenidoTipoInspeccionPregunta' => $request['contenidoTipoInspeccionPregunta'][$i] );

            $preguntas = \App\TipoInspeccionPregunta::updateOrCreate($indice, $data);

        }
    }
}
