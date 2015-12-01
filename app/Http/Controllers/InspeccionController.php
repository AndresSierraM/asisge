<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Inspeccion;
use App\Http\Requests;
use App\Http\Requests\InspeccionRequest;
use App\Http\Controllers\Controller;
use DB;

class InspeccionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        
        return view('inspecciongrid');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $tipoinspeccion = \App\TipoInspeccion::All()->lists('nombreTipoInspeccion','idTipoInspeccion');
        $tercero = \App\Tercero::All()->lists('nombreCompletoTercero','idTercero');
        
        $idTercero = \App\Tercero::All()->lists('idTercero');
        $nombreCompletoTercero = \App\Tercero::All()->lists('nombreCompletoTercero');

        return view('inspeccion',compact('tipoinspeccion','tercero','idTercero','nombreCompletoTercero'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(InspeccionRequest $request)
    {
        if($request['respuesta'] != 'falso')
        {
            \App\Inspeccion::create([
                'TipoInspeccion_idTipoInspeccion' => $request['TipoInspeccion_idTipoInspeccion'],
                'Tercero_idRealizadaPor' => $request['Tercero_idRealizadaPor'],
                'fechaElaboracionInspeccion' => $request['fechaElaboracionInspeccion'],
                'observacionesInspeccion' => $request['observacionesInspeccion']
                ]); 

            $inspeccion = \App\Inspeccion::All()->last();
            $contadorDetalle = count($request['TipoInspeccionPregunta_idTipoInspeccionPregunta']);
            for($i = 0; $i < $contadorDetalle; $i++)
            {
                \App\InspeccionDetalle::create([
                'Inspeccion_idInspeccion' => $inspeccion->idInspeccion,
                'TipoInspeccionPregunta_idTipoInspeccionPregunta' => $request['TipoInspeccionPregunta_idTipoInspeccionPregunta'][$i],
                'situacionInspeccionDetalle' => $request['situacionInspeccionDetalle'][$i],
                'fotoInspeccionDetalle' => $request['fotoInspeccionDetalle'][$i],
                'ubicacionInspeccionDetalle' => $request['ubicacionInspeccionDetalle'][$i],
                'accionMejoraInspeccionDetalle' => $request['accionMejoraInspeccionDetalle'][$i],
                'Tercero_idResponsable' => $request['Tercero_idResponsable'][$i],
                'fechaInspeccionDetalle' => $request['fechaInspeccionDetalle'][$i],
                'observacionInspeccionDetalle' => $request['observacionInspeccionDetalle'][$i]
               ]);
                
            }

           return redirect('/inspeccion');
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show(Request $request)
    {
        /*if(isset($request['accion']) and $request['accion'] == 'imprimir')
        {

          $inspeccion = \App\Inspeccion::find($id);
          
          $inspeccionDetalle = DB::table('inspecciondetalle as dd')
            ->leftJoin('inspeccionpregunta as dp', 'dd.InspeccionPregunta_idInspeccionPregunta', '=', 'dp.idInspeccionPregunta')
            ->leftJoin('tipoinspeccion as dg', 'dp.TipoInspeccion_idTipoInspeccion', '=', 'dg.idTipoInspeccion')
            ->select(DB::raw('dd.idInspeccionDetalle, dg.nombreTipoInspeccion, dp.idInspeccionPregunta, dp.ordenInspeccionPregunta, dp.detalleInspeccionPregunta, dd.puntuacionInspeccionDetalle, dd.resultadoInspeccionDetalle, dd.mejoraInspeccionDetalle'))
            ->orderBy('dg.nombreTipoInspeccion', 'ASC')
            ->orderBy('dp.ordenInspeccionPregunta', 'ASC')
            ->where('Inspeccion_idInspeccion','=',$id)
            ->get();

          $inspeccionResumen = DB::table('inspecciondetalle as dd')
            ->leftJoin('inspeccionpregunta as dp', 'dd.InspeccionPregunta_idInspeccionPregunta', '=', 'dp.idInspeccionPregunta')
            ->leftJoin('tipoinspeccion as dg', 'dp.TipoInspeccion_idTipoInspeccion', '=', 'dg.idTipoInspeccion')
            ->select(DB::raw('dg.nombreTipoInspeccion, AVG(dd.resultadoInspeccionDetalle) as resultadoInspeccionDetalle'))
            ->orderBy('dg.nombreTipoInspeccion', 'ASC')
            ->groupBy('dg.nombreTipoInspeccion')
            ->where('Inspeccion_idInspeccion','=',$id)
            ->get();

            return view('formatos.inspeccionimpresion',['inspeccion'=>$inspeccion], compact('inspeccionDetalle','inspeccionResumen'));
        }*/

        if(isset($request['idTipoInspeccion']))
        {
         
            $ids = \App\TipoInspeccionPregunta::where('TipoInspeccion_idTipoInspeccion',$request['idTipoInspeccion'])
                                        ->select('idTipoInspeccionPregunta', 'numeroTipoInspeccionPregunta', 'contenidoTipoInspeccionPregunta')
                                        ->get();

            if($request->ajax())
            {
                return response()->json([$ids]);
            }
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {

        $tipoinspeccion = \App\TipoInspeccion::All()->lists('nombreTipoInspeccion','idTipoInspeccion');
        $tercero = \App\Tercero::All()->lists('nombreCompletoTercero','idTercero');
        
        $idTercero = \App\Tercero::All()->lists('idTercero');
        $nombreCompletoTercero = \App\Tercero::All()->lists('nombreCompletoTercero');


        $inspeccion = \App\Inspeccion::find($id);

        $preguntas = DB::table('inspecciondetalle')
            ->leftJoin('tipoinspeccionpregunta', 'inspecciondetalle.TipoInspeccionPregunta_idTipoInspeccionPregunta', '=', 'tipoinspeccionpregunta.idTipoInspeccionPregunta')
            ->leftJoin('tipoinspeccion', 'tipoinspeccionpregunta.TipoInspeccion_idTipoInspeccion', '=', 'tipoinspeccion.idTipoInspeccion')
            ->select(DB::raw('TipoInspeccionPregunta_idTipoInspeccionPregunta, numeroTipoInspeccionPregunta, contenidoTipoInspeccionPregunta, 
                              situacionInspeccionDetalle,   fotoInspeccionDetalle, ubicacionInspeccionDetalle,
                              accionMejoraInspeccionDetalle, Tercero_idResponsable, fechaInspeccionDetalle,
                              observacionInspeccionDetalle'))
            ->orderBy('numeroTipoInspeccionPregunta', 'ASC')
            ->where('Inspeccion_idInspeccion','=',$id)
            ->get();

       return view('inspeccion',compact('tipoinspeccion','tercero','idTercero','nombreCompletoTercero', 'preguntas'),['inspeccion'=>$inspeccion]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update($id, InspeccionRequest $request)
    {
        if($request['respuesta'] != 'falso')
        {
            $inspeccion = \App\Inspeccion::find($id);
            $inspeccion->fill($request->all());
            //$inspeccion->Compania_idCompania = 1;
            $inspeccion->save();

            \App\InspeccionDetalle::where('Inspeccion_idInspeccion',$id)->delete();

            $contadorDetalle = count($request['TipoInspeccionPregunta_idTipoInspeccionPregunta']);
            for($i = 0; $i < $contadorDetalle; $i++)
            {
                \App\InspeccionDetalle::create([
                'Inspeccion_idInspeccion' => $id,
                'TipoInspeccionPregunta_idTipoInspeccionPregunta' => $request['TipoInspeccionPregunta_idTipoInspeccionPregunta'][$i],
                'situacionInspeccionDetalle' => $request['situacionInspeccionDetalle'][$i],
                'fotoInspeccionDetalle' => $request['fotoInspeccionDetalle'][$i],
                'ubicacionInspeccionDetalle' => $request['ubicacionInspeccionDetalle'][$i],
                'accionMejoraInspeccionDetalle' => $request['accionMejoraInspeccionDetalle'][$i],
                'Tercero_idResponsable' => $request['Tercero_idResponsable'][$i],
                'fechaInspeccionDetalle' => $request['fechaInspeccionDetalle'][$i],
                'observacionInspeccionDetalle' => $request['observacionInspeccionDetalle'][$i]
               ]);
            }

            return redirect('/inspeccion');
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

        \App\Inspeccion::destroy($id);
        return redirect('/inspeccion');
    }
}
