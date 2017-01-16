<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Http\Requests\CompetenciaRespuestaRequest;
include public_path().'/ajax/consultarPermisos.php';

class CompetenciaRespuestaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {



         $vista = basename($_SERVER["PHP_SELF"]);
         $datos = consultarPermisos($vista);

         if($datos != null)
          return view('competenciarespuestagrid', compact('datos'));
         else
            return view('accesodenegado');
        
        

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
        return view ('competenciarespuesta', compact('idModulo','nombreModulo'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CompetenciaRespuestaRequest $request)
    {
    
         \App\CompetenciaRespuesta::create([

            'respuestaCompetenciaRespuesta' => $request['respuestaCompetenciaRespuesta'],
            'porcentajeNormalCompetenciaRespuesta' => $request['porcentajeNormalCompetenciaRespuesta'],
            'porcentajeInversoCompetenciaRespuesta' => $request['porcentajeInversoCompetenciaRespuesta']
            ]);

        return redirect('/competenciarespuesta');
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
        $competenciarespuesta = \App\CompetenciaRespuesta::find($id);
         $idModulo= \App\Modulo::All()->lists('idModulo');
         $nombreModulo= \App\Modulo::All()->lists('nombreModulo');

        return view ('competenciarespuesta',['competenciarespuesta'=>$competenciarespuesta], compact('idModulo','nombreModulo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CompetenciaRespuestaRequest $request, $id)
    {
        $competenciarespuesta = \App\CompetenciaRespuesta::find($id);
        $competenciarespuesta->fill($request->all());

        $competenciarespuesta->save();

        return redirect('competenciarespuesta');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        \App\CompetenciaRespuesta::destroy($id);
        return redirect('/competenciarespuesta');
    }
}
