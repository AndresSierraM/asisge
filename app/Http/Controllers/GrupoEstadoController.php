<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\GrupoEstadoRequest;
use App\Http\Controllers\Controller;
use DB;
include public_path().'/ajax/consultarPermisos.php';

class GrupoEstadoController extends Controller
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
            return view('grupoestadogrid', compact('datos'));
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
        return view('grupoestado');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(GrupoEstadoRequest $request)
    {
        if($request['respuesta'] != 'falso')
        {
            \App\GrupoEstado::create([
            'codigoGrupoEstado' => $request['codigoGrupoEstado'],
            'nombreGrupoEstado' => $request['nombreGrupoEstado']
            ]);

            $grupoEstado = \App\GrupoEstado::All()->last();
            
            //---------------------------------
            // guardamos las tablas de detalle
            //---------------------------------
            $this->grabarDetalle($grupoEstado->idGrupoEstado, $request);
            
             return redirect('/grupoestado');
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
        $grupoEstado = \App\GrupoEstado::find($id);
        return view('grupoestado',['grupoEstado'=>$grupoEstado]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(GrupoEstadoRequest $request, $id)
    {
        if($request['respuesta'] != 'falso')
        {
            $grupoEstado = \App\GrupoEstado::find($id);
            $grupoEstado->fill($request->all());
            $grupoEstado->save();

            //---------------------------------
            // guardamos las tablas de detalle
            //---------------------------------
            $this->grabarDetalle($grupoEstado->idGrupoEstado, $request);
            
            return redirect('/grupoestado');
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
        \App\GrupoEstado::destroy($id);
        return redirect('/grupoestado');
    }

    protected function grabarDetalle($id, $request)
    {

        // en el formulario hay un campo oculto en el que almacenamos los id que se eliminan separados por coma
        // en este proceso lo convertimos en array y eliminamos dichos id de la tabla de detalle
        $idsEliminar = explode(',', $request['eliminarDetalle']);
        \App\EstadoCRM::whereIn('idEstadoCRM',$idsEliminar)->delete();

        $contadorDetalle = count($request['nombreEstadoCRM']);
        for($i = 0; $i < $contadorDetalle; $i++)
        {
            $indice = array(
             'idEstadoCRM' => $request['idEstadoCRM'][$i]);

            $data = array(
             'GrupoEstado_idGrupoEstado' => $id,
            'nombreEstadoCRM' => $request['nombreEstadoCRM'][$i],
            'tipoEstadoCRM' => $request['tipoEstadoCRM'][$i] );

            $preguntas = \App\EstadoCRM::updateOrCreate($indice, $data);

        }
    }
}
