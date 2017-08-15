<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\EquipoSeguimientoRequest;
use App\Http\Controllers\Controller;
use DB;
use Input;
use File;
use Validator;
use Response;
use Excel;
include public_path().'/ajax/consultarPermisos.php';

class EquipoSeguimientoController extends Controller
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
            return view('equiposeguimientogrid', compact('datos'));
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
        $idTercero = \App\Tercero::where('tipoTercero', "like", "%*01*%")->where('Compania_idCompania', "=", \Session::get('idCompania'))->lists('idTercero');
        $NombreTercero = \App\Tercero::where('tipoTercero', "like", "%*01*%")->where('Compania_idCompania', "=", \Session::get('idCompania'))->lists('nombreCompletoTercero');
        $Tercero = \App\Tercero::where('tipoTercero', "like", "%*01*%")->where('Compania_idCompania', "=", \Session::get('idCompania'))->lists('nombreCompletoTercero','idTercero');      
        $Proceso = \App\Proceso::where('Compania_idCompania', "=", \Session::get('idCompania'))->lists('nombreProceso','idProceso');

        $idFrecuenciaMedicion = \App\FrecuenciaMedicion::All()->lists('idFrecuenciaMedicion'); 

        $nombreFrecuenciaMedicion = \App\FrecuenciaMedicion::All()->lists('nombreFrecuenciaMedicion'); 
        
        return view('equiposeguimiento',compact('idTercero','NombreTercero','Tercero','Proceso','idFrecuenciaMedicion','nombreFrecuenciaMedicion'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(EquipoSeguimientoRequest $request)
    {
       if($request['respuesta'] != 'falso')
        {  
            \App\EquipoSeguimiento::create([
                'fechaEquipoSeguimiento' => $request['fechaEquipoSeguimiento'],
                'nombreEquipoSeguimiento' => $request['nombreEquipoSeguimiento'],
                'Tercero_idResponsable' => $request['Tercero_idResponsable'],
                'Compania_idCompania' => \Session::get('idCompania')
                ]);



             // en esta parte es el guardado de la multiregistro descripcion
           //Primero consultar el ultimo id guardado
           $equiposeguimiento = \App\EquipoSeguimiento::All()->last();
           //for para guardar cada registro de la multiregistro

        for ($i=0; $i < count($request['identificacionEquipoSeguimientoDetalle']); $i++) 
           { 
               \App\EquipoSeguimientoDetalle::create([
              'EquipoSeguimiento_idEquipoSeguimiento' => $equiposeguimiento->idEquipoSeguimiento,
              'identificacionEquipoSeguimientoDetalle' => $request['identificacionEquipoSeguimientoDetalle'][$i],
              'tipoEquipoSeguimientoDetalle' => $request['tipoEquipoSeguimientoDetalle'][$i],
              'FrecuenciaMedicion_idCalibracion' => ($request['FrecuenciaMedicion_idCalibracion'][$i] == '' ? NULL : $request['FrecuenciaMedicion_idCalibracion'][$i]),
              'fechaInicioCalibracionEquipoSeguimientoDetalle' => $request['fechaInicioCalibracionEquipoSeguimientoDetalle'][$i],
              'FrecuenciaMedicion_idVerificacion' => ($request['FrecuenciaMedicion_idVerificacion'][$i] == '' ? NULL : $request['FrecuenciaMedicion_idVerificacion'][$i]),
              'fechaInicioVerificacionEquipoSeguimientoDetalle' => $request['fechaInicioVerificacionEquipoSeguimientoDetalle'][$i],
              'unidadMedidaCalibracionEquipoSeguimientoDetalle' => $request['unidadMedidaCalibracionEquipoSeguimientoDetalle'][$i],
              'rangoInicialCalibracionEquipoSeguimientoDetalle' => $request['rangoInicialCalibracionEquipoSeguimientoDetalle'][$i],              
              'rangoFinalCalibracionEquipoSeguimientoDetalle' => $request['rangoFinalCalibracionEquipoSeguimientoDetalle'][$i],
              'escalaCalibracionEquipoSeguimientoDetalle' => $request['escalaCalibracionEquipoSeguimientoDetalle'][$i],
              'capacidadInicialCalibracionEquipoSeguimientoDetalle' => $request['capacidadInicialCalibracionEquipoSeguimientoDetalle'][$i],
              'capacidadFinalCalibracionEquipoSeguimientoDetalle' => $request['capacidadFinalCalibracionEquipoSeguimientoDetalle'][$i],
              'utilizacionCalibracionEquipoSeguimientoDetalle' => $request['utilizacionCalibracionEquipoSeguimientoDetalle'][$i],
              'toleranciaCalibracionEquipoSeguimientoDetalle' => $request['toleranciaCalibracionEquipoSeguimientoDetalle'][$i],
              'errorPermitidoCalibracionEquipoSeguimientoDetalle' => $request['errorPermitidoCalibracionEquipoSeguimientoDetalle'][$i]
              ]);
           }
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
      
        
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {   
        $equiposeguimiento = \App\EquipoSeguimiento::find($id);
        $idTercero = \App\Tercero::where('tipoTercero', "like", "%*01*%")->where('Compania_idCompania', "=", \Session::get('idCompania'))->lists('idTercero');
        $NombreTercero = \App\Tercero::where('tipoTercero', "like", "%*01*%")->where('Compania_idCompania', "=", \Session::get('idCompania'))->lists('nombreCompletoTercero');
        $Tercero = \App\Tercero::where('tipoTercero', "like", "%*01*%")->where('Compania_idCompania', "=", \Session::get('idCompania'))->lists('nombreCompletoTercero','idTercero');      
        $Proceso = \App\Proceso::where('Compania_idCompania', "=", \Session::get('idCompania'))->lists('nombreProceso','idProceso');
        $idFrecuenciaMedicion = \App\FrecuenciaMedicion::All()->lists('idFrecuenciaMedicion'); 
        $nombreFrecuenciaMedicion = \App\FrecuenciaMedicion::All()->lists('nombreFrecuenciaMedicion'); 


        $EquipoSeguimientoDetalleE = DB::SELECT('
             SELECT esd.idEquipoSeguimientoDetalle,esd.EquipoSeguimiento_idEquipoSeguimiento,esd.identificacionEquipoSeguimientoDetalle,esd.tipoEquipoSeguimientoDetalle,
        esd.FrecuenciaMedicion_idCalibracion,esd.fechaInicioCalibracionEquipoSeguimientoDetalle,esd.FrecuenciaMedicion_idVerificacion,esd.fechaInicioVerificacionEquipoSeguimientoDetalle,esd.unidadMedidaCalibracionEquipoSeguimientoDetalle,esd.rangoInicialCalibracionEquipoSeguimientoDetalle,esd.rangoFinalCalibracionEquipoSeguimientoDetalle,esd.escalaCalibracionEquipoSeguimientoDetalle,esd.capacidadInicialCalibracionEquipoSeguimientoDetalle,esd.capacidadFinalCalibracionEquipoSeguimientoDetalle,esd.utilizacionCalibracionEquipoSeguimientoDetalle,esd.toleranciaCalibracionEquipoSeguimientoDetalle,esd.errorPermitidoCalibracionEquipoSeguimientoDetalle
        FROM equiposeguimientodetalle esd
        LEFT JOIN equiposeguimiento es
        ON esd.EquipoSeguimiento_idEquipoSeguimiento = es.idEquipoSeguimiento
        LEFT JOIN frecuenciamedicion fm
        ON esd.FrecuenciaMedicion_idCalibracion = fm.idFrecuenciaMedicion
        LEFT JOIN frecuenciamedicion fv
        ON esd.FrecuenciaMedicion_idVerificacion = fv.idFrecuenciaMedicion
        WHERE esd.EquipoSeguimiento_idEquipoSeguimiento ='.$id);

        return view('equiposeguimiento',compact('EquipoSeguimientoDetalleE','idTercero','NombreTercero','Tercero','Proceso','idFrecuenciaMedicion','nombreFrecuenciaMedicion'),['equiposeguimiento'=>$equiposeguimiento]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(EquipoSeguimientoRequest $request, $id)
    {
       if($request['respuesta'] != 'falso')
        {
          $equiposeguimiento = \App\EquipoSeguimiento::find($id);
          $equiposeguimiento->fill($request->all());      
          $equiposeguimiento->Tercero_idResponsable = (($request['Tercero_idResponsable'] == '' or $request['Tercero_idResponsable'] == 0) ? null : $request['Tercero_idResponsable'
                ]);
          $equiposeguimiento->save();

                // Update para el detalle de matriz riesgo proceso
             $idsEliminar = explode("," , $request['eliminarseguimiento']);
            //Eliminar registros de la multiregistro
            \App\EquipoSeguimientoDetalle::whereIn('idEquipoSeguimientoDetalle', $idsEliminar)->delete();
            // Guardamos el detalle de los modulos
            for($i = 0; $i < count($request['idEquipoSeguimientoDetalle']); $i++)
            {
                 $indice = array(
                    'idEquipoSeguimientoDetalle' => $request['idEquipoSeguimientoDetalle'][$i]);

                $data = array(
                  'EquipoSeguimiento_idEquipoSeguimiento' => $equiposeguimiento->idEquipoSeguimiento,
                    'identificacionEquipoSeguimientoDetalle' => $request['identificacionEquipoSeguimientoDetalle'][$i],
                    'tipoEquipoSeguimientoDetalle' => $request['tipoEquipoSeguimientoDetalle'][$i],
                    'FrecuenciaMedicion_idCalibracion' => ($request['FrecuenciaMedicion_idCalibracion'][$i] == '' ? NULL : $request['FrecuenciaMedicion_idCalibracion'][$i]),
                    'fechaInicioCalibracionEquipoSeguimientoDetalle' => $request['fechaInicioCalibracionEquipoSeguimientoDetalle'][$i],
                    'FrecuenciaMedicion_idVerificacion' => ($request['FrecuenciaMedicion_idVerificacion'][$i] == '' ? NULL : $request['FrecuenciaMedicion_idVerificacion'][$i]),
                    'fechaInicioVerificacionEquipoSeguimientoDetalle' => $request['fechaInicioVerificacionEquipoSeguimientoDetalle'][$i],
                    'unidadMedidaCalibracionEquipoSeguimientoDetalle' => $request['unidadMedidaCalibracionEquipoSeguimientoDetalle'][$i],
                    'rangoInicialCalibracionEquipoSeguimientoDetalle' => $request['rangoInicialCalibracionEquipoSeguimientoDetalle'][$i],              
                    'rangoFinalCalibracionEquipoSeguimientoDetalle' => $request['rangoFinalCalibracionEquipoSeguimientoDetalle'][$i],
                    'escalaCalibracionEquipoSeguimientoDetalle' => $request['escalaCalibracionEquipoSeguimientoDetalle'][$i],
                    'capacidadInicialCalibracionEquipoSeguimientoDetalle' => $request['capacidadInicialCalibracionEquipoSeguimientoDetalle'][$i],
                    'capacidadFinalCalibracionEquipoSeguimientoDetalle' => $request['capacidadFinalCalibracionEquipoSeguimientoDetalle'][$i],
                    'utilizacionCalibracionEquipoSeguimientoDetalle' => $request['utilizacionCalibracionEquipoSeguimientoDetalle'][$i],
                    'toleranciaCalibracionEquipoSeguimientoDetalle' => $request['toleranciaCalibracionEquipoSeguimientoDetalle'][$i],
                    'errorPermitidoCalibracionEquipoSeguimientoDetalle' => $request['errorPermitidoCalibracionEquipoSeguimientoDetalle'][$i]
                  );

                $guardar = \App\EquipoSeguimientoDetalle::updateOrCreate($indice, $data);
            } 
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

