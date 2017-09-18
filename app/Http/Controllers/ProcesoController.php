<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\ProcesoRequest;
use App\Http\Controllers\Controller;
use DB;
include public_path().'/ajax/consultarPermisos.php';

class ProcesoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $vista = basename($_SERVER["PHP_SELF"].'?tipo='.$_GET['tipo']);
        $datos = consultarPermisos($vista);

        // si se recibe por get el parametro Tipo, lo enviamos a la vista
        // de lo contrario es tipo G (G=General,  P=Produccion)
        if(isset($_GET["tipo"]) and $_GET["tipo"] != "")
            $tipo = $_GET["tipo"];
        else
            $tipo = 'G';

        if($datos != null)
            return view('procesogrid', compact('datos', 'tipo'));
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
        // si se recibe por get el parametro Tipo, lo enviamos a la vista
        // de lo contrario es tipo G (G=General,  P=Produccion)
        if(isset($_GET["tipo"]) and $_GET["tipo"] != "")
            $tipo = $_GET["tipo"];
        else
            $tipo = 'G';
        
        return view('proceso', compact('tipo'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(ProcesoRequest $request)
    {
        \App\Proceso::create([
            'codigoProceso' => $request['codigoProceso'],
            'nombreProceso' => $request['nombreProceso'],
            'tipoProceso' => $request['tipoProceso'],
            'Compania_idCompania' => \Session::get("idCompania")
            ]);

        $proceso = \App\Proceso::All()->last();

        $this->grabarDetalle($proceso->idProceso,$request);

        return redirect('/proceso?tipo='.$request["tipoProceso"]);
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
        // si se recibe por get el parametro Tipo, lo enviamos a la vista
        // de lo contrario es tipo G (G=General,  P=Produccion)
        if(isset($_GET["tipo"]) and $_GET["tipo"] != "")
            $tipo = $_GET["tipo"];
        else
            $tipo = 'G';


        $proceso = \App\Proceso::find($id);
        return view('proceso',['proceso'=>$proceso], compact("tipo"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update($id,ProcesoRequest $request)
    {
        
        $proceso = \App\Proceso::find($id);
        $proceso->fill($request->all());
        $proceso->save();

        $this->grabarDetalle($id,$request);

        return redirect('/proceso?tipo='.$request["tipoProceso"]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    

    public function destroy($id)
    {
        \App\Proceso::destroy($id);
        return redirect('/proceso?tipo='.$request["tipoProceso"]);
    }

    protected function grabarDetalle($id, $request)
    {

        // en el formulario hay un campo oculto en el que almacenamos los id que se eliminan separados por coma
        // en este proceso lo convertimos en array y eliminamos dichos id de la tabla de detalle
        $idsEliminar = explode(',', $request['eliminarOperacion']);
        \App\ProcesoOperacion::whereIn('idProcesoOperacion',$idsEliminar)->delete();

        $contadorDetalle = count($request['ordenProcesoOperacion']);
        for($i = 0; $i < $contadorDetalle; $i++)
        {
            $indice = array(
             'idProcesoOperacion' => $request['idProcesoOperacion'][$i]);

            $data = array(
            'Proceso_idProceso' => $id,
            'ordenProcesoOperacion' => $request['ordenProcesoOperacion'][$i],
            'nombreProcesoOperacion' => $request['nombreProcesoOperacion'][$i],
            'samProcesoOperacion' => $request['samProcesoOperacion'][$i],
            'observacionProcesoOperacion' => $request['observacionProcesoOperacion'][$i] );


            $insertar = \App\ProcesoOperacion::updateOrCreate($indice, $data);

        }
    }
}
