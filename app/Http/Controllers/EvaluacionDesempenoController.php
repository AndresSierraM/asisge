<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

 // use App\Http\Requests\evaluaciondesempenoRequest;
use App\Http\Controllers\Controller;

include public_path().'/ajax/consultarPermisos.php';

class evaluaciondesempenoController extends Controller
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
        
         return view('evaluaciondesempeno');

     }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
       $idModulo= \App\Modulo::All()->lists('idModulo');
       $nombreModulo= \App\Modulo::All()->lists('nombreModulo');
       
         
        return view ('perfilcargo', compact('idModulo','nombreModulo'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    
       // 

        return redirect('/evaluaciondesempeno');
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
        
    

        return view ('evaluaciondesempeno',['evaluaciondesempeno'=>$evaluaciondesempeno], compact('idModulo','nombreModulo'));
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
        // $perfilcargo = \App\PerfilCargo::find($id);
        // $perfilcargo->fill($request->all());

        // $perfilcargo->save();

        return redirect('evaluaciondesempeno');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        \App\evaluaciondesempeno::destroy($id);
        return redirect('/evaluaciondesempeno');
    }
}
