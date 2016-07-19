<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\TipoRiesgoRequest;
use App\Http\Controllers\Controller;
use DB;
include public_path().'/ajax/consultarPermisos.php';

class TipoRiesgoController extends Controller
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

        return view('tiporiesgogrid', compact('datos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $clasificacionRiesgo = \App\ClasificacionRiesgo::All()->lists('nombreClasificacionRiesgo','idClasificacionRiesgo');
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
        if($request['respuesta'] != 'falso')
        {
            \App\TipoRiesgo::create([
            'codigoTipoRiesgo' => $request['codigoTipoRiesgo'],
            'nombreTipoRiesgo' => $request['nombreTipoRiesgo'],
            'origenTipoRiesgo' => $request['origenTipoRiesgo'],
            'ClasificacionRiesgo_idClasificacionRiesgo' => $request['ClasificacionRiesgo_idClasificacionRiesgo'],
            ]);

            $tipoRiesgo = \App\TipoRiesgo::All()->last();
            
            //---------------------------------
            // guardamos las tablas de detalle
            //---------------------------------
            $this->grabarDetalle($tipoRiesgo->idTipoRiesgo, $request);

            return redirect('/tiporiesgo');
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
        $clasificacionRiesgo = \App\ClasificacionRiesgo::All()->lists('nombreClasificacionRiesgo','idClasificacionRiesgo');
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
        if($request['respuesta'] != 'falso')
        {
            $tipoRiesgo = \App\TipoRiesgo::find($id);
            $tipoRiesgo->fill($request->all());
            $tipoRiesgo->save();

            //---------------------------------
            // guardamos las tablas de detalle
            //---------------------------------
            $this->grabarDetalle($tipoRiesgo->idTipoRiesgo, $request);
            
            return redirect('/tiporiesgo');
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
        \App\TipoRiesgo::destroy($id);
        return redirect('/tiporiesgo');
    }

    protected function grabarDetalle($id, $request)
    {

        // en el formulario hay un campo oculto en el que almacenamos los id que se eliminan separados por coma
        // en este proceso lo convertimos en array y eliminamos dichos id de la tabla de detalle
        $idsEliminar = explode(',', $request['eliminarDetalle']);
        \App\TipoRiesgoDetalle::whereIn('idTipoRiesgoDetalle',$idsEliminar)->delete();

        $contadorDetalle = count($request['nombreTipoRiesgoDetalle']);
        for($i = 0; $i < $contadorDetalle; $i++)
        {

            $indice = array(
             'idTipoRiesgoDetalle' => $request['idTipoRiesgoDetalle'][$i]);

            $data = array(
            'TipoRiesgo_idTipoRiesgo' => $id,
            'nombreTipoRiesgoDetalle' => $request['nombreTipoRiesgoDetalle'][$i] );

            $preguntas = \App\TipoRiesgoDetalle::updateOrCreate($indice, $data);

        }
        

        // en el formulario hay un campo oculto en el que almacenamos los id que se eliminan separados por coma
        // en este proceso lo convertimos en array y eliminamos dichos id de la tabla de detalle
        $idsEliminar = explode(',', $request['eliminarSalud']);
        \App\TipoRiesgoSalud::whereIn('idTipoRiesgoSalud',$idsEliminar)->delete();

        $contadorSalud = count($request['nombreTipoRiesgoSalud']);
        for($i = 0; $i < $contadorSalud; $i++)
        {

            $indice = array(
             'idTipoRiesgoSalud' => $request['idTipoRiesgoSalud'][$i]);

            $data = array(
            'TipoRiesgo_idTipoRiesgo' => $id,
            'nombreTipoRiesgoSalud' => $request['nombreTipoRiesgoSalud'][$i] );

            $preguntas = \App\TipoRiesgoSalud::updateOrCreate($indice, $data);

        }

    }
}
