<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\PresupuestoRequest;
use DB;
include public_path().'/ajax/consultarPermisos.php';

class PresupuestoController extends Controller
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

        return view('presupuestogrid', compact('datos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $documentocrm = \App\DocumentoCRM::All()->lists('nombreDocumentoCRM','idDocumentoCRM');
        $idLineaNegocio = \App\LineaNegocio::All()->lists('idLineaNegocio');
        $nombreLineaNegocio = \App\LineaNegocio::All()->lists('nombreLineaNegocio');
        $idTercero = \App\Tercero::where("tipoTercero","=","*03*")->lists('idTercero');
        $nombreTercero = \App\Tercero::where("tipoTercero","=","*03*")->lists('nombreCompletoTercero');
        return view('presupuesto',compact('documentocrm','idLineaNegocio','nombreLineaNegocio','idTercero','nombreTercero'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PresupuestoRequest $request)
    {
        \App\Presupuesto::create([
            'fechaInicialPresupuesto' => $request['fechaInicialPresupuesto'],
            'fechaFinalPresupuesto' => $request['fechaFinalPresupuesto'],
            'descripcionPresupuesto' => $request['descripcionPresupuesto'],
            'DocumentoCRM_idDocumentoCRM' => $request['DocumentoCRM_idDocumentoCRM'],
            ]);

        $lineaNegocio = DB::Select('SELECT idLineaNegocio from lineanegocio');
        $presupuesto = \App\Presupuesto::All()->last();
        for ($i=0; $i < count($request['Tercero_idVendedor']); $i++) 
        { 
            $idLN = get_object_vars($lineaNegocio[$i]);
            
            \App\PresupuestoDetalle::create([
            'Tercero_idVendedor' => $request['Tercero_idVendedor'][$i],
            'valorLineaNegocio' => $request['LineaNegocio_'.$idLN["idLineaNegocio"].'_'][$i],
            'Presupuesto_idPresupuesto' => $presupuesto->idPresupuesto
            ]);
        }

        return redirect('/presupuesto');
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
        $presupuesto = \App\Presupuesto::find($id);
        $documentocrm = \App\DocumentoCRM::All()->lists('nombreDocumentoCRM','idDocumentoCRM');
        $idLineaNegocio = \App\LineaNegocio::All()->lists('idLineaNegocio');
        $nombreLineaNegocio = \App\LineaNegocio::All()->lists('nombreLineaNegocio');
        $idTercero = \App\Tercero::where("tipoTercero","=","*03*")->lists('idTercero');
        $nombreTercero = \App\Tercero::where("tipoTercero","=","*03*")->lists('nombreTercero');
        return view('presupuesto',compact('documentocrm','idLineaNegocio','nombreLineaNegocio','idTercero','nombreCompletoTercero'),['presupuesto'=>$presupuesto]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PresupuestoRequest $request, $id)
    {
        $presupuesto = \App\Presupuesto::find($id);
        $presupuesto->fill($request->all());
        $presupuesto->save();

        $lineaNegocio = DB::Select('SELECT idLineaNegocio from lineanegocio');
        \App\PresupuestoDetalle::where('Presupuesto_idPresupuesto',$id)->delete();
        for ($i=0; $i < count($request['Tercero_idVendedor']); $i++) 
        { 
            $idLN = get_object_vars($lineaNegocio[$i]);
            \App\PresupuestoDetalle::create([
            'Tercero_idVendedor' => $request['Tercero_idVendedor'][$i],
            'valorLineaNegocio' => $request['LineaNegocio_'].$idLineaNegocio["idLineaNegocio"].'_'.[$i],
            'Presupuesto_idPresupuesto' => $presupuesto->idPresupuesto
            ]);
        }

        return redirect('/presupuesto');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        \App\Presupuesto::destroy($id);
        return redirect('/presupuesto');
    }
}
