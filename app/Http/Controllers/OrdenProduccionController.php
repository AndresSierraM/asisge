<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
 use App\Http\Requests\OrdenProduccionRequest;

//use Intervention\Image\ImageManagerStatic as Image;
use Input;
use File;
// include composer autoload
require '../vendor/autoload.php';
// import the Intervention Image Manager Class
use Intervention\Image\ImageManager ;


use Illuminate\Routing\Route;
use DB;
include public_path().'/ajax/consultarPermisos.php';
use Carbon;

class OrdenProduccionController extends Controller
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
        $this->ordenproduccion = \App\OrdenProduccion::find($route->getParameter('ordenproduccion'));
        return $this->ordenproduccion;
    }

    public function index()
    {
        $vista = basename($_SERVER["PHP_SELF"]);
        $datos = consultarPermisos($vista);

        if($datos != null)
            return view('ordenproducciongrid', compact('datos'));
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
        $fichatecnica = \App\FichaTecnica::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('nombreFichaTecnica','idFichaTecnica');

        $tercero = \App\Tercero::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('nombreCompletoTercero','idTercero');
        
        return view('ordenproduccion', compact('fichatecnica','tercero'));
    }

    
    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(OrdenProduccionRequest $request)
    {
        if($request['respuesta'] != 'falso')
        {
        
            $numero = DB::select(
            "SELECT CONCAT(REPEAT('0', 10 - LENGTH(ultimo+1)), (ultimo+1)) as nuevo
            FROM 
            (
                SELECT IFNULL( MAX(numeroOrdenProduccion) , 0) as ultimo
                FROM  ordenproduccion OP
                where   OP.Compania_idCompania = ".\Session::get('idCompania')." 
            ) temp");

            $numero = get_object_vars($numero[0])["nuevo"];

            \App\OrdenProduccion::create([
                'numeroOrdenProduccion' => $numero,
                'fechaElaboracionOrdenProduccion' => $request['fechaElaboracionOrdenProduccion'],
                'Tercero_idCliente' => $request['Tercero_idCliente'],
                'numeroPedidoOrdenProduccion' => $request['numeroPedidoOrdenProduccion'],
                'prioridadOrdenProduccion' => $request['prioridadOrdenProduccion'],
                'fechaMaximaEntregaOrdenProduccion' => ($request['fechaMaximaEntregaOrdenProduccion'] == '' ? null : $request['fechaMaximaEntregaOrdenProduccion']),
                'FichaTecnica_idFichaTecnica' => $request['FichaTecnica_idFichaTecnica'],
                'especificacionOrdenProduccion' => ($request['especificacionOrdenProduccion'] == '' ? null : $request['especificacionOrdenProduccion']),
                'cantidadOrdenProduccion' => 0,
                'estadoOrdenProduccion' => $request['estadoOrdenProduccion'],
                'observacionOrdenProduccion' => ($request['observacionOrdenProduccion'] == '' ? null : $request['observacionOrdenProduccion']),

                'Compania_idCompania' => \Session::get('idCompania')
                ]);

            $ordenproduccion = \App\OrdenProduccion::All()->last();

            //$this->grabarDetalle($ordenproduccion->idOrdenProduccion, $request);


            return redirect('/ordenproduccion');
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
        $ordenproduccion = \App\OrdenProduccion::find($id);

        $proceso = DB::select(
            'SELECT idOrdenProduccionProceso, 
                    ordenOrdenProduccionProceso,
                    Proceso_idProceso,
                    nombreProceso,
                    observacionOrdenProduccionProceso
            FROM ordenproduccionproceso OPP
            LEFT JOIN proceso P 
            ON OPP.Proceso_idProceso = P.idProceso
            WHERE OrdenProduccion_idOrdenProduccion = '.$id.' 
            ORDER BY ordenOrdenProduccionProceso');

        $proceso = $this->convertirArray($proceso);

        $material = DB::select(
            'SELECT idOrdenProduccionMaterial, 
                    OrdenProduccion_idOrdenProduccion, 
                    nombreOrdenProduccionMaterial, 
                    consumoUnitarioOrdenProduccionMaterial, 
                    consumoTotalOrdenProduccionMaterial
            FROM ordenproduccionmaterial OPM
            WHERE OrdenProduccion_idOrdenProduccion = '.$id);

        $material = $this->convertirArray($material);


         $fichatecnica = \App\FichaTecnica::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('nombreFichaTecnica','idFichaTecnica');

        $tercero = \App\Tercero::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('nombreCompletoTercero','idTercero');
        
        return view('ordenproduccion', ['ordenproduccion'=>$ordenproduccion], compact('fichatecnica','tercero','proceso','material'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(OrdenProduccionRequest $request, $id)
    {
        if($request['respuesta'] != 'falso')
        {
            $ordenproduccion = \App\OrdenProduccion::find($id);
            $ordenproduccion->fill($request->all());
            $ordenproduccion->save();

            $this->grabarDetalle($id, $request);

            
           return redirect('/ordenproduccion');
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
        \App\OrdenProduccion::destroy($id);
        return redirect('/ordenproduccion');
    }


     public function grabarDetalle($id, $request)
    {
        // -----------------------------------
        // PROCESOS
        // en el formulario hay un campo oculto en el que almacenamos los id que se eliminan separados por coma
        // en este proceso lo convertimos en array y eliminamos dichos id de la tabla de detalle
        // -----------------------------------
        $idsEliminar = explode(',', $request['eliminarProceso']);
        \App\OrdenProduccionProceso::whereIn('idOrdenProduccionProceso',$idsEliminar)->delete();

        $contador = count($request['idOrdenProduccionProceso']);
        for($i = 0; $i < $contador; $i++)
        {
            $indice = array(
             'idOrdenProduccionProceso' => $request['idOrdenProduccionProceso'][$i]);

            $data = array(
            'OrdenProduccion_idOrdenProduccion' => $id,
            'ordenOrdenProduccionProceso' => $request['ordenOrdenProduccionProceso'][$i],
            'Proceso_idProceso' => $request['Proceso_idProceso'][$i],
            'observacionOrdenProduccionProceso' => $request['observacionOrdenProduccionProceso'][$i] );

            $guardar = \App\OrdenProduccionProceso::updateOrCreate($indice, $data);

        }


        // -----------------------------------
        // MATERIALES
        // en el formulario hay un campo oculto en el que almacenamos los id que se eliminan separados por coma
        // en este proceso lo convertimos en array y eliminamos dichos id de la tabla de detalle
        // -----------------------------------
        $idsEliminar = explode(',', $request['eliminarMaterial']);
        \App\OrdenProduccionMaterial::whereIn('idOrdenProduccionMaterial',$idsEliminar)->delete();

        $contador = count($request['idOrdenProduccionMaterial']);
        for($i = 0; $i < $contador; $i++)
        {
            $indice = array(
             'idOrdenProduccionMaterial' => $request['idOrdenProduccionMaterial'][$i]);

            $data = array(
            'OrdenProduccion_idOrdenProduccion' => $id,
            'nombreOrdenProduccionMaterial' => $request['nombreOrdenProduccionMaterial'][$i],
            'consumoUnitarioOrdenProduccionMaterial' => $request['consumoUnitarioOrdenProduccionMaterial'][$i],
            'consumoTotalOrdenProduccionMaterial' => $request['consumoTotalOrdenProduccionMaterial'][$i]);

            $guardar = \App\OrdenProduccionMaterial::updateOrCreate($indice, $data);

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
