<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\evaluaciondesempenioRequest;
use App\Http\Controllers\Controller;
 
use DB;
include public_path().'/ajax/consultarPermisos.php';

class EvaluacionDesempenioController extends Controller
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
          return view('evaluaciondesempeniogrid', compact('datos'));
         else
            return view('accesodenegado');
        
         // return view('evaluaciondesempenio');

     }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $idTerceroResponsable = \App\Tercero::where('tipoTercero', "like", "%*01*%")->where('Compania_idCompania', "=", \Session::get('idCompania'))->lists('idTercero');
        $nombreTerceroResponsable = \App\Tercero::where('tipoTercero', "like", "%*01*%")->where('Compania_idCompania', "=", \Session::get('idCompania'))->lists('nombreCompletoTercero');
        
        $idDocumentoSoporte = \App\DocumentoSoporte::All()->lists('idDocumentoSoporte');
        $nombreDocumentoSoporte = \App\DocumentoSoporte::All()->lists('nombreDocumentoSoporte');

        $idHabilidad = \App\PerfilCargo::where('tipoPerfilCargo','=','Habilidad')->lists('idPerfilCargo');
        $nombreHabilidad = \App\PerfilCargo::where('tipoPerfilCargo','=','Habilidad')->lists('nombrePerfilCargo');

        $idFormacion = \App\PerfilCargo::where('tipoPerfilCargo','=','Formacion')->lists('idPerfilCargo');
        $nombreFormacion = \App\PerfilCargo::where('tipoPerfilCargo','=','Formacion')->lists('nombrePerfilCargo');

        $idEducacion = \App\PerfilCargo::where('tipoPerfilCargo','=','Educacion')->lists('idPerfilCargo');
        $nombreEducacion = \App\PerfilCargo::where('tipoPerfilCargo','=','Educacion')->lists('nombrePerfilCargo');

         $idRespuesta  = \App\CompetenciaRespuesta::All()->lists('idCompetenciaRespuesta');
        $nombreRespuesta  = \App\CompetenciaRespuesta::All()->lists('respuestaCompetenciaRespuesta');
        
        $Tercero_idEmpleado = \App\Tercero::where('tipoTercero', "like", "%*01*%")->where('Compania_idCompania', "=", \Session::get('idCompania'))->lists('nombreCompletoTercero','idTercero'); 

        $Tercero_idResponsable = \App\Tercero::where('tipoTercero', "like", "%*01*%")->where('Compania_idCompania', "=", \Session::get('idCompania'))->lists('nombreCompletoTercero','idTercero'); 

       $idModulo= \App\Modulo::All()->lists('idModulo');
       $nombreModulo= \App\Modulo::All()->lists('nombreModulo');


           return view ('evaluaciondesempenio', compact('idTerceroResponsable','nombreTerceroResponsable','nombreDocumentoSoporte','idDocumentoSoporte','idHabilidad','nombreHabilidad','idFormacion','nombreFormacion','idEducacion','nombreEducacion','idRespuesta','nombreRespuesta','Tercero_idEmpleado','Tercero_idResponsable','idModulo','nombreModulo'));
    
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(evaluaciondesempenioRequest $request)
    {
    
       \App\EvaluacionDesempenio::create([
            'Tercero_idEmpleado' => $request['Tercero_idEmpleado'],
            'Cargo_idCargo' => $request['Cargo_idCargo'],
            'Tercero_idResponsable' => $request['Tercero_idResponsable'],
            'fechaElaboracionEvaluacionDesempenio' => $request['fechaElaboracionEvaluacionDesempenio'],
            'observacionEvaluacionDesempenio' => $request['observacionEvaluacionDesempenio']
            ]);

       
         
       // en esta parte es el guardado de la multiregistro descripcion
         //Primero consultar el ultimo id guardado
         $evaluaciondesempenio = \App\EvaluacionDesempenio::All()->last();

          // Guardado Multiregistro Responsabilidades 
            for ($i=0; $i < count($request['CargoResponsabilidad_idCargoResponsabilidad']); $i++) 
         { 
             \App\EvaluacionDesempenioResponsabilidad::create([
            'EvaluacionDesempenio_idEvaluacionDesempenio' => $evaluaciondesempenio->idEvaluacionDesempenio,
            'CargoResponsabilidad_idCargoResponsabilidad' => $request['CargoResponsabilidad_idCargoResponsabilidad'][$i],
            'respuestaEvaluacionResponsabilidad' => $request['respuestaEvaluacionResponsabilidad'][$i]
          

            ]);
         }


          // Guardado Multiregistro Educacion 
            for ($i=0; $i < count($request['calificacionEvaluacionEducacion']); $i++) 
         { 

             \App\EvaluacionDesempenioEducacion::create([
            'EvaluacionDesempenio_idEvaluacionDesempenio' => $evaluaciondesempenio->idEvaluacionDesempenio,
            'PerfilCargo_idRequerido' => $request['PerfilCargo_idRequerido_Educacion'][$i],
            'PerfilCargo_idAspirante' => $request['PerfilCargo_idAspirante_Educacion'][$i],
            'calificacionEvaluacionEducacion' => $request['calificacionEvaluacionEducacion'][$i]
          

            ]);
         }
           // Guardado Multiregistro Formacion
            for ($i=0; $i < count($request['calificacionEvaluacionFormacion']); $i++) 
         { 

             \App\EvaluacionDesempenioFormacion::create([
            'EvaluacionDesempenio_idEvaluacionDesempenio' => $evaluaciondesempenio->idEvaluacionDesempenio,
            'PerfilCargo_idRequerido' => $request['PerfilCargo_idRequerido_Formacion'][$i],
            'PerfilCargo_idAspirante' => $request['PerfilCargo_idAspirante_Formacion'][$i],
            'calificacionEvaluacionFormacion' => $request['calificacionEvaluacionFormacion'][$i]
          

            ]);
         }

           // Guardado Multiregistro Habilidad
            for ($i=0; $i < count($request['calificacionEvaluacionHabilidad']); $i++) 
         { 

             \App\EvaluacionDesempenioHabilidad::create([
            'EvaluacionDesempenio_idEvaluacionDesempenio' => $evaluaciondesempenio->idEvaluacionDesempenio,
            'PerfilCargo_idRequerido' => $request['PerfilCargo_idRequerido_Habilidad'][$i],
            'PerfilCargo_idAspirante' => $request['PerfilCargo_idAspirante_Habilidad'][$i],
            'calificacionEvaluacionHabilidad' => $request['calificacionEvaluacionHabilidad'][$i]
          

            ]);
         }

              // Guardado Multiregistro Plan Accion
            for ($i=0; $i < count($request['actividadEvaluacionAccion']); $i++) 
         { 

             \App\EvaluacionAccion::create([
            'EvaluacionDesempenio_idEvaluacionDesempenio' => $evaluaciondesempenio->idEvaluacionDesempenio,
            'actividadEvaluacionAccion' => $request['actividadEvaluacionAccion'][$i],
            'Tercero_idResponsable' => $request['Tercero_idResponsable_Accion'][$i],
            'DocumentoSoporte_idDocumentoSoporte' => $request['DocumentoSoporte_idDocumentoSoporte'][$i],
            'fechaPlaneadaEvaluacionAccion' => $request['fechaPlaneadaEvaluacionAccion'][$i],
            'fechaEjecutadaEvaluacionAccion' => $request['fechaEjecutadaEvaluacionAccion'][$i]
         

            ]);

         }
        
       
         
           return redirect('/evaluaciondesempenio');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
             if($_GET['accion'] == 'imprimir')
        {
          $evaluaciondesempenio = \App\EvaluacionDesempenio::find($id);

         $EvaluacionDesempenio = DB::select('
            SELECT 
            idEvaluacionDesempenio,te.nombreCompletoTercero as nombreEmpleado,tr.nombreCompletoTercero as nombreResponsable, nombreCargo,
            fechaElaboracionEvaluacionDesempenio,observacionEvaluacionDesempenio
            FROM evaluaciondesempenio ed
            LEFT JOIN cargo c ON ed.Cargo_idCargo = c.idCargo
            LEFT JOIN tercero te ON ed.Tercero_idEmpleado = te.idTercero
            LEFT JOIN tercero tr ON ed.Tercero_idResponsable = tr.idTercero
            WHERE idEvaluacionDesempenio = '.$id);

               // Multiregistro consulta de Evaluaciondesempenioeducacion
          $EvaluacionDesempenioResponsabilidad = DB::Select('
            SELECT idEvaluacionResponsabilidad,EvaluacionDesempenio_idEvaluacionDesempenio,descripcionCargoResponsabilidad,CargoResponsabilidad_idCargoResponsabilidad,respuestaEvaluacionResponsabilidad
            FROM  evaluacionresponsabilidad ER
            LEFT JOIN cargoresponsabilidad CR
            On ER.CargoResponsabilidad_idCargoResponsabilidad = CR.idCargoResponsabilidad 
            WHERE ER.EvaluacionDesempenio_idEvaluacionDesempenio = '.$id);

          $EvaluacionDesempenioEducacion = DB::Select('
            SELECT  idEvaluacionEducacion,Req.nombrePerfilCargo as nombrePerfilRequerido,
            Asp.nombrePerfilCargo as nombrePerfilAspirante,calificacionEvaluacionEducacion,porcentajeCargoEducacion
            FROM evaluacioneducacion EE
            LEFT JOIN evaluaciondesempenio ed
            ON EE.EvaluacionDesempenio_idEvaluacionDesempenio = ed.idEvaluacionDesempenio
            left JOIN perfilcargo Req
            ON EE.PerfilCargo_idRequerido = Req.idPerfilCargo
            LEFT JOIN perfilcargo Asp
            ON EE.PerfilCargo_idAspirante = Asp.idPerfilCargo
            LEFT JOIN cargoeducacion CE
            ON EE.PerfilCargo_idRequerido = CE.PerfilCargo_idPerfilCargo and ed.Cargo_idCargo = CE.Cargo_idCargo
            WHERE EE.EvaluacionDesempenio_idEvaluacionDesempenio = '.$id);

       


          $EvaluacionDesempenioFormacion = DB::Select('
          SELECT  idEvaluacionFormacion,Req.nombrePerfilCargo as nombrePerfilRequerido,
            Asp.nombrePerfilCargo as nombrePerfilAspirante,calificacionEvaluacionFormacion,porcentajeCargoFormacion
            FROM evaluacionformacion EF
            LEFT JOIN evaluaciondesempenio ed
            ON EF.EvaluacionDesempenio_idEvaluacionDesempenio = ed.idEvaluacionDesempenio
            left JOIN perfilcargo Req
            ON EF.PerfilCargo_idRequerido = Req.idPerfilCargo
            LEFT JOIN perfilcargo Asp
            ON EF.PerfilCargo_idAspirante = Asp.idPerfilCargo
            LEFT JOIN cargoformacion CF
            ON EF.PerfilCargo_idRequerido = CF.PerfilCargo_idPerfilCargo and ed.Cargo_idCargo = CF.Cargo_idCargo
            WHERE EF.EvaluacionDesempenio_idEvaluacionDesempenio = '.$id);

          $EvaluacionDesempenioHabilidad = DB::Select('
          SELECT  idEvaluacionHabilidad,Req.nombrePerfilCargo as nombrePerfilRequerido,
            Asp.nombrePerfilCargo as nombrePerfilAspirante,calificacionEvaluacionHabilidad,porcentajeCargoHabilidad
            FROM evaluacionhabilidad EH
            LEFT JOIN evaluaciondesempenio ed
            ON EH.EvaluacionDesempenio_idEvaluacionDesempenio = ed.idEvaluacionDesempenio
            left JOIN perfilcargo Req
            ON EH.PerfilCargo_idRequerido = Req.idPerfilCargo
            LEFT JOIN perfilcargo Asp
            ON EH.PerfilCargo_idAspirante = Asp.idPerfilCargo
            LEFT JOIN cargohabilidad CH
            ON EH.PerfilCargo_idRequerido = CH.PerfilCargo_idPerfilCargo and ed.Cargo_idCargo = CH.Cargo_idCargo
            WHERE EH.EvaluacionDesempenio_idEvaluacionDesempenio = '.$id);

          $EvaluacionAccion = DB::Select('
        
        SELECT idEvaluacionAccion,EvaluacionDesempenio_idEvaluacionDesempenio,actividadEvaluacionAccion,Tercero_idResponsable,DocumentoSoporte_idDocumentoSoporte,fechaPlaneadaEvaluacionAccion,fechaEjecutadaEvaluacionAccion,nombreCompletoTercero,nombreDocumentoSoporte
            FROM evaluacionaccion ea
            LEFT JOIN tercero t 
            ON ea.Tercero_idResponsable = t.idTercero 
            LEFT JOIN documentosoporte ds
            ON ea.DocumentoSoporte_idDocumentoSoporte = ds.idDocumentoSoporte
            WHERE  ea.EvaluacionDesempenio_idEvaluacionDesempenio = '.$id);
                 


                
            return view('formatos.imprimirEvaluacionDesempenio',compact('EvaluacionAccion','EvaluacionDesempenio','EvaluacionDesempenioResponsabilidad','EvaluacionDesempenioEducacion','EvaluacionDesempenioFormacion','EvaluacionDesempenioHabilidad'));
       } 

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
          $evaluaciondesempenio = \App\EvaluacionDesempenio::find($id);
           $cargo = \App\Cargo::find($evaluaciondesempenio->Cargo_idCargo);
          // se llama el cargo para el momento de editar 
          // $cargo = \App\Cargo::where('idCargo','=',$evaluaciondesempenio->Cargo_idCargo)->lists('nombreCargo','porcentajeResponsabilidadCargo','porcentajeEducacionCargo','porcentajeFormacionCargo','porcentajeHabilidadCargo');

        $idTerceroResponsable = \App\Tercero::where('tipoTercero', "like", "%*01*%")->where('Compania_idCompania', "=", \Session::get('idCompania'))->lists('idTercero');
        $nombreTerceroResponsable = \App\Tercero::where('tipoTercero', "like", "%*01*%")->where('Compania_idCompania', "=", \Session::get('idCompania'))->lists('nombreCompletoTercero');

        $idDocumentoSoporte = \App\DocumentoSoporte::All()->lists('idDocumentoSoporte');
        $nombreDocumentoSoporte = \App\DocumentoSoporte::All()->lists('nombreDocumentoSoporte');

        $idHabilidad = \App\PerfilCargo::where('tipoPerfilCargo','=','Habilidad')->lists('idPerfilCargo');
        $nombreHabilidad = \App\PerfilCargo::where('tipoPerfilCargo','=','Habilidad')->lists('nombrePerfilCargo');

        $idFormacion = \App\PerfilCargo::where('tipoPerfilCargo','=','Formacion')->lists('idPerfilCargo');
        $nombreFormacion = \App\PerfilCargo::where('tipoPerfilCargo','=','Formacion')->lists('nombrePerfilCargo');

        $idEducacion = \App\PerfilCargo::where('tipoPerfilCargo','=','Educacion')->lists('idPerfilCargo');
        $nombreEducacion = \App\PerfilCargo::where('tipoPerfilCargo','=','Educacion')->lists('nombrePerfilCargo');

       $idRespuesta  = \App\CompetenciaRespuesta::All()->lists('idCompetenciaRespuesta');
        $nombreRespuesta  = \App\CompetenciaRespuesta::All()->lists('respuestaCompetenciaRespuesta');
        
        $Tercero_idEmpleado = \App\Tercero::where('tipoTercero', "like", "%*01*%")->where('Compania_idCompania', "=", \Session::get('idCompania'))->lists('nombreCompletoTercero','idTercero'); 

        $Tercero_idResponsable = \App\Tercero::where('tipoTercero', "like", "%*01*%")->where('Compania_idCompania', "=", \Session::get('idCompania'))->lists('nombreCompletoTercero','idTercero'); 

       $idModulo= \App\Modulo::All()->lists('idModulo');
       $nombreModulo= \App\Modulo::All()->lists('nombreModulo');

       // Cuando editamos la pregunta (Habilidades), debemos enviar los datos de las multiregistro que se deben cargar
        // Consultamos la multiregistro de  Competencia (tabla cargoeducacion )
    $EvaluacionDesempenioResponsabilidad = DB::Select('
         SELECT idEvaluacionResponsabilidad,EvaluacionDesempenio_idEvaluacionDesempenio,descripcionCargoResponsabilidad,CargoResponsabilidad_idCargoResponsabilidad,respuestaEvaluacionResponsabilidad
            FROM  evaluacionresponsabilidad ER
            LEFT JOIN cargoresponsabilidad CR
            On ER.CargoResponsabilidad_idCargoResponsabilidad = CR.idCargoResponsabilidad 
            WHERE ER.EvaluacionDesempenio_idEvaluacionDesempenio = '.$id);


   
        // Multiregistro consulta de Evaluaciondesempenioeducacion
  $EvaluacionDesempenioEducacion = DB::Select('
    SELECT idEvaluacionEducacion,EvaluacionDesempenio_idEvaluacionDesempenio,nombrePerfilCargo,PerfilCargo_idRequerido as PerfilCargo_idRequerido_Educacion,porcentajeCargoEducacion,PerfilCargo_idAspirante as PerfilCargo_idAspirante_Educacion,calificacionEvaluacionEducacion
    FROM
    evaluacioneducacion ee
    LEFT JOIN evaluaciondesempenio ed
    ON ee.EvaluacionDesempenio_idEvaluacionDesempenio = ed.idEvaluacionDesempenio 
    LEFT JOIN perfilcargo pc
    ON ee.PerfilCargo_idRequerido = pc.idPerfilCargo
    LEFT JOIN cargoeducacion ce
    ON ee.PerfilCargo_idRequerido = ce.PerfilCargo_idPerfilCargo and ed.Cargo_idCargo = ce.Cargo_idCargo
    WHERE  ee.EvaluacionDesempenio_idEvaluacionDesempenio = '.$id);


$EvaluacionDesempenioFormacion = DB::Select('
  SELECT idEvaluacionFormacion,EvaluacionDesempenio_idEvaluacionDesempenio,nombrePerfilCargo,PerfilCargo_idRequerido as PerfilCargo_idRequerido_Formacion,porcentajeCargoFormacion,PerfilCargo_idAspirante as PerfilCargo_idAspirante_Formacion,calificacionEvaluacionFormacion
    FROM
    evaluacionformacion ef
    LEFT JOIN evaluaciondesempenio ed
    ON ef.EvaluacionDesempenio_idEvaluacionDesempenio = ed.idEvaluacionDesempenio 
    LEFT JOIN perfilcargo pc
    ON ef.PerfilCargo_idRequerido = pc.idPerfilCargo
    LEFT JOIN cargoformacion cf
    ON ef.PerfilCargo_idRequerido = cf.PerfilCargo_idPerfilCargo and ed.Cargo_idCargo = cf.Cargo_idCargo
    WHERE  ef.EvaluacionDesempenio_idEvaluacionDesempenio = '.$id);


$EvaluacionDesempenioHabilidad = DB::Select('
  SELECT idEvaluacionHabilidad,EvaluacionDesempenio_idEvaluacionDesempenio,nombrePerfilCargo,PerfilCargo_idRequerido as PerfilCargo_idRequerido_Habilidad,porcentajeCargoHabilidad,PerfilCargo_idAspirante as PerfilCargo_idAspirante_Habilidad,calificacionEvaluacionHabilidad
    FROM
    evaluacionhabilidad eh
    LEFT JOIN evaluaciondesempenio ed
    ON eh.EvaluacionDesempenio_idEvaluacionDesempenio = ed.idEvaluacionDesempenio 
    LEFT JOIN perfilcargo pc
    ON eh.PerfilCargo_idRequerido = pc.idPerfilCargo
    LEFT JOIN cargohabilidad ch
    ON eh.PerfilCargo_idRequerido = ch.PerfilCargo_idPerfilCargo and ed.Cargo_idCargo = ch.Cargo_idCargo
    WHERE  eh.EvaluacionDesempenio_idEvaluacionDesempenio = '.$id);


$EvaluacionAccion = DB::Select('
    SELECT
      idEvaluacionAccion,EvaluacionDesempenio_idEvaluacionDesempenio,actividadEvaluacionAccion,Tercero_idResponsable as Tercero_idResponsable_Accion,DocumentoSoporte_idDocumentoSoporte,fechaPlaneadaEvaluacionAccion,fechaEjecutadaEvaluacionAccion
    FROM
      evaluacionaccion ea
      WHERE ea.EvaluacionDesempenio_idEvaluacionDesempenio = '.$id);


        return view ('evaluaciondesempenio',['evaluaciondesempenio'=>$evaluaciondesempenio], compact('EvaluacionAccion','cargo','idTerceroResponsable','nombreTerceroResponsable','nombreDocumentoSoporte','idDocumentoSoporte','EvaluacionDesempenioHabilidad','idHabilidad','nombreHabilidad','EvaluacionDesempenioFormacion','idFormacion','nombreFormacion','EvaluacionDesempenioEducacion','EvaluacionDesempenioResponsabilidad','idEducacion','nombreEducacion','idRespuesta','nombreRespuesta','Tercero_idEmpleado','Tercero_idResponsable','idModulo','nombreModulo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(evaluaciondesempenioRequest $request, $id)
    {
         $evaluaciondesempenio = \App\EvaluacionDesempenio::find($id);
         $evaluaciondesempenio->fill($request->all());

         $evaluaciondesempenio->save();


         // Update Multiregistro Responsabilidad

              $idsEliminar = explode("," , $request['eliminarresponsabilidades']);
                //Eliminar registros de la multiregistro
                \App\EvaluacionDesempenioResponsabilidad::whereIn('idEvaluacionResponsabilidad', $idsEliminar)->delete();
            // Guardamos el detalle de los modulos
            for($i = 0; $i < count($request['idEvaluacionResponsabilidad']); $i++)
            {
                     $indice = array(
                        'idEvaluacionResponsabilidad' => $request['idEvaluacionResponsabilidad'][$i]);

                    $data = array(
            'EvaluacionDesempenio_idEvaluacionDesempenio' => $evaluaciondesempenio->idEvaluacionDesempenio,
            'CargoResponsabilidad_idCargoResponsabilidad' => $request['CargoResponsabilidad_idCargoResponsabilidad'][$i],
            'respuestaEvaluacionResponsabilidad' => $request['respuestaEvaluacionResponsabilidad'][$i]);
                    $guardar = \App\EvaluacionDesempenioResponsabilidad::updateOrCreate($indice, $data);
            } 

            // Update Multiregistro Eduacion

              $idsEliminar = explode("," , $request['eliminarEvaluacionEducacion']);
                //Eliminar registros de la multiregistro
                \App\EvaluacionDesempenioEducacion::whereIn('idEvaluacionEducacion', $idsEliminar)->delete();
            // Guardamos el detalle de los modulos
            for($i = 0; $i < count($request['idEvaluacionEducacion']); $i++)
            {
                     $indice = array(
                        'idEvaluacionEducacion' => $request['idEvaluacionEducacion'][$i]);

                    $data = array(
            'EvaluacionDesempenio_idEvaluacionDesempenio' => $evaluaciondesempenio->idEvaluacionDesempenio,
            'PerfilCargo_idRequerido' => $request['PerfilCargo_idRequerido_Educacion'][$i],
            'PerfilCargo_idAspirante' => $request['PerfilCargo_idAspirante_Educacion'][$i],
            'calificacionEvaluacionEducacion' => $request['calificacionEvaluacionEducacion'][$i]);
                    $guardar = \App\EvaluacionDesempenioEducacion::updateOrCreate($indice, $data);
            } 

             // Update Multiregistro Formacion

              $idsEliminar = explode("," , $request['eliminarEvaluacionFormacion']);
                //Eliminar registros de la multiregistro
                \App\EvaluacionDesempenioFormacion::whereIn('idEvaluacionFormacion', $idsEliminar)->delete();
            // Guardamos el detalle de los modulos
            for($i = 0; $i < count($request['idEvaluacionFormacion']); $i++)
            {
                     $indice = array(
                        'idEvaluacionFormacion' => $request['idEvaluacionFormacion'][$i]);

                    $data = array(
            'EvaluacionDesempenio_idEvaluacionDesempenio' => $evaluaciondesempenio->idEvaluacionDesempenio,
            'PerfilCargo_idRequerido' => $request['PerfilCargo_idRequerido_Formacion'][$i],
            'PerfilCargo_idAspirante' => $request['PerfilCargo_idAspirante_Formacion'][$i],
            'calificacionEvaluacionEducacion' => $request['calificacionEvaluacionFormacion'][$i]);
                    $guardar = \App\EvaluacionDesempenioFormacion::updateOrCreate($indice, $data);
            } 

               // Update Multiregistro Habilidad

              $idsEliminar = explode("," , $request['eliminarEvaluacionHabilidad']);
                //Eliminar registros de la multiregistro
                \App\EvaluacionDesempenioHabilidad::whereIn('idEvaluacionHabilidad', $idsEliminar)->delete();
            // Guardamos el detalle de los modulos
            for($i = 0; $i < count($request['idEvaluacionHabilidad']); $i++)
            {
                     $indice = array(
                        'idEvaluacionHabilidad' => $request['idEvaluacionHabilidad'][$i]);

                    $data = array(
            'EvaluacionDesempenio_idEvaluacionDesempenio' => $evaluaciondesempenio->idEvaluacionDesempenio,
            'PerfilCargo_idRequerido' => $request['PerfilCargo_idRequerido_Habilidad'][$i],
            'PerfilCargo_idAspirante' => $request['PerfilCargo_idAspirante_Habilidad'][$i],
            'calificacionEvaluacionEducacion' => $request['calificacionEvaluacionHabilidad'][$i]);
                    $guardar = \App\EvaluacionDesempenioHabilidad::updateOrCreate($indice, $data);
            }

                 // Update Multiregistro PLan Accion

              $idsEliminar = explode("," , $request['eliminarEvaluacionAccion']);
                //Eliminar registros de la multiregistro
                \App\EvaluacionAccion::whereIn('idEvaluacionAccion', $idsEliminar)->delete();
            // Guardamos el detalle de los modulos
            for($i = 0; $i < count($request['idEvaluacionAccion']); $i++)
            {
                     $indice = array(
                        'idEvaluacionAccion' => $request['idEvaluacionAccion'][$i]);

                    $data = array(
            'EvaluacionDesempenio_idEvaluacionDesempenio' => $evaluaciondesempenio->idEvaluacionDesempenio,
            'actividadEvaluacionAccion' => $request['actividadEvaluacionAccion'][$i],
            'Tercero_idResponsable' => $request['Tercero_idResponsable_Accion'][$i],
            'DocumentoSoporte_idDocumentoSoporte' => $request['DocumentoSoporte_idDocumentoSoporte'][$i],
            'fechaPlaneadaEvaluacionAccion' => $request['fechaPlaneadaEvaluacionAccion'][$i],
            'fechaEjecutadaEvaluacionAccion' => $request['fechaEjecutadaEvaluacionAccion'][$i]);




                    $guardar = \App\EvaluacionAccion::updateOrCreate($indice, $data);
            }




            
        return redirect('evaluaciondesempenio');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        \App\EvaluacionDesempenio::destroy($id);
        return redirect('/evaluaciondesempenio');
    }



}
