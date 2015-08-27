<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CuadroMando;
use App\Http\Requests;
use App\Http\Requests\CuadroMandoRequest;
use App\Http\Controllers\Controller;
use App\Http\Controllers\CuadroMandoDetalle;


class CuadroMandoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $idCompaniaObjetivo = \App\CompaniaObjetivo::where('Compania_idCompania', '=',1)->lists('idCompaniaObjetivo');
        $nombreCompaniaObjetivo = \App\CompaniaObjetivo::where('Compania_idCompania', '=',1)->lists('nombreCompaniaObjetivo');

        $idTercero = \App\Tercero::where('Compania_idCompania', '=',1)->lists('idTercero');
        $nombreTercero = \App\Tercero::where('Compania_idCompania', '=',1)->lists('nombreCompletoTercero');

        $idProceso = \App\Proceso::where('Compania_idCompania', '=',1)->lists('idProceso');
        $nombreProceso = \App\Proceso::where('Compania_idCompania', '=',1)->lists('nombreProceso');

        $idFrecuenciaMedicion = \App\FrecuenciaMedicion::All()->lists('idFrecuenciaMedicion');
        $nombreFrecuenciaMedicion = \App\FrecuenciaMedicion::All()->lists('nombreFrecuenciaMedicion');
        
        return view('cuadromando', compact('idCompaniaObjetivo','nombreCompaniaObjetivo',
                                            'idTercero','nombreTercero',
                                            'idProceso','nombreProceso',
                                            'idFrecuenciaMedicion','nombreFrecuenciaMedicion'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
       
        //$idOpcion = \App\Opcion::All()->lists('idOpcion');
        //$nombreOpcion = \App\Opcion::All()->lists('nombreOpcion');
        //compact('idOpcion','nombreOpcion')
        return view('cuadromando');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(CuadroMandoRequest $request)
    {
        
        \App\CuadroMando::create([
            'politicasCuadroMando' => $request['politicasCuadroMando'],
            'fechaCreacionCuadroMando' => $request['fechaCreacionCuadroMando'],
            'fechaModificacionCuadroMando' => $request['fechaModificacionCuadroMando'],
            'Compania_idCompania' => $request['Compania_idCompania'],
            ]); 

        $cuadromando = \App\CuadroMando::All()->last();
        $contadorDetalle = count($request['CuadroMando_idCuadroMando']);
        

        for($i = 0; $i < $contadorDetalle; $i++)
        {
            \App\CuadroMandoDetalle::create([
            'CuadroMando_idCuadroMando' => $cuadromando->idCuadroMando,
            'CompaniaObjetivo_idCompaniaObjetivo' => $request['CompaniaObjetivo_idCompaniaObjetivo'][$i],
            'Proceso_idProceso' => $request['Proceso_idProceso'][$i],
            'objetivoEspecificoCuadroMandoDetalle' => $request['objetivoEspecificoCuadroMandoDetalle'][$i],
            'indicadorCuadroMandoDetalle' => $request['indicadorCuadroMandoDetalle'][$i],
            'operadorMetaCuadroMandoDetalle' => $request['operadorMetaCuadroMandoDetalle'][$i],
            'valorMetaCuadroMandoDetalle' => $request['valorMetaCuadroMandoDetalle'][$i],
            'tipoMetaCuadroMandoDetalle' => $request['tipoMetaCuadroMandoDetalle'][$i],
            'FrecuenciaMedicion_idFrecuenciaMedicion' => $request['FrecuenciaMedicion_idFrecuenciaMedicion'][$i],
            'Tercero_idResponsable' => $request['Tercero_idResponsable'][$i]

           ]);
        }

        return redirect('/cuadromando');
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
        $cuadromando = \App\CuadroMando::find($id);
        //$idOpcion = \App\Opcion::All()->lists('idOpcion');
        //$nombreOpcion = \App\Opcion::All()->lists('nombreOpcion');
        //,compact('idOpcion','nombreOpcion')
        return view('cuadromando',['cuadromando'=>$cuadromando]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update($id,CuadroMandoRequest $request)
    {
        
        $cuadromando = \App\CuadroMando::find($id);
        $cuadromando->fill($request->all());

        $cuadromando->save();

        \App\CuadroMandoDetalle::where('CuadroMando_idCuadroMando',$id)->delete();

        $contadorDetalle = count($request['CuadroMando_idCuadroMando']);
        for($i = 0; $i < $contadorDetalle; $i++)
        {
            \App\CuadroMandoDetalle::create([
            'CuadroMando_idCuadroMando' => $cuadromando->idCuadroMando,
            'CompaniaObjetivo_idCompaniaObjetivo' => $request['CompaniaObjetivo_idCompaniaObjetivo'][$i],
            'Proceso_idProceso' => $request['Proceso_idProceso'][$i],
            'objetivoEspecificoCuadroMandoDetalle' => $request['objetivoEspecificoCuadroMandoDetalle'][$i],
            'indicadorCuadroMandoDetalle' => $request['indicadorCuadroMandoDetalle'][$i],
            'operadorMetaCuadroMandoDetalle' => $request['operadorMetaCuadroMandoDetalle'][$i],
            'valorMetaCuadroMandoDetalle' => $request['valorMetaCuadroMandoDetalle'][$i],
            'tipoMetaCuadroMandoDetalle' => $request['tipoMetaCuadroMandoDetalle'][$i],
            'FrecuenciaMedicion_idFrecuenciaMedicion' => $request['FrecuenciaMedicion_idFrecuenciaMedicion'][$i],
            'Tercero_idResponsable' => $request['Tercero_idResponsable'][$i]

           ]);
        }


        return redirect('/cuadromando');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    

    public function destroy($id)
    {

        \App\CuadroMando::destroy($id);
        return redirect('/cuadromando');
    }
}
