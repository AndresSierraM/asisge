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

class VerificacionEquipoSeguimientoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    
    public function index()
    {
        //  $vista = basename($_SERVER["PHP_SELF"]);
        // $datos = consultarPermisos($vista);

        // if($datos != null)
            return view('verificacionequiposeguimiento', compact('datos'));
        // else
        //   return view('accesodenegado');
    }

  


    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {

         $EquipoSeguimientoE = \App\EquipoSeguimiento::where('Compania_idCompania', "=", \Session::get('idCompania'))->lists('nombreEquipoSeguimiento','idEquipoSeguimiento'); 
        // $idTercero = \App\Tercero::where('tipoTercero', "like", "%*01*%")->where('Compania_idCompania', "=", \Session::get('idCompania'))->lists('idTercero');
        // $NombreTercero = \App\Tercero::where('tipoTercero', "like", "%*01*%")->where('Compania_idCompania', "=", \Session::get('idCompania'))->lists('nombreCompletoTercero');
        // $Tercero = \App\Tercero::where('tipoTercero', "like", "%*01*%")->where('Compania_idCompania', "=", \Session::get('idCompania'))->lists('nombreCompletoTercero','idTercero');      
        // $Proceso = \App\Proceso::where('Compania_idCompania', "=", \Session::get('idCompania'))->lists('nombreProceso','idProceso');

        // $idFrecuenciaMedicion = \App\FrecuenciaMedicion::All()->lists('idFrecuenciaMedicion'); 

        // $nombreFrecuenciaMedicion = \App\FrecuenciaMedicion::All()->lists('nombreFrecuenciaMedicion'); 
        
         return view('verificacionequiposeguimiento',compact('EquipoSeguimientoE'));
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
         
        }
          return redirect('/equiposeguimiento');
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
        // $equiposeguimiento = \App\EquipoSeguimiento::find($id);
        // $idTercero = \App\Tercero::where('tipoTercero', "like", "%*01*%")->where('Compania_idCompania', "=", \Session::get('idCompania'))->lists('idTercero');
        // $NombreTercero = \App\Tercero::where('tipoTercero', "like", "%*01*%")->where('Compania_idCompania', "=", \Session::get('idCompania'))->lists('nombreCompletoTercero');
        // $Tercero = \App\Tercero::where('tipoTercero', "like", "%*01*%")->where('Compania_idCompania', "=", \Session::get('idCompania'))->lists('nombreCompletoTercero','idTercero');      
        // $Proceso = \App\Proceso::where('Compania_idCompania', "=", \Session::get('idCompania'))->lists('nombreProceso','idProceso');
        // $idFrecuenciaMedicion = \App\FrecuenciaMedicion::All()->lists('idFrecuenciaMedicion'); 
        // $nombreFrecuenciaMedicion = \App\FrecuenciaMedicion::All()->lists('nombreFrecuenciaMedicion'); 


        // $EquipoSeguimientoDetalleE = DB::SELECT('
        //      SELECT esd.idEquipoSeguimientoDetalle,esd.EquipoSeguimiento_idEquipoSeguimiento,esd.identificacionEquipoSeguimientoDetalle,esd.tipoEquipoSeguimientoDetalle,
        // esd.FrecuenciaMedicion_idCalibracion,esd.fechaInicioCalibracionEquipoSeguimientoDetalle,esd.FrecuenciaMedicion_idVerificacion,esd.fechaInicioVerificacionEquipoSeguimientoDetalle,esd.unidadMedidaCalibracionEquipoSeguimientoDetalle,esd.rangoInicialCalibracionEquipoSeguimientoDetalle,esd.rangoFinalCalibracionEquipoSeguimientoDetalle,esd.escalaCalibracionEquipoSeguimientoDetalle,esd.capacidadInicialCalibracionEquipoSeguimientoDetalle,esd.capacidadFinalCalibracionEquipoSeguimientoDetalle,esd.utilizacionCalibracionEquipoSeguimientoDetalle,esd.toleranciaCalibracionEquipoSeguimientoDetalle,esd.errorPermitidoCalibracionEquipoSeguimientoDetalle
        // FROM equiposeguimientodetalle esd
        // LEFT JOIN equiposeguimiento es
        // ON esd.EquipoSeguimiento_idEquipoSeguimiento = es.idEquipoSeguimiento
        // LEFT JOIN frecuenciamedicion fm
        // ON esd.FrecuenciaMedicion_idCalibracion = fm.idFrecuenciaMedicion
        // LEFT JOIN frecuenciamedicion fv
        // ON esd.FrecuenciaMedicion_idVerificacion = fv.idFrecuenciaMedicion
        // WHERE esd.EquipoSeguimiento_idEquipoSeguimiento ='.$id);

        // return view('equiposeguimiento',compact('EquipoSeguimientoDetalleE','idTercero','NombreTercero','Tercero','Proceso','idFrecuenciaMedicion','nombreFrecuenciaMedicion'),['equiposeguimiento'=>$equiposeguimiento]);
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
          
            
        }
  
          
      return redirect('/equiposeguimiento');
    }
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        \App\EquipoSeguimiento::destroy($id);
        return redirect('/equiposeguimiento');
    }

    

}

