<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

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

        $idModulo = \App\Modulo::All()->lists('idModulo');
        $nombreModulo = \App\Modulo::All()->lists('nombreModulo');
        return view('reporteacpm',compact('idTercero','nombreCompletoTercero','idProceso','nombreProceso','idModulo','nombreModulo'));
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

                    'ReporteACPM_idReporteACPM' => $id,
                    'ordenReporteACPMDetalle' => $request['ordenReporteACPMDetalle'][$i],
                    'fechaReporteACPMDetalle' => $request['fechaReporteACPMDetalle'][$i],
                    'Proceso_idProceso' => ($request['Proceso_idProceso'][$i] == '' ? NULL : $request['Proceso_idProceso'][$i]),
                    'Modulo_idModulo' => $request['Modulo_idModulo'][$i],
                    'tipoReporteACPMDetalle' => $request['tipoReporteACPMDetalle'][$i],
                    'descripcionReporteACPMDetalle' => $request['descripcionReporteACPMDetalle'][$i],
                    'analisisReporteACPMDetalle' => $request['analisisReporteACPMDetalle'][$i],
                    'correccionReporteACPMDetalle' => $request['correccionReporteACPMDetalle'][$i],
                    'Tercero_idResponsableCorrecion' => ($request['Tercero_idResponsableCorrecion'][$i] == '' ? NULL : $request['Tercero_idResponsableCorrecion'][$i]),
                    'planAccionReporteACPMDetalle' => $request['planAccionReporteACPMDetalle'][$i],
                    'Tercero_idResponsablePlanAccion' => ($request['Tercero_idResponsablePlanAccion'][$i] == '' ? NULL : $request['Tercero_idResponsablePlanAccion'][$i]),
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
    public function show($id)
    {
        
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

        $idModulo = \App\Modulo::All()->lists('idModulo');
        $nombreModulo = \App\Modulo::All()->lists('nombreModulo');
        return view('reporteacpm',compact('idTercero','nombreCompletoTercero','idProceso','nombreProceso','idModulo','nombreModulo'),['reporteACPM' => $reporteACPM]);
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

            \App\ReporteACPMDetalle::where('ReporteACPM_idReporteACPM',$id)->delete();

            $contadorDetalle = count($request['ordenReporteACPMDetalle']);
            for($i = 0; $i < $contadorDetalle; $i++)
            {
                \App\ReporteACPMDetalle::create([

                    'ReporteACPM_idReporteACPM' => $id,
                    'ordenReporteACPMDetalle' => $request['ordenReporteACPMDetalle'][$i],
                    'fechaReporteACPMDetalle' => $request['fechaReporteACPMDetalle'][$i],
                    'Proceso_idProceso' => ($request['Proceso_idProceso'][$i] == '' ? NULL : $request['Proceso_idProceso'][$i]),
                    'Modulo_idModulo' => $request['Modulo_idModulo'][$i],
                    'tipoReporteACPMDetalle' => $request['tipoReporteACPMDetalle'][$i],
                    'descripcionReporteACPMDetalle' => $request['descripcionReporteACPMDetalle'][$i],
                    'analisisReporteACPMDetalle' => $request['analisisReporteACPMDetalle'][$i],
                    'correccionReporteACPMDetalle' => $request['correccionReporteACPMDetalle'][$i],
                    'Tercero_idResponsableCorrecion' => ($request['Tercero_idResponsableCorrecion'][$i] == '' ? NULL : $request['Tercero_idResponsableCorrecion'][$i]),
                    'planAccionReporteACPMDetalle' => $request['planAccionReporteACPMDetalle'][$i],
                    'Tercero_idResponsablePlanAccion' => ($request['Tercero_idResponsablePlanAccion'][$i] == '' ? NULL : $request['Tercero_idResponsablePlanAccion'][$i]),
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
