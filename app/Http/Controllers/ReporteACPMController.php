<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;

class ReporteACPMController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('reporteacpmgrid');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $idTercero = \App\Tercero::All()->lists('idTercero');
        $nombreCompletoTercero = \App\Tercero::All()->lists('nombreCompletoTercero');

        $idProceso = \App\Proceso::All()->lists('idProceso');
        $nombreProceso = \App\Proceso::All()->lists('nombreProceso');

        return view('reporteacpm',compact('idTercero','nombreCompletoTercero','idProceso','nombreProceso'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {

            \App\ReporteACPM::create([
                'numeroReporteACPM' => $request['numeroReporteACPM'],
                'fechaElaboracionReporteACPM' => $request['fechaElaboracionReporteACPM'],
                'descripcionReporteACPM' => $request['descripcionReporteACPM']
                ]);

            $reporteACPM = \App\ReporteACPM::All()->last();
            $contadorDetalle = count($request['ordenReporteACPMDetalle']);
            for($i = 0; $i < $contadorDetalle; $i++)
            {
                \App\ReporteACPMDetalle::create([

                    'ReporteACPM_idReporteACPM' => $reporteACPM->idReporteACPM,
                    'ordenReporteACPMDetalle' => $request['ordenReporteACPMDetalle'][$i],
                    'fechaReporteACPMDetalle' => $request['fechaReporteACPMDetalle'][$i],
                    'Proceso_idProceso' => $request['Proceso_idProceso'][$i],
                    'Modelo_idModelo' => $request['Modelo_idModelo'][$i],
                    'tipoReporteACPMDetalle' => $request['tipoReporteACPMDetalle'][$i],
                    'descripcionReporteACPMDetalle' => $request['descripcionReporteACPMDetalle'][$i],
                    'analisisReporteACPMDetalle' => $request['analisisReporteACPMDetalle'][$i],
                    'correccionReporteACPMDetalle' => $request['correccionReporteACPMDetalle'][$i],
                    'Tercero_idResponsableCorrecion' => $request['Tercero_idResponsableCorrecion'][$i],
                    'planAccionReporteACPMDetalle' => $request['planAccionReporteACPMDetalle'][$i],
                    'Tercero_idResponsablePlanAccion' => $request['Tercero_idResponsablePlanAccion'][$i],
                    'fechaEstimadaCierreReporteACPMDetalle' => $request['fechaEstimadaCierreReporteACPMDetalle'][$i],
                    'estadoActualReporteACPMDetalle' => $request['estadoActualReporteACPMDetalle'][$i],
                    'fechaCierreReporteACPMDetalle' => $request['fechaCierreReporteACPMDetalle'][$i],
                    'eficazReporteACPMDetalle' => $request['eficazReporteACPMDetalle'][$i]

                ]);
            }

            return redirect('/reporteacpm');
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
            $reporteACPM = \App\ReporteACPM::find($id);

          
            $reporteACPMDetalle = DB::table('reporteacpmdetalle as rpd')
                ->leftJoin('proceso as p', 'rpd.Proceso_idProceso', '=', 'p.idProceso')
                ->leftJoin('tercero as trp', 'rpd.Tercero_idResponsablePlanAccion', '=', 'trp.idTercero')
                ->leftJoin('tercero as trc', 'rpd.Tercero_idResponsableCorrecion', '=', 'trc.idTercero')
                ->select(DB::raw('idReporteACPMDetalle, ordenReporteACPMDetalle, fechaReporteACPMDetalle, Proceso_idProceso, p.nombreProceso, Modelo_idModelo, tipoReporteACPMDetalle, descripcionReporteACPMDetalle, analisisReporteACPMDetalle, correccionReporteACPMDetalle, Tercero_idResponsableCorrecion, trc.nombreCompletoTercero as nombreCompletoResponsableCorrecion, planAccionReporteACPMDetalle, Tercero_idResponsablePlanAccion, trp.nombreCompletoTercero as nombreCompletoResponsablePlanAccion, fechaEstimadaCierreReporteACPMDetalle, estadoActualReporteACPMDetalle, fechaCierreReporteACPMDetalle, eficazReporteACPMDetalle,DATEDIFF(fechaCierreReporteACPMDetalle,fechaEstimadaCierreReporteACPMDetalle) as diasAtraso'))
                ->orderBy('ordenReporteACPMDetalle', 'ASC')
                ->where('ReporteACPM_idReporteACPM','=',$id)
                ->get();

            
            return view('formatos.reporteacpmimpresion',['reporteACPM'=>$reporteACPM], compact('reporteACPMDetalle'));

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
        $reporteACPM = \App\ReporteACPM::find($id);
        $idTercero = \App\Tercero::All()->lists('idTercero');
        $nombreCompletoTercero = \App\Tercero::All()->lists('nombreCompletoTercero');

        $idProceso = \App\Proceso::All()->lists('idProceso');
        $nombreProceso = \App\Proceso::All()->lists('nombreProceso');

        return view('reporteacpm',compact('idTercero','nombreCompletoTercero','idProceso','nombreProceso'),['reporteACPM' => $reporteACPM]);
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
            $reporteACPM = \App\ReporteACPM::find($id);
            $reporteACPM->fill($request->all());

            $reporteACPM->save();

            \App\ListaChequeoDetalle::where('ReporteACPM_idReporteACPM',$id)->delete();

            $contadorDetalle = count($request['ordenReporteACPMDetalle']);
            for($i = 0; $i < $contadorDetalle; $i++)
            {
                \App\ListaChequeoDetalle::create([

                    'ReporteACPM_idReporteACPM' => $id,
                    'ordenReporteACPMDetalle' => $request['ordenReporteACPMDetalle'][$i],
                    'fechaReporteReporteACPMDetalle' => $request['fechaReporteReporteACPMDetalle'][$i],
                    'Proceso_idProceso' => $request['Proceso_idProceso'][$i],
                    'Modelo_idModelo' => $request['Modelo_idModelo'][$i],
                    'tipoReporteACPMDetalle' => $request['tipoReporteACPMDetalle'][$i],
                    'descripcionReporteACPMDetalle' => $request['descripcionReporteACPMDetalle'][$i],
                    'analisisReporteACPMDetalle' => $request['analisisReporteACPMDetalle'][$i],
                    'correccionReporteACPMDetalle' => $request['correccionReporteACPMDetalle'][$i],
                    'Tercero_idResponsableCorrecion' => $request['Tercero_idResponsableCorrecion'][$i],
                    'planAccionReporteACPMDetalle' => $request['planAccionReporteACPMDetalle'][$i],
                    'Tercero_idResponsablePlanAccion' => $request['Tercero_idResponsablePlanAccion'][$i],
                    'fechaEstimadaCierreReporteACPMDetalle' => $request['fechaEstimadaCierreReporteACPMDetalle'][$i],
                    'estadoActualReporteACPMDetalle' => $request['estadoActualReporteACPMDetalle'][$i],
                    'fechaCierreReporteACPMDetalle' => $request['fechaCierreReporteACPMDetalle'][$i],
                    'eficazReporteACPMDetalle' => $request['eficazReporteACPMDetalle'][$i]

                ]);
            }

            return redirect('/reporteacpm');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        \App\ReporteACPM::destroy($id);
        return redirect('/reporteacpm');
    }
}