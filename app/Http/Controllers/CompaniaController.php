<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\CompaniaRequest;
use App\Http\Controllers\Controller;
use App\Http\Controllers\CompaniaObjetivo;
use DB;
include public_path().'/ajax/consultarPermisos.php';

class CompaniaController extends Controller
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

        return view('companiagrid', compact('datos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('compania');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(CompaniaRequest $request)
    {
        \App\Compania::create([
            'codigoCompania' => $request['codigoCompania'],
            'nombreCompania' => $request['nombreCompania'],
            'misionCompania' => $request['misionCompania'],
            'visionCompania' => $request['visionCompania'],
            'valoresCompania' => $request['valoresCompania'],
            'politicasCompania' => $request['politicasCompania'],
            'principiosCompania' => $request['principiosCompania'],
            'metasCompania' => $request['metasCompania']
            ]);

        $compania = \App\Compania::All()->last();

        //---------------------------------
        // guardamos las tablas de detalle
        //---------------------------------
        $this->grabarDetalle($compania->idCompania, $request);

        return redirect('/compania');
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
        $compania = \App\Compania::find($id);
        
        return view('compania',['compania'=>$compania]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update($id,CompaniaRequest $request)
    {
        $compania = \App\Compania::find($id);
        
        $compania->fill($request->all());
        $compania->save();
        
        //---------------------------------
        // guardamos las tablas de detalle
        //---------------------------------
        $this->grabarDetalle($compania->idCompania, $request);
        
        return redirect('/compania');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    

    public function destroy($id)
    {
        \App\Compania::destroy($id);
        return redirect('/compania');
    }

    protected function grabarDetalle($id, $request)
    {

        // en el formulario hay un campo oculto en el que almacenamos los id que se eliminan separados por coma
        // en este proceso lo convertimos en array y eliminamos dichos id de la tabla de detalle
        $idsEliminar = explode(',', $request['eliminarObjetivo']);
        \App\CompaniaObjetivo::whereIn('idCompaniaObjetivo',$idsEliminar)->delete();

        $contador = count($request['nombreCompaniaObjetivo']);

        for($i = 0; $i < $contador; $i++)
        {

            $indice = array(
             'idCompaniaObjetivo' => $request['idCompaniaObjetivo'][$i]);

            $data = array(
             'Compania_idCompania' => $id,
            'nombreCompaniaObjetivo' => $request['nombreCompaniaObjetivo'][$i] );

            $preguntas = \App\CompaniaObjetivo::updateOrCreate($indice, $data);

        }

    }
}
