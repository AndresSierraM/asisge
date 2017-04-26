<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\MatrizRiesgoRequest;
use App\Http\Controllers\Controller;
use DB;
use Input;
use File;
use Validator;
use Response;
use Excel;
include public_path().'/ajax/consultarPermisos.php';
include public_path().'/ajax/guardarReporteAcpm.php';
class MatrizRiesgoController extends Controller
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
            return view('matrizriesgogrid', compact('datos'));
        else
            return view('accesodenegado');
    }

    public function indexdropzone() 
    {
        return view('dropzone');
    }

    //Funcion para subir archivos con dropzone
    public function uploadFiles(Request $request) 
    {
 
        $input = Input::all();
 
        $rules = array(
        );
 
        $validation = Validator::make($input, $rules);
 
        if ($validation->fails()) {
            return Response::make($validation->errors->first(), 400);
        }
        
        $destinationPath = public_path() . '/imagenes/repositorio/temporal'; //Guardo en la carpeta  temporal

        $extension = Input::file('file')->getClientOriginalExtension(); 
        $fileName = Input::file('file')->getClientOriginalName(); // nombre de archivo
        $upload_success = Input::file('file')->move($destinationPath, $fileName);
 
        if ($upload_success) {
            return Response::json('success', 200);
        } 
        else {
            return Response::json('error', 400);
        }
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
        $manager->make($image->getRealPath())->heighten(56)->save('images/matriz/'. $imageName);*/

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
                // 'medioMatrizRiesgoDetalle' => $request['medioMatrizRiesgoDetalle'][$i],
                // 'personaMatrizRiesgoDetalle' => $request['personaMatrizRiesgoDetalle'][$i],
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
                  guardarReporteACPM(
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
                  guardarReporteACPM(
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
                  guardarReporteACPM(
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
            ->select(DB::raw('mrd.idMatrizRiesgoDetalle, mrd.MatrizRiesgo_idMatrizRiesgo, mrd.Proceso_idProceso, p.nombreProceso, mrd.rutinariaMatrizRiesgoDetalle, mrd.ClasificacionRiesgo_idClasificacionRiesgo, cr.nombreClasificacionRiesgo, mrd.TipoRiesgo_idTipoRiesgo, tr.nombreTipoRiesgo, mrd.TipoRiesgoDetalle_idTipoRiesgoDetalle, trd.nombreTipoRiesgoDetalle, mrd.TipoRiesgoSalud_idTipoRiesgoSalud, trs.nombreTipoRiesgoSalud, mrd.vinculadosMatrizRiesgoDetalle, mrd.temporalesMatrizRiesgoDetalle, mrd.independientesMatrizRiesgoDetalle, mrd.totalExpuestosMatrizRiesgoDetalle, mrd.fuenteMatrizRiesgoDetalle, mrd.nivelDeficienciaMatrizRiesgoDetalle, mrd.nivelExposicionMatrizRiesgoDetalle, mrd.nivelProbabilidadMatrizRiesgoDetalle, mrd.nombreProbabilidadMatrizRiesgoDetalle, mrd.nivelConsecuenciaMatrizRiesgoDetalle, mrd.nivelRiesgoMatrizRiesgoDetalle, mrd.nombreRiesgoMatrizRiesgoDetalle, mrd.aceptacionRiesgoMatrizRiesgoDetalle, mrd.eliminacionMatrizRiesgoDetalle, mrd.sustitucionMatrizRiesgoDetalle, mrd.controlMatrizRiesgoDetalle, mrd.elementoProteccionMatrizRiesgoDetalle,  mrd.imagenMatrizRiesgoDetalle, mrd.observacionMatrizRiesgoDetalle'))
            ->orderBy('idMatrizRiesgoDetalle', 'ASC')
            ->where('MatrizRiesgo_idMatrizRiesgo','=',$id)
            ->get();
            // Se quita de la consulta estos dos campos mrd.medioMatrizRiesgoDetalle, mrd.personaMatrizRiesgoDetalle,
            
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
              $manager->make($image->getRealPath())->heighten(56)->save('images/matriz/'. $imageName);

              $tercero->imagenTercero = 'matriz\\'. $imageName;
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
                // 'medioMatrizRiesgoDetalle' => $request['medioMatrizRiesgoDetalle'][$i],
                // 'personaMatrizRiesgoDetalle' => $request['personaMatrizRiesgoDetalle'][$i],
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
                  guardarReporteACPM(
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
                  guardarReporteACPM(
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
                  guardarReporteACPM(
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

    public function importarMatrizRiesgo()
    {
      $destinationPath = public_path() . '/imagenes/repositorio/temporal'; 
        Excel::load($destinationPath.'/Plantilla Matriz Riesgo.xlsx', function($reader) {

            $datos = $reader->getActiveSheet();

            $matriz = array();
            $errores = array();
            $fila = 10;
            $posMatriz = 0;
            $posErr = 0;            

            //*****************************
            // Fecha 
            //*****************************
            // si la celda esta en blanco, reportamos error de obligatoriedad
            $fechaMatriz = $datos->getCellByColumnAndRow(0, 5)->getValue();
            if($fechaMatriz == '' or 
                    $fechaMatriz == null)
            {
                $fechaMatriz = date("Y-m-d");
            }

            //*****************************
            // Nombre
            //*****************************
            // si la celda esta en blanco, reportamos error de obligatoriedad
            $nombreMatriz = $datos->getCellByColumnAndRow(1, 5)->getValue();
            if($nombreMatriz == '' or 
                    $nombreMatriz == null)
            {
                $errores[$posErr]["linea"] = 5;
                // $errores[$posErr]["nombre"] = $matriz[ $posMatriz]["nombreCompletoTercero"];
                $errores[$posErr]["mensaje"] = 'Debe diligenciar el nombre de la matriz';
                
                $posErr++;
            }

            //*****************************
            // Frecuencia Medicion
            //*****************************
            // si la celda esta en blanco, reportamos error de obligatoriedad
            $frecuenciaMedicion = $datos->getCellByColumnAndRow(2, 5)->getValue();
            if($frecuenciaMedicion == '' or 
                $frecuenciaMedicion == null)
            {
                $errores[$posErr]["linea"] = 5;
                // $errores[$posErr]["nombre"] = $matriz[ $posMatriz]["nombreCompletoTercero"];
                $errores[$posErr]["mensaje"] = 'Debe diligenciar la Frecuencia de Medición';
                
                $posErr;
            }
            else
            {
                $consulta = \App\FrecuenciaMedicion::where('codigoFrecuenciaMedicion','=', $frecuenciaMedicion)->lists('idFrecuenciaMedicion');

                // si se encuentra el id lo guardamos en el array
                if(isset($consulta[0]))
                    $frecuenciaMedicion = $consulta[0];
                else
                {
                    $errores[$posErr]["linea"] = 5;
                    // $errores[$posErr]["nombre"] = $matriz[ $posMatriz]["nombreCompletoTercero"];
                    $errores[$posErr]["mensaje"] = 'Frecuencia '. $frecuenciaMedicion. ' no existe';
                    
                    $posErr;
                }
            }

            while ($datos->getCellByColumnAndRow(0, $fila)->getValue() != '' and
                    $datos->getCellByColumnAndRow(0, $fila)->getValue() != NULL) {
                

                // para cada registro de matriz recorremos las columnas desde la 0 hasta la 24
                $matriz[$posMatriz]["idMatrizRiesgoDetalle"] = 0;
                $matriz[$posMatriz]["Compania_idCompania"] = 0;
                for ($columna = 0; $columna <= 24; $columna++) {
                    // en la fila 9 del archivo de excel (oculta) estan los nombres de los campos de la tabla
                    $campo = $datos->getCellByColumnAndRow($columna, 9)->getValue();

                    // si es una celda calculada, la ejeutamos, sino tomamos su valor
                    if ($datos->getCellByColumnAndRow($columna, $fila)->getDataType() == 'f')
                        $matriz[$posMatriz][$campo] = $datos->getCellByColumnAndRow($columna, $fila)->getCalculatedValue();
                    else
                    {
                        $matriz[$posMatriz][$campo] = 
                            ($datos->getCellByColumnAndRow($columna, $fila)->getValue() == null 
                                ? ''
                                : $datos->getCellByColumnAndRow($columna, $fila)->getValue());
                    }

                }

                
                //*****************************
                // Proceso
                //*****************************
                // si la celda esta en blanco, reportamos error de obligatoriedad
                if($matriz[ $posMatriz]["Proceso_idProceso"] == '' or 
                    $matriz[ $posMatriz]["Proceso_idProceso"] == null)
                {
                    $errores[$posErr]["linea"] = $fila;
                    // $errores[$posErr]["nombre"] = $matriz[ $posMatriz]["nombreCompletoTercero"];
                    $errores[$posErr]["mensaje"] = 'Debe diligenciar el Proceso';
                    
                    $posErr++;
                }
                else
                {
                    $consulta = \App\Proceso::where('codigoProceso','=', $matriz[ $posMatriz]["Proceso_idProceso"])->lists('idProceso');

                    // si se encuentra el id lo guardamos en el array
                    if(isset($consulta[0]))
                        $matriz[$posMatriz]["Proceso_idProceso"] = $consulta[0];
                    else
                    {
                        $errores[$posErr]["linea"] = $fila;
                        // $errores[$posErr]["nombre"] = $matriz[ $posMatriz]["nombreCompletoTercero"];
                        $errores[$posErr]["mensaje"] = 'Proceso '. $matriz[ $posMatriz]["Proceso_idProceso"]. ' no existe';
                        
                        $posErr++;
                    }
                }

                //*****************************
                // Clasificación
                //*****************************
                // si la celda esta en blanco, reportamos error de obligatoriedad
                if($matriz[ $posMatriz]["ClasificacionRiesgo_idClasificacionRiesgo"] == '' or 
                    $matriz[ $posMatriz]["ClasificacionRiesgo_idClasificacionRiesgo"] == null)
                {
                    $errores[$posErr]["linea"] = $fila;
                    // $errores[$posErr]["nombre"] = $matriz[ $posMatriz]["nombreCompletoTercero"];
                    $errores[$posErr]["mensaje"] = 'Debe diligenciar la Clasificación';
                    
                    $posErr++;
                }
                else
                {
                    $consulta = \App\ClasificacionRiesgo::where('codigoClasificacionRiesgo','=', $matriz[ $posMatriz]["ClasificacionRiesgo_idClasificacionRiesgo"])->lists('idClasificacionRiesgo');

                    // si se encuentra el id lo guardamos en el array
                    if(isset($consulta[0]))
                        $matriz[$posMatriz]["ClasificacionRiesgo_idClasificacionRiesgo"] = $consulta[0];
                    else
                    {
                        $errores[$posErr]["linea"] = $fila;
                        // $errores[$posErr]["nombre"] = $matriz[ $posMatriz]["nombreCompletoTercero"];
                        $errores[$posErr]["mensaje"] = 'Clasificación '. $matriz[ $posMatriz]["ClasificacionRiesgo_idClasificacionRiesgo"]. ' no existe';
                        
                        $posErr++;
                    }
                }

                //*****************************
                // Tipo Riesgo
                //*****************************
                // si la celda esta en blanco, reportamos error de obligatoriedad
                if($matriz[ $posMatriz]["TipoRiesgo_idTipoRiesgo"] == '' or 
                    $matriz[ $posMatriz]["TipoRiesgo_idTipoRiesgo"] == null)
                {
                    $errores[$posErr]["linea"] = $fila;
                    // $errores[$posErr]["nombre"] = $matriz[ $posMatriz]["nombreCompletoTercero"];
                    $errores[$posErr]["mensaje"] = 'Debe diligenciar el Tipo de Riesgo';
                    
                    $posErr++;
                }
                else
                {
                    $consulta = \App\TipoRiesgo::where('codigoTipoRiesgo','=', $matriz[ $posMatriz]["TipoRiesgo_idTipoRiesgo"])->lists('idTipoRiesgo');

                    // si se encuentra el id lo guardamos en el array
                    if(isset($consulta[0]))
                        $matriz[$posMatriz]["TipoRiesgo_idTipoRiesgo"] = $consulta[0];
                    else
                    {
                        $errores[$posErr]["linea"] = $fila;
                        // $errores[$posErr]["nombre"] = $matriz[ $posMatriz]["nombreCompletoTercero"];
                        $errores[$posErr]["mensaje"] = 'Tipo Riesgo '. $matriz[ $posMatriz]["TipoRiesgo_idTipoRiesgo"]. ' no existe';
                        
                        $posErr++;
                    }
                }

                //*****************************
                // Tipo Riesgo Detalle
                //*****************************
                // si la celda esta en blanco, reportamos error de obligatoriedad
                if($matriz[ $posMatriz]["TipoRiesgoDetalle_idTipoRiesgoDetalle"] == '' or 
                    $matriz[ $posMatriz]["TipoRiesgoDetalle_idTipoRiesgoDetalle"] == null)
                {
                    $errores[$posErr]["linea"] = $fila;
                    // $errores[$posErr]["nombre"] = $matriz[ $posMatriz]["nombreCompletoTercero"];
                    $errores[$posErr]["mensaje"] = 'Debe diligenciar el Tipo de Riesgo';
                    
                    $posErr++;
                }
                else
                {
                    $consulta = \App\TipoRiesgoDetalle::where('nombreTipoRiesgoDetalle','=', $matriz[ $posMatriz]["TipoRiesgoDetalle_idTipoRiesgoDetalle"])->lists('idTipoRiesgoDetalle');

                    // si se encuentra el id lo guardamos en el array
                    if(isset($consulta[0]))
                        $matriz[$posMatriz]["TipoRiesgoDetalle_idTipoRiesgoDetalle"] = $consulta[0];
                    else
                    {
                        $errores[$posErr]["linea"] = $fila;
                        // $errores[$posErr]["nombre"] = $matriz[ $posMatriz]["nombreCompletoTercero"];
                        $errores[$posErr]["mensaje"] = 'Tipo Riesgo Detalle '. $matriz[ $posMatriz]["TipoRiesgoDetalle_idTipoRiesgoDetalle"]. ' no existe';
                        
                        $posErr++;
                    }
                }

                //*****************************
                // Tipo Riesgo Salud
                //*****************************
                // si la celda esta en blanco, reportamos error de obligatoriedad
                if($matriz[ $posMatriz]["TipoRiesgoSalud_idTipoRiesgoSalud"] == '' or 
                    $matriz[ $posMatriz]["TipoRiesgoSalud_idTipoRiesgoSalud"] == null)
                {
                    $errores[$posErr]["linea"] = $fila;
                    // $errores[$posErr]["nombre"] = $matriz[ $posMatriz]["nombreCompletoTercero"];
                    $errores[$posErr]["mensaje"] = 'Debe diligenciar el Tipo de Riesgo ';
                    
                    $posErr++;
                }
                else
                {
                    $consulta = \App\TipoRiesgoSalud::where('nombreTipoRiesgoSalud','=', $matriz[ $posMatriz]["TipoRiesgoSalud_idTipoRiesgoSalud"])->lists('idTipoRiesgoSalud');

                    // si se encuentra el id lo guardamos en el array
                    if(isset($consulta[0]))
                        $matriz[$posMatriz]["TipoRiesgoSalud_idTipoRiesgoSalud"] = $consulta[0];
                    else
                    {
                        $errores[$posErr]["linea"] = $fila;
                        // $errores[$posErr]["nombre"] = $matriz[ $posMatriz]["nombreCompletoTercero"];
                        $errores[$posErr]["mensaje"] = 'Tipo Riesgo Salud '. $matriz[ $posMatriz]["TipoRiesgoSalud_idTipoRiesgoSalud"]. ' no existe';
                        
                        $posErr++;
                    }
                }

                //*****************************
                // Nivel Deficiencia
                //*****************************
                // si la celda esta en blanco, reportamos error de obligatoriedad
                if($matriz[ $posMatriz]["nivelDeficienciaMatrizRiesgoDetalle"] == '' or 
                    $matriz[ $posMatriz]["nivelDeficienciaMatrizRiesgoDetalle"] == null)
                {
                    $errores[$posErr]["linea"] = $fila;
                    // $errores[$posErr]["nombre"] = $matriz[ $posMatriz]["nombreCompletoTercero"];
                    $errores[$posErr]["mensaje"] = 'Debe diligenciar el Nivel de Deficiencia';
                    
                    $posErr++;
                }
                else
                {
                    //buscamos el id en el modelo correspondiente
                    $consulta = \App\MatrizRiesgoDetalle::where('nivelDeficienciaMatrizRiesgoDetalle','=', $matriz[ $posMatriz]["nivelDeficienciaMatrizRiesgoDetalle"])->lists('idMatrizRiesgoDetalle');
                    // si se encuentra el id lo guardamos en el array

                    if(isset($consulta[0]))
                        $matriz[$posMatriz]["idMatrizRiesgoDetalle"] = $consulta[0];
                }

                //*****************************
                // Nivel Exposición
                //*****************************
                // si la celda esta en blanco, reportamos error de obligatoriedad
                if($matriz[ $posMatriz]["nivelExposicionMatrizRiesgoDetalle"] == '' or 
                    $matriz[ $posMatriz]["nivelExposicionMatrizRiesgoDetalle"] == null)
                {
                    $errores[$posErr]["linea"] = $fila;
                    // $errores[$posErr]["nombre"] = $matriz[ $posMatriz]["nombreCompletoTercero"];
                    $errores[$posErr]["mensaje"] = 'Debe diligenciar el Nivel de Exposición';
                    
                    $posErr++;
                }
                else
                {
                    //buscamos el id en el modelo correspondiente
                    $consulta = \App\MatrizRiesgoDetalle::where('nivelExposicionMatrizRiesgoDetalle','=', $matriz[ $posMatriz]["nivelExposicionMatrizRiesgoDetalle"])->lists('idMatrizRiesgoDetalle');
                    // si se encuentra el id lo guardamos en el array

                    if(isset($consulta[0]))
                        $matriz[$posMatriz]["idMatrizRiesgoDetalle"] = $consulta[0];
                }

                //*****************************
                // Nivel Consecuencia
                //*****************************
                // si la celda esta en blanco, reportamos error de obligatoriedad
                if($matriz[ $posMatriz]["nivelConsecuenciaMatrizRiesgoDetalle"] == '' or 
                    $matriz[ $posMatriz]["nivelConsecuenciaMatrizRiesgoDetalle"] == null)
                {
                    $errores[$posErr]["linea"] = $fila;
                    // $errores[$posErr]["nombre"] = $matriz[ $posMatriz]["nombreCompletoTercero"];
                    $errores[$posErr]["mensaje"] = 'Debe diligenciar el Nivel de Consecuencia';
                    
                    $posErr++;
                }
                else
                {
                    //buscamos el id en el modelo correspondiente
                    $consulta = \App\MatrizRiesgoDetalle::where('nivelConsecuenciaMatrizRiesgoDetalle','=', $matriz[ $posMatriz]["nivelConsecuenciaMatrizRiesgoDetalle"])->lists('idMatrizRiesgoDetalle');
                    // si se encuentra el id lo guardamos en el array

                    if(isset($consulta[0]))
                        $matriz[$posMatriz]["idMatrizRiesgoDetalle"] = $consulta[0];
                }

                $posMatriz++;
                $fila++;
                
            }

            $totalErrores = count($errores);
            if($totalErrores > 0)
            {
                $mensaje = '<table cellspacing="0" cellpadding="1" style="width:100%;">'.
                        '<tr>'.
                            '<td colspan="3">'.
                                '<h3>Informe de inconsistencias en Importacion de matriz</h3>'.
                            '</td>'.
                        '</tr>'.
                        '<tr>'.
                            '<td >No. Línea</td>'.
                            // '<td >Nombre</td>'.
                            '<td >Mensaje</td>'.
                        '</tr>';

                for($regErr = 0; $regErr < $totalErrores; $regErr++)
                {
                     $mensaje .= '<tr>'.
                                '<td >'.$errores[$regErr]["linea"].'</td>'.
                                // '<td >'.$errores[$regErr]["nombre"].'</td>'.
                                '<td >'.$errores[$regErr]["mensaje"].'</td>'.
                            '</tr>';
                }
                $mensaje .= '</table>';
                echo json_encode(array(false, $mensaje));
            }
            else
            {

              $indice = array(
                        'idMatrizRiesgo' => 0);

              $data = array(
                  'fechaElaboracionMatrizRiesgo' => $fechaMatriz,
                  'nombreMatrizRiesgo' => $nombreMatriz,
                  'Users_id' => \Session::get("idUsuario"),
                  'FrecuenciaMedicion_idFrecuenciaMedicion' => $frecuenciaMedicion,
                  'Compania_idCompania' => \Session::get("idCompania")
              );

              $matrizriesgo = \App\MatrizRiesgo::updateOrCreate($indice, $data);

              // Consultamos el ultimo id insertado en la matriz de riesgo
              $ultmatrizRiesgo = \App\MatrizRiesgo::All()->last();              
              $matrizriesgo = $ultmatrizRiesgo->idMatrizRiesgo;
                // recorremos el array recibido para insertar o actualizar cada registro
                for($reg = 0; $reg < count($matriz); $reg++)
                {
                    $probabilidad = '';

                    $nivelProbabilidad = ((int)$matriz[$reg]['nivelDeficienciaMatrizRiesgoDetalle'] * (int)['nivelExposicionMatrizRiesgoDetalle']);

                    if($nivelProbabilidad >= 24 && $nivelProbabilidad <= 40)
                      $probabilidad = 'Muy Alto';
                    else if($nivelProbabilidad >=  10  && $nivelProbabilidad <= 20)
                      $probabilidad = 'Alto';
                    else if($nivelProbabilidad >=  6 && $nivelProbabilidad <= 8)
                      $probabilidad = 'Medio';
                    else if($nivelProbabilidad >=  2 && $nivelProbabilidad <= 4)
                      $probabilidad = 'Bajo';
                    else if($nivelProbabilidad ==  0 )
                      $probabilidad = '';  


                    $nivelRiesgo = ((int)$probabilidad * (int)$matriz[$reg]['nivelConsecuenciaMatrizRiesgoDetalle']);

                    if($nivelRiesgo >= 600 && $nivelRiesgo <= 4000)
                      { 
                          $nombreRiesgo = 'I';
                          $aceptacionRiesgo = 'No aceptable';
                      }
                      else if($nivelRiesgo >=  150  && $nivelRiesgo <= 500)
                      {
                        $nombreRiesgo = 'II';
                          $aceptacionRiesgo = 'No aceptable o aceptable con control específico';
                      }
                      else if($nivelRiesgo >=  40  && $nivelRiesgo <= 120)
                      {
                        $nombreRiesgo = 'III';
                          $aceptacionRiesgo = 'Aceptable';
                      }
                      else if($nivelRiesgo ==  20)
                      {
                        $nombreRiesgo = 'IV';
                          $aceptacionRiesgo = 'Aceptable';
                      }
                      else if($nivelRiesgo ==  0)
                      {
                        $nombreRiesgo = '';
                          $aceptacionRiesgo = '';                        
                    }
                    
                    $indice = array(
                          'idMatrizRiesgoDetalle' => $matriz[$reg]["idMatrizRiesgoDetalle"]);

                    $data = array(
                        'MatrizRiesgo_idMatrizRiesgo' => $matrizriesgo,
                        'Proceso_idProceso' => $matriz[$reg]['Proceso_idProceso'],
                        'rutinariaMatrizRiesgoDetalle' => $matriz[$reg]['rutinariaMatrizRiesgoDetalle'],
                        'ClasificacionRiesgo_idClasificacionRiesgo' => $matriz[$reg]['ClasificacionRiesgo_idClasificacionRiesgo'],
                        'TipoRiesgo_idTipoRiesgo' => $matriz[$reg]['TipoRiesgo_idTipoRiesgo'],
                        'TipoRiesgoDetalle_idTipoRiesgoDetalle' => $matriz[$reg]['TipoRiesgoDetalle_idTipoRiesgoDetalle'],
                        'TipoRiesgoSalud_idTipoRiesgoSalud' => $matriz[$reg]['TipoRiesgoSalud_idTipoRiesgoSalud'],
                        'vinculadosMatrizRiesgoDetalle' => $matriz[$reg]['vinculadosMatrizRiesgoDetalle'],
                        'temporalesMatrizRiesgoDetalle' => $matriz[$reg]['temporalesMatrizRiesgoDetalle'],
                        'totalExpuestosMatrizRiesgoDetalle' => ($matriz[$reg]['vinculadosMatrizRiesgoDetalle'] + $matriz[$reg]['temporalesMatrizRiesgoDetalle']),
                        'fuenteMatrizRiesgoDetalle' => $matriz[$reg]['fuenteMatrizRiesgoDetalle'],
                        // 'medioMatrizRiesgoDetalle' => $matriz[$reg]['medioMatrizRiesgoDetalle'],
                        // 'personaMatrizRiesgoDetalle' => $matriz[$reg]['personaMatrizRiesgoDetalle'],
                        'nivelDeficienciaMatrizRiesgoDetalle' => $matriz[$reg]['nivelDeficienciaMatrizRiesgoDetalle'],
                        'nivelExposicionMatrizRiesgoDetalle' => $matriz[$reg]['nivelExposicionMatrizRiesgoDetalle'],
                        'nivelProbabilidadMatrizRiesgoDetalle' => $nivelProbabilidad,
                        'nombreProbabilidadMatrizRiesgoDetalle' => $probabilidad,
                        'nivelConsecuenciaMatrizRiesgoDetalle' => $matriz[$reg]['nivelConsecuenciaMatrizRiesgoDetalle'],
                        'nivelRiesgoMatrizRiesgoDetalle' => $nivelRiesgo,
                        'nombreRiesgoMatrizRiesgoDetalle' => $nombreRiesgo,
                        'aceptacionRiesgoMatrizRiesgoDetalle' => $aceptacionRiesgo,
                        'eliminacionMatrizRiesgoDetalle' => $matriz[$reg]['eliminacionMatrizRiesgoDetalle'],
                        'sustitucionMatrizRiesgoDetalle' => $matriz[$reg]['sustitucionMatrizRiesgoDetalle'],
                        'controlMatrizRiesgoDetalle' => $matriz[$reg]['controlMatrizRiesgoDetalle'],
                        'elementoProteccionMatrizRiesgoDetalle' => $matriz[$reg]['elementoProteccionMatrizRiesgoDetalle'],
                        'observacionMatrizRiesgoDetalle' => $matriz[$reg]['observacionMatrizRiesgoDetalle'],
                        'Compania_idCompania' => \Session::get("idCompania")
                    );

                    $matrizriesgodetalle = \App\MatrizRiesgoDetalle::updateOrCreate($indice, $data);
                }
                echo json_encode(array(true, 'Importacion Exitosa, por favor verifique'));
            }


        });
        unlink ( $destinationPath.'/Plantilla Matriz Riesgo.xlsx');

    }
}

