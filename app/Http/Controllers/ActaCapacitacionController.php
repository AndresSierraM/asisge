<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\ActaCapacitacionRequest;
use App\Http\Controllers\Controller;
use DB;
include public_path().'/ajax/consultarPermisos.php';

class ActaCapacitacionController extends Controller
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
            return view('actacapacitaciongrid', compact('datos'));
        else
            return view('accesodenegado');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */


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

    public function create()
    {

        $planCapacitacion = DB::table('plancapacitacion as PC')
            ->leftJoin('plancapacitaciontema as PCT', 'PC.idPlanCapacitacion', '=', 'PCT.PlanCapacitacion_idPlanCapacitacion')
            ->where('dictadaPlanCapacitacionTema','=',0)
            ->where('Compania_idCompania','=',\Session::get("idCompania"))
            ->groupBy('idPlanCapacitacion')
            ->lists('nombrePlanCapacitacion', 'idPlanCapacitacion');

//            print_r($planCapacitacion);
        $idTercero = \App\Tercero::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('idTercero');
        $nombreCompletoTercero = \App\Tercero::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('nombreCompletoTercero');
        return view('actacapacitacion',compact('planCapacitacion','idTercero','nombreCompletoTercero'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(ActaCapacitacionRequest $request)
    {
        if($request['respuesta'] != 'falso')
        {
            \App\ActaCapacitacion::create([
                'numeroActaCapacitacion' => $request['numeroActaCapacitacion'],
                'fechaElaboracionActaCapacitacion' => $request['fechaElaboracionActaCapacitacion'],
                'PlanCapacitacion_idPlanCapacitacion' => $request['PlanCapacitacion_idPlanCapacitacion'],
                'observacionesActaCapacitacion' => $request['observacionesActaCapacitacion'],
                'Compania_idCompania' => \Session::get('idCompania')
                ]);

            $actaCapacitacion = \App\ActaCapacitacion::All()->last();
            
           

            // Guardado del dropzone
                $arrayImage = $request['archivoActaCapacitacionArray'];
                $arrayImage = substr($arrayImage, 0, strlen($arrayImage)-1);
                $arrayImage = explode(",", $arrayImage);
                $ruta = '';
                for ($i=0; $i < count($arrayImage) ; $i++) 
                { 
                    if ($arrayImage[$i] != '' || $arrayImage[$i] != 0) 
                    {
                        $origen = public_path() . '/imagenes/repositorio/temporal/'.$arrayImage[$i];
                        $destinationPath = public_path() . '/imagenes/actacapacitacion/'.$arrayImage[$i];
                        $ruta = '/actacapacitacion/'.$arrayImage[$i];
                       
                        if (file_exists($origen))
                        {
                            copy($origen, $destinationPath);
                            unlink($origen);
                        }   
                        else
                        {
                            echo "No existe el archivo";
                        }
                        \App\ActaCapacitacionArchivo::create([
                        'ActaCapacitacion_idActaCapacitacion' => $actaCapacitacion->idActaCapacitacion,
                        'rutaActaCapacitacionArchivo' => $ruta
                       ]);
                    }

                }


            //---------------------------------
            // guardamos las tablas de detalle
            //---------------------------------
            $this->grabarDetalle($actaCapacitacion->idActaCapacitacion, $request);

            return redirect('/actacapacitacion');
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
            $idPlanCapacitacion = \App\ActaCapacitacion::find($id);

            $actaCapacitacion = DB::table('actacapacitacion as ac')
            ->leftJoin('plancapacitacion as pc', 'ac.PlanCapacitacion_idPlanCapacitacion', '=', 'pc.idPlanCapacitacion')
            ->leftJoin('tercero as t', 'pc.Tercero_idResponsable', '=', 't.idTercero')
            ->select(DB::raw('numeroActaCapacitacion, fechaElaboracionActaCapacitacion, PlanCapacitacion_idPlanCapacitacion, idPlanCapacitacion, tipoPlanCapacitacion, nombrePlanCapacitacion, objetivoPlanCapacitacion, Tercero_idResponsable, t.nombreCompletoTercero, personalInvolucradoPlanCapacitacion, fechaInicioPlanCapacitacion, fechaFinPlanCapacitacion, metodoEficaciaPlanCapacitacion'))
            ->where('idActaCapacitacion','=',$id)
            ->get();

            $planCapacitacionTema = DB::table('plancapacitaciontema as pct')
            ->leftJoin('tercero as t', 'pct.Tercero_idCapacitador', '=', 't.idTercero')
            ->select(DB::raw('nombrePlanCapacitacionTema, Tercero_idCapacitador, t.nombreCompletoTercero,fechaPlanCapacitacionTema, horaPlanCapacitacionTema,duracionActaCapacitacionTema,dictadaPlanCapacitacionTema,cumpleObjetivoPlanCapacitacionTema'))
            ->orderby('idPlanCapacitacionTema','ASC')
            ->where('PlanCapacitacion_idPlanCapacitacion','=',$idPlanCapacitacion->PlanCapacitacion_idPlanCapacitacion)
            ->get();

            $actaCapacitacionAsistente = DB::table('actacapacitacionasistente as aca')
            ->leftJoin('tercero as t', 'aca.Tercero_idAsistente', '=', 't.idTercero')
            ->leftJoin('cargo as c', 't.Cargo_idCargo', '=', 'c.idCargo')
            ->select(DB::raw('ActaCapacitacion_idActaCapacitacion, Tercero_idAsistente, t.nombreCompletoTercero, t.Cargo_idCargo, c.nombreCargo'))
            ->orderby('idActaCapacitacionAsistente','ASC')
            ->where('ActaCapacitacion_idActaCapacitacion','=',$id)
            ->get();

            return view('formatos.actacapacitacionimpresion',compact('actaCapacitacion','planCapacitacionTema','actaCapacitacionAsistente'));
        }

        $planCapacitacion = \App\PlanCapacitacion::find($request['idPlanCapacitacion']);
        $tercero = \App\Tercero::find($planCapacitacion->Tercero_idResponsable);
        if($request->ajax())
        {

            $plan = DB::select(
                'SELECT idPlanCapacitacionTema as PlanCapacitacionTema_idPlanCapacitacionTema, 0 as idActaCapacitacionTema, nombrePlanCapacitacionTema, PCT.Tercero_idCapacitador, fechaPlanCapacitacionTema, horaPlanCapacitacionTema,duracionActaCapacitacionTema, 1 as dictadaPlanCapacitacionTema,  0 as cumpleObjetivoPlanCapacitacionTema
                FROM plancapacitaciontema PCT
                LEFT JOIN actacapacitaciontema ACT
                    ON PCT.idPlanCapacitacionTema = ACT.PlanCapacitacionTema_idPlanCapacitacionTema
                LEFT JOIN plancapacitacion PC 
                    ON PC.idPlanCapacitacion = PCT.PlanCapacitacion_idPlanCapacitacion
                WHERE   PlanCapacitacion_idPlanCapacitacion = '.$request['idPlanCapacitacion'].' and Compania_idCompania = '.\Session::get("idCompania").' and (cumpleObjetivoActaCapacitacionTema = 0 or cumpleObjetivoActaCapacitacionTema IS NULL)');


// $plan = DB::select(
//                 'SELECT idPlanCapacitacionTema as PlanCapacitacionTema_idPlanCapacitacionTema, 0 as idActaCapacitacionTema, nombrePlanCapacitacionTema, PCT.Tercero_idCapacitador, fechaPlanCapacitacionTema, horaPlanCapacitacionTema, 1 as dictadaPlanCapacitacionTema,  0 as cumpleObjetivoPlanCapacitacionTema
//                 FROM plancapacitaciontema PCT
//                 LEFT JOIN actacapacitaciontema ACT
//                     ON PCT.idPlanCapacitacionTema = ACT.PlanCapacitacionTema_idPlanCapacitacionTema
//                 WHERE   PlanCapacitacion_idPlanCapacitacion = '.$request['idPlanCapacitacion'].' and 
//                         ACT.PlanCapacitacionTema_idPlanCapacitacionTema IS NULL OR 
//                         (dictadaActaCapacitacionTema = 0 OR cumpleObjetivoActaCapacitacionTema = 0)');


            return response()->json([
                $planCapacitacion,
                $plan,
                $tercero
            ]);
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
        $planCapacitacion = DB::table('plancapacitacion as PC')
            ->leftJoin('plancapacitaciontema as PCT', 'PC.idPlanCapacitacion', '=', 'PCT.PlanCapacitacion_idPlanCapacitacion')
            //->where('dictadaPlanCapacitacionTema','=',0)
            ->where('Compania_idCompania','=',\Session::get("idCompania"))
            ->groupBy('idPlanCapacitacion')
            ->lists('nombrePlanCapacitacion', 'idPlanCapacitacion');
            
        $idTercero = \App\Tercero::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('idTercero');
        $nombreCompletoTercero = \App\Tercero::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('nombreCompletoTercero');

        $actaCapacitacion = \App\ActaCapacitacion::find($id);
        return view('actacapacitacion',compact('planCapacitacion','idTercero','nombreCompletoTercero'),['actaCapacitacion'=>$actaCapacitacion]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(ActaCapacitacionRequest $request, $id)
    {
        if($request['respuesta'] != 'falso')
        {
            $actaCapacitacion = \App\ActaCapacitacion::find($id);
            $actaCapacitacion->fill($request->all());

            $actaCapacitacion->save();

            //Para sobreescribir  el archivo 
            // HAGO UN INSERT A LOS NUEVOS ARCHIVOS SUBIDOS EN EL DROPZONE
            if ($request['archivoActaCapacitacionArray'] != '') 
            {
                $arrayImage = $request['archivoActaCapacitacionArray'];
                $arrayImage = substr($arrayImage, 0, strlen($arrayImage)-1);
                $arrayImage = explode(",", $arrayImage);
                $ruta = '';

                for($i = 0; $i < count($arrayImage); $i++)
                {
                    if ($arrayImage[$i] != '' || $arrayImage[$i] != 0) 
                    {
                        $origen = public_path() . '/imagenes/repositorio/temporal/'.$arrayImage[$i];
                        $destinationPath = public_path() . '/imagenes/actacapacitacion/'.$arrayImage[$i];
                        
                        if (file_exists($origen))
                        {
                            copy($origen, $destinationPath);
                            unlink($origen);
                            $ruta = '/actacapacitacion/'.$arrayImage[$i];

                            DB::table('actacapacitacionarchivo')->insert(['idActaCapacitacionArchivo' => '0', 'ActaCapacitacion_idActaCapacitacion' =>$id,'rutaActaCapacitacionArchivo' => $ruta]);
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
                \App\ActaCapacitacionArchivo::whereIn('idActaCapacitacionArchivo',$idsEliminar)->delete();
            }

            // 

            \App\ActaCapacitacionAsistente::where('ActaCapacitacion_idActaCapacitacion',$id)->delete();

            //---------------------------------
            // guardamos las tablas de detalle
            //---------------------------------
            $this->grabarDetalle($id, $request);

            return redirect('/actacapacitacion');
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
        \App\ActaCapacitacion::destroy($id);
        return redirect('/actacapacitacion');
    }

    protected function grabarDetalle($id, $request)
    {



        // en el formulario hay un campo oculto en el que almacenamos los id que se eliminan separados por coma
        // en este proceso lo convertimos en array y eliminamos dichos id de la tabla de detalle
        $idsEliminar = explode(',', $request['eliminarAsistente']);
        \App\ActaCapacitacionAsistente::whereIn('idActaCapacitacionAsistente',$idsEliminar)->delete();

        $contadorDetalle = count($request['Tercero_idAsistente']);
            
        for($i = 0; $i < $contadorDetalle; $i++)
        {
            // armamos una ruta para el archivo de imagen y volvemos a actualizar el registro
            // esto es porque la creamos con el ID del acta y el id del asistente y debiamos grabar primero para obtenerlo
            $ruta = 'actacapacitacion/firmaactacapacitacion_'.$id.'_'.$request['Tercero_idAsistente'][$i].'.png';


            $indice = array(
             'idActaCapacitacionAsistente' => $request['idActaCapacitacionAsistente'][$i]);

             $data = array(
             'Tercero_idAsistente' => $request['Tercero_idAsistente'][$i],
             'ActaCapacitacion_idActaCapacitacion' => $id,
             'firmaActaCapacitacionAsistente' => $ruta);

            $preguntas = \App\ActaCapacitacionAsistente::updateOrCreate($indice, $data);
            
            //----------------------------
            // Guardamos la imagen de la firma como un archivo en disco
            $data = $request['firmabase64'][$i];
            if($data != '')
            {
                list($type, $data) = explode(';', $data);
                list(, $data)      = explode(',', $data);
                $data = base64_decode($data);

                file_put_contents('imagenes/'.$ruta, $data);
            }
            //----------------------------
        }

        
        // en el formulario hay un campo oculto en el que almacenamos los id que se eliminan separados por coma
        // en este proceso lo convertimos en array y eliminamos dichos id de la tabla de detalle
        $idsEliminar = explode(',', $request['eliminarTema']);
        \App\ActaCapacitacionTema::whereIn('idActaCapacitacionTema',$idsEliminar)->delete();

        for($i = 0; $i < count($request['Tercero_idCapacitador']); $i++)
        {
            $indice = array(
             'idActaCapacitacionTema' => $request['idActaCapacitacionTema'][$i]);

             $data = array(
                'ActaCapacitacion_idActaCapacitacion' => $id,
                'PlanCapacitacionTema_idPlanCapacitacionTema' => $request['PlanCapacitacionTema_idPlanCapacitacionTema'][$i],
                'Tercero_idCapacitador' => $request['Tercero_idCapacitador'][$i],
                 'fechaActaCapacitacionTema' => $request['fechaActaCapacitacionTema'][$i],
                 'horaActaCapacitacionTema' => $request['horaActaCapacitacionTema'][$i],
                 'duracionActaCapacitacionTema' => $request['duracionActaCapacitacionTema'][$i],
                 'dictadaActaCapacitacionTema' => $request['dictadaActaCapacitacionTema'][$i],
                 'cumpleObjetivoActaCapacitacionTema' => $request['cumpleObjetivoActaCapacitacionTema'][$i]);

            $respuesta = \App\ActaCapacitacionTema::updateOrCreate($indice, $data);
        }
    }
}
