<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use App\Http\Requests\CompetenciaRequest;
use App\Http\Controllers\Controller;
use DB;
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

    // Se envian las consultas de la respetivas Multiregistros en el index 
    
    $CompetenciaRespuesta = DB::select ('
        SELECT
        idCompetenciaRespuesta,respuestaCompetenciaRespuesta,porcentajeNormalCompetenciaRespuesta,porcentajeInversoCompetenciaRespuesta
        From
        competenciarespuesta CR');

    $CompetenciaRango = DB::select ('
        SELECT
        idCompetenciaRango,ordenCompetenciaRango,nivelCompetenciaRango,desdeCompetenciaRango,hastaCompetenciaRango
        FROM
        competenciarango');
   
         return view('parametrogestionhumana',compact('CompetenciaRespuesta','CompetenciaRango'));
  
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
        return view ('parametrogestionhumana', compact('idModulo','nombreModulo'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

         // Detalle Competencia Respuesta 
        $idsEliminar = explode("," , $request['eliminarcompetenciarango']);
        //Eliminar registros de la multiregistro
        \App\CompetenciaRango::whereIn('idCompetenciaRango', $idsEliminar)->delete();
        // Competencia Rango
          for($i = 0; $i < count($request['ordenCompetenciaRango']); $i++)
        {
            $indice = array(
             'idCompetenciaRango' => $request['idCompetenciaRango'][$i]);

             $data = array(
             'ordenCompetenciaRango' => $request['ordenCompetenciaRango'][$i],
             'nivelCompetenciaRango' => $request['nivelCompetenciaRango'][$i],
             'desdeCompetenciaRango' => $request['desdeCompetenciaRango'][$i],
             'hastaCompetenciaRango' => $request['hastaCompetenciaRango'][$i]);
            

            $preguntas = \App\CompetenciaRango::updateOrCreate($indice, $data);
        }

         // Detalle Competencia Respuesta 
        $idsEliminar = explode("," , $request['eliminarcompetenciarespuesta']);
        //Eliminar registros de la multiregistro
        \App\CompetenciaRespuesta::whereIn('idCompetenciaRespuesta', $idsEliminar)->delete();
        // Guardado Competencia Respuesta 
         for($i = 0; $i < count($request['respuestaCompetenciaRespuesta']); $i++)
        {
            $indice = array(
             'idCompetenciaRespuesta' => $request['idCompetenciaRespuesta'][$i]);

             $data = array(
             'respuestaCompetenciaRespuesta' => $request['respuestaCompetenciaRespuesta'][$i],
             'porcentajeNormalCompetenciaRespuesta' => $request['porcentajeNormalCompetenciaRespuesta'][$i],
             'porcentajeInversoCompetenciaRespuesta' => $request['porcentajeInversoCompetenciaRespuesta'][$i]);
             
            

            $preguntas = \App\CompetenciaRespuesta::updateOrCreate($indice, $data);
        }

        
       

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
       

      
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
           // ...
    }
}
