<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class TipoProveedorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('tipoproveedorgrid');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tipoproveedor');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        \App\TipoProveedor::create([
        'codigoTipoProveedor' => $request['codigoTipoProveedor'],
        'nombreTipoProveedor' => $request['nombreTipoProveedor']
        ]);

        $tipoproveedor = \App\TipoProveedor::All()->last();

        $this->grabarDetalle($request, $tipoproveedor->id)

        return redirect('tipoproveedor');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
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
        $tipoproveedor = \App\TipoProveedor::find($id);

        return view('tipoproveedor',['tipoproveedor' => $tipoproveedor]);
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
        $tipoproveedor = \App\TipoProveedor::find($id);
        $tipoproveedor->fill($request->all());
        $tipoproveedor->save();

        $this->grabarDetalle($request, $id);

        return redirect('tipoproveedor');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        \App\TipoProveedor::destroy($id);
        $return redirect('tipoproveedor');
    }

    protected function grabarDetalle($request, $id)
    {
        $idsSeleccion = explode(',', $request['eliminarTipoProveedorSeleccion']);
        \App\TipoProveedorSeleccion::whereIn('idTipoProveedorSeleccion',$idsSeleccion)->delete();

        for($i = 0; $i < count($request['descripcionTipoProveedorSeleccion']); $i++)
        {
            $indice = array(
                'idTipoProveedorSeleccion' => $request['idTipoProveedorSeleccion'][$i]);

            $datos= array(
                'TipoProveedor_idTipoProveedor' => $id,
                'descripcionTipoProveedorSeleccion' => $request['descripcionTipoProveedorSeleccion'][$i]
                );

            $guardar = \App\TipoProveedorSeleccion::updateOrCreate($indice, $datos);
        }

        $idsEvaluacion = explode(',', $request['eliminarTipoProveedorEvaluacion']);
        \App\TipoProveedorEvaluacion::whereIn('idTipoProveedorEvaluacion',$idsEvaluacion)->delete();

        for($i = 0; $i < count($request['descripcionTipoProveedorEvaluacion']); $i++)
        {
            $indice = array(
                'idTipoProveedorEvaluacion' => $request['idTipoProveedorEvaluacion'][$i]);

            $datos= array(
                'TipoProveedor_idTipoProveedor' => $id,
                'descripcionTipoProveedorEvaluacion' => $request['descripcionTipoProveedorEvaluacion'][$i],
                'pesoTipoProveedorEvaluacion' => $request['pesoTipoProveedorEvaluacion'][$i]
                );

            $guardar = \App\TipoProveedorEvaluacion::updateOrCreate($indice, $datos);
        }
    }
}
