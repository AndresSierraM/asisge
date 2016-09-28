<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Procedimiento;
use App\Http\Requests;
use App\Http\Requests\ProcedimientoRequest;
use App\Http\Controllers\Controller;
use DB;
include public_path().'/ajax/consultarPermisos.php';

class ProcedimientoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $vista = basename($_SERVER["PHP_SELF"]);
        $datos = consultarPermisos($vista);

        if($datos != null)
            return view('procedimientogrid', compact('datos'));
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
        // cuando se crea un nuevo procedimiento, enviamos los procesos para el encabezado y los documentos 
        //  y los terceros que son la base para el llenado del detalle
        
        $procesos = \App\Proceso::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('nombreProceso','idProceso');

        $idTercero = \App\Tercero::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('idTercero');
        $nombreCompletoTercero = \App\Tercero::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('nombreCompletoTercero');

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
            'nombreProcedimiento' => $request['nombreProcedimiento'],
            'fechaElaboracionProcedimiento' => $request['fechaElaboracionProcedimiento'],
            'objetivoProcedimiento' => $request['objetivoProcedimiento'],
            'alcanceProcedimiento' => $request['alcanceProcedimiento'],
            'responsabilidadProcedimiento' => $request['responsabilidadProcedimiento'],
            'Compania_idCompania' => \Session::get('idCompania')
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
         if(isset($request['accion']) and $request['accion'] == 'imprimir')
        {
            $procedimiento = DB::select ("SELECT nombreProceso,nombreProcedimiento,fechaElaboracionProcedimiento,objetivoProcedimiento,alcanceProcedimiento,responsabilidadProcedimiento from procedimiento p LEFT JOIN proceso pr ON pr.idProceso = p.Proceso_idProceso WHERE idProcedimiento = ".$id." AND p.Compania_idCompania = ".\Session::get("idCompania"));

          
            $procedimientoDetalle = DB::select("SELECT actividadProcedimientoDetalle,nombreCompletoTercero,nombreDocumento from procedimientodetalle pd LEFT JOIN tercero t ON t.idTercero = pd.Tercero_idResponsable LEFT JOIN documento d ON d.idDocumento = pd.Documento_idDocumento WHERE Procedimiento_idProcedimiento =  ".$id);

            
            return view('formatos.procedimientoimpresion',compact('procedimiento','procedimientoDetalle'));
       } 
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
        $procesos = \App\Proceso::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('nombreProceso','idProceso');

        $idTercero = \App\Tercero::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('idTercero');
        $nombreCompletoTercero = \App\Tercero::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('nombreCompletoTercero');

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
