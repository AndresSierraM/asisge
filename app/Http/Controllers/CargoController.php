<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\CargoRequest;
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
        
        $idTipoExamen = \App\TipoExamenMedico::All()->lists('idTipoExamenMedico');
        $nombreTipoExamen = \App\TipoExamenMedico::All()->lists('nombreTipoExamenMedico');

        $idListaVacuna = \App\ListaGeneral::where('tipoListaGeneral','Vacuna')->lists('idListaGeneral');
        $nombreListaVacuna = \App\ListaGeneral::where('tipoListaGeneral','Vacuna')->lists('nombreListaGeneral');

        $idListaElemento = \App\ElementoProteccion::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('idElementoProteccion');
        $nombreListaElemento = \App\ElementoProteccion::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('nombreElementoProteccion');

        $idFrecuenciaMedicion = \App\FrecuenciaMedicion::All()->lists('idFrecuenciaMedicion');
        $nombreFrecuenciaMedicion = \App\FrecuenciaMedicion::All()->lists('nombreFrecuenciaMedicion');
        
        return view('cargo',compact('idListaTarea','nombreListaTarea','idTipoExamen','nombreTipoExamen','idListaVacuna','nombreListaVacuna','idListaElemento','nombreListaElemento','idFrecuenciaMedicion','nombreFrecuenciaMedicion','idFrecuenciaMedicion','nombreFrecuenciaMedicion'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(CargoRequest $request)
    {
        if($request['respuesta'] != 'falso')
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
                'autoridadesCargo' => $request['autoridadesCargo'],
                'Compania_idCompania' => \Session::get('idCompania')
                ]);

            $cargo = \App\Cargo::All()->last();
            
            //---------------------------------
            // guardamos las tablas de detalle
            //---------------------------------
            $this->grabarDetalle($cargo->idCargo, $request);

            return redirect('/cargo');
        }

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
        
        $idTipoExamen = \App\TipoExamenMedico::All()->lists('idTipoExamenMedico');
        $nombreTipoExamen = \App\TipoExamenMedico::All()->lists('nombreTipoExamenMedico');

        $idListaVacuna = \App\ListaGeneral::where('tipoListaGeneral','Vacuna')->lists('idListaGeneral');
        $nombreListaVacuna = \App\ListaGeneral::where('tipoListaGeneral','Vacuna')->lists('nombreListaGeneral');

        $idListaElemento = \App\ElementoProteccion::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('idElementoProteccion');
        $nombreListaElemento = \App\ElementoProteccion::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('nombreElementoProteccion');

        $idFrecuenciaMedicion = \App\FrecuenciaMedicion::All()->lists('idFrecuenciaMedicion');
        $nombreFrecuenciaMedicion = \App\FrecuenciaMedicion::All()->lists('nombreFrecuenciaMedicion');
        $cargo = \App\Cargo::find($id);
        return view('cargo',compact('idListaTarea','nombreListaTarea','idTipoExamen','nombreTipoExamen','idListaVacuna','nombreListaVacuna','idListaElemento','nombreListaElemento','idFrecuenciaMedicion','nombreFrecuenciaMedicion','idFrecuenciaMedicion','nombreFrecuenciaMedicion'),['cargo'=>$cargo]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(CargoRequest $request, $id)
    {
        if($request['respuesta'] != 'falso')
        {    
            $cargo = \App\Cargo::find($id);
            $cargo->fill($request->all());

            $cargo->save();

            //---------------------------------
            // guardamos las tablas de detalle
            //---------------------------------
            $this->grabarDetalle($cargo->idCargo, $request);

            return redirect('/cargo');
        }

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

    protected function grabarDetalle($id, $request)
    {
        // en el formulario hay un campo oculto en el que almacenamos los id que se eliminan separados por coma
        // en este proceso lo convertimos en array y eliminamos dichos id de la tabla de detalle
        $idsEliminar = explode(',', $request['eliminarElemento']);
        \App\CargoElementoProteccion::whereIn('idCargoElementoProteccion',$idsEliminar)->delete();

        $contadorElemento = count($request['ElementoProteccion_idElementoProteccion']);
        for($i = 0; $i < $contadorElemento; $i++)
        {

            $indice = array(
             'idCargoElementoProteccion' => $request['idCargoElementoProteccion'][$i]);

            $data = array(
             'Cargo_idCargo' => $id,
             'ElementoProteccion_idElementoProteccion' => $request['ElementoProteccion_idElementoProteccion'][$i]);

            $preguntas = \App\CargoElementoProteccion::updateOrCreate($indice, $data);

        }


        // en el formulario hay un campo oculto en el que almacenamos los id que se eliminan separados por coma
        // en este proceso lo convertimos en array y eliminamos dichos id de la tabla de detalle
        $idsEliminar = explode(',', $request['eliminarTarea']);
        \App\CargoTareaRiesgo::whereIn('idCargoTareaRiesgo',$idsEliminar)->delete();
        
        $contadorRiesgo = count($request['ListaGeneral_idTareaAltoRiesgo']);
        for($i = 0; $i < $contadorRiesgo; $i++)
        {
            $indice = array(
             'idCargoTareaRiesgo' => $request['idCargoTareaRiesgo'][$i]);

            $data = array(
             'Cargo_idCargo' => $id,
             'ListaGeneral_idTareaAltoRiesgo' => $request['ListaGeneral_idTareaAltoRiesgo'][$i]);

            $preguntas = \App\CargoTareaRiesgo::updateOrCreate($indice, $data);

        }


        // en el formulario hay un campo oculto en el que almacenamos los id que se eliminan separados por coma
        // en este proceso lo convertimos en array y eliminamos dichos id de la tabla de detalle
        $idsEliminar = explode(',', $request['eliminarVacuna']);
        \App\CargoVacuna::whereIn('idCargoVacuna',$idsEliminar)->delete();
        
        $contadorVacuna = count($request['ListaGeneral_idVacuna']);
        for($i = 0; $i < $contadorVacuna; $i++)
        {

            $indice = array(
             'idCargoVacuna' => $request['idCargoVacuna'][$i]);

            $data = array(
             'Cargo_idCargo' => $id,
             'ListaGeneral_idVacuna' => $request['ListaGeneral_idVacuna'][$i]);

            $preguntas = \App\CargoVacuna::updateOrCreate($indice, $data);

        }


        // en el formulario hay un campo oculto en el que almacenamos los id que se eliminan separados por coma
        // en este proceso lo convertimos en array y eliminamos dichos id de la tabla de detalle
        $idsEliminar = explode(',', $request['eliminarExamen']);
        \App\CargoExamenMedico::whereIn('idCargoExamenMedico',$idsEliminar)->delete();

        $contadorExamen = count($request['TipoExamenMedico_idTipoExamenMedico']);
        
        for($i = 0; $i < $contadorExamen; $i++)
        {

            $indice = array(
             'idCargoExamenMedico' => $request['idCargoExamenMedico'][$i]);

            $data = array(
             'Cargo_idCargo' => $id,
            'TipoExamenMedico_idTipoExamenMedico' => $request['TipoExamenMedico_idTipoExamenMedico'][$i], 
            'ingresoCargoExamenMedico' => $request['ingresoCargoExamenMedico'][$i], 
            'retiroCargoExamenMedico' => $request['retiroCargoExamenMedico'][$i], 
            'periodicoCargoExamenMedico' => $request['periodicoCargoExamenMedico'][$i], 
            'FrecuenciaMedicion_idFrecuenciaMedicion' => $request['FrecuenciaMedicion_idFrecuenciaMedicion'][$i] );

            $preguntas = \App\CargoExamenMedico::updateOrCreate($indice, $data);

           
        }
    }
}
