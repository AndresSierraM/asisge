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
        $ordenproduccion = \App\OrdenProduccion::where('Compania_idCompania','=', \Session::get('idCompania'))->where('estadoOrdenProduccion','!=','Cerrada')->lists('numeroOrdenProduccion','idOrdenProduccion');

        return view('ordentrabajo', compact('ordenproduccion'));
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
                'Tercero_idCliente' => $request['Tercero_idCliente'],
                'numeroPedidoOrdenTrabajo' => $request['numeroPedidoOrdenTrabajo'],
                'prioridadOrdenTrabajo' => $request['prioridadOrdenTrabajo'],
                'fechaMaximaEntregaOrdenTrabajo' => ($request['fechaMaximaEntregaOrdenTrabajo'] == '' ? null : $request['fechaMaximaEntregaOrdenTrabajo']),
                'FichaTecnica_idFichaTecnica' => $request['FichaTecnica_idFichaTecnica'],
                'especificacionOrdenTrabajo' => ($request['especificacionOrdenTrabajo'] == '' ? null : $request['especificacionOrdenTrabajo']),
                'cantidadOrdenTrabajo' => 0,
                'estadoOrdenTrabajo' => $request['estadoOrdenTrabajo'],
                'observacionOrdenTrabajo' => ($request['observacionOrdenTrabajo'] == '' ? null : $request['observacionOrdenTrabajo']),

                'Compania_idCompania' => \Session::get('idCompania')
                ]);

            $ordentrabajo = \App\OrdenTrabajo::All()->last();


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

        
        return view('ordentrabajo', ['ordentrabajo'=>$ordentrabajo], compact('ordenproduccion'));
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

            //$this->grabarDetalle($id, $request);

            
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
        // PROCESOS
        // en el formulario hay un campo oculto en el que almacenamos los id que se eliminan separados por coma
        // en este proceso lo convertimos en array y eliminamos dichos id de la tabla de detalle
        // -----------------------------------
        $idsEliminar = explode(',', $request['eliminarProceso']);
        \App\OrdenTrabajoProceso::whereIn('idOrdenTrabajoProceso',$idsEliminar)->delete();

        $contador = count($request['idOrdenTrabajoProceso']);
        for($i = 0; $i < $contador; $i++)
        {
            $indice = array(
             'idOrdenTrabajoProceso' => $request['idOrdenTrabajoProceso'][$i]);

            $data = array(
            'OrdenTrabajo_idOrdenTrabajo' => $id,
            'ordenOrdenTrabajoProceso' => $request['ordenOrdenTrabajoProceso'][$i],
            'Proceso_idProceso' => $request['Proceso_idProceso'][$i],
            'observacionOrdenTrabajoProceso' => $request['observacionOrdenTrabajoProceso'][$i] );

            $guardar = \App\OrdenTrabajoProceso::updateOrCreate($indice, $data);

        }


        // -----------------------------------
        // MATERIALES
        // en el formulario hay un campo oculto en el que almacenamos los id que se eliminan separados por coma
        // en este proceso lo convertimos en array y eliminamos dichos id de la tabla de detalle
        // -----------------------------------
        $idsEliminar = explode(',', $request['eliminarMaterial']);
        \App\OrdenTrabajoMaterial::whereIn('idOrdenTrabajoMaterial',$idsEliminar)->delete();

        $contador = count($request['idOrdenTrabajoMaterial']);
        for($i = 0; $i < $contador; $i++)
        {
            $indice = array(
             'idOrdenTrabajoMaterial' => $request['idOrdenTrabajoMaterial'][$i]);

            $data = array(
            'OrdenTrabajo_idOrdenTrabajo' => $id,
            'FichaTecnica_idMaterial' => $request['FichaTecnica_idMaterial'][$i],
            'consumoUnitarioOrdenTrabajoMaterial' => $request['consumoUnitarioOrdenTrabajoMaterial'][$i],
            'consumoTotalOrdenTrabajoMaterial' => $request['consumoTotalOrdenTrabajoMaterial'][$i]);

            $guardar = \App\OrdenTrabajoMaterial::updateOrCreate($indice, $data);

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
