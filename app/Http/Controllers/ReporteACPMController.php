<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\ReporteACPMRequest;
use App\Http\Controllers\Controller;
use DB;
include public_path().'/ajax/consultarPermisos.php';

class ReporteACPMController extends Controller
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
            return view('reporteacpmgrid', compact('datos'));
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
        $idTercero = \App\Tercero::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('idTercero');
        $nombreCompletoTercero = \App\Tercero::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('nombreCompletoTercero');

        $idProceso = \App\Proceso::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('idProceso');
        $nombreProceso = \App\Proceso::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('nombreProceso');

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
    public function store(ReporteACPMRequest $request)
    {
        if($request['respuesta'] != 'falso')
        { 
            \App\ReporteACPM::create([
                'numeroReporteACPM' => $request['numeroReporteACPM'],
                'fechaElaboracionReporteACPM' => $request['fechaElaboracionReporteACPM'],
                'descripcionReporteACPM' => $request['descripcionReporteACPM'],
                'Compania_idCompania' => \Session::get('idCompania')
                ]);

            $reporteACPM = \App\ReporteACPM::All()->last();
            $contadorDetalle = count($request['ordenReporteACPMDetalle']);
            for($i = 0; $i < $contadorDetalle; $i++)
            {
                \App\ReporteACPMDetalle::create([

                    'ReporteACPM_idReporteACPM' => $reporteACPM->idReporteACPM,
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
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id, Request $request)
    {
        if($_GET['accion'] == 'imprimir')
            {

            // Se llaman todos los id del Módulo
         $reporteACPM = \App\ReporteACPM::find($id);



        $reporteACPMEncabezado = DB::select('
          SELECT ra.numeroReporteACPM,ra.fechaElaboracionReporteACPM,ra.descripcionReporteACPM
          FROM reporteacpm ra
          WHERE ra.idReporteACPM = '.$id);



        $reporteACPMDetalle = DB::select('
            SELECT rad.ordenReporteACPMDetalle,rad.fechaReporteACPMDetalle,p.nombreProceso,m.nombreModulo,rad.tipoReporteACPMDetalle,rad.descripcionReporteACPMDetalle,rad.analisisReporteACPMDetalle,rad.correccionReporteACPMDetalle,trc.nombreCompletoTercero as ResponsableCoreccion,rad.planAccionReporteACPMDetalle,trpa.nombreCompletoTercero as ResponsablePlanAccion,rad.fechaEstimadaCierreReporteACPMDetalle,rad.estadoActualReporteACPMDetalle,rad.fechaCierreReporteACPMDetalle,rad.eficazReporteACPMDetalle
            FROM reporteacpmdetalle rad
            LEFT JOIN reporteacpm ra
            ON rad.ReporteACPM_idReporteACPM = ra.idReporteACPM
            LEFT JOIN proceso p
            ON rad.Proceso_idProceso = p.idProceso
            LEFT JOIN modulo m
            ON rad.Modulo_idModulo = m.idModulo
            LEFT JOIN tercero trc 
            ON rad.Tercero_idResponsableCorrecion = trc.idTercero
            LEFT JOIN tercero trpa 
            ON rad.Tercero_idResponsablePlanAccion = trpa.idTercero
            WHERE rad.ReporteACPM_idReporteACPM = '.$id);
            



             return view('formatos.reporteacpmimpresion',compact('reporteACPMEncabezado','reporteACPMDetalle'));

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
        $idTercero = \App\Tercero::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('idTercero');
        $nombreCompletoTercero = \App\Tercero::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('nombreCompletoTercero');

        $idProceso = \App\Proceso::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('idProceso');
        $nombreProceso = \App\Proceso::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('nombreProceso');

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
    public function update(ReporteACPMRequest $request, $id)
    {
        if($request['respuesta'] != 'falso')
        { 
            $reporteACPM = \App\ReporteACPM::find($id);
            $reporteACPM->fill($request->all());

            $reporteACPM->save();

            $idsEliminar = explode(',', $request['eliminarReporteACPMDetalle']);
            \App\ReporteACPMDetalle::whereIn('idReporteACPMDetalle',$idsEliminar)->delete();

            $contadorDetalle = count($request['ordenReporteACPMDetalle']);
            for($i = 0; $i < $contadorDetalle; $i++)
            {
                 $indice = array(
                'idReporteACPMDetalle' => $request['idReporteACPMDetalle'][$i]);

                $datos= array(
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
                    'eficazReporteACPMDetalle' => $request['eficazReporteACPMDetalle'][$i]);

                    $guardar = \App\ReporteACPMDetalle::updateOrCreate($indice, $datos);
            }

            return redirect('/reporteacpm');
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
        \App\ReporteACPM::destroy($id);
        return redirect('/reporteacpm');
    }
}
