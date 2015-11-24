<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class CargoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('cargogrid');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $idListaTarea = \App\ListaGeneral::where('tipoListaGeneral','TareaAltoRiesgo')->lists('idListaGeneral');
        $nombreListaTarea = \App\ListaGeneral::where('tipoListaGeneral','TareaAltoRiesgo')->lists('nombreListaGeneral');
        
        $idListaExamen = \App\ListaGeneral::where('tipoListaGeneral','ExamenMedico')->lists('idListaGeneral');
        $nombreListaExamen = \App\ListaGeneral::where('tipoListaGeneral','ExamenMedico')->lists('nombreListaGeneral');

        $idListaVacuna = \App\ListaGeneral::where('tipoListaGeneral','Vacuna')->lists('idListaGeneral');
        $nombreListaVacuna = \App\ListaGeneral::where('tipoListaGeneral','Vacuna')->lists('nombreListaGeneral');

        $idListaElemento = \App\ListaGeneral::where('tipoListaGeneral','ElementoProteccion')->lists('idListaGeneral');
        $nombreListaElemento = \App\ListaGeneral::where('tipoListaGeneral','ElementoProteccion')->lists('nombreListaGeneral');

        $idFrecuenciaMedicion = \App\FrecuenciaMedicion::All()->lists('idFrecuenciaMedicion');
        $nombreFrecuenciaMedicion = \App\FrecuenciaMedicion::All()->lists('nombreFrecuenciaMedicion');
        
        return view('cargo',compact('idListaTarea','nombreListaTarea','idListaExamen','nombreListaExamen','idListaVacuna','nombreListaVacuna','idListaElemento','nombreListaElemento','idFrecuenciaMedicion','nombreFrecuenciaMedicion','idFrecuenciaMedicion','nombreFrecuenciaMedicion'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        \App\Cargo::create([
            'codigoCargo' => $request['codigoCargo'],
            'nombreCargo' => $request['nombreCargo'],
            'salarioBaseCargo' => $request['salarioBaseCargo'],
            'nivelRiesgoCargo' => $request['nivelRiesgoCargo'],
            'objetivoCargo' => $request['objetivoCargo'],
            'educacionCargo' => $request['educacionCargo'],
            'experienciaCargo' => $request['experienciaCargo'],
            'formacionCargo' => $request['formacionCargo'],
            'posicionPredominanteCargo' => $request['posicionPredominanteCargo'],
            'restriccionesCargo' => $request['restriccionesCargo'],
            'habilidadesCargo' => $request['habilidadesCargo'],
            'responsabilidadesCargo' => $request['responsabilidadesCargo'],
            'autoridadesCargo' => $request['autoridadesCargo']
            ]);

        $cargo = \App\Cargo::All()->last();
        
        $contadorElemento = count($request['ListaGeneral_idElementoProteccion']);
        for($i = 0; $i < $contadorElemento; $i++)
        {
            \App\CargoElementoProteccion::create([
            'Cargo_idCargo' => $cargo->idCargo,
            'ListaGeneral_idElementoProteccion' => $request['ListaGeneral_idElementoProteccion'][$i]
           ]);
        }

        $contadorRiesgo = count($request['ListaGeneral_idTareaAltoRiesgo']);
        for($i = 0; $i < $contadorRiesgo; $i++)
        {
            \App\CargoTareaRiesgo::create([
            'Cargo_idCargo' => $cargo->idCargo,
            'ListaGeneral_idTareaAltoRiesgo' => $request['ListaGeneral_idTareaAltoRiesgo'][$i]
           ]);
        }

        $contadorVacuna = count($request['ListaGeneral_idVacuna']);
        for($i = 0; $i < $contadorVacuna; $i++)
        {
            \App\CargoVacuna::create([
            'Cargo_idCargo' => $cargo->idCargo,
            'ListaGeneral_idVacuna' => $request['ListaGeneral_idVacuna'][$i]
           ]);
        }

        $contadorExamen = count($request['ListaGeneral_idExamenMedico']);
        
        for($i = 0; $i < $contadorExamen; $i++)
        {
            \App\CargoExamenMedico::create([
            'Cargo_idCargo' => $cargo->idCargo,
            'ListaGeneral_idExamenMedico' => $request['ListaGeneral_idExamenMedico'][$i], 
            'ingresoCargoExamenMedico' => $request['ingresoCargoExamenMedico'][$i], 
            'retiroCargoExamenMedico' => $request['retiroCargoExamenMedico'][$i], 
            'periodicoCargoExamenMedico' => $request['periodicoCargoExamenMedico'][$i], 
            'FrecuenciaMedicion_idFrecuenciaMedicion' => $request['FrecuenciaMedicion_idFrecuenciaMedicion'][$i]   
           ]);
        }

        return redirect('/cargo');

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
        $idListaTarea = \App\ListaGeneral::where('tipoListaGeneral','TareaAltoRiesgo')->lists('idListaGeneral');
        $nombreListaTarea = \App\ListaGeneral::where('tipoListaGeneral','TareaAltoRiesgo')->lists('nombreListaGeneral');
        
        $idListaExamen = \App\ListaGeneral::where('tipoListaGeneral','ExamenMedico')->lists('idListaGeneral');
        $nombreListaExamen = \App\ListaGeneral::where('tipoListaGeneral','ExamenMedico')->lists('nombreListaGeneral');

        $idListaVacuna = \App\ListaGeneral::where('tipoListaGeneral','Vacuna')->lists('idListaGeneral');
        $nombreListaVacuna = \App\ListaGeneral::where('tipoListaGeneral','Vacuna')->lists('nombreListaGeneral');

        $idListaElemento = \App\ListaGeneral::where('tipoListaGeneral','ElementoProteccion')->lists('idListaGeneral');
        $nombreListaElemento = \App\ListaGeneral::where('tipoListaGeneral','ElementoProteccion')->lists('nombreListaGeneral');

        $idFrecuenciaMedicion = \App\FrecuenciaMedicion::All()->lists('idFrecuenciaMedicion');
        $nombreFrecuenciaMedicion = \App\FrecuenciaMedicion::All()->lists('nombreFrecuenciaMedicion');
        $cargo = \App\Cargo::find($id);
        return view('cargo',compact('idListaTarea','nombreListaTarea','idListaExamen','nombreListaExamen','idListaVacuna','nombreListaVacuna','idListaElemento','nombreListaElemento','idFrecuenciaMedicion','nombreFrecuenciaMedicion','idFrecuenciaMedicion','nombreFrecuenciaMedicion'),['cargo'=>$cargo]);
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
        $cargo = \App\Cargo::find($id);
        $cargo->fill($request->all());

        $cargo->save();

        \App\CargoElementoProteccion::where('Cargo_idCargo',$id)->delete();
        \App\CargoTareaRiesgo::where('Cargo_idCargo',$id)->delete();
        \App\CargoVacuna::where('Cargo_idCargo',$id)->delete();
        \App\CargoExamenMedico::where('Cargo_idCargo',$id)->delete();

        $contadorElemento = count($request['ListaGeneral_idElementoProteccion']);
        for($i = 0; $i < $contadorElemento; $i++)
        {
            \App\CargoElementoProteccion::create([
            'Cargo_idCargo' => $id,
            'ListaGeneral_idElementoProteccion' => $request['ListaGeneral_idElementoProteccion'][$i]
           ]);
        }

        $contadorRiesgo = count($request['ListaGeneral_idTareaAltoRiesgo']);
        for($i = 0; $i < $contadorRiesgo; $i++)
        {
            \App\CargoTareaRiesgo::create([
            'Cargo_idCargo' => $id,
            'ListaGeneral_idTareaAltoRiesgo' => $request['ListaGeneral_idTareaAltoRiesgo'][$i]
           ]);
        }

        $contadorVacuna = count($request['ListaGeneral_idVacuna']);
        for($i = 0; $i < $contadorVacuna; $i++)
        {
            \App\CargoVacuna::create([
            'Cargo_idCargo' => $id,
            'ListaGeneral_idVacuna' => $request['ListaGeneral_idVacuna'][$i]
           ]);
        }

        $contadorExamen = count($request['ListaGeneral_idExamenMedico']);
        for($i = 0; $i < $contadorExamen; $i++)
        {
            \App\CargoExamenMedico::create([
            'Cargo_idCargo' => $cargo->idCargo,
            'ListaGeneral_idExamenMedico' => $request['ListaGeneral_idExamenMedico'][$i], 
            'ingresoCargoExamenMedico' => $request['ingresoCargoExamenMedico'][$i], 
            'retiroCargoExamenMedico' => $request['retiroCargoExamenMedico'][$i], 
            'periodicoCargoExamenMedico' => $request['periodicoCargoExamenMedico'][$i], 
            'FrecuenciaMedicion_idFrecuenciaMedicion' => $request['FrecuenciaMedicion_idFrecuenciaMedicion'][$i]   
           ]);
        }

        return redirect('/cargo');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        \App\Cargo::destroy($id);
        return redirect('/cargo');
    }
}
