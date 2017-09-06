<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
// use App\Http\Requests\EquipoSeguimientoRequest;
use App\Http\Controllers\Controller;
use DB;
use Input;
use File;
// use Validator;
// use Response;
// use Excel;
include public_path().'/ajax/consultarPermisos.php';

class EquipoSeguimientoControllerVerificacion extends Controller
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
    public function store(Request $request)
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

            // return view('formatos.equiposeguimientoimpresion',compact('EquipoSeguimientoEncabezadoS','EquipoSeguimientoDetalleS'));
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
    public function update(Request $request, $id)
    {
       if($request['respuesta'] != 'falso')
        {
        $equiposeguimientoverificacion = \App\EquipoSeguimientoVerificacion::find($id);

        $EquipoSeguimientoE = \App\EquipoSeguimiento::where('Compania_idCompania', "=", \Session::get('idCompania'))->lists('nombreEquipoSeguimiento','idEquipoSeguimiento');

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

