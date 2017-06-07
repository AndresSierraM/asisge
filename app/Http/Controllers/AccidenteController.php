<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\AccidenteRequest;
use App\Http\Controllers\ReporteACPMController;

use Illuminate\Routing\Route;
use DB;
include public_path().'/ajax/consultarPermisos.php';
include public_path().'/ajax/guardarReporteAcpm.php';

// use traitSisoft;


class AccidenteController extends Controller
{
    public function _construct(){
        $this->beforeFilter('@find',['only'=>['edit','update','destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function find(Route $route){
        $this->accidente = \App\Accidente::find($route->getParameter('accidente'));
        return $this->accidente;
    }

    public function index()
    {
        $vista = basename($_SERVER["PHP_SELF"]);
        $datos = consultarPermisos($vista);

        if($datos != null)
            return view('accidentegrid', compact('datos'));
        else
            return view('accesodenegado');


    }


    // Esta funcion es para que cuando suba el archvio vaya al repositorio/temporal y guarde una copia mientras le dan guardar al registro 
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
        $terceroCoord = \App\Tercero::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('nombreCompletoTercero','idTercero');
        // $terceroEmple = \App\Tercero::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('nombreCompletoTercero','idTercero');

        $terceroEmple = DB::Select('SELECT idTercero as id, nombreCompletoTercero as nombre from ausentismo left join tercero on `Tercero_idTercero` = idTercero left join `accidente` on Ausentismo_idAusentismo = idAusentismo where ausentismo.Compania_idCompania = '.\Session::get('idCompania').' and tipoAusentismo like "%ente%" and nombreAccidente IS NULL');
        $terceroEmple = $this->convertirArray($terceroEmple);
        

        $ausentismo  = \App\Ausentismo::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('nombreAusentismo','idAusentismo');
         
        $proceso  = \App\Proceso::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('nombreProceso','idProceso');
        $idProceso  = \App\Proceso::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('idProceso');
        $nombreProceso  = \App\Proceso::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('nombreProceso');
        $idTercero = \App\Tercero::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('idTercero');
        $nombreCompletoTercero = \App\Tercero::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('nombreCompletoTercero');
        return view('accidente',compact('terceroCoord','terceroEmple','ausentismo',
            'proceso','idProceso','nombreProceso','idTercero','nombreCompletoTercero'));
    }

    function convertirArray($dato)
    {
        $nuevo = array();
        $nuevo[0] = 'Seleccione';
        for($i = 0; $i < count($dato); $i++) 
        {
          $nuevo[get_object_vars($dato[$i])["id"]] = get_object_vars($dato[$i])["nombre"] ;
        }
        return $nuevo;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(AccidenteRequest $request)
    {
        // acá me lo pase por alto, pero todos los formularios que tienen validacion con ajax deben tener esto, tanto en el store
        // como en el update
        if($request['respuesta'] != 'falso')
        {    
            \App\Accidente::create([
                'numeroAccidente' => $request['numeroAccidente'],
                'nombreAccidente' => $request['nombreAccidente'],
                'clasificacionAccidente' => $request['clasificacionAccidente'],
                'Ausentismo_idAusentismo' => (($request['Ausentismo_idAusentismo'] == '') ? null : $request['Ausentismo_idAusentismo']),
                'Tercero_idCoordinador' => $request['Tercero_idCoordinador'],
                'Tercero_idEmpleado' => $request['Tercero_idEmpleado'],
                'edadEmpleadoAccidente' => $request['edadEmpleadoAccidente'],
                'tiempoServicioAccidente' => $request['tiempoServicioAccidente'],
                'Proceso_idProceso' => $request['Proceso_idProceso'],
                'enSuLaborAccidente' => (($request['enSuLaborAccidente'] !== null) ? 1 : 0),
                'laborAccidente' => $request['laborAccidente'],
                'enLaEmpresaAccidente' => (($request['enLaEmpresaAccidente'] !== null) ? 1 : 0),
                'lugarAccidente' => $request['lugarAccidente'],
                'fechaOcurrenciaAccidente' => $request['fechaOcurrenciaAccidente'],
                'tiempoEnLaborAccidente' => $request['tiempoEnLaborAccidente'],
                'tareaDesarrolladaAccidente' => $request['tareaDesarrolladaAccidente'],
                'descripcionAccidente' => $request['descripcionAccidente'],
                'observacionTrabajadorAccidente' => $request['observacionTrabajadorAccidente'],
                'observacionEmpresaAccidente' => $request['observacionEmpresaAccidente'],
                'agenteYMecanismoAccidente' => $request['agenteYMecanismoAccidente'],
                'naturalezaLesionAccidente' => $request['naturalezaLesionAccidente'],
                'parteCuerpoAfectadaAccidente' => $request['parteCuerpoAfectadaAccidente'],
                'tipoAccidente' => $request['tipoAccidente'],
                'observacionAccidente'  => $request['observacionAccidente'],
                'Compania_idCompania' => \Session::get('idCompania')
                ]);


            $accidente = \App\Accidente::All()->last();


            // Guardado del dropzone
                $arrayImage = $request['archivoAccidenteArray'];
                $arrayImage = substr($arrayImage, 0, strlen($arrayImage)-1);
                $arrayImage = explode(",", $arrayImage);
                $ruta = '';
                for ($i=0; $i < count($arrayImage) ; $i++) 
                { 
                    if ($arrayImage[$i] != '' || $arrayImage[$i] != 0) 
                    {
                        $origen = public_path() . '/imagenes/repositorio/temporal/'.$arrayImage[$i];
                        $destinationPath = public_path() . '/imagenes/accidente/'.$arrayImage[$i];
                        $ruta = '/accidente/'.$arrayImage[$i];
                       
                        if (file_exists($origen))
                        {
                            copy($origen, $destinationPath);
                            unlink($origen);
                        }   
                        else
                        {
                            echo "No existe el archivo";
                        }
                        \App\AccidenteArchivo::create([
                        'Accidente_idAccidente' => $accidente->idAccidente,
                        'rutaAccidenteArchivo' => $ruta
                       ]);
                    }

                }




            // armamos una ruta para el archivo de imagen y volvemos a actualizar el registro
            // esto es porque la creamos con el ID del accidente y debiamos grabar primero para obtenerlo
            $accidente->firmaCoordinadorAccidente = 'accidente/firmaaccidente_'.$accidente->idAccidente.'.png';

            $accidente->save();

            //----------------------------
            // Guardamos la imagen de la firma como un archivo en disco
            if (isset($request['firmabase64']) and $request['firmabase64'] != '') 
            {
                $data = $request['firmabase64'];

                list($type, $data) = explode(';', $data);
                list(, $data)      = explode(',', $data);
                $data = base64_decode($data);

                file_put_contents('imagenes/accidente/firmaaccidente_'.$accidente->idAccidente.'.png', $data);
            }
            //----------------------------

            //---------------------------------
            // guardamos las tablas de detalle
            //---------------------------------
            $this->grabarDetalle($accidente->idAccidente, $request);
        }
        

        return redirect('/accidente');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $accidente = \App\Accidente::find($id);
        $terceroCoord = \App\Tercero::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('nombreCompletoTercero','idTercero');
        $terceroEmple = \App\Tercero::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('nombreCompletoTercero','idTercero');
        $ausentismo  = \App\Ausentismo::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('nombreAusentismo','idAusentismo');
        $proceso  = \App\Proceso::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('nombreProceso','idProceso');
        $idProceso  = \App\Proceso::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('idProceso');
        $nombreProceso  = \App\Proceso::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('nombreProceso');
        $idTercero = \App\Tercero::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('idTercero');
        $nombreCompletoTercero = \App\Tercero::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('nombreCompletoTercero');
        

        
        return view('accidente',compact('terceroCoord','terceroEmple','ausentismo',
            'proceso','idProceso','nombreProceso','idTercero','nombreCompletoTercero'),['accidente'=>$accidente]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(AccidenteRequest $request, $id)
    {
        if ($request['respuesta'] != 'falso') 
        {
            $accidente = \App\Accidente::find($id);
            $accidente->fill($request->all());
            $accidente->enSuLaborAccidente = (($request['enSuLaborAccidente'] !== null) ? 1 : 0);
            $accidente->enLaEmpresaAccidente = (($request['enLaEmpresaAccidente'] !== null) ? 1 : 0);
            $accidente->Ausentismo_idAusentismo = (($request['Ausentismo_idAusentismo'] == '') ? null : $request['Ausentismo_idAusentismo']);
            $accidente->firmaCoordinadorAccidente = 'accidente/firmaaccidente_'.$id.'.png'; 

            $accidente->save();



             //Para sobreescribir  el archivo 
            // HAGO UN INSERT A LOS NUEVOS ARCHIVOS SUBIDOS EN EL DROPZONE
            if ($request['archivoAccidenteArray'] != '') 
            {
                $arrayImage = $request['archivoAccidenteArray'];
                $arrayImage = substr($arrayImage, 0, strlen($arrayImage)-1);
                $arrayImage = explode(",", $arrayImage);
                $ruta = '';

                for($i = 0; $i < count($arrayImage); $i++)
                {
                    if ($arrayImage[$i] != '' || $arrayImage[$i] != 0) 
                    {
                        $origen = public_path() . '/imagenes/repositorio/temporal/'.$arrayImage[$i];
                        $destinationPath = public_path() . '/imagenes/accidente/'.$arrayImage[$i];
                        
                        if (file_exists($origen))
                        {
                            copy($origen, $destinationPath);
                            unlink($origen);
                            $ruta = '/accidente/'.$arrayImage[$i];
 
                            DB::table('accidentearchivo')->insert(['idAccidenteArchivo' => '0', 'Accidente_idAccidente' =>$id,'rutaAccidenteArchivo' => $ruta]);
                        }   
                        else
                        {
                            echo "No existe el archivo";
                        }
                    }
                }
            }

            
            // Para eliminar los archivos que se muestran en el preview del archivo cargado.Se hace una funcion en el JS para eliminar el div 
            // ELIMINO LOS ARCHIVOS
            $idsEliminar = $request['eliminarArchivo'];
            $idsEliminar = substr($idsEliminar, 0, strlen($idsEliminar)-1);
            if($idsEliminar != '')
            {
                $idsEliminar = explode(',',$idsEliminar);
                \App\AccidenteArchivo::whereIn('idAccidenteArchivo',$idsEliminar)->delete();
            }



            //----------------------------
            // Guardamos la imagen de la firma como un archivo en disco
            $data = $request['firmabase64'];
            if($data != '') 
            {
                list($type, $data) = explode(';', $data);
                list(, $data)      = explode(',', $data);
                $data = base64_decode($data);

                file_put_contents('imagenes/accidente/firmaaccidente_'.$id.'.png', $data);
            }
            //----------------------------


            //---------------------------------
            // guardamos las tablas de detalle
            //---------------------------------
            $this->grabarDetalle($id, $request);
        }
        // encierra en el if todo el codigo que guarda en la bd

       

       return redirect('/accidente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        \App\Accidente::destroy($id);
        return redirect('/accidente');
    }

    protected function grabarDetalle($id, $request)
    {
        // en el formulario hay un campo oculto en el que almacenamos los id que se eliminan separados por coma
        // en este proceso lo convertimos en array y eliminamos dichos id de la tabla de detalle
        $idsEliminar = explode(',', $request['eliminarRecomendacion']);
        \App\AccidenteRecomendacion::whereIn('idAccidenteRecomendacion',$idsEliminar)->delete();

        $contadorDetalle = count($request['idAccidenteRecomendacion']);
        $causas = '';
        
        for($i = 0; $i < $contadorDetalle; $i++)
        {

            $indice = array(
                'idAccidenteRecomendacion' => $request['idAccidenteRecomendacion'][$i]);

            $data = array(
                'Accidente_idAccidente' => $id, 
                'controlAccidenteRecomendacion' => $request['controlAccidenteRecomendacion'][$i], 
                'fuenteAccidenteRecomendacion' => $request['fuenteAccidenteRecomendacion'][$i], 
                'medioAccidenteRecomendacion' => $request['medioAccidenteRecomendacion'][$i], 
                'personaAccidenteRecomendacion' => $request['personaAccidenteRecomendacion'][$i], 
                'fechaVerificacionAccidenteRecomendacion' => $request['fechaVerificacionAccidenteRecomendacion'][$i], 
                'medidaEfectivaAccidenteRecomendacion' => $request['medidaEfectivaAccidenteRecomendacion'][$i], 
                'Proceso_idResponsable' => $request['Proceso_idResponsable'][$i]);

            $respuesta = \App\AccidenteRecomendacion::updateOrCreate($indice, $data);

            $causas .= $request['controlAccidenteRecomendacion'][$i].', ';
        }

        $causas = substr($causas, 0, strlen($causas)-2);

        
        //************************************************
        //
        //  R E P O R T E   A C C I O N E S   
        //  C O R R E C T I V A S,  P R E V E N T I V A S 
        //  Y   D E   M E J O R A 
        //
        //************************************************
        // todos los accidentes o incidentes los  insertamos un registro en el ACPM (Accion Correctiva)

        //COnsultamos el nombre del tercero empleado
        $nombreTercero = \App\Tercero::find($request['Tercero_idEmpleado']);

        guardarReporteACPM(
                $fechaAccion = date("Y-m-d"), 
                $idModulo = 3, 
                $tipoAccion = 'Correctiva', 
                $descripcionAccion = 'Para el '.$request['clasificacionAccidente'].' de '.$nombreTercero->nombreCompletoTercero.', se recomienda implementar controles por las siguientes causas: '.$causas
                );   

                
        // en el formulario hay un campo oculto en el que almacenamos los id que se eliminan separados por coma
        // en este proceso lo convertimos en array y eliminamos dichos id de la tabla de detalle
        $idsEliminar = explode(',', $request['eliminarEquipo']);
        \App\AccidenteEquipo::whereIn('idAccidenteEquipo',$idsEliminar)->delete();
        
        $contadorDetalle = count($request['idAccidenteEquipo']);
        
        for($i = 0; $i < $contadorDetalle; $i++)
        {
            $indice = array(
                'idAccidenteEquipo' => $request['idAccidenteEquipo'][$i]);

            $data = array(
                'Accidente_idAccidente' => $id, 
                'Tercero_idInvestigador' => $request['Tercero_idInvestigador'][$i]);

            $respuesta = \App\AccidenteEquipo::updateOrCreate($indice, $data);

        }
    }

}
