<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\EvaluacionProveedorRequest;
use App\Http\Controllers\Controller;
use DB;
include public_path().'/ajax/consultarPermisos.php';

class EvaluacionProveedorController extends Controller
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
            return view('evaluacionproveedorgrid', compact('datos'));
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
        $proveedor = \App\Tercero::where('tipoTercero','like','%*02*%')->where('Compania_idCompania', '=', \Session::get('idCompania'))->lists('nombreCompletoTercero', 'idTercero');

        return view('evaluacionproveedor', compact('proveedor'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EvaluacionProveedorRequest $request)
    {
        if($request['respuesta'] != 'falso')
        {    
            \App\EvaluacionProveedor::Create([
                'Tercero_idProveedor' => $request['Tercero_idProveedor'],
                'fechaElaboracionEvaluacionProveedor' => $request['fechaElaboracionEvaluacionProveedor'],
                'fechaInicialEvaluacionProveedor' => $request['fechaInicialEvaluacionProveedor'],
                'fechaFinalEvaluacionProveedor' => $request['fechaFinalEvaluacionProveedor'],
                'Users_idCrea' => $request['Users_idCrea'],
                'observacionEvaluacionProveedor' => $request['observacionEvaluacionProveedor']
            ]);

            $evaluacionproveedor = \App\EvaluacionProveedor::All()->last();

            $this->grabarDetalle($request, $evaluacionproveedor->idEvaluacionProveedor);

            return redirect('evaluacionproveedor');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        $evaluacionproveedor = DB::Select(
            'SELECT nombreCompletoTercero, fechaElaboracionEvaluacionProveedor, fechaInicialEvaluacionProveedor, fechaFinalEvaluacionProveedor, name, observacionEvaluacionProveedor
            FROM evaluacionproveedor ep
            LEFT JOIN tercero t ON ep.Tercero_idProveedor = t.idTercero
            LEFT JOIN users u ON ep.Users_idCrea = u.id');

        $evaluacionproveedorresultado = DB::Select(
            'SELECT idEvaluacionProveedorResultado, descripcionEvaluacionProveedorResultado, porcentajeEvaluacionProveedorResultado, pesoEvaluacionProveedorResultado,resultadoEvaluacionProveedorResultado
            FROM evaluacionproveedorresultado
            WHERE EvaluacionProveedor_idEvaluacionProveedor = '.$id);

        return view('formatos.evaluacionproveedorimpresion', compact('evaluacionproveedor','evaluacionproveedorresultado'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $evaluacionproveedor = \App\EvaluacionProveedor::find($id);

        $proveedor = \App\Tercero::where('tipoTercero','like','%*02*%')->where('Compania_idCompania', '=', \Session::get('idCompania'))->lists('nombreCompletoTercero', 'idTercero');

        $resultadoevaluacion = DB::Select(
            'SELECT idEvaluacionProveedorResultado, descripcionEvaluacionProveedorResultado, porcentajeEvaluacionProveedorResultado, pesoEvaluacionProveedorResultado,resultadoEvaluacionProveedorResultado
            FROM evaluacionproveedorresultado
            WHERE EvaluacionProveedor_idEvaluacionProveedor = '.$id);
            
        return view('evaluacionproveedor',compact('proveedor' ,'resultadoevaluacion'), ['evaluacionproveedor' => $evaluacionproveedor]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EvaluacionProveedorRequest $request, $id)
    {
        if($request['respuesta'] != 'falso')
        {    
            $evaluacionproveedor = \App\EvaluacionProveedor::find($id);
            $evaluacionproveedor->fill($request->all());
            $evaluacionproveedor->save();

            $this->grabarDetalle($request, $id);

            return redirect('evaluacionproveedor');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        \App\EvaluacionProveedor::destroy($id);
        return redirect('/evaluacionproveedor');
    }

    public function grabarDetalle($request, $id)
    {
        $idsEliminar = explode(',', $request['eliminarEvaluacionProveedor']);
        \App\EvaluacionProveedorResultado::whereIn('idEvaluacionProveedorResultado',$idsEliminar)->delete();

        $contador = count($request['idEvaluacionProveedorResultado']);
        for($i = 0; $i < $contador; $i++)
        {
            $indice = array(
             'idEvaluacionProveedorResultado' => $request['idEvaluacionProveedorResultado'][$i]);

            $data = array(
            'EvaluacionProveedor_idEvaluacionProveedor' => $id,
            'descripcionEvaluacionProveedorResultado' => $request['descripcionEvaluacionProveedorResultado'][$i],
            'porcentajeEvaluacionProveedorResultado' => $request['porcentajeEvaluacionProveedorResultado'][$i],
            'pesoEvaluacionProveedorResultado' => $request['pesoEvaluacionProveedorResultado'][$i],
            'resultadoEvaluacionProveedorResultado' => $request['resultadoEvaluacionProveedorResultado'][$i]);

            $guardar = \App\EvaluacionProveedorResultado::updateOrCreate($indice, $data);

        }
    }
}
