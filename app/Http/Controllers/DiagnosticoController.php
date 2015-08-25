<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Diagnostico;
use App\Http\Requests;
use App\Http\Requests\DiagnosticoRequest;
use App\Http\Controllers\Controller;
use App\Http\Controllers\DiagnosticoDetalle;
use DB;

class DiagnosticoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        
        return view('diagnosticogrid');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        // cuando se crea un nuevo diagnostico, enviamos como detalle las preguntas del 
        // maestro de DiagnosticoPregunta y Diagnostico Grupo que son la base para el llenado
        // pero cuando se hace modificacion, se envia el detalle mismo del diagnostico
        $preguntas = DB::table('diagnosticopregunta')
            ->leftJoin('diagnosticogrupo', 'diagnosticopregunta.DiagnosticoGrupo_idDiagnosticoGrupo', '=', 'diagnosticogrupo.idDiagnosticoGrupo')
            ->select(DB::raw('idDiagnosticoGrupo, idDiagnosticoPregunta as DiagnosticoPregunta_idDiagnosticoPregunta, nombreDiagnosticoGrupo, detalleDiagnosticoPregunta, 0 as puntuacionDiagnosticoDetalle, 0 as resultadoDiagnosticoDetalle, "" as mejoraDiagnosticoDetalle'))
            ->orderBy('ordenDiagnosticoPregunta', 'ASC')
            //->skip(0)->take(3)
            ->get();

        return view('diagnostico',compact('preguntas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(DiagnosticoRequest $request)
    {
        
        \App\Diagnostico::create([
            'codigoDiagnostico' => $request['codigoDiagnostico'],
            'nombreDiagnostico' => $request['nombreDiagnostico'],
            'fechaElaboracionDiagnostico' => $request['fechaElaboracionDiagnostico'],
            'equiposCriticosDiagnostico' => $request['equiposCriticosDiagnostico'],
            'herramientasCriticasDiagnostico' => $request['herramientasCriticasDiagnostico'],
            'observacionesDiagnostico' => $request['observacionesDiagnostico'],
            'Compania_idCompania' => 1
            ]); 

        $diagnostico = \App\Diagnostico::All()->last();
        $contadorDetalle = count($request['detalleDiagnosticoPregunta']);
        for($i = 0; $i < $contadorDetalle; $i++)
        {
            \App\DiagnosticoDetalle::create([
            'Diagnostico_idDiagnostico' => $diagnostico->idDiagnostico,
            'DiagnosticoPregunta_idDiagnosticoPregunta' => $request['DiagnosticoPregunta_idDiagnosticoPregunta'][$i],
            'puntuacionDiagnosticoDetalle' => $request['puntuacionDiagnosticoDetalle'][$i],
            'resultadoDiagnosticoDetalle' => $request['resultadoDiagnosticoDetalle'][$i],
            'mejoraDiagnosticoDetalle' => $request['mejoraDiagnosticoDetalle'][$i],
            'consultarDiagnosticoDetalle' => $request['consultarDiagnosticoDetalle'][$i]
           ]);
        }

        return redirect('/diagnostico');
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
        $diagnostico = \App\Diagnostico::find($id);

        $preguntas = DB::table('diagnosticodetalle')
            ->leftJoin('diagnosticopregunta', 'diagnosticodetalle.DiagnosticoPregunta_idDiagnosticoPregunta', '=', 'diagnosticopregunta.idDiagnosticoPregunta')
            ->leftJoin('diagnosticogrupo', 'diagnosticopregunta.DiagnosticoGrupo_idDiagnosticoGrupo', '=', 'diagnosticogrupo.idDiagnosticoGrupo')
            ->select(DB::raw('idDiagnosticoGrupo, diagnosticodetalle.DiagnosticoPregunta_idDiagnosticoPregunta, 
                                nombreDiagnosticoGrupo, detalleDiagnosticoPregunta, 
                                puntuacionDiagnosticoDetalle, resultadoDiagnosticoDetalle, mejoraDiagnosticoDetalle'))
            ->orderBy('ordenDiagnosticoPregunta', 'ASC')
            ->where('Diagnostico_idDiagnostico','=',$id)
            ->get();

        return view('diagnostico',compact('preguntas'),['diagnostico'=>$diagnostico]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update($id,DiagnosticoRequest $request)
    {
        
        $diagnostico = \App\Diagnostico::find($id);
        $diagnostico->fill($request->all());
        //$diagnostico->Compania_idCompania = 1;
        $diagnostico->save();

        \App\DiagnosticoDetalle::where('Diagnostico_idDiagnostico',$id)->delete();

        $contadorDetalle = count($request['detalleDiagnosticoPregunta']);
        for($i = 0; $i < $contadorDetalle; $i++)
        {
            \App\DiagnosticoDetalle::create([
            'Diagnostico_idDiagnostico' => $id,
            'DiagnosticoPregunta_idDiagnosticoPregunta' => $request['DiagnosticoPregunta_idDiagnosticoPregunta'][$i],
            'puntuacionDiagnosticoDetalle' => $request['puntuacionDiagnosticoDetalle'][$i],
            'resultadoDiagnosticoDetalle' => $request['resultadoDiagnosticoDetalle'][$i],
            'mejoraDiagnosticoDetalle' => $request['mejoraDiagnosticoDetalle'][$i],
            'consultarDiagnosticoDetalle' => $request['consultarDiagnosticoDetalle'][$i]
           ]);
        }

        return redirect('/diagnostico');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    

    public function destroy($id)
    {

        \App\Diagnostico::destroy($id);
        return redirect('/diagnostico');
    }
}
