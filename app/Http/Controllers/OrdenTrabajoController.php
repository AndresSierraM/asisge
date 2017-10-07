<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\OrdenTrabajoRequest;

//use Intervention\Image\ImageManagerStatic as Image;
use Input;
use File;
// include composer autoload
require '../vendor/autoload.php';


use Illuminate\Routing\Route;
use DB;
include public_path().'/ajax/consultarPermisos.php';
use Carbon;

class OrdenTrabajoController extends Controller
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
        $this->ordentrabajo = \App\OrdenTrabajo::find($route->getParameter('ordentrabajo'));
        return $this->ordentrabajo;
    }

    public function index()
    {
        $vista = basename($_SERVER["PHP_SELF"]);
        $datos = consultarPermisos($vista);

        if($datos != null)
            return view('ordentrabajogrid', compact('datos'));
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
        // $ordenproduccion = \App\OrdenProduccion::where('Compania_idCompania','=', \Session::get('idCompania'))
        //                     ->where('estadoOrdenProduccion','!=','Cerrada')
        //                     ->lists(DB::raw('concat(numeroOrdenProduccion, fechaElaboracionOrdenProduccion) as numeroOrdenProduccion, idOrdenProduccion'));
        // $ordenproduccion = DB::table('ordenproduccion')
        // ->select(DB::raw('idOrdenProduccion, concat(numeroOrdenProduccion, fechaElaboracionOrdenProduccion) as numeroOrdenProduccion'))
        // ->where('Compania_idCompania','=', \Session::get('idCompania'))
        // ->where('estadoOrdenProduccion','!=','Cerrada')
        // ->orderby('numeroOrdenProduccion')
        // ->get();

        $ordenproduccion = \App\OrdenProduccion::selectRaw('idOrdenProduccion, concat(numeroOrdenProduccion, fechaElaboracionOrdenProduccion) as numeroOrdenProduccion')
        ->where('Compania_idCompania','=', \Session::get('idCompania'))
        ->where('estadoOrdenProduccion','!=','Cerrada')
        ->orderby('numeroOrdenProduccion')
        ->get();

        $proceso = \App\Proceso::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('nombreProceso','idProceso');
        $idTipoCalidad = \App\TipoCalidad::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('idTipoCalidad');
        $nombreTipoCalidad = \App\TipoCalidad::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('nombreTipoCalidad');
        

        return view('ordentrabajo', compact('ordenproduccion','proceso','idTipoCalidad','nombreTipoCalidad'));
    }

    
    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(OrdenTrabajoRequest $request)
    {
        if($request['respuesta'] != 'falso')
        {
        
            $numero = DB::select(
            "SELECT CONCAT(REPEAT('0', 10 - LENGTH(ultimo+1)), (ultimo+1)) as nuevo
            FROM 
            (
                SELECT IFNULL( MAX(numeroOrdenTrabajo) , 0) as ultimo
                FROM  ordentrabajo OP
                where   OP.Compania_idCompania = ".\Session::get('idCompania')." 
            ) temp");

            $numero = get_object_vars($numero[0])["nuevo"];

            \App\OrdenTrabajo::create([
                'numeroOrdenTrabajo' => $numero,
                'fechaElaboracionOrdenTrabajo' => $request['fechaElaboracionOrdenTrabajo'],
                'OrdenProduccion_idOrdenProduccion' => $request['OrdenProduccion_idOrdenProduccion'],
                'Proceso_idProceso' => $request['Proceso_idProceso'],
                'cantidadOrdenTrabajo' => $request['cantidadOrdenTrabajo'],
                'estadoOrdenTrabajo' => $request['estadoOrdenTrabajo'],
                'observacionOrdenTrabajo' => ($request['observacionOrdenTrabajo'] == '' ? null : $request['observacionOrdenTrabajo']),

                'Compania_idCompania' => \Session::get('idCompania')
                ]);

            $ordentrabajo = \App\OrdenTrabajo::All()->last();

            $this->grabarDetalle($ordentrabajo->idOrdenTrabajo, $request);

            return redirect('/ordentrabajo');
        }
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
        $ordentrabajo = \App\OrdenTrabajo::find($id);
        $ordenproduccion = \App\OrdenProduccion::where('Compania_idCompania','=', \Session::get('idCompania'))->where('estadoOrdenProduccion','!=','Cerrada')->lists('numeroOrdenProduccion','idOrdenProduccion');
        $proceso = \App\Proceso::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('nombreProceso','idProceso');
        $idTipoCalidad = \App\TipoCalidad::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('idTipoCalidad');
        $nombreTipoCalidad = \App\TipoCalidad::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('nombreTipoCalidad');
        $detalle = DB::select(
            'SELECT idOrdenTrabajoDetalle, 
                    TipoCalidad_idTipoCalidad,
                    cantidadOrdenTrabajoDetalle
                FROM ordentrabajodetalle
                WHERE OrdenTrabajo_idOrdenTrabajo = '. $id );

        $operacion = DB::select(
            'SELECT idOrdenTrabajoOperacion,
                    ordenOrdenTrabajoOperacion, 
                    nombreOrdenTrabajoOperacion, 
                    samOrdenTrabajoOperacion
                FROM ordentrabajooperacion
                WHERE OrdenTrabajo_idOrdenTrabajo = '. $id );
                
        return view('ordentrabajo', ['ordentrabajo'=>$ordentrabajo], compact('ordenproduccion','proceso','idTipoCalidad','nombreTipoCalidad','detalle','operacion'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(OrdenTrabajoRequest $request, $id)
    {
        if($request['respuesta'] != 'falso')
        {
            $ordentrabajo = \App\OrdenTrabajo::find($id);
            $ordentrabajo->fill($request->all());
            $ordentrabajo->save();

            $this->grabarDetalle($id, $request);

            
            return redirect('/ordentrabajo');
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
        \App\OrdenTrabajo::destroy($id);
        return redirect('/ordentrabajo');
    }


     public function grabarDetalle($id, $request)
    {
        // -----------------------------------
        // DETALLE
        // en el formulario hay un campo oculto en el que almacenamos los id que se eliminan separados por coma
        // en este proceso lo convertimos en array y eliminamos dichos id de la tabla de detalle
        // -----------------------------------
        $idsEliminar = explode(',', $request['eliminarDetalle']);
        \App\OrdenTrabajoDetalle::whereIn('idOrdenTrabajoDetalle',$idsEliminar)->delete();

        $contador = count($request['idOrdenTrabajoDetalle']);
        for($i = 0; $i < $contador; $i++)
        {
            $indice = array(
             'idOrdenTrabajoDetalle' => $request['idOrdenTrabajoDetalle'][$i]);

            $data = array(
            'OrdenTrabajo_idOrdenTrabajo' => $id,
            'TipoCalidad_idTipoCalidad' => $request['TipoCalidad_idTipoCalidad'][$i],
            'cantidadOrdenTrabajoDetalle' => $request['cantidadOrdenTrabajoDetalle'][$i] );

            $guardar = \App\OrdenTrabajoDetalle::updateOrCreate($indice, $data);

        }


        // -----------------------------------
        // OPERACIONES
        // en el formulario hay un campo oculto en el que almacenamos los id que se eliminan separados por coma
        // en este proceso lo convertimos en array y eliminamos dichos id de la tabla de detalle
        // -----------------------------------
        $idsEliminar = explode(',', $request['eliminarOperacion']);
        \App\OrdenTrabajoOperacion::whereIn('idOrdenTrabajoOperacion',$idsEliminar)->delete();

        $contador = count($request['idOrdenTrabajoOperacion']);
        for($i = 0; $i < $contador; $i++)
        {
            $indice = array(
             'idOrdenTrabajoOperacion' => $request['idOrdenTrabajoOperacion'][$i]);

            $data = array(
            'OrdenTrabajo_idOrdenTrabajo' => $id,
            'ordenOrdenTrabajoOperacion' => $request['ordenOrdenTrabajoOperacion'][$i],
            'nombreOrdenTrabajoOperacion' => $request['nombreOrdenTrabajoOperacion'][$i],
            'samOrdenTrabajoOperacion' => $request['samOrdenTrabajoOperacion'][$i]);

            $guardar = \App\OrdenTrabajoOperacion::updateOrCreate($indice, $data);

        }


        
    }

    function convertirArray($dato)
    {
        $nuevo = array();

        for($i = 0; $i < count($dato); $i++) 
        {
          $nuevo[] = get_object_vars($dato[$i]) ;
        }
        return $nuevo;
    }

}
