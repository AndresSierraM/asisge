<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\EjecucionTrabajoRequest;

//use Intervention\Image\ImageManagerStatic as Image;
use Input;
use File;
// include composer autoload
require '../vendor/autoload.php';


use Illuminate\Routing\Route;
use DB;
include public_path().'/ajax/consultarPermisos.php';
use Carbon;

class EjecucionTrabajoController extends Controller
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
        $this->ejecuciontrabajo = \App\EjecucionTrabajo::find($route->getParameter('ejecuciontrabajo'));
        return $this->ejecuciontrabajo;
    }

    public function index()
    {
        $vista = basename($_SERVER["PHP_SELF"]);
        $datos = consultarPermisos($vista);

        if($datos != null)
            return view('ejecuciontrabajogrid', compact('datos'));
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
        $ordentrabajo = \App\OrdenTrabajo::where('Compania_idCompania','=', \Session::get('idCompania'))->where('estadoOrdenTrabajo','!=','Cerrada')->lists('numeroOrdenTrabajo','idOrdenTrabajo');
        $idTipoCalidad = \App\TipoCalidad::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('idTipoCalidad');
        $nombreTipoCalidad = \App\TipoCalidad::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('nombreTipoCalidad');
       
        return view('ejecuciontrabajo', compact('ordentrabajo','idTipoCalidad','nombreTipoCalidad'));
    }

    
    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(EjecucionTrabajoRequest $request)
    {
        if($request['respuesta'] != 'falso')
        {
        
            $numero = DB::select(
            "SELECT CONCAT(REPEAT('0', 10 - LENGTH(ultimo+1)), (ultimo+1)) as nuevo
            FROM 
            (
                SELECT IFNULL( MAX(numeroEjecucionTrabajo) , 0) as ultimo
                FROM  ejecuciontrabajo ET
                where   ET.Compania_idCompania = ".\Session::get('idCompania')." 
            ) temp");

            $numero = get_object_vars($numero[0])["nuevo"];

            \App\EjecucionTrabajo::create([
                'numeroEjecucionTrabajo' => $numero,
                'fechaElaboracionEjecucionTrabajo' => $request['fechaElaboracionEjecucionTrabajo'],
                'OrdenTrabajo_idOrdenTrabajo' => $request['OrdenTrabajo_idOrdenTrabajo'],
                'cantidadEjecucionTrabajo' => $request['cantidadEjecucionTrabajo'],
                'observacionEjecucionTrabajo' => ($request['observacionEjecucionTrabajo'] == '' ? null : $request['observacionEjecucionTrabajo']),
                'Compania_idCompania' => \Session::get('idCompania')
                ]);

            $ejecuciontrabajo = \App\EjecucionTrabajo::All()->last();

            $this->grabarDetalle($ejecuciontrabajo->idEjecucionTrabajo, $request);

            return redirect('/ejecuciontrabajo');
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
        $ejecuciontrabajo = \App\EjecucionTrabajo::find($id);
        $ordentrabajo = \App\OrdenTrabajo::where('Compania_idCompania','=', \Session::get('idCompania'))->where('estadoOrdenTrabajo','!=','Cerrada')->lists('numeroOrdenTrabajo','idOrdenTrabajo');
        $idTipoCalidad = \App\TipoCalidad::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('idTipoCalidad');
        $nombreTipoCalidad = \App\TipoCalidad::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('nombreTipoCalidad');
        $detalle = DB::select(
            'SELECT idEjecucionTrabajoDetalle, 
                    TipoCalidad_idTipoCalidad,
                    cantidadEjecucionTrabajoDetalle
                FROM ejecuciontrabajodetalle
                WHERE EjecucionTrabajo_idEjecucionTrabajo = '. $id );
                      
        return view('ejecuciontrabajo', ['ejecuciontrabajo'=>$ejecuciontrabajo], compact('ordentrabajo','idTipoCalidad','nombreTipoCalidad','detalle'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(EjecucionTrabajoRequest $request, $id)
    {
        if($request['respuesta'] != 'falso')
        {
            $ejecuciontrabajo = \App\EjecucionTrabajo::find($id);
            $ejecuciontrabajo->fill($request->all());
            $ejecuciontrabajo->save();

            $this->grabarDetalle($id, $request);

            
            return redirect('/ejecuciontrabajo');
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
        \App\EjecucionTrabajo::destroy($id);
        return redirect('/ejecuciontrabajo');
    }


     public function grabarDetalle($id, $request)
    {
        // -----------------------------------
        // DETALLE
        // en el formulario hay un campo oculto en el que almacenamos los id que se eliminan separados por coma
        // en este proceso lo convertimos en array y eliminamos dichos id de la tabla de detalle
        // -----------------------------------
        $idsEliminar = explode(',', $request['eliminarDetalle']);
        \App\EjecucionTrabajoDetalle::whereIn('idEjecucionTrabajoDetalle',$idsEliminar)->delete();

        $contador = count($request['idEjecucionTrabajoDetalle']);
        for($i = 0; $i < $contador; $i++)
        {
            $indice = array(
             'idEjecucionTrabajoDetalle' => $request['idEjecucionTrabajoDetalle'][$i]);

            $data = array(
            'EjecucionTrabajo_idEjecucionTrabajo' => $id,
            'TipoCalidad_idTipoCalidad' => $request['TipoCalidad_idTipoCalidad'][$i],
            'cantidadEjecucionTrabajoDetalle' => $request['cantidadEjecucionTrabajoDetalle'][$i] );

            $guardar = \App\EjecucionTrabajoDetalle::updateOrCreate($indice, $data);

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
