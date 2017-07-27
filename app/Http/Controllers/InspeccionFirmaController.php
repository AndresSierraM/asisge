<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
// include public_path().'/ajax/consultarPermisos.php';

class InspeccionFirmaController extends Controller
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
        
         return view('inspeccionfirma');

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
          $nuevo[get_object_vars($dato[$i])["idInspeccion"]] = get_object_vars($dato[$i])["concatenado"];
        }
        return $nuevo;
    }
    public function create()
    {
         // Se crea una variable que va a contener a inspeccion
         // $grupoapoyo = \App\GrupoApoyo::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('nombreGrupoApoyo','idGrupoApoyo');

        $inspeccion = DB::Select('
            SELECT inspeccion.idInspeccion,CONCAT(tipoinspeccion.nombreTipoInspeccion,"  ",inspeccion.fechaElaboracionInspeccion) as concatenado
            FROM inspeccion
            LEFT JOIN tipoinspeccion ON inspeccion.TipoInspeccion_idTipoInspeccion = tipoinspeccion.idTipoInspeccion
            LEFT JOIN compania ON tipoinspeccion.Compania_idCompania = compania.idCompania  
            WHERE compania.idCompania = '.\Session::get('idCompania').'
            ORDER BY inspeccion.idInspeccion  asc');

    
        $Inspeccion = $this->convertirArray($inspeccion);



        return view ('inspeccionfirma', compact('Inspeccion'));
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
