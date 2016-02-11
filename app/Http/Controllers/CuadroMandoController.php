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
        return view('cuadromandogrid');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $companiaobjetivo = \App\CompaniaObjetivo::All()->lists('nombreCompaniaObjetivo','idCompaniaObjetivo');
        $proceso = \App\Proceso::All()->lists('nombreProceso','idProceso');
        $frecuenciamedicion = \App\FrecuenciaMedicion::All()->lists('nombreFrecuenciaMedicion','idFrecuenciaMedicion');
        $tercero = \App\Tercero::All()->lists('nombreCompletoTercero','idTercero');
        $modulo = \App\Modulo::All()->lists('nombreModulo', 'idModulo');

        return view('cuadromando',compact('companiaobjetivo','proceso','frecuenciamedicion','tercero','modulo'));

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
            'numeroCuadroMando'=> $request['numeroCuadroMando'],
            'CompaniaObjetivo_idCompaniaObjetivo'=> $request['CompaniaObjetivo_idCompaniaObjetivo'],
            'Compania_idCompania' => 1,
            'Proceso_idProceso' =>$request['Proceso_idProceso'],
            'objetivoEspecificoCuadroMando' => $request['objetivoEspecificoCuadroMando'],
            'indicadorCuadroMando' => $request['indicadorCuadroMando'],
            'definicionIndicadorCuadroMando' => $request['definicionIndicadorCuadroMando'],
            'formulaCuadroMando' => $request['formulaCuadroMando'],
            'operadorMetaCuadroMando' => $request['operadorMetaCuadroMando'],
            'valorMetaCuadroMando' => $request['valorMetaCuadroMando'],
            'tipoMetaCuadroMando' => $request['tipoMetaCuadroMando'],
            'FrecuenciaMedicion_idFrecuenciaMedicion' => $request['FrecuenciaMedicion_idFrecuenciaMedicion'],
            'visualizacionCuadroMando' => $request['visualizacionCuadroMando'],
            'Tercero_idResponsable' => $request['Tercero_idResponsable']
            ]);

           /* $cuadromando = \App\CuadroMandoFormula::All()->last();
            $contadorCuadroMandoFormula = count($request['tipoCuadroMandoFormula']);
            for ($i=0; $i <$contadorCuadroMandoFormula ; $i++) 
            { 
                \App\CuadroMandoFormula::create([
                'CuadroMando_idCuadroMando' => $cuadromando->idCuadroMando,
                'tipoCuadroMandoFormula' => $request['tipoCuadroMandoFormula'],
                'CuadroMando_idIndicador' => $request['CuadroMando_idIndicador'],
                'nombreCuadroMandoFormula' => $request['nombreCuadroMandoFormula'],
                'Modulo_idModulo' => $request['Modulo_idModulo'],
                'campoCuadroMandoFormula' => $request['campoCuadroMandoFormula'],
                'calculoCuadroMandoFormula' => $request['calculoCuadroMandoFormula']
                ]);

                $cuadromandoformula = \App\CuadroMandoFormula::All()->last();
                $contadorCuadroMandoCondicion = count($request['tipoCuadroMandoFormula']);
                for ($i=0; $i <$contadorCuadroMandoCondicion; $i++) 
                { 
                    \App\CuadroMandoCondicion::create([
                    'CuadroMandoFormula_idCuadroMando' => $cuadromandoformula->idCuadroMandoFormula,
                    'parentesisInicioCuadroMandoCondicion' => $request['parentesisInicioCuadroMandoCondicion'],
                    'campoCuadroMandoCondicion' => $request['campoCuadroMandoCondicion'],
                    'operadorCuadroMandoCondicion' => $request['operadorCuadroMandoCondicion'],
                    'valorCuadroMandoCondicion' => $request['valorCuadroMandoCondicion'],
                    'parentesisFinCuadroMandoCondicion' => $request['parentesisFinCuadroMandoCondicion'],
                    'conectorCuadroMandoCondicion' => $request['conectorCuadroMandoCondicion']
                    ]);
                }

                $cuadromandoformula = \App\CuadroMandoFormula::All()->last();
                $contadorCuadroMandoAgrupador = count($request['campoCuadroMandoAgrupador']);
                for ($i=0; $i <$contadorCuadroMandoAgrupador ; $i++) 
                { 
                    \App\CuadroMandoAgrupador::create([
                    'CuadroMandoFormula_idCuadroMando' => $cuadromandoformula->idCuadroMandoFormula,
                    'campoCuadroMandoAgrupador' => $request['campoCuadroMandoAgrupador']
                    ]);
                }


                
            }*/

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
    public function edit($id, CuadroMandoRequest $request)
    {
        $cuadromando = \App\CuadroMando::find($id);
        //$cuadromandoformula = \App\CuadroMandoFormula::where('CuadroMando_idCuadroMando',$id)->list();
        $indicador = \App\CuadroMando::where('idCuadroMando','!=',$id)->lists('indicadorCuadroMando','idCuadroMando');;
        $companiaobjetivo = \App\CompaniaObjetivo::All()->lists('nombreCompaniaObjetivo','idCompaniaObjetivo');
        $proceso = \App\Proceso::All()->lists('nombreProceso','idProceso');
        $frecuenciamedicion = \App\FrecuenciaMedicion::All()->lists('nombreFrecuenciaMedicion','idFrecuenciaMedicion');
        $tercero = \App\Tercero::All()->lists('nombreCompletoTercero','idTercero');
        $modulo = \App\Modulo::All()->lists('nombreModulo', 'idModulo');

        return view('cuadromando',compact('indicador','companiaobjetivo','proceso','frecuenciamedicion','tercero','modulo'),['cuadromando'=>$cuadromando]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(CuadroMandoRequest $request, $id)
    {
        $cuadromando = \App\CuadroMando::find($id);
        $cuadromando->fill($request->all());
        $cuadromando->save();

        \App\CuadroMandoFormula::where('CuadroMando_idCuadroMando',$id)->delete();

        $registroFormula = explode('|', substr($request["datosgrabar"],0, strlen($request["datosgrabar"])-1)) ;
        foreach ($registroFormula as $reg => $datos) 
        {
            $datoFormula = explode(',', $datos) ;
        
            \App\CuadroMandoFormula::create([
            'CuadroMando_idCuadroMando' => $id,
            'tipoCuadroMandoFormula' => $datoFormula[2],
            'CuadroMando_idIndicador' => $datoFormula[3],
            'nombreCuadroMandoFormula' => $datoFormula[4],
            'Modulo_idModulo' => $datoFormula[5],
            'campoCuadroMandoFormula' => $datoFormula[6],
            'calculoCuadroMandoFormula' => $datoFormula[7]
             ]);
        }
        /*
            $cuadromando = \App\CuadroMandoFormula::All()->last();
            $contadorCuadroMandoFormula = count($request['tipoCuadroMandoFormula']);
            for ($i=0; $i <$contadorCuadroMandoFormula ; $i++) 
            { 
                \App\CuadroMandoFormula::create([
                'CuadroMando_idCuadroMando' => $cuadromando->idCuadroMando,
                'tipoCuadroMandoFormula' => $request['tipoCuadroMandoFormula'],
                'CuadroMando_idIndicador' => $request['CuadroMando_idIndicador'],
                'nombreCuadroMandoFormula' => $request['nombreCuadroMandoFormula'],
                'Modulo_idModulo' => $request['Modulo_idModulo'],
                'campoCuadroMandoFormula' => $request['campoCuadroMandoFormula'],
                'calculoCuadroMandoFormula' => $request['calculoCuadroMandoFormula']
                 ]);

                $cuadromandoformula = \App\CuadroMandoFormula::All()->last();
                $contadorCuadroMandoCondicion = count($request['tipoCuadroMandoFormula']);
                for ($i=0; $i <$contadorCuadroMandoCondicion; $i++) 
                { 
                    \App\CuadroMandoCondicion::create([
                    'CuadroMandoFormula_idCuadroMando' => $cuadromandoformula->idCuadroMandoFormula,
                    'parentesisInicioCuadroMandoCondicion' => $request['parentesisInicioCuadroMandoCondicion'],
                    'campoCuadroMandoCondicion' => $request['campoCuadroMandoCondicion'],
                    'operadorCuadroMandoCondicion' => $request['operadorCuadroMandoCondicion'],
                    'valorCuadroMandoCondicion' => $request['valorCuadroMandoCondicion'],
                    'parentesisFinCuadroMandoCondicion' => $request['parentesisFinCuadroMandoCondicion'],
                    'conectorCuadroMandoCondicion' => $request['conectorCuadroMandoCondicion']
                    ]);
                }

                $cuadromandoformula = \App\CuadroMandoFormula::All()->last();
                $contadorCuadroMandoAgrupador = count($request['campoCuadroMandoAgrupador']);
                for ($i=0; $i <$contadorCuadroMandoAgrupador ; $i++) 
                { 
                    \App\CuadroMandoAgrupador::create([
                    'CuadroMandoFormula_idCuadroMando' => $cuadromandoformula->idCuadroMandoFormula,
                    'campoCuadroMandoAgrupador' => $request['campoCuadroMandoAgrupador']
                    ]);
                }

            }*/

       // return redirect('/cuadromando');
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
