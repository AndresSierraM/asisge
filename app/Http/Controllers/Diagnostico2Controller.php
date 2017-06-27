<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Diagnostico;
use App\Http\Requests;
// use App\Http\Requests\DiagnosticoRequest
use App\Http\Controllers\Controller;
use DB;
// include public_path().'/ajax/consultarPermisos.php';

class Diagnostico2Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        // $vista = basename($_SERVER["PHP_SELF"]);
        // $datos = consultarPermisos($vista);

        // if($datos != null)
        //     return view('diagnosticogrid', compact('datos'));
        // else
        //     return view('accesodenegado');
        return view('diagnostico2');
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
        // $preguntas = DB::table('diagnosticopregunta')
        //     ->leftJoin('diagnosticogrupo', 'diagnosticopregunta.DiagnosticoGrupo_idDiagnosticoGrupo', '=', 'diagnosticogrupo.idDiagnosticoGrupo')
        //     ->select(DB::raw('idDiagnosticoGrupo, idDiagnosticoPregunta as DiagnosticoPregunta_idDiagnosticoPregunta, nombreDiagnosticoGrupo, detalleDiagnosticoPregunta, 0 as puntuacionDiagnosticoDetalle, 0 as resultadoDiagnosticoDetalle, "" as mejoraDiagnosticoDetalle'))
        //     ->orderBy('ordenDiagnosticoPregunta', 'ASC')
            //->skip(0)->take(3)
            // ->get();
        $diagnostico = DB::select('
        SELECT diag1.idDiagnosticoNivel1,diag1.numeroDiagnosticoNivel1,diag1.tituloDiagnosticoNivel1,diag2.numeroDiagnosticoNivel2,
        diag2.tituloDiagnosticoNivel2,diag2.valorDiagnosticoNivel2,diag3.numeroDiagnosticoNivel3,diag3.tituloDiagnosticoNivel3,
        diag3.valorDiagnosticoNivel3,diag4.numeroDiagnosticoNivel4,diag4.tituloDiagnosticoNivel4,diag4.valorDiagnosticoNivel4
        FROM
          diagnosticonivel1 diag1
          LEFT JOIN diagnosticonivel2 diag2
          ON diag2.DiagnosticoNivel1_idDiagnosticoNivel1 = diag1.idDiagnosticoNivel1
          LEFT JOIN diagnosticonivel3 diag3
          ON diag3.DiagnosticoNivel2_idDiagnosticoNivel2 = diag2.idDiagnosticoNivel2
          LEFT JOIN diagnosticonivel4 diag4
          ON diag4.DiagnosticoNivel3_idDiagnosticoNivel3 = diag3.idDiagnosticoNivel3
          ORDER BY idDiagnosticoNivel1 ASC,idDiagnosticoNivel2 ASC,idDiagnosticoNivel3 ASC,idDiagnosticoNivel4 ASC,tituloDiagnosticoNivel1,tituloDiagnosticoNivel2,tituloDiagnosticoNivel3,tituloDiagnosticoNivel4');
        // Se organiza por un order By que sean ascendetes los id de las tablas para que cuando se visualice se vea tal cual en la tabla 



      

        return view('diagnostico2',compact('diagnostico'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(DiagnosticoRequest $request)
    {
        if($request['respuesta'] != 'falso')
        {
            // \App\Diagnostico::create([
            //     'codigoDiagnostico' => $request['codigoDiagnostico'],
            //     'nombreDiagnostico' => $request['nombreDiagnostico'],
            //     'fechaElaboracionDiagnostico' => $request['fechaElaboracionDiagnostico'],
            //     'equiposCriticosDiagnostico' => $request['equiposCriticosDiagnostico'],
            //     'herramientasCriticasDiagnostico' => $request['herramientasCriticasDiagnostico'],
            //     'observacionesDiagnostico' => $request['observacionesDiagnostico'],
            //     'Compania_idCompania' => \Session::get('idCompania')
            //     ]); 

            // $diagnostico = \App\Diagnostico::All()->last();
            // $contadorDetalle = count($request['detalleDiagnosticoPregunta']);
            // for($i = 0; $i < $contadorDetalle; $i++)
            // {
            //     \App\DiagnosticoDetalle::create([
            //     'Diagnostico_idDiagnostico' => $diagnostico->idDiagnostico,
            //     'DiagnosticoPregunta_idDiagnosticoPregunta' => $request['DiagnosticoPregunta_idDiagnosticoPregunta'][$i],
            //     'puntuacionDiagnosticoDetalle' => $request['puntuacionDiagnosticoDetalle'][$i],
            //     'resultadoDiagnosticoDetalle' => $request['resultadoDiagnosticoDetalle'][$i],
            //     'mejoraDiagnosticoDetalle' => $request['mejoraDiagnosticoDetalle'][$i],
            //     'consultarDiagnosticoDetalle' => $request['consultarDiagnosticoDetalle'][$i]
            //    ]);
            // }

            return redirect('/diagnostico2');
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id, Request $request)
    {
        // if(isset($request['accion']) and $request['accion'] == 'imprimir')
        // {

        //   $diagnostico = \App\Diagnostico::find($id);
          
        //   $diagnosticoDetalle = DB::table('diagnosticodetalle as dd')
        //     ->leftJoin('diagnosticopregunta as dp', 'dd.DiagnosticoPregunta_idDiagnosticoPregunta', '=', 'dp.idDiagnosticoPregunta')
        //     ->leftJoin('diagnosticogrupo as dg', 'dp.DiagnosticoGrupo_idDiagnosticoGrupo', '=', 'dg.idDiagnosticoGrupo')
        //     ->select(DB::raw('dd.idDiagnosticoDetalle, dg.nombreDiagnosticoGrupo, dp.idDiagnosticoPregunta, dp.ordenDiagnosticoPregunta, dp.detalleDiagnosticoPregunta, dd.puntuacionDiagnosticoDetalle, dd.resultadoDiagnosticoDetalle, dd.mejoraDiagnosticoDetalle'))
        //     ->orderBy('dg.nombreDiagnosticoGrupo', 'ASC')
        //     ->orderBy('dp.ordenDiagnosticoPregunta', 'ASC')
        //     ->where('Diagnostico_idDiagnostico','=',$id)
        //     ->get();

        //   $diagnosticoResumen = DB::table('diagnosticodetalle as dd')
        //     ->leftJoin('diagnosticopregunta as dp', 'dd.DiagnosticoPregunta_idDiagnosticoPregunta', '=', 'dp.idDiagnosticoPregunta')
        //     ->leftJoin('diagnosticogrupo as dg', 'dp.DiagnosticoGrupo_idDiagnosticoGrupo', '=', 'dg.idDiagnosticoGrupo')
        //     ->select(DB::raw('dg.nombreDiagnosticoGrupo, AVG(dd.resultadoDiagnosticoDetalle) as resultadoDiagnosticoDetalle'))
        //     ->orderBy('dg.nombreDiagnosticoGrupo', 'ASC')
        //     ->groupBy('dg.nombreDiagnosticoGrupo')
        //     ->where('Diagnostico_idDiagnostico','=',$id)
        //     ->get();

        //     return view('formatos.diagnosticoimpresion',['diagnostico'=>$diagnostico], compact('diagnosticoDetalle','diagnosticoResumen'));
        // }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        // $diagnostico = \App\Diagnostico::find($id);

        // $preguntas = DB::table('diagnosticodetalle')
        //     ->leftJoin('diagnosticopregunta', 'diagnosticodetalle.DiagnosticoPregunta_idDiagnosticoPregunta', '=', 'diagnosticopregunta.idDiagnosticoPregunta')
        //     ->leftJoin('diagnosticogrupo', 'diagnosticopregunta.DiagnosticoGrupo_idDiagnosticoGrupo', '=', 'diagnosticogrupo.idDiagnosticoGrupo')
        //     ->select(DB::raw('idDiagnosticoGrupo, diagnosticodetalle.DiagnosticoPregunta_idDiagnosticoPregunta, 
        //                         nombreDiagnosticoGrupo, detalleDiagnosticoPregunta, 
        //                         puntuacionDiagnosticoDetalle, resultadoDiagnosticoDetalle, mejoraDiagnosticoDetalle'))
        //     ->orderBy('ordenDiagnosticoPregunta', 'ASC')
        //     ->where('Diagnostico_idDiagnostico','=',$id)
        //     ->get();

        return view('diagdiagnostico2nostico',compact(''),[/*'diagnostico'=>$diagnostico*/]);
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
        // if($request['respuesta'] != 'falso')
        // {
        //     $diagnostico = \App\Diagnostico::find($id);
        //     $diagnostico->fill($request->all());
        //     $diagnostico->save();

        //     \App\DiagnosticoDetalle::where('Diagnostico_idDiagnostico',$id)->delete();

        //     $contadorDetalle = count($request['detalleDiagnosticoPregunta']);
        //     for($i = 0; $i < $contadorDetalle; $i++)
        //     {
        //         \App\DiagnosticoDetalle::create([
        //         'Diagnostico_idDiagnostico' => $id,
        //         'DiagnosticoPregunta_idDiagnosticoPregunta' => $request['DiagnosticoPregunta_idDiagnosticoPregunta'][$i],
        //         'puntuacionDiagnosticoDetalle' => $request['puntuacionDiagnosticoDetalle'][$i],
        //         'resultadoDiagnosticoDetalle' => $request['resultadoDiagnosticoDetalle'][$i],
        //         'mejoraDiagnosticoDetalle' => $request['mejoraDiagnosticoDetalle'][$i],
        //         'consultarDiagnosticoDetalle' => $request['consultarDiagnosticoDetalle'][$i]
        //        ]);
        //     }

        //     return redirect('/diagnostico');
        // }    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    

    public function destroy($id)
    {

        // \App\Diagnostico::destroy($id);
        // return redirect('/diagnostico');
    }
}
