<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Procedimiento;
use App\Http\Requests;
use App\Http\Requests\ProcedimientoRequest;
use App\Http\Controllers\Controller;
use DB;

class ProcedimientoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        
        return view('procedimientogrid');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        // cuando se crea un nuevo procedimiento, enviamos los procesos para el encabezado y los documentos 
        //  y los terceros que son la base para el llenado del detalle
        
        $procesos = \App\Proceso::All()->lists('nombreProceso','idProceso');

        $idTercero = \App\Tercero::All()->lists('idTercero');
        $nombreCompletoTercero = \App\Tercero::All()->lists('nombreCompletoTercero');

        $idDocumento = \App\Documento::All()->lists('idDocumento');
        $nombreDocumento = \App\Documento::All()->lists('nombreDocumento');

        return view('procedimiento',compact('procesos','idTercero','nombreCompletoTercero','idDocumento','nombreDocumento'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(ProcedimientoRequest $request)
    {
        
        \App\Procedimiento::create([
            'Proceso_idProceso' => $request['Proceso_idProceso'],
            'fechaElaboracionProcedimiento' => $request['fechaElaboracionProcedimiento'],
            'objetivoProcedimiento' => $request['objetivoProcedimiento'],
            'alcanceProcedimiento' => $request['alcanceProcedimiento'],
            'responsabilidadProcedimiento' => $request['responsabilidadProcedimiento'],
            'Compania_idCompania' => 1
            ]); 

        $procedimiento = \App\Procedimiento::All()->last();
        $contadorDetalle = count($request['Documento_idDocumento']);
        for($i = 0; $i < $contadorDetalle; $i++)
        {
            \App\ProcedimientoDetalle::create([
            'Procedimiento_idProcedimiento' => $procedimiento->idProcedimiento,
            'Documento_idDocumento' => $request['Documento_idDocumento'][$i],
            'Tercero_idResponsable' => $request['Tercero_idResponsable'][$i],
            'actividadProcedimientoDetalle' => $request['actividadProcedimientoDetalle'][$i]
           ]);
        }

        return redirect('/procedimiento');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id, Request $request)
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
        // cuando se modifica un procedimiento, enviamos los procesos para el encabezado y los documentos 
        //  y los terceros que son la base para el llenado del detalle
        $procedimiento = \App\Procedimiento::find($id);
        $procesos = \App\Proceso::All()->lists('nombreProceso','idProceso');

        $idTercero = \App\Tercero::All()->lists('idTercero');
        $nombreCompletoTercero = \App\Tercero::All()->lists('nombreCompletoTercero');

        $idDocumento = \App\Documento::All()->lists('idDocumento');
        $nombreDocumento = \App\Documento::All()->lists('nombreDocumento');
       
        return view('procedimiento',compact('procesos','idTercero','nombreCompletoTercero','idDocumento','nombreDocumento'),['procedimiento'=>$procedimiento]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update($id,ProcedimientoRequest $request)
    {
        
        $procedimiento = \App\Procedimiento::find($id);
        $procedimiento->fill($request->all());
        //$procedimiento->Compania_idCompania = 1;
        $procedimiento->save();

        \App\ProcedimientoDetalle::where('Procedimiento_idProcedimiento',$id)->delete();

        $contadorDetalle = count($request['Documento_idDocumento']);
        for($i = 0; $i < $contadorDetalle; $i++)
        {
            \App\ProcedimientoDetalle::create([
            'Procedimiento_idProcedimiento' => $id,
            'Documento_idDocumento' => $request['Documento_idDocumento'][$i],
            'Tercero_idResponsable' => $request['Tercero_idResponsable'][$i],
            'actividadProcedimientoDetalle' => $request['actividadProcedimientoDetalle'][$i]
           ]);
        }

        return redirect('/procedimiento');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    

    public function destroy($id)
    {

        \App\Procedimiento::destroy($id);
        return redirect('/procedimiento');
    }
}