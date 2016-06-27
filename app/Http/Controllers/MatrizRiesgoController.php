<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\MatrizRiesgoRequest;
use App\Http\Controllers\Controller;
use DB;
class MatrizRiesgoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    
    public function index()
    {
        return view('matrizriesgogrid');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $frecuenciaMedicion = \App\FrecuenciaMedicion::All()->lists('nombreFrecuenciaMedicion','idFrecuenciaMedicion');
        $idProceso = \App\Proceso::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('idProceso');
        $nombreProceso = \App\Proceso::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('nombreProceso');
        $idClasificacionRiesgo = \App\ClasificacionRiesgo::All()->lists('idClasificacionRiesgo');
        $nombreClasificacionRiesgo = \App\ClasificacionRiesgo::All()->lists('nombreClasificacionRiesgo');
        
        return view('matrizriesgo',compact('idProceso','nombreProceso','idClasificacionRiesgo','nombreClasificacionRiesgo','frecuenciaMedicion'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(MatrizRiesgoRequest $request)
    {
        /*$image = Input::file('imagenTercero');
        $imageName = $request->file('imagenTercero')->getClientOriginalName();
        $manager = new ImageManager();
        $manager->make($image->getRealPath())->heighten(56)->save('images/terceros/'. $imageName);*/

        if($request['respuesta'] != 'falso')
        {  

          \App\MatrizRiesgo::create([
              'nombreMatrizRiesgo' => $request['nombreMatrizRiesgo'],
              'fechaElaboracionMatrizRiesgo' => $request['fechaElaboracionMatrizRiesgo'],
              'FrecuenciaMedicion_idFrecuenciaMedicion' => $request['FrecuenciaMedicion_idFrecuenciaMedicion'],
              'fechaActualizacionMatrizRiesgo' => date("Y-m-d"),
              'Compania_idCompania' => \Session::get('idCompania'),
              'Users_id' => \Session::get('idUsuario')
              ]);
          
          $matrizRiesgo = \App\MatrizRiesgo::All()->last();
          $contadorDetalle = count($request['Proceso_idProceso']);
          for($i = 0; $i < $contadorDetalle; $i++)
          {
              \App\MatrizRiesgoDetalle::create([
                'MatrizRiesgo_idMatrizRiesgo' => $matrizRiesgo->idMatrizRiesgo,
                'Proceso_idProceso' => $request['Proceso_idProceso'][$i],
                'rutinariaMatrizRiesgoDetalle' => $request['rutinariaMatrizRiesgoDetalle'][$i],
                'ClasificacionRiesgo_idClasificacionRiesgo' => $request['ClasificacionRiesgo_idClasificacionRiesgo'][$i],
                'TipoRiesgo_idTipoRiesgo' => $request['TipoRiesgo_idTipoRiesgo'][$i],
                'TipoRiesgoDetalle_idTipoRiesgoDetalle' => $request['TipoRiesgoDetalle_idTipoRiesgoDetalle'][$i],
                'TipoRiesgoSalud_idTipoRiesgoSalud' => $request['TipoRiesgoSalud_idTipoRiesgoSalud'][$i],
                'vinculadosMatrizRiesgoDetalle' => $request['vinculadosMatrizRiesgoDetalle'][$i],
                'temporalesMatrizRiesgoDetalle' => $request['temporalesMatrizRiesgoDetalle'][$i],
                'independientesMatrizRiesgoDetalle' => $request['independientesMatrizRiesgoDetalle'][$i],
                'totalExpuestosMatrizRiesgoDetalle' => $request['totalExpuestosMatrizRiesgoDetalle'][$i],
                'fuenteMatrizRiesgoDetalle' => $request['fuenteMatrizRiesgoDetalle'][$i],
                'medioMatrizRiesgoDetalle' => $request['medioMatrizRiesgoDetalle'][$i],
                'personaMatrizRiesgoDetalle' => $request['personaMatrizRiesgoDetalle'][$i],
                'nivelDeficienciaMatrizRiesgoDetalle' => $request['nivelDeficienciaMatrizRiesgoDetalle'][$i],
                'nivelExposicionMatrizRiesgoDetalle' => $request['nivelExposicionMatrizRiesgoDetalle'][$i],
                'nivelProbabilidadMatrizRiesgoDetalle' => $request['nivelProbabilidadMatrizRiesgoDetalle'][$i],
                'nombreProbabilidadMatrizRiesgoDetalle' => $request['nombreProbabilidadMatrizRiesgoDetalle'][$i],
                'nivelConsecuenciaMatrizRiesgoDetalle' => $request['nivelConsecuenciaMatrizRiesgoDetalle'][$i],
                'nivelRiesgoMatrizRiesgoDetalle' => $request['nivelRiesgoMatrizRiesgoDetalle'][$i],
                'nombreRiesgoMatrizRiesgoDetalle' => $request['nombreRiesgoMatrizRiesgoDetalle'][$i],
                'aceptacionRiesgoMatrizRiesgoDetalle' => $request['aceptacionRiesgoMatrizRiesgoDetalle'][$i],
                'eliminacionMatrizRiesgoDetalle' => $request['eliminacionMatrizRiesgoDetalle'][$i],
                'sustitucionMatrizRiesgoDetalle' => $request['sustitucionMatrizRiesgoDetalle'][$i],
                'controlMatrizRiesgoDetalle' => $request['controlMatrizRiesgoDetalle'][$i],
                'elementoProteccionMatrizRiesgoDetalle' => $request['elementoProteccionMatrizRiesgoDetalle'][$i],
                'observacionMatrizRiesgoDetalle' => $request['observacionMatrizRiesgoDetalle'][$i]   
              ]);

              //************************************************
              //
              //  R E P O R T E   A C C I O N E S   
              //  C O R R E C T I V A S,  P R E V E N T I V A S 
              //  Y   D E   M E J O R A 
              //
              //************************************************
              // todos los accidentes o incidentes los  insertamos un registro en el ACPM (Accion Correctiva)

              //COnsultamos el nombre del tercero empleado
              $nombreClasificacion = \App\ClasificacionRiesgo::find($request['ClasificacionRiesgo_idClasificacionRiesgo'][$i]);
              $nombreRiesgo = \App\TipoRiesgo::find($request['TipoRiesgo_idTipoRiesgo'][$i]);
              $nombreDescripcion = \App\TipoRiesgoDetalle::find($request['TipoRiesgoDetalle_idTipoRiesgoDetalle'][$i]);
              

              if($request['eliminacionMatrizRiesgoDetalle'][$i] != '')
              {
                  $accionACPM = 'Clasificación: '.$nombreClasificacion->nombreClasificacionRiesgo.', '.
                            'Tipo: '.$nombreRiesgo->nombreTipoRiesgo.', '.
                            'Descripción: '.$nombreDescripcion->nombreTipoRiesgoDetalle.', '.
                            'Eliminación: '.$request['eliminacionMatrizRiesgoDetalle'][$i];
                  $this->guardarReporteACPM(
                      $fechaAccion = date("Y-m-d"), 
                      $idModulo = 28, 
                      $tipoAccion = 'Correctiva', 
                      $descripcionAccion = $accionACPM
                      ); 
              }
              if($request['sustitucionMatrizRiesgoDetalle'][$i] != '')
              {
                  $accionACPM = 'Clasificación: '.$nombreClasificacion->nombreClasificacionRiesgo.', '.
                            'Tipo: '.$nombreRiesgo->nombreTipoRiesgo.', '.
                            'Descripción: '.$nombreDescripcion->nombreTipoRiesgoDetalle.', '.
                            'Sustitución: '.$request['sustitucionMatrizRiesgoDetalle'][$i];
                  $this->guardarReporteACPM(
                      $fechaAccion = date("Y-m-d"), 
                      $idModulo = 28, 
                      $tipoAccion = 'Correctiva', 
                      $descripcionAccion = $accionACPM
                      ); 
              }
              if($request['controlMatrizRiesgoDetalle'][$i] != '')
              {
                  $accionACPM = 'Clasificación: '.$nombreClasificacion->nombreClasificacionRiesgo.', '.
                            'Tipo: '.$nombreRiesgo->nombreTipoRiesgo.', '.
                            'Descripción: '.$nombreDescripcion->nombreTipoRiesgoDetalle.', '.
                            'Control Adm: '.$request['controlMatrizRiesgoDetalle'][$i];
                  $this->guardarReporteACPM(
                      $fechaAccion = date("Y-m-d"), 
                      $idModulo = 28, 
                      $tipoAccion = 'Correctiva', 
                      $descripcionAccion = $accionACPM
                      ); 
              }

          }
        

          return redirect('/matrizriesgo');
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

          $matrizRiesgo = \App\MatrizRiesgo::find($id);
          
          $matrizRiesgoDetalle = DB::table('matrizriesgodetalle as mrd')
            ->leftJoin('proceso as p', 'mrd.Proceso_idProceso', '=', 'p.idProceso')
            ->leftJoin('clasificacionriesgo as cr', 'mrd.ClasificacionRiesgo_idClasificacionRiesgo', '=', 'cr.idClasificacionRiesgo')
            ->leftJoin('tiporiesgo as tr', 'mrd.TipoRiesgo_idTipoRiesgo', '=', 'tr.idTipoRiesgo')
            ->leftJoin('tiporiesgodetalle as trd', 'mrd.TipoRiesgoDetalle_idTipoRiesgoDetalle', '=', 'trd.idTipoRiesgoDetalle')
            ->leftJoin('tiporiesgosalud as trs', 'mrd.TipoRiesgoSalud_idTipoRiesgoSalud', '=', 'trs.idTipoRiesgoSalud')
            ->select(DB::raw('mrd.idMatrizRiesgoDetalle, mrd.MatrizRiesgo_idMatrizRiesgo, mrd.Proceso_idProceso, p.nombreProceso, mrd.rutinariaMatrizRiesgoDetalle, mrd.ClasificacionRiesgo_idClasificacionRiesgo, cr.nombreClasificacionRiesgo, mrd.TipoRiesgo_idTipoRiesgo, tr.nombreTipoRiesgo, mrd.TipoRiesgoDetalle_idTipoRiesgoDetalle, trd.nombreTipoRiesgoDetalle, mrd.TipoRiesgoSalud_idTipoRiesgoSalud, trs.nombreTipoRiesgoSalud, mrd.vinculadosMatrizRiesgoDetalle, mrd.temporalesMatrizRiesgoDetalle, mrd.independientesMatrizRiesgoDetalle, mrd.totalExpuestosMatrizRiesgoDetalle, mrd.fuenteMatrizRiesgoDetalle, mrd.medioMatrizRiesgoDetalle, mrd.personaMatrizRiesgoDetalle, mrd.nivelDeficienciaMatrizRiesgoDetalle, mrd.nivelExposicionMatrizRiesgoDetalle, mrd.nivelProbabilidadMatrizRiesgoDetalle, mrd.nombreProbabilidadMatrizRiesgoDetalle, mrd.nivelConsecuenciaMatrizRiesgoDetalle, mrd.nivelRiesgoMatrizRiesgoDetalle, mrd.nombreRiesgoMatrizRiesgoDetalle, mrd.aceptacionRiesgoMatrizRiesgoDetalle, mrd.eliminacionMatrizRiesgoDetalle, mrd.sustitucionMatrizRiesgoDetalle, mrd.controlMatrizRiesgoDetalle, mrd.elementoProteccionMatrizRiesgoDetalle,  mrd.imagenMatrizRiesgoDetalle, mrd.observacionMatrizRiesgoDetalle'))
            ->orderBy('idMatrizRiesgoDetalle', 'ASC')
            ->where('MatrizRiesgo_idMatrizRiesgo','=',$id)
            ->get();

            
            return view('formatos.matrizriesgoimpresion',['matrizRiesgo'=>$matrizRiesgo], compact('matrizRiesgoDetalle'));
        }

        if(isset($request['clasificacionRiesgo']))
        {

            $ids = \App\MatrizRiesgoDetalle::where('idMatrizRiesgoDetalle',$id)
                                        ->select('TipoRiesgo_idTipoRiesgo')
                                        ->get();

            $idTipoRiesgo = \App\TipoRiesgo::where('ClasificacionRiesgo_idClasificacionRiesgo',$request['clasificacionRiesgo'])
                                            ->select('idTipoRiesgo')
                                            ->get();
            $nombreTipoRiesgo = \App\TipoRiesgo::where('ClasificacionRiesgo_idClasificacionRiesgo',$request['clasificacionRiesgo'])
                                            ->select('nombreTipoRiesgo')
                                            ->get();                                
        
            if($request->ajax())
            {
                return response()->json([
                    $idTipoRiesgo,
                    $nombreTipoRiesgo,
                    $ids
                ]);
            }
        }

        if(isset($request['tipoRiesgo']))
        {
            $ids = \App\MatrizRiesgoDetalle::where('idMatrizRiesgoDetalle',$id)
                                        ->select('TipoRiesgoDetalle_idTipoRiesgoDetalle','TipoRiesgoSalud_idTipoRiesgoSalud')
                                        ->get();
            
            $idTipoRiesgoSalud = \App\TipoRiesgoSalud::where('TipoRiesgo_idTipoRiesgo',$request['tipoRiesgo'])
                                        ->select('idTipoRiesgoSalud')
                                        ->get();

            $nombreTipoRiesgoSalud = \App\TipoRiesgoSalud::where('TipoRiesgo_idTipoRiesgo',$request['tipoRiesgo'])
                                        ->select('nombreTipoRiesgoSalud')
                                        ->get();                            

            $idTipoRiesgoDetalle = \App\TipoRiesgoDetalle::where('TipoRiesgo_idTipoRiesgo',$request['tipoRiesgo'])
                                        ->select('idTipoRiesgoDetalle')
                                        ->get();

            $nombreTipoRiesgoDetalle = \App\TipoRiesgoDetalle::where('TipoRiesgo_idTipoRiesgo',$request['tipoRiesgo'])
                                        ->select('nombreTipoRiesgoDetalle')
                                        ->get();                                                                                                             

            if($request->ajax())
            {
                return response()->json([
                    $idTipoRiesgoDetalle,
                    $nombreTipoRiesgoDetalle,
                    $idTipoRiesgoSalud,
                    $nombreTipoRiesgoSalud,
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
        $frecuenciaMedicion = \App\FrecuenciaMedicion::All()->lists('nombreFrecuenciaMedicion','idFrecuenciaMedicion');
        $idProceso = \App\Proceso::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('idProceso');
        $nombreProceso = \App\Proceso::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('nombreProceso');
        $idClasificacionRiesgo = \App\ClasificacionRiesgo::All()->lists('idClasificacionRiesgo');
        $nombreClasificacionRiesgo = \App\ClasificacionRiesgo::All()->lists('nombreClasificacionRiesgo');

        
        $matrizRiesgo = \App\MatrizRiesgo::find($id);
        return view('matrizriesgo',compact('idProceso','nombreProceso','idClasificacionRiesgo','nombreClasificacionRiesgo','frecuenciaMedicion'),['matrizRiesgo'=>$matrizRiesgo]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(MatrizRiesgoRequest $request, $id)
    {


        if($request['respuesta'] != 'falso')
        {
          $matrizRiesgo = \App\MatrizRiesgo::find($id);
          $matrizRiesgo->fill($request->all());
          $matrizRiesgo->fechaActualizacionMatrizRiesgo = date("Y-m-d");


          /*if(null !== Input::file('imagenTercero') )
          {
              $image = Input::file('imagenTercero');
              $imageName = $request->file('imagenTercero')->getClientOriginalName();
              $manager = new ImageManager();
              $manager->make($image->getRealPath())->heighten(56)->save('images/terceros/'. $imageName);

              $tercero->imagenTercero = 'terceros\\'. $imageName;
          } */  

          $matrizRiesgo->save();

          \App\MatrizRiesgoDetalle::where('MatrizRiesgo_idMatrizRiesgo',$id)->delete();
          
          $contadorDetalle = count($request['Proceso_idProceso']);
          for($i = 0; $i < $contadorDetalle; $i++)
          {
              \App\MatrizRiesgoDetalle::create([
               'MatrizRiesgo_idMatrizRiesgo' => $id,
                'Proceso_idProceso' => $request['Proceso_idProceso'][$i],
                'rutinariaMatrizRiesgoDetalle' => $request['rutinariaMatrizRiesgoDetalle'][$i],
                'ClasificacionRiesgo_idClasificacionRiesgo' => $request['ClasificacionRiesgo_idClasificacionRiesgo'][$i],
                'TipoRiesgo_idTipoRiesgo' => $request['TipoRiesgo_idTipoRiesgo'][$i],
                'TipoRiesgoDetalle_idTipoRiesgoDetalle' => $request['TipoRiesgoDetalle_idTipoRiesgoDetalle'][$i],
                'TipoRiesgoSalud_idTipoRiesgoSalud' => $request['TipoRiesgoSalud_idTipoRiesgoSalud'][$i],
                'vinculadosMatrizRiesgoDetalle' => $request['vinculadosMatrizRiesgoDetalle'][$i],
                'temporalesMatrizRiesgoDetalle' => $request['temporalesMatrizRiesgoDetalle'][$i],
                'independientesMatrizRiesgoDetalle' => $request['independientesMatrizRiesgoDetalle'][$i],
                'totalExpuestosMatrizRiesgoDetalle' => $request['totalExpuestosMatrizRiesgoDetalle'][$i],
                'fuenteMatrizRiesgoDetalle' => $request['fuenteMatrizRiesgoDetalle'][$i],
                'medioMatrizRiesgoDetalle' => $request['medioMatrizRiesgoDetalle'][$i],
                'personaMatrizRiesgoDetalle' => $request['personaMatrizRiesgoDetalle'][$i],
                'nivelDeficienciaMatrizRiesgoDetalle' => $request['nivelDeficienciaMatrizRiesgoDetalle'][$i],
                'nivelExposicionMatrizRiesgoDetalle' => $request['nivelExposicionMatrizRiesgoDetalle'][$i],
                'nivelProbabilidadMatrizRiesgoDetalle' => $request['nivelProbabilidadMatrizRiesgoDetalle'][$i],
                'nombreProbabilidadMatrizRiesgoDetalle' => $request['nombreProbabilidadMatrizRiesgoDetalle'][$i],
                'nivelConsecuenciaMatrizRiesgoDetalle' => $request['nivelConsecuenciaMatrizRiesgoDetalle'][$i],
                'nivelRiesgoMatrizRiesgoDetalle' => $request['nivelRiesgoMatrizRiesgoDetalle'][$i],
                'nombreRiesgoMatrizRiesgoDetalle' => $request['nombreRiesgoMatrizRiesgoDetalle'][$i],
                'aceptacionRiesgoMatrizRiesgoDetalle' => $request['aceptacionRiesgoMatrizRiesgoDetalle'][$i],
                'eliminacionMatrizRiesgoDetalle' => $request['eliminacionMatrizRiesgoDetalle'][$i],
                'sustitucionMatrizRiesgoDetalle' => $request['sustitucionMatrizRiesgoDetalle'][$i],
                'controlMatrizRiesgoDetalle' => $request['controlMatrizRiesgoDetalle'][$i],
                'elementoProteccionMatrizRiesgoDetalle' => $request['elementoProteccionMatrizRiesgoDetalle'][$i],
                'observacionMatrizRiesgoDetalle' => $request['observacionMatrizRiesgoDetalle'][$i]   
              ]);

              //************************************************
              //
              //  R E P O R T E   A C C I O N E S   
              //  C O R R E C T I V A S,  P R E V E N T I V A S 
              //  Y   D E   M E J O R A 
              //
              //************************************************
              // todos los accidentes o incidentes los  insertamos un registro en el ACPM (Accion Correctiva)

              //COnsultamos el nombre del tercero empleado
              $nombreClasificacion = \App\ClasificacionRiesgo::find($request['ClasificacionRiesgo_idClasificacionRiesgo'][$i]);
              $nombreRiesgo = \App\TipoRiesgo::find($request['TipoRiesgo_idTipoRiesgo'][$i]);
              $nombreDescripcion = \App\TipoRiesgoDetalle::find($request['TipoRiesgoDetalle_idTipoRiesgoDetalle'][$i]);
              

              if($request['eliminacionMatrizRiesgoDetalle'][$i] != '')
              {
                  $accionACPM = 'Clasificación: '.$nombreClasificacion->nombreClasificacionRiesgo.', '.
                            'Tipo: '.$nombreRiesgo->nombreTipoRiesgo.', '.
                            'Descripción: '.$nombreDescripcion->nombreTipoRiesgoDetalle.', '.
                            'Eliminación: '.$request['eliminacionMatrizRiesgoDetalle'][$i];
                  $this->guardarReporteACPM(
                      $fechaAccion = date("Y-m-d"), 
                      $idModulo = 28, 
                      $tipoAccion = 'Correctiva', 
                      $descripcionAccion = $accionACPM
                      ); 
              }
              if($request['sustitucionMatrizRiesgoDetalle'][$i] != '')
              {
                  $accionACPM = 'Clasificación: '.$nombreClasificacion->nombreClasificacionRiesgo.', '.
                            'Tipo: '.$nombreRiesgo->nombreTipoRiesgo.', '.
                            'Descripción: '.$nombreDescripcion->nombreTipoRiesgoDetalle.', '.
                            'Sustitución: '.$request['sustitucionMatrizRiesgoDetalle'][$i];
                  $this->guardarReporteACPM(
                      $fechaAccion = date("Y-m-d"), 
                      $idModulo = 28, 
                      $tipoAccion = 'Correctiva', 
                      $descripcionAccion = $accionACPM
                      ); 
              }
              if($request['controlMatrizRiesgoDetalle'][$i] != '')
              {
                  $accionACPM = 'Clasificación: '.$nombreClasificacion->nombreClasificacionRiesgo.', '.
                            'Tipo: '.$nombreRiesgo->nombreTipoRiesgo.', '.
                            'Descripción: '.$nombreDescripcion->nombreTipoRiesgoDetalle.', '.
                            'Control Adm: '.$request['controlMatrizRiesgoDetalle'][$i];
                  $this->guardarReporteACPM(
                      $fechaAccion = date("Y-m-d"), 
                      $idModulo = 28, 
                      $tipoAccion = 'Correctiva', 
                      $descripcionAccion = $accionACPM
                      ); 
              }

          }
          
          return redirect('/matrizriesgo');
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
        \App\MatrizRiesgo::destroy($id);
        return redirect('/matrizriesgo');
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
