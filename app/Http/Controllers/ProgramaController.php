<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Programa;
use App\Http\Requests;
use App\Http\Requests\ProgramaRequest;
use App\Http\Controllers\Controller;
use DB;

class ProgramaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        
        return view('programagrid');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        // cuando se crea un nuevo programa, enviamos los maestros requeridos para el encabezado         
        $clasificacionriesgo = \App\ClasificacionRiesgo::All()->lists('nombreClasificacionRiesgo','idClasificacionRiesgo');
        $terceros = \App\Tercero::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('nombreCompletoTercero', 'idTercero');
        $companiaobjetivo = \App\CompaniaObjetivo::All()->lists('nombreCompaniaObjetivo','idCompaniaObjetivo');

        $idTercero = \App\Tercero::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('idTercero');
        $nombreCompletoTercero = \App\Tercero::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('nombreCompletoTercero');

        $idDocumento = \App\Documento::All()->lists('idDocumento');
        $nombreDocumento = \App\Documento::All()->lists('nombreDocumento');

        return view('programa',compact('clasificacionriesgo','terceros','companiaobjetivo', 'nombreCompletoTercero', 'idTercero', 'nombreDocumento', 'idDocumento'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(ProgramaRequest $request)
    {
        
        \App\Programa::create([
            'nombrePrograma' => $request['nombrePrograma'],
            'fechaElaboracionPrograma' => $request['fechaElaboracionPrograma'],
            'ClasificacionRiesgo_idClasificacionRiesgo' => $request['ClasificacionRiesgo_idClasificacionRiesgo'],
            'alcancePrograma' => $request['alcancePrograma'],
            'CompaniaObjetivo_idCompaniaObjetivo' => $request['CompaniaObjetivo_idCompaniaObjetivo'],
            'objetivoEspecificoPrograma' => $request['objetivoEspecificoPrograma'],
            'Tercero_idElabora' => $request['Tercero_idElabora'],
            'Compania_idCompania' => \Session::get('idCompania')
            ]); 

        $programa = \App\Programa::All()->last();
        $contadorDetalle = count($request['actividadProgramaDetalle']);
        for($i = 0; $i < $contadorDetalle; $i++)
        {
            \App\ProgramaDetalle::create([
            'Programa_idPrograma' => $programa->idPrograma,
            'actividadProgramaDetalle' => $request['actividadProgramaDetalle'][$i],
            'Tercero_idResponsable' => $request['Tercero_idResponsable'][$i],
            'fechaPlaneadaProgramaDetalle' => $request['fechaPlaneadaProgramaDetalle'][$i],
            'Documento_idDocumento' => $request['Documento_idDocumento'][$i],
            'recursoPlaneadoProgramaDetalle' => $request['recursoPlaneadoProgramaDetalle'][$i],
            'recursoEjecutadoProgramaDetalle' => $request['recursoEjecutadoProgramaDetalle'][$i],
            'fechaEjecucionProgramaDetalle' => $request['fechaEjecucionProgramaDetalle'][$i],
            'observacionProgramaDetalle' => $request['observacionProgramaDetalle'][$i]
           ]);
        }

        return redirect('/programa');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id, Request $request)
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

        $programa = \App\Programa::find($id);

        // cuando se modifica  un programa, enviamos los maestros requeridos para el encabezado         
        $clasificacionriesgo = \App\ClasificacionRiesgo::All()->lists('nombreClasificacionRiesgo','idClasificacionRiesgo');
        $terceros = \App\Tercero::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('nombreCompletoTercero', 'idTercero');
        $companiaobjetivo = \App\CompaniaObjetivo::All()->lists('nombreCompaniaObjetivo','idCompaniaObjetivo');

        $idTercero = \App\Tercero::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('idTercero');
        $nombreCompletoTercero = \App\Tercero::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('nombreCompletoTercero');

        $idDocumento = \App\Documento::All()->lists('idDocumento');
        $nombreDocumento = \App\Documento::All()->lists('nombreDocumento');

        return view('programa',
                    compact('clasificacionriesgo','terceros','companiaobjetivo', 'nombreCompletoTercero', 'idTercero', 'nombreDocumento', 'idDocumento'),
                    ['programa'=>$programa]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update($id,ProgramaRequest $request)
    {
        
        $programa = \App\Programa::find($id);
        $programa->fill($request->all());
        $programa->save();

        \App\ProgramaDetalle::where('Programa_idPrograma',$id)->delete();

        $contadorDetalle = count($request['actividadProgramaDetalle']);
        for($i = 0; $i < $contadorDetalle; $i++)
        {
            \App\ProgramaDetalle::create([
            'Programa_idPrograma' => $id,
            'actividadProgramaDetalle' => $request['actividadProgramaDetalle'][$i],
            'Tercero_idResponsable' => $request['Tercero_idResponsable'][$i],
            'fechaPlaneadaProgramaDetalle' => $request['fechaPlaneadaProgramaDetalle'][$i],
            'Documento_idDocumento' => $request['Documento_idDocumento'][$i],
            'recursoPlaneadoProgramaDetalle' => $request['recursoPlaneadoProgramaDetalle'][$i],
            'recursoEjecutadoProgramaDetalle' => $request['recursoEjecutadoProgramaDetalle'][$i],
            'fechaEjecucionProgramaDetalle' => $request['fechaEjecucionProgramaDetalle'][$i],
            'observacionProgramaDetalle' => $request['observacionProgramaDetalle'][$i]
           ]);
        }

        return redirect('/programa');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    

    public function destroy($id)
    {

        \App\Programa::destroy($id);
        return redirect('/programa');
    }
}
