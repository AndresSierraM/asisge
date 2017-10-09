<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\MatrizLegalRequest;
use App\Http\Controllers\Controller;
use DB;
use Input;
use File;
use Validator;
use Response;
use Excel; 
include public_path().'/ajax/consultarPermisos.php';
include public_path().'/ajax/guardarReporteAcpm.php';

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

        if($datos != null)
            return view('matrizlegalgrid', compact('datos'));
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
                    // 'medioMatrizLegalDetalle' => $request['medioMatrizLegalDetalle'][$i],
                    // 'personaMatrizLegalDetalle' => $request['personaMatrizLegalDetalle'][$i],
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

                        guardarReporteACPM(
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
            ->select(DB::raw('mld.idMatrizLegalDetalle, mld.MatrizLegal_idMatrizLegal, mld.TipoNormaLegal_idTipoNormaLegal, tpl.nombreTipoNormaLegal, mld.articuloAplicableMatrizLegalDetalle, mld.ExpideNormaLegal_idExpideNormaLegal, enl.nombreExpideNormaLegal, mld.exigenciaMatrizLegalDetalle, mld.fuenteMatrizLegalDetalle, mld.herramientaSeguimientoMatrizLegalDetalle, mld.cumpleMatrizLegalDetalle, mld.fechaVerificacionMatrizLegalDetalle, mld.accionEvidenciaMatrizLegalDetalle, mld.controlAImplementarMatrizLegalDetalle'))
            ->orderBy('idMatrizLegalDetalle', 'ASC')
            ->where('MatrizLegal_idMatrizLegal','=',$id)
            ->get();
            // Se quita de la consulta estos dos campos  , mld.medioMatrizLegalDetalle, mld.personaMatrizLegalDetalle,
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


            // cada que se actualice la matriz, guardamos una nueva fecha de actualizacion
            \App\MatrizLegalActualizacion::create([
                'MatrizLegal_idMatrizLegal' => $id,
                'fechaMatrizLegalActualizacion' => date("Y-m-d")
                ]);

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
                    // 'medioMatrizLegalDetalle' => $request['medioMatrizLegalDetalle'][$i],
                    // 'personaMatrizLegalDetalle' => $request['personaMatrizLegalDetalle'][$i],
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

                        guardarReporteACPM(
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


    function quitarCaracterEspeciales($string) 
    {
        // recibe el texto completo en str
         // Se valida el string que esta recibiendo para que elimine el ENTER, Comillas sencillas y dobles y lo deje vacio en php
        $str  = preg_replace("[\n|\r|\n\r|\'|\"]", ' ', $string);
        // 1. lo convierte todo a minúsculas y lo guarda en lower
        $lower = strtolower($str);
        // Se convierte a array  e igualando a la variable todo lo que está convertido en miniscula (para devolverlo con posicion y letra)
        $lower = str_split($lower);

        // 2. lo convierte todo a mayúsculas y lo guarda en upper
        $upper = strtoupper($str);
        
        // Se convierte a array  e igualando a la variable todo lo que está convertido en Mayuscula- (para devolverlo con posicion y letra)
        $upper = str_split($upper);
        // se iguala el string e iguala la variable a array para que pueda tomar posicion 0
        $str = str_split($str);

        $res = '';
        // 3. con el for recorre el texto original letra por letra
        for($i=0; $i<count($lower); $i++) 
        {  
            // si esa letra en minúscula no es igual a la misma letra en mayúscula lower[i] != upper[i]
            // OR
            // 5. SI es un espacio en blanco o un vacio
            // OR
            // 6. si es un numero de 0 a 9
            // 7. Si es una de las anteriores gurda ese carácter en la variable RES
            // por ultimo devuelve RES
            if($lower[$i] != $upper[$i] || trim($lower[$i]) === '' || (trim($lower[$i]) >= 0 && trim($lower[$i]) <= 9))
                $res .= $str[$i];
        }
        return $res;
    } 

    public function importarMatrizLegal()   
    {
      $destinationPath = public_path() . '/imagenes/repositorio/temporal'; 
        Excel::load($destinationPath.'/Plantilla Matriz Legal.xlsx', function($reader) {

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
            // Origen
            //*****************************
            // si la celda esta en blanco, reportamos error de obligatoriedad
            $origenMatriz = $datos->getCellByColumnAndRow(2, 5)->getValue();
            if($origenMatriz == '' or 
                    $origenMatriz == null)
            {
                $errores[$posErr]["linea"] = 5;
                // $errores[$posErr]["nombre"] = $matriz[ $posMatriz]["nombreCompletoTercero"];
                $errores[$posErr]["mensaje"] = 'Debe diligenciar el origen de la matriz';
                
                $posErr++;
            }

            //*****************************
            // Frecuencia Medicion
            //*****************************
            // si la celda esta en blanco, reportamos error de obligatoriedad
            $frecuenciaMedicion = $datos->getCellByColumnAndRow(3, 5)->getValue();
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
                    $datos->getCellByColumnAndRow(0, $fila)->getValue() != NULL)    {
                

                // para cada registro de matriz recorremos las columnas desde la 0 hasta la 11
                $matriz[$posMatriz]["idMatrizLegalDetalle"] = 0;
                $matriz[$posMatriz]["Compania_idCompania"] = 0;
                for ($columna = 0; $columna <= 11; $columna++) 
                {
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
                // Se agrega la funcion para que limpie campo a campo (celda a celda)
                    $matriz[$posMatriz][$campo] = $this->quitarCaracterEspeciales($matriz[$posMatriz][$campo]);
                }

                
                
                //*****************************
                // Tipo de norma
                //*****************************
                // si la celda esta en blanco, reportamos error de obligatoriedad
                if($matriz[ $posMatriz]["TipoNormaLegal_idTipoNormaLegal"] == '' or 
                    $matriz[ $posMatriz]["TipoNormaLegal_idTipoNormaLegal"] == null)
                {
                    $errores[$posErr]["linea"] = $fila;
                    // $errores[$posErr]["nombre"] = $matriz[ $posMatriz]["nombreCompletoTercero"];
                    $errores[$posErr]["mensaje"] = 'Debe diligenciar el tipo de norma';
                    
                    $posErr++;
                }
                else
                {
                    $consulta = \App\TipoNormaLegal::where('codigoTipoNormaLegal','=', $matriz[ $posMatriz]["TipoNormaLegal_idTipoNormaLegal"])->lists('idTipoNormaLegal');

                    // si se encuentra el id lo guardamos en el array
                    if(isset($consulta[0]))
                        $matriz[$posMatriz]["TipoNormaLegal_idTipoNormaLegal"] = $consulta[0];
                    else
                    {
                        $errores[$posErr]["linea"] = $fila;
                        // $errores[$posErr]["nombre"] = $matriz[ $posMatriz]["nombreCompletoTercero"];
                        $errores[$posErr]["mensaje"] = 'Tipo Norma Legal '. $matriz[ $posMatriz]["TipoNormaLegal_idTipoNormaLegal"]. ' no existe';
                        
                        $posErr++;
                    }
                }
   

                //*****************************
                // Expedida por
                //*****************************
                // si la celda esta en blanco, reportamos error de obligatoriedad
                if($matriz[ $posMatriz]["ExpideNormaLegal_idExpideNormaLegal"] == '' or 
                    $matriz[ $posMatriz]["ExpideNormaLegal_idExpideNormaLegal"] == null)
                {
                    $errores[$posErr]["linea"] = $fila;
                    // $errores[$posErr]["nombre"] = $matriz[ $posMatriz]["nombreCompletoTercero"];
                    $errores[$posErr]["mensaje"] = 'Debe diligenciar expedido por';
                    
                    $posErr++;
                }
                else
                {
                    $consulta = \App\ExpideNormaLegal::where('codigoExpideNormaLegal','=', $matriz[ $posMatriz]["ExpideNormaLegal_idExpideNormaLegal"])->lists('idExpideNormaLegal');

                    // si se encuentra el id lo guardamos en el array
                    if(isset($consulta[0]))
                        $matriz[$posMatriz]["ExpideNormaLegal_idExpideNormaLegal"] = $consulta[0];
                    else
                    {
                        $errores[$posErr]["linea"] = $fila;
                        // $errores[$posErr]["nombre"] = $matriz[ $posMatriz]["nombreCompletoTercero"];
                        $errores[$posErr]["mensaje"] = 'Expide Norma Legal '. $matriz[ $posMatriz]["ExpideNormaLegal_idExpideNormaLegal"]. ' no existe';
                        
                        $posErr++;
                    }
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
                        'idMatrizLegal' => 0);

              $data = array(
                  'fechaElaboracionMatrizLegal' => $fechaMatriz,
                  'nombreMatrizLegal' => $nombreMatriz,
                  'origenMatrizLegal' => $origenMatriz,
                  'Users_id' => \Session::get("idUsuario"),
                  'FrecuenciaMedicion_idFrecuenciaMedicion' => $frecuenciaMedicion,
                  'Compania_idCompania' => \Session::get("idCompania")
              );

              $matrizlegal = \App\MatrizLegal::updateOrCreate($indice, $data);

              // Consultamos el ultimo id insertado en la matriz legal
              $ultmatrizLegal = \App\MatrizLegal::All()->last();              
              $matrizlegal = $ultmatrizLegal->idMatrizLegal;
                // recorremos el array recibido para insertar o actualizar cada registro
                for($reg = 0; $reg < count($matriz); $reg++)
                {
                    
                    $indice = array(
                          'idMatrizLegalDetalle' => $matriz[$reg]["idMatrizLegalDetalle"]);

                    $data = array(
                        'MatrizLegal_idMatrizLegal' => $matrizlegal,
                        'TipoNormaLegal_idTipoNormaLegal' => $matriz[$reg]['TipoNormaLegal_idTipoNormaLegal'],
                        'articuloAplicableMatrizLegalDetalle' => $matriz[$reg]['articuloAplicableMatrizLegalDetalle'],
                        'ExpideNormaLegal_idExpideNormaLegal' => $matriz[$reg]['ExpideNormaLegal_idExpideNormaLegal'],
                        'exigenciaMatrizLegalDetalle' => $matriz[$reg]['exigenciaMatrizLegalDetalle'],
                        'fuenteMatrizLegalDetalle' => $matriz[$reg]['fuenteMatrizLegalDetalle'],
                        // 'medioMatrizLegalDetalle' => $matriz[$reg]['medioMatrizLegalDetalle'],
                        // 'personaMatrizLegalDetalle' => $matriz[$reg]['personaMatrizLegalDetalle'],
                        'herramientaSeguimientoMatrizLegalDetalle' => $matriz[$reg]['herramientaSeguimientoMatrizLegalDetalle'],
                        'cumpleMatrizLegalDetalle' => $matriz[$reg]['cumpleMatrizLegalDetalle'],
                        'fechaVerificacionMatrizLegalDetalle' => $matriz[$reg]['fechaVerificacionMatrizLegalDetalle'],
                        'accionEvidenciaMatrizLegalDetalle' => $matriz[$reg]['accionEvidenciaMatrizLegalDetalle'],
                        'controlAImplementarMatrizLegalDetalle' => $matriz[$reg]['controlAImplementarMatrizLegalDetalle'],
                        'Compania_idCompania' => \Session::get("idCompania")
                    );

                    $matrizlegaldetalle = \App\MatrizLegalDetalle::updateOrCreate($indice, $data);
                }
                echo json_encode(array(true, 'Importacion Exitosa, por favor verifique'));
            }


        });
        unlink ($destinationPath.'/Plantilla Matriz Legal.xlsx');

    }
}
