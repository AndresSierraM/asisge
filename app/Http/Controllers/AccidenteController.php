<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\AccidenteRequest;

use Illuminate\Routing\Route;

class AccidenteController extends Controller
{
    public function _construct(){
        $this->beforeFilter('@find',['only'=>['edit','update','destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function find(Route $route){
        $this->accidente = \App\Accidente::find($route->getParameter('accidente'));
        return $this->accidente;
    }

    public function index()
    {
        return view('accidentegrid');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $terceroCoord = \App\Tercero::All()->lists('nombreCompletoTercero','idTercero');
        $terceroEmple = \App\Tercero::All()->lists('nombreCompletoTercero','idTercero');
        $ausentismo  = \App\Ausentismo::All()->lists('nombreAusentismo','idAusentismo');
        $proceso  = \App\Proceso::All()->lists('nombreProceso','idProceso');
        $idProceso  = \App\Proceso::All()->lists('idProceso');
        $nombreProceso  = \App\Proceso::All()->lists('nombreProceso');
        $idTercero = \App\Tercero::All()->lists('idTercero');
        $nombreCompletoTercero = \App\Tercero::All()->lists('nombreCompletoTercero');
        return view('accidente',compact('terceroCoord','terceroEmple','ausentismo',
            'proceso','idProceso','nombreProceso','idTercero','nombreCompletoTercero'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(AccidenteRequest $request)
    {
        
        \App\Accidente::create([
            'numeroAccidente' => $request['numeroAccidente'],
            'nombreAccidente' => $request['nombreAccidente'],
            'clasificacionAccidente' => $request['clasificacionAccidente'],
            'Ausentismo_idAusentismo' => (($request['Ausentismo_idAusentismo'] == '') ? null : $request['Ausentismo_idAusentismo']),
            'Tercero_idCoordinador' => $request['Tercero_idCoordinador'],
            'Tercero_idEmpleado' => $request['Tercero_idEmpleado'],
            'edadEmpleadoAccidente' => $request['edadEmpleadoAccidente'],
            'tiempoServicioAccidente' => $request['tiempoServicioAccidente'],
            'Proceso_idProceso' => $request['Proceso_idProceso'],
            'enSuLaborAccidente' => (($request['enSuLaborAccidente'] !== null) ? 1 : 0),
            'laborAccidente' => $request['laborAccidente'],
            'enLaEmpresaAccidente' => (($request['enLaEmpresaAccidente'] !== null) ? 1 : 0),
            'lugarAccidente' => $request['lugarAccidente'],
            'fechaOcurrenciaAccidente' => $request['fechaOcurrenciaAccidente'],
            'tiempoEnLaborAccidente' => $request['tiempoEnLaborAccidente'],
            'tareaDesarrolladaAccidente' => $request['tareaDesarrolladaAccidente'],
            'descripcionAccidente' => $request['descripcionAccidente'],
            'observacionTrabajadorAccidente' => $request['observacionTrabajadorAccidente'],
            'observacionEmpresaAccidente' => $request['observacionEmpresaAccidente'],
            'agenteYMecanismoAccidente' => $request['agenteYMecanismoAccidente'],
            'naturalezaLesionAccidente' => $request['naturalezaLesionAccidente'],
            'parteCuerpoAfectadaAccidente' => $request['parteCuerpoAfectadaAccidente'],
            'tipoAccidente' => $request['tipoAccidente'],
            'observacionAccidente'  => $request['observacionAccidente']
            ]);


        $accidente = \App\Accidente::All()->last();
        $contadorDetalle = count($request['idAccidenteRecomendacion']);
        
        for($i = 0; $i < $contadorDetalle; $i++)
        {
            \App\AccidenteRecomendacion::create([

                'idAccidenteRecomendacion' => $request['idAccidenteRecomendacion'][$i], 
                'Accidente_idAccidente' => $accidente->idAccidente, 
                'controlAccidenteRecomendacion' => $request['controlAccidenteRecomendacion'][$i], 
                'fuenteAccidenteRecomendacion' => $request['fuenteAccidenteRecomendacion'][$i], 
                'medioAccidenteRecomendacion' => $request['medioAccidenteRecomendacion'][$i], 
                'personaAccidenteRecomendacion' => $request['personaAccidenteRecomendacion'][$i], 
                'fechaVerificacionAccidenteRecomendacion' => $request['fechaVerificacionAccidenteRecomendacion'][$i], 
                'medidaEfectivaAccidenteRecomendacion' => $request['medidaEfectivaAccidenteRecomendacion'][$i], 
                'Proceso_idResponsable' => $request['Proceso_idResponsable'][$i]
            ]);
        }

        return redirect('/accidente');
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
        $accidente = \App\Accidente::find($id);
        $terceroCoord = \App\Tercero::All()->lists('nombreCompletoTercero','idTercero');
        $terceroEmple = \App\Tercero::All()->lists('nombreCompletoTercero','idTercero');
        $ausentismo  = \App\Ausentismo::All()->lists('nombreAusentismo','idAusentismo');
        $proceso  = \App\Proceso::All()->lists('nombreProceso','idProceso');
        $idProceso  = \App\Proceso::All()->lists('idProceso');
        $nombreProceso  = \App\Proceso::All()->lists('nombreProceso');
        $idTercero = \App\Tercero::All()->lists('idTercero');
        $nombreCompletoTercero = \App\Tercero::All()->lists('nombreCompletoTercero');
        return view('accidente',compact('terceroCoord','terceroEmple','ausentismo',
            'proceso','idProceso','nombreProceso','idTercero','nombreCompletoTercero'),['accidente'=>$accidente]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(AccidenteRequest $request, $id)
    {
        $accidente = \App\Accidente::find($id);
        $accidente->fill($request->all());
        $accidente->enSuLaborAccidente = (($request['enSuLaborAccidente'] !== null) ? 1 : 0);
        $accidente->enLaEmpresaAccidente = (($request['enLaEmpresaAccidente'] !== null) ? 1 : 0);
        $accidente->Ausentismo_idAusentismo = (($request['Ausentismo_idAusentismo'] == '') ? null : $request['Ausentismo_idAusentismo']);

        $accidente->save();

        \App\AccidenteRecomendacion::where('Accidente_idAccidente',$id)->delete();

        $contadorDetalle = count($request['idAccidenteRecomendacion']);
        
        for($i = 0; $i < $contadorDetalle; $i++)
        {
            \App\AccidenteRecomendacion::create([

                'idAccidenteRecomendacion' => $request['idAccidenteRecomendacion'][$i], 
                'Accidente_idAccidente' => $id, 
                'controlAccidenteRecomendacion' => $request['controlAccidenteRecomendacion'][$i], 
                'fuenteAccidenteRecomendacion' => $request['fuenteAccidenteRecomendacion'][$i], 
                'medioAccidenteRecomendacion' => $request['medioAccidenteRecomendacion'][$i], 
                'personaAccidenteRecomendacion' => $request['personaAccidenteRecomendacion'][$i], 
                'fechaVerificacionAccidenteRecomendacion' => $request['fechaVerificacionAccidenteRecomendacion'][$i], 
                'medidaEfectivaAccidenteRecomendacion' => $request['medidaEfectivaAccidenteRecomendacion'][$i], 
                'Proceso_idResponsable' => $request['Proceso_idResponsable'][$i]
            ]);
        }

        \App\AccidenteEquipo::where('Accidente_idAccidente',$id)->delete();

        $contadorDetalle = count($request['idAccidenteEquipo']);
        
        for($i = 0; $i < $contadorDetalle; $i++)
        {
            \App\AccidenteEquipo::create([

                'idAccidenteEquipo' => $request['idAccidenteEquipo'][$i], 
                'Accidente_idAccidente' => $id, 
                'Tercero_idInvestigador' => $request['Tercero_idInvestigador'][$i]
            ]);
        }

       return redirect('/accidente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        \App\Accidente::destroy($id);
        return redirect('/accidente');
    }
}
