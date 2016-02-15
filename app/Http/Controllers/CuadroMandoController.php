<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CuadroMando;
use App\Http\Requests;
use App\Http\Requests\CuadroMandoRequest;
use App\Http\Controllers\Controller;
use DB;

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


        $cuadromandoformula = DB::table('cuadromandoformula as CF')
            ->leftJoin('cuadromandocondicion as CC', 'CF.idCuadroMandoFormula', '=', 'CC.CuadroMandoFormula_idCuadroMandoFormula');

        $indicador = \App\CuadroMando::All()->lists('indicadorCuadroMando','idCuadroMando');;
        $companiaobjetivo = \App\CompaniaObjetivo::All()->lists('nombreCompaniaObjetivo','idCompaniaObjetivo');
        $proceso = \App\Proceso::All()->lists('nombreProceso','idProceso');
        $frecuenciamedicion = \App\FrecuenciaMedicion::All()->lists('nombreFrecuenciaMedicion','idFrecuenciaMedicion');
        $tercero = \App\Tercero::All()->lists('nombreCompletoTercero','idTercero');
        $modulo = \App\Modulo::All()->lists('nombreModulo', 'idModulo');

        return view('cuadromando',compact('cuadromandoformula', 'indicador','companiaobjetivo','proceso','frecuenciamedicion','tercero','modulo'));

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

        $cuadromando = \App\CuadroMando::All()->last();

        $registroFormula = explode('|', substr($request["datosGrabarFormula"],0, strlen($request["datosGrabarFormula"])-1)) ;
        $registroCondicion = explode('|', substr($request["datosGrabarCondicion"],0, strlen($request["datosGrabarCondicion"])-1)) ;
        $registroAgrupador = explode('|', substr($request["datosGrabarAgrupador"],0, strlen($request["datosGrabarAgrupador"])-1)) ;


        // al fraccionar el string con explode, siempre segenera un array, aunque este vacio
        // preguntamos si en l aprimera posicion tiene algun dato para saber si lo recorremos
        // con el fin de que no saque error de offset en las posiciones fijas (2,3,4,5,6,7)
        if($registroFormula[0] != '')
        {
            foreach ($registroFormula as $regF => $datosF) 
            {
                $datoFormula = explode(',', $datosF) ;
            
                \App\CuadroMandoFormula::create([
                'CuadroMando_idCuadroMando' => $cuadromando->idCuadroMando,
                'tipoCuadroMandoFormula' => $datoFormula[2],
                'CuadroMando_idIndicador' => $datoFormula[3],
                'nombreCuadroMandoFormula' => $datoFormula[4],
                'Modulo_idModulo' => $datoFormula[5],
                'campoCuadroMandoFormula' => $datoFormula[6],
                'calculoCuadroMandoFormula' => $datoFormula[7]
                 ]);

                // Obtenemos el ultimo ID insertado para relacionarlo con las condiciones y agrupaciones
                $cuadromandoformula = \App\CuadroMandoFormula::All()->last();

                // Por cada una de los componentes de la formula, posiblemente hay unas condiciones
                // solo aplica para los componentes de tipo Variable
                if($datoFormula[2] == 'Variable' and $registroCondicion[0] != '')
                {
                    //echo 'Tipo Variable =  '. $datoFormula[2]. ' AND  '. $registroCondicion[0].'<br>';
                    foreach ($registroCondicion as $regC => $datosC) 
                    {
                        $datoCondicion = explode(',', $datosC) ;
                        // si el primer id de este array es igual al del array de Formula, insertamos este valor
                        //echo 'id Cond '. $datoCondicion[0]. ' == '. $datoFormula[0].'<br>';
                        if($datoCondicion[0] == $datoFormula[0])
                        {
                            
                            \App\CuadroMandoCondicion::create([
                            'CuadroMandoFormula_idCuadroMandoFormula' => $cuadromandoformula->idCuadroMandoFormula,
                            'parentesisInicioCuadroMandoCondicion' => $datoCondicion[1],
                            'campoCuadroMandoCondicion' => $datoCondicion[2],
                            'operadorCuadroMandoCondicion' => $datoCondicion[3],
                            'valorCuadroMandoCondicion' => $datoCondicion[4],
                            'parentesisFinCuadroMandoCondicion' => $datoCondicion[5],
                            'conectorCuadroMandoCondicion' => $datoCondicion[6]
                             ]);
                            
                            
                        }
                    }
                }


                // Repetimos el mismo proceso para los agrupadores de las variables 
                // Por cada una de los componentes de la formula, posiblemente hay unos agrupadores
                // solo aplica para los componentes de tipo Variable
                if($datoFormula[2] == 'Variable' and $registroAgrupador[0] != '')
                {
                    //echo 'Tipo Variable =  '. $datoFormula[2]. ' AND  '. $registroAgrupador[0].'<br>';
                    foreach ($registroAgrupador as $regC => $datosC) 
                    {
                        $datoAgrupador = explode(',', $datosC) ;
                        // si el primer id de este array es igual al del array de Formula, insertamos este valor
                        //echo 'id Cond '. $datoAgrupador[0]. ' == '. $datoFormula[0].'<br>';
                        if($datoAgrupador[0] == $datoFormula[0])
                        {

                            \App\CuadroMandoAgrupador::create([
                            'CuadroMandoFormula_idCuadroMandoFormula' => $cuadromandoformula->idCuadroMandoFormula,
                            'campoCuadroMandoAgrupador' => $datoAgrupador[1]
                             ]);
                            
                        }
                    }
                }

            }
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
    public function edit($id, CuadroMandoRequest $request)
    {
        $cuadromando = \App\CuadroMando::find($id);

        $cuadromandoformula = DB::table('cuadromandoformula as CF')
            ->leftJoin('cuadromandocondicion as CC', 'CF.idCuadroMandoFormula', '=', 'CC.CuadroMandoFormula_idCuadroMandoFormula')
            ->where('CF.CuadroMando_idCuadroMando','=',$id);

        //$cuadromandoformula = \App\CuadroMandoFormula::where('CuadroMando_idCuadroMando',$id)->list();
        $indicador = \App\CuadroMando::where('idCuadroMando','!=',$id)->lists('indicadorCuadroMando','idCuadroMando');;
        $companiaobjetivo = \App\CompaniaObjetivo::All()->lists('nombreCompaniaObjetivo','idCompaniaObjetivo');
        $proceso = \App\Proceso::All()->lists('nombreProceso','idProceso');
        $frecuenciamedicion = \App\FrecuenciaMedicion::All()->lists('nombreFrecuenciaMedicion','idFrecuenciaMedicion');
        $tercero = \App\Tercero::All()->lists('nombreCompletoTercero','idTercero');
        $modulo = \App\Modulo::All()->lists('nombreModulo', 'idModulo');

        return view('cuadromando',compact('cuadromandoformula', 'indicador','companiaobjetivo','proceso','frecuenciamedicion','tercero','modulo'),['cuadromando'=>$cuadromando]);
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
        
        \App\CuadroMandoFormula::where('CuadroMando_idCuadroMando','=',$id)->delete();

        $registroFormula = explode('|', substr($request["datosGrabarFormula"],0, strlen($request["datosGrabarFormula"])-1)) ;
        $registroCondicion = explode('|', substr($request["datosGrabarCondicion"],0, strlen($request["datosGrabarCondicion"])-1)) ;
        $registroAgrupador = explode('|', substr($request["datosGrabarAgrupador"],0, strlen($request["datosGrabarAgrupador"])-1)) ;


        // al fraccionar el string con explode, siempre segenera un array, aunque este vacio
        // preguntamos si en l aprimera posicion tiene algun dato para saber si lo recorremos
        // con el fin de que no saque error de offset en las posiciones fijas (2,3,4,5,6,7)
        if($registroFormula[0] != '')
        {
            foreach ($registroFormula as $regF => $datosF) 
            {
                $datoFormula = explode(',', $datosF) ;
            
                \App\CuadroMandoFormula::create([
                'CuadroMando_idCuadroMando' => $id,
                'tipoCuadroMandoFormula' => $datoFormula[2],
                'CuadroMando_idIndicador' => $datoFormula[3],
                'nombreCuadroMandoFormula' => $datoFormula[4],
                'Modulo_idModulo' => $datoFormula[5],
                'campoCuadroMandoFormula' => $datoFormula[6],
                'calculoCuadroMandoFormula' => $datoFormula[7]
                 ]);

                // Obtenemos el ultimo ID insertado para relacionarlo con las condiciones y agrupaciones
                $cuadromandoformula = \App\CuadroMandoFormula::All()->last();

                // Por cada una de los componentes de la formula, posiblemente hay unas condiciones
                // solo aplica para los componentes de tipo Variable
                if($datoFormula[2] == 'Variable' and $registroCondicion[0] != '')
                {
                    //echo 'Tipo Variable =  '. $datoFormula[2]. ' AND  '. $registroCondicion[0].'<br>';
                    foreach ($registroCondicion as $regC => $datosC) 
                    {
                        $datoCondicion = explode(',', $datosC) ;
                        // si el primer id de este array es igual al del array de Formula, insertamos este valor
                        //echo 'id Cond '. $datoCondicion[0]. ' == '. $datoFormula[0].'<br>';
                        if($datoCondicion[0] == $datoFormula[0])
                        {
                            
                            \App\CuadroMandoCondicion::create([
                            'CuadroMandoFormula_idCuadroMandoFormula' => $cuadromandoformula->idCuadroMandoFormula,
                            'parentesisInicioCuadroMandoCondicion' => $datoCondicion[1],
                            'campoCuadroMandoCondicion' => $datoCondicion[2],
                            'operadorCuadroMandoCondicion' => $datoCondicion[3],
                            'valorCuadroMandoCondicion' => $datoCondicion[4],
                            'parentesisFinCuadroMandoCondicion' => $datoCondicion[5],
                            'conectorCuadroMandoCondicion' => $datoCondicion[6]
                             ]);
                            
                            
                        }
                    }
                }


                // Repetimos el mismo proceso para los agrupadores de las variables 
                // Por cada una de los componentes de la formula, posiblemente hay unos agrupadores
                // solo aplica para los componentes de tipo Variable
                if($datoFormula[2] == 'Variable' and $registroAgrupador[0] != '')
                {
                    //echo 'Tipo Variable =  '. $datoFormula[2]. ' AND  '. $registroAgrupador[0].'<br>';
                    foreach ($registroAgrupador as $regC => $datosC) 
                    {
                        $datoAgrupador = explode(',', $datosC) ;
                        // si el primer id de este array es igual al del array de Formula, insertamos este valor
                        //echo 'id Cond '. $datoAgrupador[0]. ' == '. $datoFormula[0].'<br>';
                        if($datoAgrupador[0] == $datoFormula[0])
                        {

                            \App\CuadroMandoAgrupador::create([
                            'CuadroMandoFormula_idCuadroMandoFormula' => $cuadromandoformula->idCuadroMandoFormula,
                            'campoCuadroMandoAgrupador' => $datoAgrupador[1]
                             ]);
                            
                        }
                    }
                }

            }
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
