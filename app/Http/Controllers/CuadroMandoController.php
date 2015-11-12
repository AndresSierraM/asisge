<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CuadroMando;
use App\Http\Requests;
use App\Http\Requests\CuadroMandoRequest;
use App\Http\Controllers\Controller;


class CuadroMandoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {

        $cuadromando = \App\CuadroMando::All()->last();

        $politicasCompania = \App\Compania::where('idCompania', '=',1)->lists('politicasCompania');
        $idCompaniaObjetivo = \App\CompaniaObjetivo::where('Compania_idCompania', '=',1)->lists('idCompaniaObjetivo');
        $nombreCompaniaObjetivo = \App\CompaniaObjetivo::where('Compania_idCompania', '=',1)->lists('nombreCompaniaObjetivo');

        $idTercero = \App\Tercero::where('Compania_idCompania', '=',1)->lists('idTercero');
        $nombreTercero = \App\Tercero::where('Compania_idCompania', '=',1)->lists('nombreCompletoTercero');

        $idProceso = \App\Proceso::where('Compania_idCompania', '=',1)->lists('idProceso');
        $nombreProceso = \App\Proceso::where('Compania_idCompania', '=',1)->lists('nombreProceso');

        $idFrecuenciaMedicion = \App\FrecuenciaMedicion::All()->lists('idFrecuenciaMedicion');
        $nombreFrecuenciaMedicion = \App\FrecuenciaMedicion::All()->lists('nombreFrecuenciaMedicion');
        
        

        if(count($cuadromando) > 0)
        {
            return view('cuadromando', 
                compact('idCompaniaObjetivo','nombreCompaniaObjetivo',
                        'idTercero','nombreTercero',
                        'idProceso','nombreProceso',
                        'idFrecuenciaMedicion','nombreFrecuenciaMedicion','politicasCompania'),
                ['cuadromando'=>$cuadromando]);
        }
        else
        {
            return view('cuadromando', 
                compact('idCompaniaObjetivo','nombreCompaniaObjetivo',
                        'idTercero','nombreTercero',
                        'idProceso','nombreProceso',
                        'idFrecuenciaMedicion','nombreFrecuenciaMedicion','politicasCompania'));
        }
        
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
            'fechaCreacionCuadroMando' => date('Y-m-d H:i:s'),
            'fechaModificacionCuadroMando' => date('Y-m-d H:i:s'),
            'Compania_idCompania' => 1,
            ]); 

        $cuadromando = \App\CuadroMando::All()->last();
        $contadorDetalle = count($request['CompaniaObjetivo_idCompaniaObjetivo']);
        

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
        $cuadromando->fechaModificacionCuadroMando = date('Y-m-d H:i:s');
        $cuadromando->save();

        \App\CuadroMandoDetalle::where('CuadroMando_idCuadroMando',$id)->delete();

        $contadorDetalle = count($request['CompaniaObjetivo_idCompaniaObjetivo']);
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
