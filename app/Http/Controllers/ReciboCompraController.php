<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
include public_path().'/ajax/consultarPermisos.php';

class ReciboCompraController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vista = basename($_SERVER["PHP_SELF"]);
        $datos = consultarPermisos($vista);

        if($datos != null)
            return view('recibocompragrid', compact('datos'));
        else
            return view('accesodenegado');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $num = DB::Select("
        //     SELECT 
        //         IF(numeroReciboCompra IS NULL,'0000000001' ,LPAD((MAX(numeroReciboCompra) + 1),10,'0')) as numeroReciboCompra
        //     FROM
        //         recibocompra
        //     WHERE Compania_idCompania = ".\Session::get('idCompania'));

        $num = DB::Select("
            SELECT 
                IF(numeroReciboCompra IS NULL,'0000000001' ,LPAD((MAX(numeroReciboCompra) + 1),10,'0')) as numeroReciboCompra
            FROM
                recibocompra");

        $numeroRecibo = get_object_vars($num[0])['numeroReciboCompra'];

        $idTipoCalidad = \App\TipoCalidad::where('Compania_idCompania','=',\Session::get('idCompania'))->lists('idTipoCalidad');
        $nombreTipoCalidad = \App\TipoCalidad::where('Compania_idCompania','=',\Session::get('idCompania'))->lists('nombreTipoCalidad');

        return view('recibocompra', compact('numeroRecibo', 'idTipoCalidad', 'nombreTipoCalidad'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        \App\ReciboCompra::Create([
            'numeroReciboCompra' => $request['numeroReciboCompra'],
            'OrdenCompra_idOrdenCompra' => $request['OrdenCompra_idOrdenCompra'],
            'fechaElaboracionReciboCompra' => $request['fechaElaboracionReciboCompra'],
            'fechaRealReciboCompra' => $request['fechaRealReciboCompra'],
            'Users_idCrea' => $request['Users_idCrea'],
            'estadoReciboCompra' => $request['estadoReciboCompra'],
            'observacionReciboCompra' => $request['observacionReciboCompra']
        ]);

        $recibocompra = \App\ReciboCompra::All()->last();

        $this->grabarDetalle($request, $recibocompra->idReciboCompra);

        return view('recibocompra');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $recibocompra = \App\ReciboCompra::find($id);

        $idTipoCalidad = \App\TipoCalidad::where('Compania_idCompania','=',\Session::get('idCompania'))->lists('idTipoCalidad');
        $nombreTipoCalidad = \App\TipoCalidad::where('Compania_idCompania','=',\Session::get('idCompania'))->lists('nombreTipoCalidad');

        $reciboCompraProducto = DB::Select(
            'SELECT idReciboCompraProducto, rcp.FichaTecnica_idFichaTecnica, referenciaFichaTecnica as referenciaReciboCompraProducto, nombreFichaTecnica as descripcionReciboCompraProducto, cantidadOrdenCompraProducto, cantidadReciboCompraProducto, TipoCalidad_idTipoCalidad, valorUnitarioOrdenCompraProducto, valorUnitarioReciboCompraProducto, cantidadReciboCompraProducto * valorUnitarioReciboCompraProducto as valorTotalReciboCompraProducto
            FROM recibocompraproducto rcp
            LEFT JOIN fichatecnica ft ON rcp.FichaTecnica_idFichaTecnica = ft.idFichaTecnica
            LEFT JOIN tipocalidad tc ON rcp.TipoCalidad_idTipoCalidad = tc.idTipoCalidad
            LEFT JOIN recibocompra rc ON rcp.ReciboCompra_idReciboCompra = rc.idReciboCompra
            LEFT JOIN ordencompra oc ON rc.OrdenCompra_idOrdenCompra = oc.idOrdenCompra
            LEFT JOIN ordencompraproducto ocp ON oc.idOrdenCompra = ocp.OrdenCompra_idOrdenCompra
            WHERE ReciboCompra_idReciboCompra = '.$id);

        $resultadoCompra = DB::Select(
            'SELECT idReciboCompraResultado, descripcionReciboCompraResultado, valorCompraReciboCompraResultado, valorReciboReciboCompraResultado,diferenciaReciboCompraResultado, porcentajeReciboCompraResultado, pesoReciboCompraResultado, resultadoReciboCompraResultado
            FROM recibocompraresultado
            WHERE ReciboCompra_idReciboCompra = '.$id);
            
        return view('recibocompra',compact('reciboCompraProducto', 'resultadoCompra', 'idTipoCalidad', 'nombreTipoCalidad'), ['recibocompra' => $recibocompra]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $recibocompra = \App\ReciboCompra::find($id);
        $recibocompra->fill($request->all());
        $recibocompra->save();

        $this->grabarDetalle($request, $id);

        return view('recibocompra');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        \App\ReciboCompra::destroy($id);
        return redirect('/recibocompra');
    }

    public function grabarDetalle($request, $id)
    {
        $idsEliminar = explode(',', $request['eliminarReciboCompraProducto']);
        \App\ReciboCompraProducto::whereIn('idReciboCompraProducto',$idsEliminar)->delete();

        $contador = count($request['idReciboCompraProducto']);
        for($i = 0; $i < $contador; $i++)
        {
            $indice = array(
             'idReciboCompraProducto' => $request['idReciboCompraProducto'][$i]);

            $data = array(
            'ReciboCompra_idReciboCompra' => $id,
            'FichaTecnica_idFichaTecnica' => $request['FichaTecnica_idFichaTecnica'][$i],
            'cantidadReciboCompraProducto' => $request['cantidadReciboCompraProducto'][$i],
            'TipoCalidad_idTipoCalidad' => $request['TipoCalidad_idTipoCalidad'][$i],
            'valorUnitarioReciboCompraProducto' => $request['valorUnitarioReciboCompraProducto'][$i] );

            $guardar = \App\ReciboCompraProducto::updateOrCreate($indice, $data);

        }

        $contador = count($request['idReciboCompraResultado']);
        for($i = 0; $i < $contador; $i++)
        {
            $indice = array(
             'idReciboCompraResultado' => $request['idReciboCompraResultado'][$i]);

            $data = array(
            'ReciboCompra_idReciboCompra' => $id,
            'descripcionReciboCompraResultado' => $request['descripcionReciboCompraResultado'][$i],
            'valorCompraReciboCompraResultado' => $request['valorCompraReciboCompraResultado'][$i],
            'valorReciboReciboCompraResultado' => $request['valorReciboReciboCompraResultado'][$i],
            'diferenciaReciboCompraResultado' => $request['diferenciaReciboCompraResultado'][$i],
            'porcentajeReciboCompraResultado' => $request['porcentajeReciboCompraResultado'][$i],
            'pesoReciboCompraResultado' => $request['pesoReciboCompraResultado'][$i],
            'resultadoReciboCompraResultado' => $request['resultadoReciboCompraResultado'][$i] );

            $guardar = \App\ReciboCompraResultado::updateOrCreate($indice, $data);

        }
    }
}
