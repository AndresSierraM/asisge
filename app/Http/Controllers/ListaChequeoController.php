<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
class ListaChequeoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('listachequeogrid');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $preguntaListaChequeo = DB::table('preguntalistachequeo')
            ->select(DB::raw('idPreguntaListaChequeo as PreguntaListaChequeo_idPreguntaListaChequeo, ordenPreguntaListaChequeo, descripcionPreguntaListaChequeo'))
            ->orderBy('ordenPreguntaListaChequeo', 'ASC')
            ->get();

        $planAuditoria = \App\PlanAuditoria::All()->lists('numeroPlanAuditoria','idPlanAuditoria');
        $idTercero = \App\Tercero::All()->lists('idTercero');
        $nombreCompletoTercero = \App\Tercero::All()->lists('nombreCompletoTercero');
        return view('listachequeo',compact('planAuditoria','preguntaListaChequeo','idTercero','nombreCompletoTercero'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
            \App\ListaChequeo::create([
                    'numeroListaChequeo' => $request['numeroListaChequeo'],
                    'fechaElaboracionListaChequeo' => $request['fechaElaboracionListaChequeo'],
                    'PlanAuditoria_idPlanAuditoria' => $request['PlanAuditoria_idPlanAuditoria'],
                    'Proceso_idProceso' => $request['Proceso_idProceso'],
                    'observacionesListaChequeo' => $request['observacionesListaChequeo']

                ]);

            $listaChequeo = \App\listaChequeo::All()->last();
            $contadorDetalle = count($request['Tercero_idTercero']);
            for($i = 0; $i < $contadorDetalle; $i++)
            {
                \App\ListaChequeoDetalle::create([

                    'ListaChequeo_idListaChequeo' => $listaChequeo->idListaChequeo,
                    'PreguntaListaChequeo_idPreguntaListaChequeo' => $request['PreguntaListaChequeo_idPreguntaListaChequeo'][$i],
                    'ordenPreguntaListaChequeo' => $request['ordenPreguntaListaChequeo'][$i],
                    'descripcionPreguntaListaChequeo' => $request['descripcionPreguntaListaChequeo'][$i],
                    'Tercero_idTercero' => $request['Tercero_idTercero'][$i],
                    'respuestaListaChequeoDetalle' => $request['respuestaListaChequeoDetalle'][$i],
                    'conformeListaChequeoDetalle' => $request['conformeListaChequeoDetalle'][$i],
                    'hallazgoListaChequeoDetalle' => $request['hallazgoListaChequeoDetalle'][$i],
                    'observacionListaChequeoDetalle' => $request['observacionListaChequeoDetalle'][$i]

                ]);
            }

            return redirect('/listachequeo');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id, Request $request)
    {
        if(isset($request['accion']) and $request['accion'] == 'imprimir')
        {
            $listaChequeo = DB::table('listachequeo as lc')
                ->leftJoin('proceso as p', 'lc.Proceso_idProceso', '=', 'p.idProceso')
                ->leftJoin('planauditoria as pa', 'lc.PlanAuditoria_idPlanAuditoria', '=', 'pa.idPlanAuditoria')
                ->select(DB::raw('idListaChequeo, numeroListaChequeo, fechaElaboracionListaChequeo, PlanAuditoria_idPlanAuditoria, pa.numeroPlanAuditoria, Proceso_idProceso, p.nombreProceso, observacionesListaChequeo'))
                ->orderBy('idListaChequeo', 'ASC')
                ->where('idListaChequeo','=',$id)
                ->get();

          
            $listaChequeoDetalle = DB::table('listachequeodetalle as lcd')
                ->leftJoin('preguntalistachequeo as plc', 'lcd.PreguntaListaChequeo_idPreguntaListaChequeo', '=', 'plc.idPreguntaListaChequeo')
                ->leftJoin('tercero as t', 'lcd.Tercero_idTercero', '=', 't.idTercero')
                ->select(DB::raw('lcd.idListaChequeoDetalle, lcd.ListaChequeo_idListaChequeo,  lcd.PreguntaListaChequeo_idPreguntaListaChequeo, plc.ordenPreguntaListaChequeo, plc.descripcionPreguntaListaChequeo,lcd.Tercero_idTercero, t.nombreCompletoTercero, lcd.respuestaListaChequeoDetalle, lcd.conformeListaChequeoDetalle, lcd.hallazgoListaChequeoDetalle,lcd.observacionListaChequeoDetalle'))
                ->orderBy('plc.ordenPreguntaListaChequeo', 'ASC')
                ->where('ListaChequeo_idListaChequeo','=',$id)
                ->get();

            
            return view('formatos.listachequeoimpresion',['listaChequeo'=>$listaChequeo], compact('listaChequeoDetalle'));

        }

        if(isset($request['planAuditoria']))
        {
            
            $ids = \App\ListaChequeo::where('idListaChequeo',$id)
                                        ->select('Proceso_idProceso')
                                        ->get();

            $idProceso = DB::table('planauditoriaagenda as paa')
                ->leftJoin('proceso as p','paa.Proceso_idProceso','=','p.idProceso')
                ->select(DB::raw('p.idProceso'))
                ->where('PlanAuditoria_idPlanAuditoria','=',$request['planAuditoria'])
                ->orderBy('Proceso_idProceso', 'ASC')
                ->get();

            $nombreProceso = DB::table('planauditoriaagenda as paa')
                ->leftJoin('proceso as p','paa.Proceso_idProceso','=','p.idProceso')
                ->select(DB::raw('p.nombreProceso'))
                ->where('PlanAuditoria_idPlanAuditoria','=',$request['planAuditoria'])
                ->orderBy('Proceso_idProceso', 'ASC')
                ->get();    

            if($request->ajax())
            {
                return response()->json([
                    $idProceso,
                    $nombreProceso,
                    $ids
                ]);
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
        $preguntaListaChequeo = DB::table('listachequeodetalle as lcd')
            ->leftJoin('preguntalistachequeo as plc', 'lcd.PreguntaListaChequeo_idPreguntaListaChequeo', '=', 'idPreguntaListaChequeo')
            ->select(DB::raw('lcd.idListaChequeoDetalle, PreguntaListaChequeo_idPreguntaListaChequeo, plc.ordenPreguntaListaChequeo, plc.descripcionPreguntaListaChequeo,lcd.Tercero_idTercero, lcd.respuestaListaChequeoDetalle, lcd.conformeListaChequeoDetalle, lcd.hallazgoListaChequeoDetalle,lcd.observacionListaChequeoDetalle'))
            ->orderBy('ordenPreguntaListaChequeo', 'ASC')
            ->where('ListaChequeo_idListaChequeo','=',$id)
            ->get();

        $planAuditoria = \App\PlanAuditoria::All()->lists('numeroPlanAuditoria','idPlanAuditoria');
        $idTercero = \App\Tercero::All()->lists('idTercero');
        $nombreCompletoTercero = \App\Tercero::All()->lists('nombreCompletoTercero');
        $listaChequeo = \App\ListaChequeo::find($id);
        return view('listachequeo',compact('planAuditoria','preguntaListaChequeo','idTercero','nombreCompletoTercero'),['listaChequeo'=>$listaChequeo]);
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
            $listaChequeo = \App\ListaChequeo::find($id);
            $listaChequeo->fill($request->all());

            $listaChequeo->save();

            \App\ListaChequeoDetalle::where('ListaChequeo_idListaChequeo',$id)->delete();

            $contadorDetalle = count($request['Tercero_idTercero']);
            for($i = 0; $i < $contadorDetalle; $i++)
            {
                \App\ListaChequeoDetalle::create([

                    'ListaChequeo_idListaChequeo' => $listaChequeo->idListaChequeo,
                    'PreguntaListaChequeo_idPreguntaListaChequeo' => $request['PreguntaListaChequeo_idPreguntaListaChequeo'][$i],
                    'ordenPreguntaListaChequeo' => $request['ordenPreguntaListaChequeo'][$i],
                    'descripcionPreguntaListaChequeo' => $request['descripcionPreguntaListaChequeo'][$i],
                    'Tercero_idTercero' => $request['Tercero_idTercero'][$i],
                    'respuestaListaChequeoDetalle' => $request['respuestaListaChequeoDetalle'][$i],
                    'conformeListaChequeoDetalle' => $request['conformeListaChequeoDetalle'][$i],
                    'hallazgoListaChequeoDetalle' => $request['hallazgoListaChequeoDetalle'][$i],
                    'observacionListaChequeoDetalle' => $request['observacionListaChequeoDetalle'][$i]

                ]);
            }

            return redirect('/listachequeo');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        \App\ListaChequeo::destroy($id);
        return redirect('/listachequeo');
    }
}
