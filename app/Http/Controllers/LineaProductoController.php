<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\LineaProductoRequest;

use Illuminate\Routing\Route;
use DB;
include public_path().'/ajax/consultarPermisos.php';

class LineaProductoController extends Controller
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
        $this->lineaproducto = \App\LineaProducto::find($route->getParameter('lineaproducto'));
        return $this->lineaproducto;
    }

    public function index()
    {
        $vista = basename($_SERVER["PHP_SELF"]);
        $datos = consultarPermisos($vista);

        if($datos != null)
            return view('lineaproductogrid', compact('datos'));
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
        return view('lineaproducto');
    }

    
    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(LineaProductoRequest $request)
    {
        
        \App\LineaProducto::create([
            'codigoLineaProducto' => $request['codigoLineaProducto'],
            'nombreLineaProducto' => $request['nombreLineaProducto'],
            'Compania_idCompania' => \Session::get('idCompania')
            ]);

        return redirect('/lineaproducto');
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
        $lineaproducto = \App\LineaProducto::find($id);
        
        return view('lineaproducto', ['lineaproducto'=>$lineaproducto]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(LineaProductoRequest $request, $id)
    {
        $lineaproducto = \App\LineaProducto::find($id);
        $lineaproducto->fill($request->all());
        $lineaproducto->save();

       return redirect('/lineaproducto');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        \App\LineaProducto::destroy($id);
        return redirect('/lineaproducto');
    }


}
