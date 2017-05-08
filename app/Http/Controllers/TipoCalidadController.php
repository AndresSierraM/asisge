<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\TipoCalidadRequest;

use Illuminate\Routing\Route;
use DB;
include public_path().'/ajax/consultarPermisos.php';

class TipoCalidadController extends Controller
{
    public function _construct(){
        $this->beforeFilter('@find',['only'=>['edit','update','destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function find(Route $route){
        $this->tipocalidad = \App\TipoCalidad::find($route->getParameter('tipocalidad'));
        return $this->tipocalidad;
    }

    public function index()
    {
        $vista = basename($_SERVER["PHP_SELF"]);
        $datos = consultarPermisos($vista);

        if($datos != null)
            return view('tipocalidadgrid', compact('datos'));
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
        return view('tipocalidad');
    }

    
    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(TipoCalidadRequest $request)
    {
        \App\TipoCalidad::create([
            'codigoTipoCalidad' => $request['codigoTipoCalidad'],
            'nombreTipoCalidad' => $request['nombreTipoCalidad'],
            'noConformeTipoCalidad' => (($request['noConformeTipoCalidad'] !== null) ? 1 : 0),
            'alertaCorreoTipoCalidad' => (($request['alertaCorreoTipoCalidad'] !== null) ? 1 : 0),
            'paraTipoCalidad' => $request['paraTipoCalidad'],
            'asuntoTipoCalidad' => $request['asuntoTipoCalidad'],
            'mensajeTipoCalidad' => $request['mensajeTipoCalidad'],
            'Compania_idCompania' => \Session::get('idCompania')
            ]);

        return redirect('/tipocalidad');
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
        $tipocalidad = \App\TipoCalidad::find($id);
        
        return view('tipocalidad', ['tipocalidad'=>$tipocalidad]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(TipoCalidadRequest $request, $id)
    {
        $tipocalidad = \App\TipoCalidad::find($id);
        $tipocalidad->fill($request->all());
        $tipocalidad->noConformeTipoCalidad = (($request['noConformeTipoCalidad'] !== null) ? 1 : 0);
        $tipocalidad->alertaCorreoTipoCalidad = (($request['alertaCorreoTipoCalidad'] !== null) ? 1 : 0);
        $tipocalidad->save();

       return redirect('/tipocalidad');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        \App\TipoCalidad::destroy($id);
        return redirect('/tipocalidad');
    }


}
