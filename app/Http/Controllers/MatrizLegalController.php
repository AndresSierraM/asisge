<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\MatrizLegalRequest;
use App\Http\Controllers\Controller;
use DB;
include public_path().'/ajax/consultarPermisos.php';

class MatrizLegalController extends Controller
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

        return view('matrizlegalgrid', compact('datos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $frecuenciaMedicion = \App\FrecuenciaMedicion::All()->lists('nombreFrecuenciaMedicion','idFrecuenciaMedicion');
        $idTipoNormaLegal = \App\TipoNormaLegal::All()->lists('idTipoNormaLegal');
        $nombreTipoNormaLegal = \App\TipoNormaLegal::All()->lists('nombreTipoNormaLegal');
        $idExpideNormaLegal = \App\ExpideNormaLegal::All()->lists('idExpideNormaLegal');
        $nombreExpideNormaLegal = \App\ExpideNormaLegal::All()->lists('nombreExpideNormaLegal');
        return view('matrizlegal', compact('idTipoNormaLegal','nombreTipoNormaLegal','idExpideNormaLegal','nombreExpideNormaLegal', 'frecuenciaMedicion'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(MatrizLegalRequest $request)
    {

        if($request['respuesta'] != 'falso')
        {
            \App\MatrizLegal::create([
                'nombreMatrizLegal' => $request['nombreMatrizLegal'],
                'fechaElaboracionMatrizLegal' => $request['fechaElaboracionMatrizLegal'],
                'origenMatrizLegal' => $request['origenMatrizLegal'],
                'FrecuenciaMedicion_idFrecuenciaMedicion' => $request['FrecuenciaMedicion_idFrecuenciaMedicion'],
                'fechaActualizacionMatrizLegal' => date("Y-m-d"),
                'Compania_idCompania' => \Session::get('idCompania'),
                'Users_id' => \Session::get('idUsuario')
                ]);
            
            $matrizLegal = \App\MatrizLegal::All()->last();
            $contadorDetalle = count($request['TipoNormaLegal_idTipoNormaLegal']);
            for($i = 0; $i < $contadorDetalle; $i++)
            {
                \App\MatrizLegalDetalle::create([

                    'MatrizLegal_idMatrizLegal' => $matrizLegal->idMatrizLegal,
                    'TipoNormaLegal_idTipoNormaLegal' => $request['TipoNormaLegal_idTipoNormaLegal'][$i],
                    'articuloAplicableMatrizLegalDetalle' => $request['articuloAplicableMatrizLegalDetalle'][$i],
                    'ExpideNormaLegal_idExpideNormaLegal' => $request['ExpideNormaLegal_idExpideNormaLegal'][$i],
                    'exigenciaMatrizLegalDetalle' => $request['exigenciaMatrizLegalDetalle'][$i],
                    'fuenteMatrizLegalDetalle' => $request['fuenteMatrizLegalDetalle'][$i],
                    'medioMatrizLegalDetalle' => $request['medioMatrizLegalDetalle'][$i],
                    'personaMatrizLegalDetalle' => $request['personaMatrizLegalDetalle'][$i],
                    'herramientaSeguimientoMatrizLegalDetalle' => $request['herramientaSeguimientoMatrizLegalDetalle'][$i],
                    'cumpleMatrizLegalDetalle' => $request['cumpleMatrizLegalDetalle'][$i],
                    'fechaVerificacionMatrizLegalDetalle' => $request['fechaVerificacionMatrizLegalDetalle'][$i],
                    'accionEvidenciaMatrizLegalDetalle' => $request['accionEvidenciaMatrizLegalDetalle'][$i],
                    'controlAImplementarMatrizLegalDetalle' => $request['controlAImplementarMatrizLegalDetalle'][$i]
                ]);

                // verificamos si no tiene el chulo SE CUMPLE, insertamos un registro en el ACPM (Accion Correctiva)
                if($request['cumpleMatrizLegalDetalle'][$i] == 0 )
                {
                        //************************************************
                        //
                        //  R E P O R T E   A C C I O N E S   
                        //  C O R R E C T I V A S,  P R E V E N T I V A S 
                        //  Y   D E   M E J O R A 
                        //
                        //************************************************
                        // todos los accidentes o incidentes los  insertamos un registro en el ACPM (Accion Correctiva)

                        $this->guardarReporteACPM(
                                $fechaAccion = date("Y-m-d"), 
                                $idModulo = 30, 
                                $tipoAccion = 'Correctiva', 
                                $descripcionAccion = $request['controlAImplementarMatrizLegalDetalle'][$i]
                                ); 
                }
            }
            
            return redirect('/matrizlegal');
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
        if(isset($request['accion']) and $request['accion'] == 'imprimir')
        {

          $matrizLegal = \App\MatrizLegal::find($id);
          
          $matrizLegalDetalle = DB::table('matrizlegaldetalle as mld')
            ->leftJoin('tiponormalegal as tpl', 'mld.TipoNormaLegal_idTipoNormaLegal', '=', 'tpl.idTipoNormaLegal')
            ->leftJoin('expidenormalegal as enl', 'mld.ExpideNormaLegal_idExpideNormaLegal', '=', 'enl.idExpideNormaLegal')
            ->select(DB::raw('mld.idMatrizLegalDetalle, mld.MatrizLegal_idMatrizLegal, mld.TipoNormaLegal_idTipoNormaLegal, tpl.nombreTipoNormaLegal, mld.articuloAplicableMatrizLegalDetalle, mld.ExpideNormaLegal_idExpideNormaLegal, enl.nombreExpideNormaLegal, mld.exigenciaMatrizLegalDetalle, mld.fuenteMatrizLegalDetalle, mld.medioMatrizLegalDetalle, mld.personaMatrizLegalDetalle, mld.herramientaSeguimientoMatrizLegalDetalle, mld.cumpleMatrizLegalDetalle, mld.fechaVerificacionMatrizLegalDetalle, mld.accionEvidenciaMatrizLegalDetalle, mld.controlAImplementarMatrizLegalDetalle'))
            ->orderBy('idMatrizLegalDetalle', 'ASC')
            ->where('MatrizLegal_idMatrizLegal','=',$id)
            ->get();

            return view('formatos.matrizlegalimpresion',['matrizLegal'=>$matrizLegal], compact('matrizLegalDetalle'));
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
        $frecuenciaMedicion = \App\FrecuenciaMedicion::All()->lists('nombreFrecuenciaMedicion','idFrecuenciaMedicion');
        $idTipoNormaLegal = \App\TipoNormaLegal::All()->lists('idTipoNormaLegal');
        $nombreTipoNormaLegal = \App\TipoNormaLegal::All()->lists('nombreTipoNormaLegal');
        $idExpideNormaLegal = \App\ExpideNormaLegal::All()->lists('idExpideNormaLegal');
        $nombreExpideNormaLegal = \App\ExpideNormaLegal::All()->lists('nombreExpideNormaLegal');

        $matrizLegal = \App\MatrizLegal::find($id);
        return view('matrizlegal', compact('idTipoNormaLegal','nombreTipoNormaLegal','idExpideNormaLegal','nombreExpideNormaLegal','frecuenciaMedicion'),['matrizLegal'=>$matrizLegal]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(MatrizLegalRequest $request, $id)
    {

        if($request['respuesta'] != 'falso')
        {
            $matrizLegal = \App\MatrizLegal::find($id);
            $matrizLegal->fill($request->all());
            $matrizLegal->Users_id = \Session::get('idUsuario');
            $matrizLegal->fechaActualizacionMatrizLegal = date("Y-m-d");

            $matrizLegal->save();

            \App\MatrizLegalDetalle::where('MatrizLegal_idMatrizLegal',$id)->delete();
            
            $contadorDetalle = count($request['TipoNormaLegal_idTipoNormaLegal']);
            for($i = 0; $i < $contadorDetalle; $i++)
            {
                \App\MatrizLegalDetalle::create([

                    'MatrizLegal_idMatrizLegal' => $id,
                    'TipoNormaLegal_idTipoNormaLegal' => $request['TipoNormaLegal_idTipoNormaLegal'][$i],
                    'articuloAplicableMatrizLegalDetalle' => $request['articuloAplicableMatrizLegalDetalle'][$i],
                    'ExpideNormaLegal_idExpideNormaLegal' => $request['ExpideNormaLegal_idExpideNormaLegal'][$i],
                    'exigenciaMatrizLegalDetalle' => $request['exigenciaMatrizLegalDetalle'][$i],
                    'fuenteMatrizLegalDetalle' => $request['fuenteMatrizLegalDetalle'][$i],
                    'medioMatrizLegalDetalle' => $request['medioMatrizLegalDetalle'][$i],
                    'personaMatrizLegalDetalle' => $request['personaMatrizLegalDetalle'][$i],
                    'herramientaSeguimientoMatrizLegalDetalle' => $request['herramientaSeguimientoMatrizLegalDetalle'][$i],
                    'cumpleMatrizLegalDetalle' => $request['cumpleMatrizLegalDetalle'][$i],
                    'fechaVerificacionMatrizLegalDetalle' => $request['fechaVerificacionMatrizLegalDetalle'][$i],
                    'accionEvidenciaMatrizLegalDetalle' => $request['accionEvidenciaMatrizLegalDetalle'][$i],
                    'controlAImplementarMatrizLegalDetalle' => $request['controlAImplementarMatrizLegalDetalle'][$i]
                ]);

                // verificamos si no tiene el chulo SE CUMPLE, insertamos un registro en el ACPM (Accion Correctiva)
                if($request['cumpleMatrizLegalDetalle'][$i] == 0 )
                {
                        //************************************************
                        //
                        //  R E P O R T E   A C C I O N E S   
                        //  C O R R E C T I V A S,  P R E V E N T I V A S 
                        //  Y   D E   M E J O R A 
                        //
                        //************************************************
                        // todos los accidentes o incidentes los  insertamos un registro en el ACPM (Accion Correctiva)

                        $this->guardarReporteACPM(
                                $fechaAccion = date("Y-m-d"), 
                                $idModulo = 30, 
                                $tipoAccion = 'Correctiva', 
                                $descripcionAccion = $request['controlAImplementarMatrizLegalDetalle'][$i]
                                );   
                }
            }
            
            return redirect('/matrizlegal');
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
        \App\MatrizLegal::destroy($id);
        return redirect('/matrizlegal');
    }

    protected function guardarReporteACPM($fechaAccion, $idModulo, $tipoAccion, $descripcionAccion)
    {   

        $reporteACPM = \App\ReporteACPM::All()->last();
        
        $indice = array(
            'ReporteACPM_idReporteACPM' => $reporteACPM->idReporteACPM, 
            'fechaReporteACPMDetalle' => $fechaAccion,
            'Modulo_idModulo' => $idModulo,
            'tipoReporteACPMDetalle' => $tipoAccion,
            'descripcionReporteACPMDetalle' => $descripcionAccion);

        $data = array(
            'ReporteACPM_idReporteACPM' => $reporteACPM->idReporteACPM,
            'ordenReporteACPMDetalle' => 0,
            'fechaReporteACPMDetalle' => $fechaAccion,
            'Proceso_idProceso' => NULL,
            'Modulo_idModulo' => $idModulo,
            'tipoReporteACPMDetalle' => $tipoAccion,
            'descripcionReporteACPMDetalle' => $descripcionAccion,
            'analisisReporteACPMDetalle' => '',
            'correccionReporteACPMDetalle' => '',
            'Tercero_idResponsableCorrecion' => NULL,
            'planAccionReporteACPMDetalle' => '',
            'Tercero_idResponsablePlanAccion' => NULL,
            'fechaEstimadaCierreReporteACPMDetalle' => '0000-00-00',
            'estadoActualReporteACPMDetalle' => '',
            'fechaCierreReporteACPMDetalle' => '0000-00-00',
            'eficazReporteACPMDetalle' => 0);

        $respuesta = \App\ReporteACPMDetalle::updateOrCreate($indice, $data);
    }
}
