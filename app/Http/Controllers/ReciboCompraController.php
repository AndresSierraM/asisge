<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;

class ReciboCompraController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('recibocompragrid');
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

        $reciboCompraProducto = DB::Select('
            SELECT idReciboCompraProducto, FichaTecnica_idFichaTecnica, referenciaFichaTecnica as referenciaOrdenCompraProducto, nombreFichaTecnica as descripcionOrdenCompraProducto, cantidadOrdenCompraProducto, TipoCalidad_idTipoCalidad, valorUnitarioReciboCompraProducto,
            FROM recibocompraproducto rcp
            LEFT JOIN fichatecnica ft ON ocp.FichaTecnica_idFichaTecnica = ft.idFichaTecnica
            LEFT JOIN tipocalidad tc ON rcp.TipoCalidad_idTipoCalidad = tp.idTipoCalidad
            WHERE ReciboCompra_idReciboCompra = '.$id);

        return view('recibocompra',compact('reciboCompraProducto', 'idTipoCalidad', 'nombreTipoCalidad'), ['recibocompra' => $recibocompra]);
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
    }
}
