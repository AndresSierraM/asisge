<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\EquipoSeguimientoVerificacionRequest;
use App\Http\Controllers\Controller;
use DB;
use Input;
use File;

include public_path().'/ajax/consultarPermisos.php';

class EquipoSeguimientoVerificacionController extends Controller
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
            return view('equiposeguimientoverificaciongrid', compact('datos'));
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

         $EquipoSeguimientoE = \App\EquipoSeguimiento::where('Compania_idCompania', "=", \Session::get('idCompania'))->lists('nombreEquipoSeguimiento','idEquipoSeguimiento'); 
        
         return view('equiposeguimientoverificacion',compact('EquipoSeguimientoE'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(EquipoSeguimientoVerificacionRequest $request)
    {
       if($request['respuesta'] != 'falso')
        {  
          \App\EquipoSeguimientoVerificacion::create([
                'fechaEquipoSeguimientoVerificacion' => $request['fechaEquipoSeguimientoVerificacion'],
                'EquipoSeguimiento_idEquipoSeguimiento' => $request['EquipoSeguimiento_idEquipoSeguimiento'],
                'EquipoSeguimientoDetalle_idEquipoSeguimientoDetalle' => $request['EquipoSeguimientoDetalle_idEquipoSeguimientoDetalle'],
                'errorEncontradoEquipoSeguimientoVerificacion' => $request['errorEncontradoEquipoSeguimientoVerificacion'],
                'resultadoEquipoSeguimientoVerificacion' => $request['resultadoEquipoSeguimientoVerificacion'],
                'accionEquipoSeguimientoVerificacion' => $request['accionEquipoSeguimientoVerificacion']
                ]);

        }
          return redirect('/equiposeguimientoverificacion');
    }
    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id, Request $request)
    {
      
      if($_GET['accion'] == 'imprimir')
        {


            // Se llama los registros para saber  cual es  la que va a imprimir el usuario
           $equiposeguimientoverificacion = \App\EquipoSeguimientoVerificacion::find($id);


              $EquipoSeguimientoVerificacionEncabezadoS = DB::select('
                SELECT esv.idEquipoSeguimientoVerificacion,esv.fechaEquipoSeguimientoVerificacion,es.nombreEquipoSeguimiento,t.nombreCompletoTercero,esd.identificacionEquipoSeguimientoDetalle,esv.errorEncontradoEquipoSeguimientoVerificacion,esv.resultadoEquipoSeguimientoVerificacion,esv.accionEquipoSeguimientoVerificacion
                FROM equiposeguimientoverificacion esv
                LEFT JOIN equiposeguimiento es
                ON esv.EquipoSeguimiento_idEquipoSeguimiento = es.idEquipoSeguimiento
                LEFT JOIN tercero t  
                ON es.Tercero_idResponsable = t.idTercero
                LEFT JOIN equiposeguimientodetalle esd
                ON esv.EquipoSeguimientoDetalle_idEquipoSeguimientoDetalle = esd.idEquipoSeguimientoDetalle
                WHERE   esv.idEquipoSeguimientoVerificacion = '.$id);


             return view('formatos.equiposeguimientoverificacionimpresion',compact('EquipoSeguimientoVerificacionEncabezadoS'));
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
        $equiposeguimientoverificacion = \App\EquipoSeguimientoVerificacion::find($id);
        $EquipoSeguimientoE = \App\EquipoSeguimiento::where('Compania_idCompania', "=", \Session::get('idCompania'))->lists('nombreEquipoSeguimiento','idEquipoSeguimiento');  

        return view('equiposeguimientoverificacion',compact('EquipoSeguimientoE'),['equiposeguimientoverificacion'=>$equiposeguimientoverificacion]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(EquipoSeguimientoVerificacionRequest $request, $id)
    {
       if($request['respuesta'] != 'falso')
        {

          $equiposeguimientoverificacion = \App\EquipoSeguimientoVerificacion::find($id);
          $equiposeguimientoverificacion->fill($request->all());      
          $equiposeguimientoverificacion->EquipoSeguimiento_idEquipoSeguimiento = (($request['EquipoSeguimiento_idEquipoSeguimiento'] == '' or $request['EquipoSeguimiento_idEquipoSeguimiento'] == 0) ? null : $request['EquipoSeguimiento_idEquipoSeguimiento'
                ]);
          $equiposeguimientoverificacion->save();
            
        }
  
          
      return redirect('/equiposeguimientoverificacion');
    }
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        \App\EquipoSeguimientoVerificacion::destroy($id);
        return redirect('/equiposeguimientoverificacion');
    }

    

}

