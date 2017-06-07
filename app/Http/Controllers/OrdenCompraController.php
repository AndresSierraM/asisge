<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Mail;
include public_path().'/ajax/consultarPermisosCRM.php';

class OrdenCompraController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $idDocumento = $_GET["idDocumentoCRM"];
        $vista = basename($_SERVER["PHP_SELF"]);
        $datos = consultarPermisosCRM($idDocumento);

        if($datos != null)
            return view('ordencompragrid', compact('datos'));
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
        $num = DB::Select("
            SELECT 
                IF(numeroOrdenCompra IS NULL,'0000000001' ,LPAD((MAX(numeroOrdenCompra) + 1),10,'0')) as numeroOrdenCompra
            FROM
                ordencompra
            WHERE Compania_idCompania = ".\Session::get('idCompania'));

        $numeroOrden = get_object_vars($num[0])['numeroOrdenCompra'];

        $proveedor = \App\Tercero::where('tipoTercero','like','%*02*%')->where('Compania_idCompania', '=', \Session::get('idCompania'))->lists('nombreCompletoTercero', 'idTercero');

        return view('ordencompra',compact('proveedor','numeroOrden'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        \App\OrdenCompra::create([
            'DocumentoCRM_idDocumentoCRM' => $request['DocumentoCRM_idDocumentoCRM'],
            'numeroOrdenCompra' => $request['numeroOrdenCompra'],
            'requerimientoOrdenCompra' => $request['requerimientoOrdenCompra'],
            'sitioEntregaOrdenCompra' => $request['sitioEntregaOrdenCompra'],
            'fechaElaboracionOrdenCompra' => $request['fechaElaboracionOrdenCompra'],
            'fechaEstimadaOrdenCompra' => $request['fechaEstimadaOrdenCompra'],
            'fechaVencimientoOrdenCompra' => $request['fechaVencimientoOrdenCompra'],
            'fechaAprobacionOrdenCompra' => $request['fechaAprobacionOrdenCompra'],
            'Tercero_idProveedor' => $request['Tercero_idProveedor'],
            'Tercero_idSolicitante' => $request['Tercero_idSolicitante'],
            'Tercero_idAutorizador' => ($request['Tercero_idAutorizador'] == '' or $request['Tercero_idAutorizador'] == 0 ? NULL : $request['Tercero_idAutorizador']),
            'estadoOrdenCompra' => $request['estadoOrdenCompra'],
            'observacionOrdenCompra' => $request['observacionOrdenCompra'],
            'observacionAprobacionOrdenCompra' => $request['observacionAprobacionOrdenCompra'],
            'Compania_idCompania' => \Session::get('idCompania')
        ]);

        $ordencompra = \App\OrdenCompra::All()->last();
        for($i = 0; $i < count($request['cantidadOrdenCompraProducto']); $i++)
        {
            \App\OrdenCompraProducto::create([
            'OrdenCompra_idOrdenCompra' => $ordencompra->idOrdenCompra,
            'FichaTecnica_idFichaTecnica' => $request['FichaTecnica_idFichaTecnica'][$i],
            'cantidadOrdenCompraProducto' => $request['cantidadOrdenCompraProducto'][$i],
            'valorUnitarioOrdenCompraProducto' => $request['valorUnitarioOrdenCompraProducto'][$i],
            'MovimientoCRM_idMovimientoCRM' => ($request['MovimientoCRM_idMovimientoCRM'][$i] == 0 ? NULL : $request['MovimientoCRM_idMovimientoCRM'][$i])
            ]);
        }

        return redirect('/ordencompra?idDocumentoCRM='.$request['DocumentoCRM_idDocumentoCRM']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $ordencompra = DB::Select('
            SELECT 
                idOrdenCompra,
                numeroOrdenCompra,
                requerimientoOrdenCompra,
                sitioEntregaOrdenCompra,
                fechaElaboracionOrdenCompra,
                fechaEstimadaOrdenCompra,
                fechaVencimientoOrdenCompra,
                tp.nombreCompletoTercero as nombreProveedor,
                ts.nombreCompletoTercero as nombreSolicitante,
                ta.nombreCompletoTercero as nombreAutorizador,
                estadoOrdenCompra,
                observacionOrdenCompra,
                referenciaFichaTecnica as referenciaOrdenCompraProducto, 
                nombreFichaTecnica as descripcionOrdenCompraProducto, 
                cantidadOrdenCompraProducto, 
                valorUnitarioOrdenCompraProducto,
                cantidadOrdenCompraProducto * valorUnitarioOrdenCompraProducto as valorTotalOrdenCompraProducto
            FROM
                ordencompra oc
                    left join
                tercero tp ON oc.Tercero_idProveedor = tp.idTercero
                    left join
                tercero ts ON oc.Tercero_idSolicitante = ts.idTercero
                    left join
                tercero ta ON oc.Tercero_idAutorizador = ta.idTercero
                    left join
                ordencompraproducto ocp ON oc.idOrdenCompra = ocp.OrdenCompra_idOrdenCompra
                    left join
                fichatecnica ft ON ocp.FichaTecnica_idFichaTecnica = ft.idFichaTecnica
            WHERE
                idOrdenCompra = '.$id);

            $idDocumentoCRM= $_GET['idDocumentoCRM'];
            

            return view('formatos.formatoordencompra', compact('ordencompra','idDocumentoCRM'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $ordencompra = \App\OrdenCompra::find($id);

        $solicita = DB::Select('SELECT idTercero, nombreCompletoTercero as nombreSolicitante FROM tercero WHERE idTercero = '.\Session::get('idTercero'));
        $solicitante = get_object_vars($solicita[0]);

        $proveedor = \App\Tercero::where('tipoTercero','like','%*02*%')->where('Compania_idCompania', '=', \Session::get('idCompania'))->lists('nombreCompletoTercero', 'idTercero');

        $ordenCompraProducto = DB::Select('
            SELECT idOrdenCompraProducto, FichaTecnica_idFichaTecnica, referenciaFichaTecnica as referenciaOrdenCompraProducto, nombreFichaTecnica as descripcionOrdenCompraProducto, cantidadOrdenCompraProducto, valorUnitarioOrdenCompraProducto, MovimientoCRM_idMovimientoCRM
            FROM ordencompraproducto ocp
            LEFT JOIN fichatecnica ft ON ocp.FichaTecnica_idFichaTecnica = ft.idFichaTecnica
            WHERE OrdenCompra_idOrdenCompra = '.$id);

        return view('ordencompra',compact('proveedor','solicitante', 'ordenCompraProducto'), ['ordencompra' => $ordencompra]);
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
        $ordencompra = \App\OrdenCompra::find($id);
        $ordencompra->fill($request->all());
        $ordencompra->Tercero_idAutorizador = ($request['Tercero_idAutorizador'] == '' or $request['Tercero_idAutorizador'] == 0) ? null : $request['Tercero_idAutorizador'];
        $ordencompra->save();

        $idsEliminar = explode(',', $request['eliminarOrdenCompraProducto']);
        \App\OrdenCompraProducto::whereIn('idOrdenCompraProducto',$idsEliminar)->delete();
        for($i = 0; $i < count($request['cantidadOrdenCompraProducto']); $i++)
        {
            $indice = array(
                'idOrdenCompraProducto' => $request['idOrdenCompraProducto'][$i]);

            $datos= array(
                'OrdenCompra_idOrdenCompra' => $id,
                'FichaTecnica_idFichaTecnica' => $request['FichaTecnica_idFichaTecnica'][$i],
                'cantidadOrdenCompraProducto' => $request['cantidadOrdenCompraProducto'][$i],
                'valorUnitarioOrdenCompraProducto' => $request['valorUnitarioOrdenCompraProducto'][$i],
                'MovimientoCRM_idMovimientoCRM' => ($request['MovimientoCRM_idMovimientoCRM'][$i] == 0 ? NULL : $request['MovimientoCRM_idMovimientoCRM'][$i]));

            $guardar = \App\OrdenCompraProducto::updateOrCreate($indice, $datos);
        }

        return redirect('/ordencompra?idDocumentoCRM='.$request['DocumentoCRM_idDocumentoCRM']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        \App\OrdenCompra::destroy($id);
        return redirect('/ordencompra?idDocumentoCRM='.$request['DocumentoCRM_idDocumentoCRM']);
    }

    public function autorizarOrdenCompra()
    {
        $ordencompra = \App\OrdenCompra::find($_POST["idOrdenCompra"]);
        $ordencompra->Tercero_idAutorizador = $_POST["Tercero_idAutorizador"];
        $ordencompra->fechaAprobacionOrdenCompra = $_POST["fechaAprobacionOrdenCompra"];
        $ordencompra->estadoOrdenCompra = $_POST["estadoOrdenCompra"];
        $ordencompra->observacionAprobacionOrdenCompra = $_POST["observacionAprobacionOrdenCompra"];
        $ordencompra->save();

        $movimientocrm = DB::Select('SELECT MovimientoCRM_idMovimientoCRM FROM ordencompraproducto WHERE MovimientoCRM_idMovimientoCRM IS NOT NULL AND OrdenCompra_idOrdenCompra = '.$_POST['idOrdenCompra']);

        if ($_POST['estadoOrdenCompra'] == 'Aprobado') 
        {
            // for ($i=0; $i < count($movimientocrm); $i++) 
            // { 
            //     $movimiento = get_object_vars($movimientocrm[$i]);

            // }   

            $datos = Array();

            $proveedor = DB::select('
            SELECT correoElectronicoTercero
            FROM  tercero
            WHERE idTercero = '.$ordencompra->Tercero_idProveedor);

            $datos['correo'] = 'santi-0310@hotmail.com';

            $datos['asunto'] = 'Aprobación de Orden de Compra número: '.$ordencompra->numeroOrdenCompra;
            $datos['mensaje'] = $ordencompra->observacionAprobacionOrdenCompra. '  
                <a href="http://'.$_SERVER["HTTP_HOST"].'/ordencompra/'.$ordencompra->idOrdenCompra.'?idDocumentoCRM='.$ordencompra->DocumentoCRM_idDocumentoCRM.'&accion=imprimir">Ver Orden de compra</a>';

            Mail::send('emails.contact',$datos,function($msj) use ($datos)
            {
                $msj->to($datos['correo']);
                $msj->subject($datos['asunto']);
            });
        }
        else
        {
            for ($i=0; $i < count($movimientocrm); $i++) 
            { 
                $movimiento = get_object_vars($movimientocrm[$i]);

            }
        }

        echo json_encode(array(true, 'Se ha guardado exitosamente.'));
    }
}
