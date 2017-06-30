<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Diagnostico;
use App\Http\Requests;
use App\Http\Requests\Diagnostico2Request;
use App\Http\Controllers\Controller;
use DB;
include public_path().'/ajax/consultarPermisos.php';

class Diagnostico2Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $vista = basename($_SERVER["PHP_SELF"]);
        $datos = consultarPermisos($vista);

        if($datos != null)
            return view('diagnostico2grid', compact('datos'));
        else
            return view('accesodenegado');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    { 
        // SE ENVIA EL idDiagnostico2 como null para engañar al sistema y hacer una validacion en el boton preguntando si es nulo o no para identificar si es Modificar o Adicionar
       $diagnostico2 = DB::select('
        SELECT NULL as idDiagnostico2Detalle,NULL as respuestaDiagnostico2Detalle,NULL as mejoraDiagnostico2Detalle,NULL as resultadoDiagnostico2Detalle,NULL as idDiagnostico2,diag4.idDiagnosticoNivel4,diag1.idDiagnosticoNivel1,diag2.idDiagnosticoNivel2,diag1.numeroDiagnosticoNivel1,diag1.tituloDiagnosticoNivel1,diag2.numeroDiagnosticoNivel2,
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
        return view('diagnostico2',compact('diagnostico2'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Diagnostico2Request $request)
    {
        if($request['respuesta'] != 'falso')
        {
            \App\Diagnostico2::create([
                'codigoDiagnostico2' => $request['codigoDiagnostico2'],
                'nombreDiagnostico2' => $request['nombreDiagnostico2'],
                'fechaElaboracionDiagnostico2' => $request['fechaElaboracionDiagnostico2'],
                'equiposCriticosDiagnostico2' => $request['equiposCriticosDiagnostico2'],
                'herramientasCriticasDiagnostico2' => $request['herramientasCriticasDiagnostico2'],
                'observacionesDiagnostico2' => $request['observacionesDiagnostico2'],
                'Compania_idCompania' => \Session::get('idCompania')
                ]); 

            $diagnostico2 = \App\Diagnostico2::All()->last();

            $contadorDetalle = count($request['puntuacionDiagnostico2Detalle']);
            for($i = 0; $i < $contadorDetalle; $i++)
            {
                \App\Diagnostico2Detalle::create([
                'Diagnostico2_idDiagnostico2' => $diagnostico2->idDiagnostico2,
                'DiagnosticoNivel4_idDiagnosticoNivel4' => $request['idDiagnosticoNivel4'][$i],
                'puntuacionDiagnostico2Detalle' => $request['puntuacionDiagnostico2Detalle'][$i],
                'respuestaDiagnostico2Detalle' => $request['respuestaDiagnostico2Detalle'][$i],
                'resultadoDiagnostico2Detalle' => $request['resultadoDiagnostico2Detalle'][$i],
                'mejoraDiagnostico2Detalle' => $request['mejoraDiagnostico2Detalle'][$i],            
               ]);
            }

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
        $diagnosticoEncabezado = \App\Diagnostico2::find($id);

        // Se hace una consulta de la tabla Diagnostico2 Para traer todos los registros que fueron llenados
        $diagnostico2 = DB::select('
            SELECT idDiagnostico2Detalle,diag2.idDiagnostico2,diagn4.idDiagnosticoNivel4,diagn1.idDiagnosticoNivel1,diagn2.idDiagnosticoNivel2,diagn1.numeroDiagnosticoNivel1,
            diagn1.tituloDiagnosticoNivel1,diagn2.numeroDiagnosticoNivel2,diagn2.tituloDiagnosticoNivel2,
            diagn2.valorDiagnosticoNivel2,diagn3.numeroDiagnosticoNivel3,diagn3.tituloDiagnosticoNivel3,
            diagn3.valorDiagnosticoNivel3,diagn4.numeroDiagnosticoNivel4,diagn4.tituloDiagnosticoNivel4,
            diagn4.valorDiagnosticoNivel4,diag2.codigoDiagnostico2,diag2d.idDiagnostico2Detalle,diag2d.DiagnosticoNivel4_idDiagnosticoNivel4,diag2d.puntuacionDiagnostico2Detalle,
            diag2d.respuestaDiagnostico2Detalle,diag2d.resultadoDiagnostico2Detalle,diag2d.mejoraDiagnostico2Detalle,
            diag2d.Diagnostico2_idDiagnostico2
            FROM
              diagnostico2detalle diag2d
              LEFT JOIN diagnosticonivel4 diagn4
              ON diag2d.DiagnosticoNivel4_idDiagnosticoNivel4 = diagn4.idDiagnosticoNivel4
              LEFT JOIN diagnosticonivel3 diagn3
              ON diagn4.DiagnosticoNivel3_idDiagnosticoNivel3 = diagn3.idDiagnosticoNivel3
              LEFT JOIN diagnosticonivel2 diagn2
              ON diagn3.DiagnosticoNivel2_idDiagnosticoNivel2 = diagn2.idDiagnosticoNivel2
              LEFT JOIN diagnosticonivel1 diagn1
              ON diagn2.DiagnosticoNivel1_idDiagnosticoNivel1 = diagn1.idDiagnosticoNivel1
              LEFT JOIN diagnostico2 diag2
              ON diag2d.Diagnostico2_idDiagnostico2 = diag2.idDiagnostico2
              where diag2d.Diagnostico2_idDiagnostico2 = '.$id);    

 
        return view('diagnostico2',compact('diagnostico2'),['diagnosticoEncabezado'=>$diagnosticoEncabezado]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update($id,Diagnostico2Request $request)
    {
        if($request['respuesta'] != 'falso')
        {
            $diagnostico2 = \App\Diagnostico2::find($id);
            $diagnostico2->fill($request->all());
            $diagnostico2->save();

                //Eliminar registros de la multiregistro
                // Guardamos el detalle de los modulos
                for($i = 0; $i < count($request['puntuacionDiagnostico2Detalle']); $i++)
                {
                     $indice = array(
                        'idDiagnostico2Detalle' => $request['idDiagnostico2Detalle'][$i]);

                    $data = array(
                     'Diagnostico2_idDiagnostico2' => $id,
                    'DiagnosticoNivel4_idDiagnosticoNivel4' => $request['idDiagnosticoNivel4'][$i],
                    'puntuacionDiagnostico2Detalle' => $request['puntuacionDiagnostico2Detalle'][$i],
                    'respuestaDiagnostico2Detalle' => $request['respuestaDiagnostico2Detalle'][$i],
                    'resultadoDiagnostico2Detalle' => $request['resultadoDiagnostico2Detalle'][$i],
                    'mejoraDiagnostico2Detalle' => $request['mejoraDiagnostico2Detalle'][$i]);  
                    $guardar = \App\Diagnostico2Detalle::updateOrCreate($indice, $data);
                } 
            return redirect('/diagnostico2');
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

        \App\Diagnostico2::destroy($id);
        return redirect('/diagnostico2');
    }
}
