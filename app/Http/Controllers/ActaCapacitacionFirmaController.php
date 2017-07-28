<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
// include public_path().'/ajax/consultarPermisos.php';

class ActaCapacitacionFirmaController extends Controller
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
        
         return view('actacapacitacionfirma');

     }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // funcion para convertir la consulta de actagrupoapoyo
  
    public function create()
    {


        return view ('actacapacitacionfirma', compact(''));
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
