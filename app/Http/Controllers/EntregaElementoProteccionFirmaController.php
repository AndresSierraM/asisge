<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
// include public_path().'/ajax/consultarPermisos.php';

class EntregaElementoProteccionFirmaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         // $vista = basename($_SERVER["PHP_SELF"]);
         // $datos = consultarPermisos($vista);

         // if($datos != null)
         //  return view('perfilcargogrid', compact('datos'));
         // else
         //    return view('accesodenegado');
        
         return view('entraelementoproteccionfirma');

     }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // funcion para convertir la consulta de actagrupoapoyo
    function convertirArray($dato)
    {

        $nuevo = array();
        for($i = 0; $i < count($dato); $i++) 
        {
            // Se trae el id y el contatenado qeu es el alias que se le dio a la consulta 
          $nuevo[get_object_vars($dato[$i])["idEntregaElementoProteccion"]] = get_object_vars($dato[$i])["concatenado"];
        }
        return $nuevo;
    }
    public function create()
    {
         // Se crea una variable que va a contener a Entrega elemento proteccion 
         // $grupoapoyo = \App\GrupoApoyo::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('nombreGrupoApoyo','idGrupoApoyo');

        $Entregaepp = DB::Select('
            SELECT eep.idEntregaElementoProteccion,concat(t.nombreCompletoTercero,"  ",eep.fechaEntregaElementoProteccion) as concatenado
            FROM entregaelementoproteccion eep
            LEFT JOIN tercero t
            ON eep.Tercero_idTercero = t.idTercero
            LEFT JOIN compania c
            ON eep.Compania_idCompania = c.idCompania  
            WHERE c.idCompania = '.\Session::get('idCompania').'
            ORDER BY eep.idEntregaElementoProteccion  asc');

    
        $EntregaEPP = $this->convertirArray($Entregaepp);



        return view ('entregaelementoproteccionfirma', compact('EntregaEPP'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(request $request)
    {
        // 
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
   
        // return view ('perfilcargo',['perfilcargo'=>$perfilcargo], compact('idModulo','nombreModulo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(request $request, $id)
    {
        // return redirect('perfilcargo');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // 
    }
}
