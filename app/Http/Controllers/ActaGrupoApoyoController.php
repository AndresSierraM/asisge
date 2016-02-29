<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\ActaGrupoApoyoRequest;
use App\Http\Controllers\Controller;

class ActaGrupoApoyoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('actagrupoapoyogrid');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $grupoapoyo = \App\GrupoApoyo::All()->lists('nombreGrupoApoyo','idGrupoApoyo');
        return view('actagrupoapoyo', compact('grupoapoyo'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(ActaGrupoApoyoRequest $request)
    {
            \App\ActaGrupoApoyo::create([
                'GrupoApoyo_idGrupoApoyo' => $request['GrupoApoyo_idGrupoApoyo'],
                'fechaActaGrupoApoyo' => $request['fechaActaGrupoApoyo'],
                'horaInicioActaGrupoApoyo' => $request['horaInicioActaGrupoApoyo'],
                'horaFinActaGrupoApoyo' => $request['horaFinActaGrupoApoyo'],
                'observacionActaGrupoApoyo' => $request['observacionActaGrupoApoyo']
                ]);

            
            return redirect('/actagrupoapoyo');
        

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
        
        $actaGrupoApoyo = \App\ActaGrupoApoyo::find($id);
        $grupoapoyo = \App\GrupoApoyo::All()->lists('nombreGrupoApoyo','idGrupoApoyo');
        
        $idTercero = \App\Tercero::All()->lists('idTercero');
        $nombreCompletoTercero = \App\Tercero::All()->lists('nombreCompletoTercero');

        return view('actagrupoapoyo', compact('grupoapoyo','idTercero','nombreCompletoTercero'), ['actaGrupoApoyo'=>$actaGrupoApoyo])
        ;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(ActaGrupoApoyoRequest $request, $id)
    {
           
            $actagrupoapoyo = \App\ActaGrupoApoyo::find($id);
            $actagrupoapoyo->fill($request->all());

            $actagrupoapoyo->save();

            for($i = 0; $i < count($request['Tercero_idParticipante']); $i++)
            {
                $indice = array(
                 'idActaGrupoApoyoTercero' => $request['idActaGrupoApoyoTercero'][$i]);

                 $data = array(
                 'Tercero_idParticipante' => $request['Tercero_idParticipante'][$i],
                 'ActaGrupoApoyo_idActaGrupoApoyo' => $id);

                $preguntas = \App\ActaGrupoApoyoTercero::updateOrCreate($indice, $data);
            }
            
            for($i = 0; $i < count($request['temaActaGrupoApoyoTema']); $i++)
            {
                $indice = array(
                 'idActaGrupoApoyoTema' => $request['idActaGrupoApoyoTema'][$i]);

                 $data = array(
                    'temaActaGrupoApoyoTema' => $request['temaActaGrupoApoyoTema'][$i],
                    'desarrolloActaGrupoApoyoTema' => $request['desarrolloActaGrupoApoyoTema'][$i],
                     'Tercero_idResponsable' => $request['Tercero_idResponsable'][$i],
                     'observacionActaGrupoApoyoTema' => $request['observacionActaGrupoApoyoTema'][$i],
                     'ActaGrupoApoyo_idActaGrupoApoyo' => $id);

                $preguntas = \App\ActaGrupoApoyoTema::updateOrCreate($indice, $data);
            }

            
            return redirect('/actagrupoapoyo');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        \App\ActaGrupoApoyo::destroy($id);
        return redirect('/actagrupoapoyo');
    }
}
