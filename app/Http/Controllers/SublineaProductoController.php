<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\SublineaProductoRequest;

use Illuminate\Routing\Route;
use DB;
include public_path().'/ajax/consultarPermisos.php';

class SublineaProductoController extends Controller
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
        $this->sublineaproducto = \App\SublineaProducto::find($route->getParameter('sublineaproducto'));
        return $this->sublineaproducto;
    }

    public function index()
    {
        $vista = basename($_SERVER["PHP_SELF"]);
        $datos = consultarPermisos($vista);

        if($datos != null)
            return view('sublineaproductogrid', compact('datos'));
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
        return view('sublineaproducto');
    }

    
    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(SublineaProductoRequest $request)
    {
        
        \App\SublineaProducto::create([
            'codigoSublineaProducto' => $request['codigoSublineaProducto'],
            'nombreSublineaProducto' => $request['nombreSublineaProducto'],
            'Compania_idCompania' => \Session::get('idCompania')
            ]);

        return redirect('/sublineaproducto');
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
        $sublineaproducto = \App\SublineaProducto::find($id);
        
        return view('sublineaproducto', ['sublineaproducto'=>$sublineaproducto]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(SublineaProductoRequest $request, $id)
    {
        $sublineaproducto = \App\SublineaProducto::find($id);
        $sublineaproducto->fill($request->all());
        $sublineaproducto->save();

       return redirect('/sublineaproducto');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        \App\SublineaProducto::destroy($id);
        return redirect('/sublineaproducto');
    }


}
