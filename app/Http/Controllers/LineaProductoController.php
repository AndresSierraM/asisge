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

      if($request['respuesta'] != 'falso')
        {  
        
        \App\LineaProducto::create([
            'codigoLineaProducto' => $request['codigoLineaProducto'],
            'nombreLineaProducto' => $request['nombreLineaProducto'],
            'Compania_idCompania' => \Session::get('idCompania')
            ]);



        // en esta parte es el guardado de la multiregistro descripcion
         //Primero consultar el ultimo id guardado
         $lineaproducto = \App\lineaproducto::All()->last();
         //---------------------------------
        // guardamos las tablas de detalle
        //---------------------------------
            $this->grabarDetalle($lineaproducto->idLineaProducto, $request);
        
        return redirect('/lineaproducto');
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
        $lineaproducto = \App\LineaProducto::find($id);


        //Hacemos una consulta para devolver los datos de la multiregistro con todos los campos igual 
        $sublinea = DB::Select('
         SELECT  slp.idSublineaProducto,slp.codigoSublineaProducto,slp.nombreSublineaProducto
         FROM lineaproducto lp
         LEFT JOIN sublineaproducto slp
         ON  lp.idLineaProducto = slp.LineaProducto_idLineaProducto
         WHERE slp.LineaProducto_idLineaProducto ='.$id);
        
        return view('lineaproducto',compact('sublinea'),['lineaproducto'=>$lineaproducto]);
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
      if($request['respuesta'] != 'falso')
        {  
        $lineaproducto = \App\LineaProducto::find($id);
        $lineaproducto->fill($request->all());
        $lineaproducto->save();


        //---------------------------------
        // guardamos las tablas de detalle
        //---------------------------------
        $this->grabarDetalle($lineaproducto->idLineaProducto, $request);

       return redirect('/lineaproducto');
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
        \App\LineaProducto::destroy($id);
        return redirect('/lineaproducto');
    }
    protected function grabarDetalle($id, $request)
    {

         $idsEliminar = explode("," , $request['eliminarsublinea']);
        //Eliminar registros de la multiregistro
        \App\SublineaProducto::whereIn('idSublineaProducto', $idsEliminar)->delete();
        $contador = count($request['idSublineaProducto']);
        for ($i=0; $i < $contador; $i++) 
        { 
            $indice = array(
                'idSublineaProducto' => $request['idSublineaProducto'][$i]);

            $data = array(
                'LineaProducto_idLineaProducto' => $id,
                'codigoSublineaProducto' => $request['codigoSublineaProducto'][$i],
                'nombreSublineaProducto' => $request['nombreSublineaProducto'][$i]);

            $guardar = \App\SublineaProducto::updateOrCreate($indice, $data);
        }

    }


}
