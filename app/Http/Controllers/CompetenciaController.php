<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CompetenciaRequest;
use App\Http\Controllers\Controller;
include public_path().'/ajax/consultarPermisos.php';

class CompetenciaController extends Controller
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
            return view('competenciagrid', compact('datos'));
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
        return view ('competencia', compact('idModulo','nombreModulo'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CompetenciaRequest $request)
    {
        
         \App\Competencia::create([
            'nombreCompetencia' => $request['nombreCompetencia'],
            'estadoCompetencia' => $request['estadoCompetencia']
        ]);


// en esta parte es el guardado de la multiregistro descripcion
         //Primero consultar el ultimo id guardado
         $competencia = \App\Competencia::All()->last();
         //for para guardar cada registro de la multiregistro

         for ($i=0; $i < count($request['ordenCompetenciaPregunta']); $i++) 
         { 
             \App\CompetenciaPregunta::create([
            'Competencia_idCompetencia' => $competencia->idCompetencia,
            'ordenCompetenciaPregunta' => $request['ordenCompetenciaPregunta'][$i],
            'preguntaCompetenciaPregunta' => $request['preguntaCompetenciaPregunta'][$i],
            'respuestaCompetenciaPregunta' => $request['respuestaCompetenciaPregunta'][$i],
            'estadoCompetenciaPregunta' => $request['estadoCompetenciaPregunta'][$i],
            'respuestaCompetenciaPregunta' => $request['respuestaCompetenciaPregunta'][$i],


            ]);
         }

        return redirect('/competencia');
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
          $competencia = \App\Competencia::find($id);
         $idModulo= \App\Modulo::All()->lists('idModulo');
         $nombreModulo= \App\Modulo::All()->lists('nombreModulo');
        return view ('competencia',['competencia'=>$competencia], compact('idModulo','nombreModulo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CompetenciaRequest $request, $id)
    {
        $Competencia = \App\Competencia::find($id);
        $Competencia->fill($request->all());

        $Competencia->save();

        $idsEliminar = explode("," , $request['idsborrados']);
        //Eliminar registros de la multiregistro
        \App\CompetenciaPregunta::whereIn('idCompetenciaPregunta', $idsEliminar)->delete();

        for ($i=0; $i < count($request['ordenCompetenciaPregunta']); $i++) 
        { 
            $indice = array(
                'idCompetenciaPregunta' => $request['idCompetenciaPregunta'][$i]);

            $data = array(
                'Competencia_idCompetencia' => $id,
                'ordenCompetenciaPregunta' => $request['ordenCompetenciaPregunta'][$i],
                'preguntaCompetenciaPregunta' => $request['preguntaCompetenciaPregunta'][$i],
                'respuestaCompetenciaPregunta' => $request['respuestaCompetenciaPregunta'][$i],
                'estadoCompetenciaPregunta' => $request['estadoCompetenciaPregunta'][$i],
                'respuestaCompetenciaPregunta' => $request['respuestaCompetenciaPregunta'][$i]);

            $guardar = \App\CompetenciaPregunta::updateOrCreate($indice, $data);
        }

        return redirect('competencia');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         \App\Competencia::destroy($id);
        return redirect('/competencia');        
    }
}
