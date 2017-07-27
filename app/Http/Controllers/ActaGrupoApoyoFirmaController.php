<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
// include public_path().'/ajax/consultarPermisos.php';

class ActaGrupoApoyoFirmaController extends Controller
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
        
         return view('actagrupoapoyofirma');

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
          $nuevo[get_object_vars($dato[$i])["idActaGrupoApoyo"]] = get_object_vars($dato[$i])["concatenado"];
        }
        return $nuevo;
    }
    public function create()
    {
         // Se crea una variable que va a contener a grupo de apoyo 
         // $grupoapoyo = \App\GrupoApoyo::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('nombreGrupoApoyo','idGrupoApoyo');

        $actagrupoapoyo = DB::Select('
            SELECT actagrupoapoyo.idActaGrupoApoyo,CONCAT(grupoapoyo.nombreGrupoApoyo," ",actagrupoapoyo.fechaActaGrupoApoyo,"  ",actagrupoapoyo.horaInicioActaGrupoApoyo,"  ",actagrupoapoyo.horaFinActaGrupoApoyo) as concatenado
            FROM actagrupoapoyo
            LEFT JOIN grupoapoyo ON actagrupoapoyo.GrupoApoyo_idGrupoApoyo = grupoapoyo.idGrupoApoyo
            LEFT JOIN compania ON grupoapoyo.Compania_idCompania = compania.idCompania
            WHERE compania.idCompania = '.\Session::get('idCompania').'
            ORDER BY actagrupoapoyo.idActaGrupoApoyo  asc');
    
        $grupoapoyo = $this->convertirArray($actagrupoapoyo);



        return view ('actagrupoapoyofirma', compact('grupoapoyo'));
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
