<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

include public_path().'/ajax/consultarPermisos.php';


class EncuestaController extends Controller
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

        return view('encuestagrid', compact('datos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('encuesta');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Insertamos el encabezado
        \App\Encuesta::create([
            'tituloEncuesta' => $request['tituloEncuesta'],
            'descripcionEncuesta' => $request['descripcionEncuesta'],
            'Compania_idCompania' => \Session::get('idCompania')
            ]);

        // Consultamos el ultimo id insertado
        $encuesta = \App\Encuesta::All()->last();
        
        // ejecutamos la funcion para grabar las preguntas y sus opciones
        $this->grabarDetalle($encuesta->idEncuesta, $request);


        //return redirect('/encuesta');
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
        $encuesta = \App\Encuesta::find($id);
        return view('encuesta', ['encuesta'=>$encuesta]);
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
        $encuesta = \App\Encuesta::find($id);
        $encuesta->fill($request->all());
        $accidente->save();

        //return redirect('/encuesta');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        \App\Encuesta::destroy($id);
        return redirect('/encuesta');
    }

    protected function grabarDetalle($id, $request)
    {

        // en el formulario hay un campo oculto en el que almacenamos los 
        // id que se eliminan separados por coma, en este proceso lo convertimos 
        // en array y eliminamos dichos id de la tabla de detalle preguntas
        // $idsEliminar = explode(',', $request['eliminarTercero']);
        // \App\EncuestaPregunta::whereIn('idActaGrupoApoyoTercero',$idsEliminar)->delete();

        for($i = 0; $i < count($request['idEncuestaPregunta']); $i++)
        {
           
            $indice = array(
             'idEncuestaPregunta' => $request['idEncuestaPregunta'][$i]);

             $data = array(
             'preguntaEncuestaPregunta' => $request['preguntaEncuestaPregunta'][$i],
             'detalleEncuestaPregunta' => $request['detalleEncuestaPregunta'][$i],
             'tipoRespuestaEncuestaPregunta' => $request['tipoRespuestaEncuestaPregunta'][$i],
             'Encuesta_idEncuesta' => $id);

            $preguntas = \App\EncuestaPregunta::updateOrCreate($indice, $data);

            // Consultamos el ultimo id insertado
            $idPregunta = $request['idEncuestaPregunta'][$i];
            if($idPregunta == 0)
            {
                $encuesta = \App\EncuestaPregunta::All()->last();
                $idPregunta = $encuesta->idEncuestaPregunta;
            }
            
            // por cada pregunta, gurdamos el subdetalle (Opciones de la pregunta)
            $this->grabarSubDetalle($idPregunta, $request, $i);

        }
        
    }


    protected function grabarSubDetalle($id, $request, $i)
    {

        for($j = 0; $j < count($request['idEncuestaOpcion'][$i]); $j++)
        {
            $indice = array(
             'idEncuestaOpcion' => $request['idEncuestaOpcion'][$i][$j]);

            $data = array(
             'valorEncuestaOpcion' => $request['valorEncuestaOpcion'][$i][$j],
             'nombreEncuestaOpcion' => $request['nombreEncuestaOpcion'][$i][$j],
             'EncuestaPregunta_idEncuestaPregunta' => $id);

            $preguntas = \App\EncuestaOpcion::updateOrCreate($indice, $data);
        }
    }

}
