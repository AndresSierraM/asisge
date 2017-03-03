<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use App\Http\Requests\CompetenciaRequest;
use App\Http\Controllers\Controller;
include public_path().'/ajax/consultarPermisos.php';

class ParametroGestionHumanaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        //    $parametrogestionhumana = \App\PreguntasListaChequeo::where('Compania_idCompania','=', \Session::get('idCompania'))
        // ->get();
        // return view('parametrogestionhumana',compact('parametrogestionhumana'));  
          

      
        
   return view('parametrogestionhumana');
  
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
        return view ('competencia', compact('idModulo','nombreModulo'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    

        return redirect('/parametrogestionhumana');
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
         //  $competencia = \App\Competencia::find($id);
         // $idModulo= \App\Modulo::All()->lists('idModulo');
         // $nombreModulo= \App\Modulo::All()->lists('nombreModulo');
        return view ('parametrogestionhumana',['parametrogestionhumana'=>$idNombreAndres], compact('idModulo','nombreModulo'));
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
        // $Competencia = \App\Competencia::find($id);
        // $Competencia->fill($request->all());

        // $Competencia->save();


        return redirect('parametrogestionhumana');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         // \App\Competencia::destroy($id);
        return redirect('/parametrogestionhumana');        
    }
}
