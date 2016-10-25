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
            ->select(DB::raw('nombrePlanCapacitacionTema, Tercero_idCapacitador, t.nombreCompletoTercero,fechaPlanCapacitacionTema, horaPlanCapacitacionTema,dictadaPlanCapacitacionTema,cumpleObjetivoPlanCapacitacionTema'))
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
                'SELECT idPlanCapacitacionTema as PlanCapacitacionTema_idPlanCapacitacionTema, 0 as idActaCapacitacionTema, nombrePlanCapacitacionTema, PCT.Tercero_idCapacitador, fechaPlanCapacitacionTema, horaPlanCapacitacionTema, 1 as dictadaPlanCapacitacionTema,  0 as cumpleObjetivoPlanCapacitacionTema
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
                 'dictadaActaCapacitacionTema' => $request['dictadaActaCapacitacionTema'][$i],
                 'cumpleObjetivoActaCapacitacionTema' => $request['cumpleObjetivoActaCapacitacionTema'][$i]);

            $respuesta = \App\ActaCapacitacionTema::updateOrCreate($indice, $data);
        }
    }
}
