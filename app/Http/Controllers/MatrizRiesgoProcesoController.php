<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\MatrizRiesgoProcesoRequest;
use App\Http\Controllers\Controller;
use DB;
use Input;
use File;
use Validator;
use Response;
use Excel;
include public_path().'/ajax/consultarPermisos.php';

class MatrizRiesgoProcesoController extends Controller
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
            return view('matrizriesgoprocesogrid', compact('datos'));
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
        
        return view('matrizriesgoproceso',compact('idTercero','NombreTercero','Tercero','Proceso'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(MatrizRiesgoProcesoRequest $request)
    {
       if($request['respuesta'] != 'falso')
        {  

            \App\MatrizRiesgoProceso::create([
                'fechaMatrizRiesgoProceso' => $request['fechaMatrizRiesgoProceso'],
                'Tercero_idRespondable' => $request['Tercero_idRespondable'],
                'Proceso_idProceso' => $request['Proceso_idProceso'],
                'Compania_idCompania' => \Session::get('idCompania')
                ]);

             // en esta parte es el guardado de la multiregistro descripcion
           //Primero consultar el ultimo id guardado
           $matrizriesgoproceso = \App\MatrizRiesgoProceso::All()->last();
           //for para guardar cada registro de la multiregistro

           for ($i=0; $i < count($request['descripcionMatrizRiesgoProcesoDetalle']); $i++) 
           { 
               \App\MatrizRiesgoProcesoDetalle::create([
              'MatrizRiesgoProceso_idMatrizRiesgoProceso' => $matrizriesgoproceso->idMatrizRiesgoProceso,
              'descripcionMatrizRiesgoProcesoDetalle' => $request['descripcionMatrizRiesgoProcesoDetalle'][$i],
              'efectoMatrizRiesgoProcesoDetalle' => $request['efectoMatrizRiesgoProcesoDetalle'][$i],
              'frecuenciaMatrizRiesgoProcesoDetalle' => $request['frecuenciaMatrizRiesgoProcesoDetalle'][$i],
              'impactoMatrizRiesgoProcesoDetalle' => $request['impactoMatrizRiesgoProcesoDetalle'][$i],
              'nivelValorMatrizRiesgoProcesoDetalle' => $request['nivelValorMatrizRiesgoProcesoDetalle'][$i],
              'interpretacionValorMatrizRiesgoProcesoDetalle' => $request['interpretacionValorMatrizRiesgoProcesoDetalle'][$i],
              'accionesMatrizRiesgoProcesoDetalle' => $request['accionesMatrizRiesgoProcesoDetalle'][$i],
              'descripcionAccionMatrizRiesgoProcesoDetalle' => $request['descripcionAccionMatrizRiesgoProcesoDetalle'][$i],
              'Tercero_idResponsableAccion' => ($request['Tercero_idResponsableAccion'][$i] == '' ? NULL : $request['Tercero_idResponsableAccion'][$i]),              
              'seguimientoMatrizRiesgoProcesoDetalle' => $request['seguimientoMatrizRiesgoProcesoDetalle'][$i],
              'fechaSeguimientoMatrizRiesgoProcesoDetalle' => $request['fechaSeguimientoMatrizRiesgoProcesoDetalle'][$i],
              'fechaCierreMatrizRiesgoProcesoDetalle' => $request['fechaCierreMatrizRiesgoProcesoDetalle'][$i],
              'eficazMatrizRiesgoProcesoDetalle' => $request['eficazMatrizRiesgoProcesoDetalle'][$i]
              ]);
           }

        }

      
          return redirect('/matrizriesgoproceso');
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
           $matrizriesgoproceso = \App\MatrizRiesgoProceso::find($id);

            $MatrizRiesgoProcesoEncabezado = DB::select('
            SELECT mrp.fechaMatrizRiesgoProceso,t.nombreCompletoTercero,p.nombreProceso,mrp.idMatrizRiesgoProceso
            FROM matrizriesgoproceso mrp
            LEFT JOIN tercero t
            ON mrp.Tercero_idRespondable = t.idTercero
            LEFT JOIN proceso p
            ON mrp.Proceso_idProceso = p.idProceso
            WHERE mrp.idMatrizRiesgoProceso = '.$id);



            $MatrizRiesgoProcesoDetalle = DB::select('
              SELECT mrpd.idMatrizRiesgoProcesoDetalle,mrpd.MatrizRiesgoProceso_idMatrizRiesgoProceso,mrpd.descripcionMatrizRiesgoProcesoDetalle,mrpd.efectoMatrizRiesgoProcesoDetalle,mrpd.frecuenciaMatrizRiesgoProcesoDetalle,mrpd.impactoMatrizRiesgoProcesoDetalle,
              mrpd.nivelValorMatrizRiesgoProcesoDetalle,mrpd.interpretacionValorMatrizRiesgoProcesoDetalle,
              mrpd.accionesMatrizRiesgoProcesoDetalle,mrpd.descripcionAccionMatrizRiesgoProcesoDetalle,
              t.nombreCompletoTercero,mrpd.seguimientoMatrizRiesgoProcesoDetalle,mrpd.fechaSeguimientoMatrizRiesgoProcesoDetalle,
              mrpd.fechaCierreMatrizRiesgoProcesoDetalle,mrpd.eficazMatrizRiesgoProcesoDetalle
              FROM matrizriesgoprocesodetalle mrpd
              LEFT JOIN tercero t
              ON mrpd.Tercero_idResponsableAccion = t.idTercero
              where mrpd.MatrizRiesgoProceso_idMatrizRiesgoProceso ='.$id);


            return view('formatos.matrizriesgoprocesoimpresion',compact('MatrizRiesgoProcesoEncabezado','MatrizRiesgoProcesoDetalle'));
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
        $matrizriesgoproceso = \App\MatrizRiesgoProceso::find($id);

        $idTercero = \App\Tercero::where('tipoTercero', "like", "%*01*%")->where('Compania_idCompania', "=", \Session::get('idCompania'))->lists('idTercero');
        $NombreTercero = \App\Tercero::where('tipoTercero', "like", "%*01*%")->where('Compania_idCompania', "=", \Session::get('idCompania'))->lists('nombreCompletoTercero');
        $Tercero = \App\Tercero::where('tipoTercero', "like", "%*01*%")->where('Compania_idCompania', "=", \Session::get('idCompania'))->lists('nombreCompletoTercero','idTercero');      
        $Proceso = \App\Proceso::where('Compania_idCompania', "=", \Session::get('idCompania'))->lists('nombreProceso','idProceso');


        // Consulta para devolver los datos a la multiregistro
        $MatrizRiesgoProcesoDetalleS  = DB::SELECT('
        SELECT mrd.idMatrizRiesgoProcesoDetalle,mrd.MatrizRiesgoProceso_idMatrizRiesgoProceso,mrd.descripcionMatrizRiesgoProcesoDetalle,
        mrd.efectoMatrizRiesgoProcesoDetalle,mrd.frecuenciaMatrizRiesgoProcesoDetalle,mrd.impactoMatrizRiesgoProcesoDetalle,
        mrd.nivelValorMatrizRiesgoProcesoDetalle,mrd.interpretacionValorMatrizRiesgoProcesoDetalle,mrd.accionesMatrizRiesgoProcesoDetalle,
        mrd.descripcionAccionMatrizRiesgoProcesoDetalle,mrd.Tercero_idResponsableAccion,mrd.seguimientoMatrizRiesgoProcesoDetalle,
        mrd.fechaSeguimientoMatrizRiesgoProcesoDetalle,mrd.fechaCierreMatrizRiesgoProcesoDetalle,mrd.eficazMatrizRiesgoProcesoDetalle
        FROM matrizriesgoprocesodetalle mrd
        LEFT JOIN matrizriesgoproceso mrp
        ON mrd.MatrizRiesgoProceso_idMatrizRiesgoProceso = mrp.idMatrizRiesgoProceso
        LEFT JOIN tercero t
        ON mrd.Tercero_idResponsableAccion = t.idTercero
        where mrd.MatrizRiesgoProceso_idMatrizRiesgoProceso ='.$id);

        
    

        return view('matrizriesgoproceso',compact('MatrizRiesgoProcesoDetalleS','idTercero','NombreTercero','Tercero','Proceso'),['matrizriesgoproceso'=>$matrizriesgoproceso]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(MatrizRiesgoProcesoRequest $request, $id)
    {
       if($request['respuesta'] != 'falso')
        {
          $matrizriesgoproceso = \App\MatrizRiesgoProceso::find($id);
          $matrizriesgoproceso->fill($request->all());      
          $matrizriesgoproceso->Tercero_idRespondable = (($request['Tercero_idRespondable'] == '' or $request['Tercero_idRespondable'] == 0) ? null : $request['Tercero_idRespondable'
                ]);
          $matrizriesgoproceso->Proceso_idProceso = (($request['Proceso_idProceso'] == '' or $request['Proceso_idProceso'] == 0) ? null : $request['Proceso_idProceso'
                ]);
          $matrizriesgoproceso->save();


          // Update para el detalle de matriz riesgo proceso
             $idsEliminar = explode("," , $request['eliminarproceso']);
            //Eliminar registros de la multiregistro
            \App\MatrizRiesgoProcesoDetalle::whereIn('idMatrizRiesgoProcesoDetalle', $idsEliminar)->delete();
            // Guardamos el detalle de los modulos
            for($i = 0; $i < count($request['idMatrizRiesgoProcesoDetalle']); $i++)
            {
                 $indice = array(
                    'idMatrizRiesgoProcesoDetalle' => $request['idMatrizRiesgoProcesoDetalle'][$i]);

                $data = array(
                  'MatrizRiesgoProceso_idMatrizRiesgoProceso' => $matrizriesgoproceso->idMatrizRiesgoProceso,
                  'descripcionMatrizRiesgoProcesoDetalle' => $request['descripcionMatrizRiesgoProcesoDetalle'][$i],
                  'efectoMatrizRiesgoProcesoDetalle' => $request['efectoMatrizRiesgoProcesoDetalle'][$i],
                  'frecuenciaMatrizRiesgoProcesoDetalle' => $request['frecuenciaMatrizRiesgoProcesoDetalle'][$i],
                  'impactoMatrizRiesgoProcesoDetalle' => $request['impactoMatrizRiesgoProcesoDetalle'][$i],
                  'nivelValorMatrizRiesgoProcesoDetalle' => $request['nivelValorMatrizRiesgoProcesoDetalle'][$i],
                  'interpretacionValorMatrizRiesgoProcesoDetalle' => $request['interpretacionValorMatrizRiesgoProcesoDetalle'][$i],
                  'accionesMatrizRiesgoProcesoDetalle' => $request['accionesMatrizRiesgoProcesoDetalle'][$i],
                  'descripcionAccionMatrizRiesgoProcesoDetalle' => $request['descripcionAccionMatrizRiesgoProcesoDetalle'][$i],
                  'Tercero_idResponsableAccion' => ($request['Tercero_idResponsableAccion'][$i] == '' ? NULL : $request['Tercero_idResponsableAccion'][$i]),
                  'seguimientoMatrizRiesgoProcesoDetalle' => $request['seguimientoMatrizRiesgoProcesoDetalle'][$i],
                  'fechaSeguimientoMatrizRiesgoProcesoDetalle' => $request['fechaSeguimientoMatrizRiesgoProcesoDetalle'][$i],
                  'fechaCierreMatrizRiesgoProcesoDetalle' => $request['fechaCierreMatrizRiesgoProcesoDetalle'][$i],
                  'eficazMatrizRiesgoProcesoDetalle' => $request['eficazMatrizRiesgoProcesoDetalle'][$i]
                  );

                $guardar = \App\MatrizRiesgoProcesoDetalle::updateOrCreate($indice, $data);
            } 
        }
  
          
      return redirect('/matrizriesgoproceso');
    }
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        \App\MatrizRiesgoProceso::destroy($id);
        return redirect('/matrizriesgoproceso');
    }

    

}

