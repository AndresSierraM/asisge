<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ConformacionGrupoApoyoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('conformaciongrupoapoyogrid');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $idTercero = \App\Tercero::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('idTercero');
        $nombreCompletoTercero = \App\Tercero::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('nombreCompletoTercero');
        $tercero = \App\Tercero::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('nombreCompletoTercero','idTercero');
        $grupoApoyo = \App\GrupoApoyo::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('nombreGrupoApoyo','idGrupoApoyo');
        return view('conformaciongrupoapoyo',compact('grupoApoyo','tercero','idTercero','nombreCompletoTercero'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
            \App\ConformacionGrupoApoyo::create([
                'GrupoApoyo_idGrupoApoyo' => $request['GrupoApoyo_idGrupoApoyo'],
                'nombreConformacionGrupoApoyo' => $request['nombreConformacionGrupoApoyo'],
                'fechaConformacionGrupoApoyo' => $request['fechaConformacionGrupoApoyo'],
                'fechaConvocatoriaConformacionGrupoApoyo' => $request['fechaConvocatoriaConformacionGrupoApoyo'],
                'Tercero_idRepresentante' => $request['Tercero_idRepresentante'],
                'fechaVotacionConformacionGrupoApoyo' => $request['fechaVotacionConformacionGrupoApoyo'],
                'Tercero_idGerente' => $request['Tercero_idGerente'],
                'fechaActaConformacionGrupoApoyo' => $request['fechaActaConformacionGrupoApoyo'],
                'horaActaConformacionGrupoApoyo' => $request['horaActaConformacionGrupoApoyo'],
                'fechaInicioConformacionGrupoApoyo' => $request['fechaInicioConformacionGrupoApoyo'],
                'fechaFinConformacionGrupoApoyo' => $request['fechaFinConformacionGrupoApoyo'],
                'fechaConstitucionConformacionGrupoApoyo' => $request['fechaConstitucionConformacionGrupoApoyo'],
                'Tercero_idPresidente' => $request['Tercero_idPresidente'],
                'Tercero_idSecretario' => $request['Tercero_idSecretario'],
                'Compania_idCompania' => \Session::get('idCompania')
                ]);

            $conformacionGrupoApoyo = \App\ConformacionGrupoApoyo::All()->last();
            
            $contadorComite = count($request['Tercero_idPrincipal']);
            for($i = 0; $i < $contadorComite; $i++)
            {
                \App\ConformacionGrupoApoyoComite::create([
                'ConformacionGrupoApoyo_idConformacionGrupoApoyo' => $conformacionGrupoApoyo->idConformacionGrupoApoyo,
                'nombradoPorConformacionGrupoApoyoComite' => $request['nombradoPorConformacionGrupoApoyoComite'][$i],
                'Tercero_idPrincipal' => $request['Tercero_idPrincipal'][$i],
                'Tercero_idSuplente' => $request['Tercero_idSuplente'][$i]
               ]);
            }

            $contadorJurado = count($request['Tercero_idJurado']);
            for($i = 0; $i < $contadorJurado; $i++)
            {
                \App\ConformacionGrupoApoyoJurado::create([
                'ConformacionGrupoApoyo_idConformacionGrupoApoyo' => $conformacionGrupoApoyo->idConformacionGrupoApoyo,
                'Tercero_idJurado' => $request['Tercero_idJurado'][$i]
               ]);
            }

            $contadorResultado = count($request['Tercero_idCandidato']);
            for($i = 0; $i < $contadorResultado; $i++)
            {
                \App\ConformacionGrupoApoyoResultado::create([
                'ConformacionGrupoApoyo_idConformacionGrupoApoyo' => $conformacionGrupoApoyo->idConformacionGrupoApoyo,
                'Tercero_idCandidato' => $request['Tercero_idCandidato'][$i],
                'votosConformacionGrupoApoyoResultado' => $request['votosConformacionGrupoApoyoResultado'][$i]
               ]);
            }

            return redirect('/conformaciongrupoapoyo');
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
        $idTercero = \App\Tercero::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('idTercero');
        $nombreCompletoTercero = \App\Tercero::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('nombreCompletoTercero');
        $tercero = \App\Tercero::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('nombreCompletoTercero','idTercero');
        $grupoApoyo = \App\GrupoApoyo::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('nombreGrupoApoyo','idGrupoApoyo');
        $conformacionGrupoApoyo = \App\ConformacionGrupoApoyo::find($id);
        return view('conformaciongrupoapoyo',compact('grupoApoyo','tercero','idTercero','nombreCompletoTercero'),['conformacionGrupoApoyo'=>$conformacionGrupoApoyo]);
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
            $conformacionGrupoApoyo = \App\ConformacionGrupoApoyo::find($id);
            $conformacionGrupoApoyo->fill($request->all());

            $conformacionGrupoApoyo->save();

            \App\ConformacionGrupoApoyoComite::where('ConformacionGrupoApoyo_idConformacionGrupoApoyo',$id)->delete();
            \App\ConformacionGrupoApoyoJurado::where('ConformacionGrupoApoyo_idConformacionGrupoApoyo',$id)->delete();
            \App\ConformacionGrupoApoyoResultado::where('ConformacionGrupoApoyo_idConformacionGrupoApoyo',$id)->delete();
            
            $contadorComite = count($request['Tercero_idPrincipal']);
            for($i = 0; $i < $contadorComite; $i++)
            {
                \App\ConformacionGrupoApoyoComite::create([
                'ConformacionGrupoApoyo_idConformacionGrupoApoyo' => $id,
                'nombradoPorConformacionGrupoApoyoComite' => $request['nombradoPorConformacionGrupoApoyoComite'][$i],
                'Tercero_idPrincipal' => $request['Tercero_idPrincipal'][$i],
                'Tercero_idSuplente' => $request['Tercero_idSuplente'][$i]
               ]);
            }

            $contadorJurado = count($request['Tercero_idJurado']);
            for($i = 0; $i < $contadorJurado; $i++)
            {
                \App\ConformacionGrupoApoyoJurado::create([
                'ConformacionGrupoApoyo_idConformacionGrupoApoyo' => $id,
                'Tercero_idJurado' => $request['Tercero_idJurado'][$i]
               ]);
            }

            $contadorResultado = count($request['Tercero_idCandidato']);
            for($i = 0; $i < $contadorResultado; $i++)
            {
                \App\ConformacionGrupoApoyoResultado::create([
                'ConformacionGrupoApoyo_idConformacionGrupoApoyo' => $id,
                'Tercero_idCandidato' => $request['Tercero_idCandidato'][$i],
                'votosConformacionGrupoApoyoResultado' => $request['votosConformacionGrupoApoyoResultado'][$i]
               ]);
            }

            return redirect('/conformaciongrupoapoyo');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        \App\ConformacionGrupoApoyo::destroy($id);
        return redirect('/conformaciongrupoapoyo');
    }
}
