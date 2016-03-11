<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class PreguntasListaChequeoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $preguntaListaChequeo = \App\PreguntasListaChequeo::where('Compania_idCompania','=', \Session::get('idCompania'))
->get();
        return view('preguntaslistachequeo',compact('preguntaListaChequeo'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $preguntaListaChequeo = \App\PreguntasListaChequeo::where('Compania_idCompania','=', \Session::get('idCompania'))
->get();
        return view('preguntaslistachequeo',compact('preguntaListaChequeo'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        for($i = 0; $i < count($request['ordenPreguntaListaChequeo']); $i++)
        {
            $indice = array(
             'idPreguntaListaChequeo' => $request['idPreguntaListaChequeo'][$i]);

             $data = array(
             'ordenPreguntaListaChequeo' => $request['ordenPreguntaListaChequeo'][$i],
             'descripcionPreguntaListaChequeo' => $request['descripcionPreguntaListaChequeo'][$i],
             'Compania_idCompania' => \Session::get('idCompania'));

            $preguntas = \App\PreguntasListaChequeo::updateOrCreate($indice, $data);
        }
         $preguntaListaChequeo = \App\PreguntasListaChequeo::where('Compania_idCompania','=', \Session::get('idCompania'))
->get();
        return view('preguntaslistachequeo',compact('preguntaListaChequeo'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
      
        for($i = 0; $i < count($request['ordenPreguntaListaChequeo']); $i++)
        {
            $indice = array(
             'idPreguntaListaChequeo' => $request['idPreguntaListaChequeo'][$i]);

             $data = array(
             'ordenPreguntaListaChequeo' => $request['ordenPreguntaListaChequeo'][$i],
             'descripcionPreguntaListaChequeo' => $request['descripcionPreguntaListaChequeo'][$i],
             'Compania_idCompania' => \Session::get('idCompania'));

            $preguntas = \App\PreguntasListaChequeo::updateOrCreate($indice, $data);
        }
        $preguntaListaChequeo = \App\PreguntasListaChequeo::where('Compania_idCompania','=', \Session::get('idCompania'))
->get();
        return view('preguntaslistachequeo',compact('preguntaListaChequeo'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
