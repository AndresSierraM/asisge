<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\requests\EntrevistaRequest;
use App\Http\Controllers\Controller;
use DB;
include public_path().'/ajax/consultarPermisos.php';

class EntrevistaController extends Controller
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
          return view('entrevistagrid', compact('datos'));
         else
            return view('accesodenegado');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

            

 //         son datos para mandarle a una multi registro con un campo tipo SELECT se consultan diferentes
 // porque tienes que mandar el ID y la respuesta aparte
         $idRespuesta  = \App\CompetenciaRespuesta::All()->lists('idCompetenciaRespuesta');
        $nombreRespuesta  = \App\CompetenciaRespuesta::All()->lists('respuestaCompetenciaRespuesta');



        $Ciudad_idResidencia = \App\Ciudad::All()->lists('nombreCiudad','idCiudad');
        //Creamos una busqueda de la sesion segun la compañia para saber el tercero si tiene chulito en Empleado
         $Tercero = \App\Tercero::where('tipoTercero', "like", "%*01*%")->where('Compania_idCompania', "=", \Session::get('idCompania'))->lists('nombreCompletoTercero','idTercero'); 

        $cargo = \App\Cargo::where('Compania_idCompania', "=", \Session::get('idCompania'))->lists('nombreCargo','idCargo'); 
        $idModulo= \App\Modulo::All()->lists('idModulo');
        $nombreModulo= \App\Modulo::All()->lists('nombreModulo');
        
        $idEducacion = \App\PerfilCargo::where('tipoPerfilCargo','=','Educacion')->lists('idPerfilCargo');
        $nombreEducacion = \App\PerfilCargo::where('tipoPerfilCargo','=','Educacion')->lists('nombrePerfilCargo');

        $idFormacion = \App\PerfilCargo::where('tipoPerfilCargo','=','Formacion')->lists('idPerfilCargo');
        $nombreFormacion = \App\PerfilCargo::where('tipoPerfilCargo','=','Formacion')->lists('nombrePerfilCargo');

          return view('entrevista',compact('cargo','Tercero','Ciudad_idResidencia','idRespuesta','nombreRespuesta','entrevistapregunta','idEducacion','nombreEducacion','idFormacion','nombreFormacion'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EntrevistaRequest $request)
    {

         
          \App\Entrevista::create([
            'documentoAspiranteEntrevista' => $request['documentoAspiranteEntrevista'],
            'estadoEntrevista' => $request['estadoEntrevista'],
            'nombre1AspiranteEntrevista' => $request['nombre1AspiranteEntrevista'],
            'nombre2AspiranteEntrevista' => $request['nombre2AspiranteEntrevista'],
            'apellido1AspiranteEntrevista' => $request['apellido1AspiranteEntrevista'],
            'apellido2AspiranteEntrevista' => $request['apellido2AspiranteEntrevista'],
            'fechaEntrevista' => $request ['fechaEntrevista'],
            'Tercero_idEntrevistador' => $request['Tercero_idEntrevistador'],
            'Cargo_idCargo' => $request['Cargo_idCargo'],
            'experienciaAspiranteEntrevista' => $request['experienciaAspiranteEntrevista'],  
            'experienciaRequeridaEntrevista' => $request['experienciaRequeridaEntrevista'],  
           
     
            ]);


    $entrevista = \App\entrevista::All()->last();
      \App\EntrevistaPregunta::create([
            'Entrevista_idEntrevista' => $entrevista->idEntrevista,
            'fechaNacimientoEntrevistaPregunta' => $request['fechaNacimientoEntrevistaPregunta'],  
            'edadEntrevistaPregunta' => $request['edadEntrevistaPregunta'],  
            'estadoCivilEntrevistaPregunta' => $request['estadoCivilEntrevistaPregunta'],  
            'telefonoEntrevistaPregunta' => $request['telefonoEntrevistaPregunta'],  
            'movilEntrevistaPregunta' => $request['movilEntrevistaPregunta'],  
            'correoElectronicoEntrevistaPregunta' => $request['correoElectronicoEntrevistaPregunta'],  
            'direccionEntrevistaPregunta' => $request['direccionEntrevistaPregunta'],  
            'Ciudad_idResidencia' => $request['Ciudad_idResidencia'],  
            'nombreConyugeEntrevistaPregunta' => $request['nombreConyugeEntrevistaPregunta'],  
            'ocupacionConyugeEntrevistaPregunta' => $request['ocupacionConyugeEntrevistaPregunta'],
            'numeroHijosEntrevistaPregunta' => $request['numeroHijosEntrevistaPregunta'],
            'conQuienViveEntrevistaPregunta' => $request['conQuienViveEntrevistaPregunta'],
            'dondeViveEntrevistaPregunta' => $request['dondeViveEntrevistaPregunta'],
            'ocupacionActualEntrevistaPregunta' => $request['ocupacionActualEntrevistaPregunta'],
            'estudioActualEntrevistaPregunta' => $request['estudioActualEntrevistaPregunta'],
            'horarioEstudioEntrevistaPregunta' => $request['horarioEstudioEntrevistaPregunta'],
            'motivacionCarreraEntrevistaPregunta' => $request['motivacionCarreraEntrevistaPregunta'],
            'expectativaEstudioEntrevistaPregunta' => $request['expectativaEstudioEntrevistaPregunta'],
            'ultimoEmpleoEntrevistaPregunta' => $request['ultimoEmpleoEntrevistaPregunta'],
            'funcionesEmpleoEntrevistaPregunta' => $request['funcionesEmpleoEntrevistaPregunta'],
            'logrosEmpleoEntrevistaPregunta' => $request['logrosEmpleoEntrevistaPregunta'],
            'ultimoSalarioEntrevistaPregunta' => $request['ultimoSalarioEntrevistaPregunta'],
            'motivoRetiroEntrevistaPregunta' => $request['motivoRetiroEntrevistaPregunta'],
            'expectativaLaboralEntrevistaPregunta' => $request['expectativaLaboralEntrevistaPregunta'],
            'disponibilidadInicioEntrevistaPregunta' => $request['disponibilidadInicioEntrevistaPregunta'],
            'aspiracionSalarialEntrevistaPregunta' => $request['aspiracionSalarialEntrevistaPregunta'],
            'motivacionTrabajoEntrevistaPregunta' => $request['motivacionTrabajoEntrevistaPregunta'],
            'proyeccion5AñosEntrevistaPregunta' => $request['proyeccion5AñosEntrevistaPregunta'],
            'tiempoLibreEntrevistaPregunta' => $request['tiempoLibreEntrevistaPregunta'],
            'introvertidoEntrevistaPregunta' => $request['introvertidoEntrevistaPregunta'],
            'vicioEntrevistaPregunta' => $request['vicioEntrevistaPregunta'],
            'antecedentesEntrevistaPregunta' => $request['antecedentesEntrevistaPregunta'],
            'anecdotaEntrevistaPregunta' => $request['anecdotaEntrevistaPregunta'],
            'observacionEntrevistaPregunta' => $request['observacionEntrevistaPregunta']        
            

    
        ]);


        // en esta parte es el guardado de la multiregistro descripcion
         //Primero consultar el ultimo id guardado
         $entrevista = \App\entrevista::All()->last();
         //for para guardar cada registro de la multiregistro

         for ($i=0; $i < count($request['nombreEntrevistaHijo']); $i++) 
         { 
             \App\EntrevistaHijo::create([
            'Entrevista_idEntrevista' => $entrevista->idEntrevista,
            'nombreEntrevistaHijo' => $request['nombreEntrevistaHijo'][$i],
            'edadEntrevistaHijo' => $request['edadEntrevistaHijo'][$i],
            'ocupacionEntrevistaHijo' => $request['ocupacionEntrevistaHijo'][$i]
           


            ]);
         }

     // en esta parte es el guardado de la multiregistro descripcion
         //Primero consultar el ultimo id guardado
         // $entrevista = \App\entrevista::All()->last();
         //for para guardar cada registro de la multiregistro

         for ($i=0; $i < count($request['parentescoEntrevistaRelacionFamiliar']); $i++) 
         { 
             \App\EntrevistaRelacionFamiliar::create([
             'Entrevista_idEntrevista' => $entrevista->idEntrevista,
            'parentescoEntrevistaRelacionFamiliar' => $request['parentescoEntrevistaRelacionFamiliar'][$i],
            'relacionEntrevistaRelacionFamiliar' => $request['relacionEntrevistaRelacionFamiliar'][$i]
           


            ]);
         }

           // en esta parte es el guardado de la multiregistro descripcion
         //Primero consultar el ultimo id guardado
         // $entrevista = \App\entrevista::All()->last();
         //for para guardar cada registro de la multiregistro

         for ($i=0; $i < count($request['CompetenciaPregunta_idCompetenciaPregunta']); $i++) 
         { 
             \App\EntrevistaCompetencia::create([
             'Entrevista_idEntrevista' => $entrevista->idEntrevista,
            'CompetenciaPregunta_idCompetenciaPregunta' => $request['CompetenciaPregunta_idCompetenciaPregunta'][$i],
            'CompetenciaRespuesta_idCompetenciaRespuesta' => $request['CompetenciaRespuesta_idCompetenciaRespuesta'][$i]
           


            ]);
         }

              // en esta parte es el guardado de la multiregistro descripcion
         //Primero consultar el ultimo id guardado
         // $entrevista = \App\entrevista::All()->last();
         //for para guardar cada registro de la multiregistro
            for ($i=0; $i < count($request['calificacionEntrevistaFormacion']); $i++) 
         { 

             \App\EntrevistaFormacion::create([
             'Entrevista_idEntrevista' => $entrevista->idEntrevista,
            'PerfilCargo_idRequerido' => $request['PerfilCargo_idRequerido_Formacion'][$i],
            'PerfilCargo_idAspirante' => $request['PerfilCargo_idAspirante_Formacion'][$i],
            'calificacionEntrevistaFormacion' => $request['calificacionEntrevistaFormacion'][$i]

            ]);
         }
        // en esta parte es el guardado de la multiregistro descripcion
         //Primero consultar el ultimo id guardado
         // $entrevista = \App\entrevista::All()->last();
         //for para guardar cada registro de la multiregistro

            for ($i=0; $i < count($request['calificacionEntrevistaEducacion']); $i++) 
         { 
             \App\EntrevistaEducacion::create([
             'Entrevista_idEntrevista' => $entrevista->idEntrevista,
            'PerfilCargo_idRequerido' => $request['PerfilCargo_idRequerido_Educacion'][$i],
            'PerfilCargo_idAspirante' => $request['PerfilCargo_idAspirante_Educacion'][$i],
            'calificacionEntrevistaEducacion' => $request['calificacionEntrevistaEducacion'][$i]
          

            ]);
         }


        return redirect('/entrevista'); 
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
            // son datos para mandarle a una multi registro con un campo tipo SELECT se consultan diferentes
            // porque tienes que mandar el ID y la respuesta aparte
         $idRespuesta  = \App\CompetenciaRespuesta::All()->lists('idCompetenciaRespuesta');
        $nombreRespuesta  = \App\CompetenciaRespuesta::All()->lists('respuestaCompetenciaRespuesta');

         $Ciudad_idResidencia = \App\Ciudad::All()->lists('nombreCiudad','idCiudad');

         $entrevista = \App\Entrevista::find($id);
         $Tercero = \App\Tercero::where('tipoTercero', "like", "%*01*%")->where('Compania_idCompania', "=", \Session::get('idCompania'))->lists('nombreCompletoTercero','idTercero'); 
          $cargo = \App\Cargo::where('Compania_idCompania', "=", \Session::get('idCompania'))->lists('nombreCargo','idCargo'); 
        $idEducacion = \App\PerfilCargo::where('tipoPerfilCargo','=','Educacion')->lists('idPerfilCargo');
        $nombreEducacion = \App\PerfilCargo::where('tipoPerfilCargo','=','Educacion')->lists('nombrePerfilCargo');

        $idFormacion = \App\PerfilCargo::where('tipoPerfilCargo','=','Formacion')->lists('idPerfilCargo');
        $nombreFormacion = \App\PerfilCargo::where('tipoPerfilCargo','=','Formacion')->lists('nombrePerfilCargo');



        // Cuando editamos la pregunta (Habilidades), debemos enviar los datos de las multiregistro que se deben cargar
        // Consultamos la multiregistro de  Competencia (tabla cargoeducacion )
        $entrevistacompetencia = DB::Select('
         SELECT idEntrevistaCompetencia,CompetenciaPregunta_idCompetenciaPregunta,preguntaCompetenciaPregunta,CompetenciaRespuesta_idCompetenciaRespuesta
            FROM entrevistacompetencia  EC
            LEFT JOIN competenciarespuesta  CR
            ON EC.CompetenciaRespuesta_idCompetenciaRespuesta = CR.idCompetenciaRespuesta
            LEFT JOIN competenciapregunta CP
            on  EC.CompetenciaPregunta_idCompetenciaPregunta = CP.idCompetenciaPregunta
            WHERE EC.Entrevista_idEntrevista = '.$id);


        //consulta para traer los datos a educacion pestaña general 
            $EntrevistaEducacion  = DB::SELECT(' 
            SELECT idEntrevistaEducacion,nombrePerfilCargo,PerfilCargo_idRequerido as PerfilCargo_idRequerido_Educacion,porcentajeCargoEducacion,PerfilCargo_idAspirante as PerfilCargo_idAspirante_Educacion ,calificacionEntrevistaEducacion,Entrevista_idEntrevista
            FROM entrevistaeducacion ed
            LEFT JOIN  perfilcargo pca
            ON ed.PerfilCargo_idRequerido = pca.idPerfilCargo  
            LEFT JOIN cargoeducacion ce
            ON ce.PerfilCargo_idPerfilCargo = pca.idPerfilCargo
            WHERE ed.Entrevista_idEntrevista = '.$id);

            //consulta para traer los datos a Formacion pestaña general 
            $EntrevistaFormacion  = DB::SELECT(' 
            SELECT idEntrevistaFormacion,nombrePerfilCargo,PerfilCargo_idRequerido as PerfilCargo_idRequerido_Formacion ,porcentajeCargoFormacion,PerfilCargo_idAspirante as PerfilCargo_idAspirante_Formacion ,calificacionEntrevistaFormacion,Entrevista_idEntrevista
            FROM entrevistaformacion ef
            LEFT JOIN perfilcargo pca
            ON ef.PerfilCargo_idRequerido = pca.idPerfilCargo
            LEFT JOIN cargoformacion cf
            ON cf.PerfilCargo_idPerfilCargo = pca.idPerfilCargo
            WHERE ef.Entrevista_idEntrevista = '.$id);





          return view('entrevista',compact('cargo','Tercero','Ciudad_idResidencia','idRespuesta','nombreRespuesta','entrevistapregunta','idEducacion','nombreEducacion','idFormacion','nombreFormacion','entrevistacompetencia','EntrevistaEducacion','EntrevistaFormacion'),['entrevista'=>$entrevista]);

          
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EntrevistaRequest $request, $id)
    {
         

        $entrevista = \App\Entrevista::find($id);
        $entrevista->fill($request->all());
        $entrevista->save();

//Se guarda los registros de Entrevista pregunta de esta manera ya que no son el encabezado 
        //se pregunta si el ID ya existe para que reemplace todos los campos Actuales
    $indice = array(
        'Entrevista_idEntrevista' => $id);

    $data = array(
        'fechaNacimientoEntrevistaPregunta' => $request['fechaNacimientoEntrevistaPregunta'],  
        'edadEntrevistaPregunta' => $request['edadEntrevistaPregunta'],  
        'estadoCivilEntrevistaPregunta' => $request['estadoCivilEntrevistaPregunta'],  
        'telefonoEntrevistaPregunta' => $request['telefonoEntrevistaPregunta'],  
        'movilEntrevistaPregunta' => $request['movilEntrevistaPregunta'],  
        'correoElectronicoEntrevistaPregunta' => $request['correoElectronicoEntrevistaPregunta'],  
        'direccionEntrevistaPregunta' => $request['direccionEntrevistaPregunta'],  
        'Ciudad_idResidencia' => $request['Ciudad_idResidencia'],  
        'nombreConyugeEntrevistaPregunta' => $request['nombreConyugeEntrevistaPregunta'],  
        'ocupacionConyugeEntrevistaPregunta' => $request['ocupacionConyugeEntrevistaPregunta'],
        'numeroHijosEntrevistaPregunta' => $request['numeroHijosEntrevistaPregunta'],
        'conQuienViveEntrevistaPregunta' => $request['conQuienViveEntrevistaPregunta'],
        'dondeViveEntrevistaPregunta' => $request['dondeViveEntrevistaPregunta'],
        'ocupacionActualEntrevistaPregunta' => $request['ocupacionActualEntrevistaPregunta'],
        'estudioActualEntrevistaPregunta' => $request['estudioActualEntrevistaPregunta'],
        'horarioEstudioEntrevistaPregunta' => $request['horarioEstudioEntrevistaPregunta'],
        'motivacionCarreraEntrevistaPregunta' => $request['motivacionCarreraEntrevistaPregunta'],
        'expectativaEstudioEntrevistaPregunta' => $request['expectativaEstudioEntrevistaPregunta'],
        'ultimoEmpleoEntrevistaPregunta' => $request['ultimoEmpleoEntrevistaPregunta'],
        'funcionesEmpleoEntrevistaPregunta' => $request['funcionesEmpleoEntrevistaPregunta'],
        'logrosEmpleoEntrevistaPregunta' => $request['logrosEmpleoEntrevistaPregunta'],
        'ultimoSalarioEntrevistaPregunta' => $request['ultimoSalarioEntrevistaPregunta'],
        'motivoRetiroEntrevistaPregunta' => $request['motivoRetiroEntrevistaPregunta'],
        'expectativaLaboralEntrevistaPregunta' => $request['expectativaLaboralEntrevistaPregunta'],
        'disponibilidadInicioEntrevistaPregunta' => $request['disponibilidadInicioEntrevistaPregunta'],
        'aspiracionSalarialEntrevistaPregunta' => $request['aspiracionSalarialEntrevistaPregunta'],
        'motivacionTrabajoEntrevistaPregunta' => $request['motivacionTrabajoEntrevistaPregunta'],
        'proyeccion5AñosEntrevistaPregunta' => $request['proyeccion5AñosEntrevistaPregunta'],
        'tiempoLibreEntrevistaPregunta' => $request['tiempoLibreEntrevistaPregunta'],
        'introvertidoEntrevistaPregunta' => $request['introvertidoEntrevistaPregunta'],
        'vicioEntrevistaPregunta' => $request['vicioEntrevistaPregunta'],
        'antecedentesEntrevistaPregunta' => $request['antecedentesEntrevistaPregunta'],
        'anecdotaEntrevistaPregunta' => $request['anecdotaEntrevistaPregunta'],
        'observacionEntrevistaPregunta' => $request['observacionEntrevistaPregunta']); 

         $entrevistapregunta = \App\EntrevistaPregunta::updateOrCreate($indice, $data);

        $idsEliminar = explode("," , $request['eliminarEntrevistaHijo']);
        //Eliminar registros de la multiregistro
        \App\EntrevistaHijo::whereIn('idEntrevistaHijo', $idsEliminar)->delete();
        // Guardamos el detalle de los modulos
        for($i = 0; $i < count($request['idEntrevistaHijo']); $i++)
        {
             $indice = array(
                'idEntrevistaHijo' => $request['idEntrevistaHijo'][$i]);

            $data = array(
                'Entrevista_idEntrevista' => $id,
                'nombreEntrevistaHijo' => $request['nombreEntrevistaHijo'][$i],
                'edadEntrevistaHijo' => $request['edadEntrevistaHijo'][$i],
                'ocupacionEntrevistaHijo' => $request['ocupacionEntrevistaHijo'][$i]);
            $guardar = \App\EntrevistaHijo::updateOrCreate($indice, $data);
        } 

        
         $idsEliminar = explode("," , $request['eliminarEntrevistaRelacionFamilia']);
        //Eliminar registros de la multiregistro
        \App\EntrevistaRelacionFamiliar::whereIn('idEntrevistaRelacionFamiliar', $idsEliminar)->delete();
        // Guardamos el detalle de los modulos
        for($i = 0; $i < count($request['idEntrevistaRelacionFamiliar']); $i++)
        {
             $indice = array(
                'idEntrevistaRelacionFamiliar' => $request['idEntrevistaRelacionFamiliar'][$i]);

            $data = array(
                'Entrevista_idEntrevista' => $id,
                'parentescoEntrevistaRelacionFamiliar' => $request['parentescoEntrevistaRelacionFamiliar'][$i],
                'relacionEntrevistaRelacionFamiliar' => $request['relacionEntrevistaRelacionFamiliar'][$i]);

            $guardar = \App\EntrevistaRelacionFamiliar::updateOrCreate($indice, $data);
        } 

            $idsEliminar = explode("," , $request['eliminarEducacionEntrevista']);
        //Eliminar registros de la multiregistro
        \App\EntrevistaEducacion::whereIn('idEntrevistaEducacion', $idsEliminar)->delete();
        // Guardamos el detalle de los modulos
        for($i = 0; $i < count($request['idEntrevistaEducacion']); $i++)
        {
             $indice = array(
                'idEntrevistaEducacion' => $request['idEntrevistaEducacion'][$i]);

            $data = array(
                'Entrevista_idEntrevista' => $id,
                'PerfilCargo_idRequerido' => $request['PerfilCargo_idRequerido_Educacion'][$i],
                    'PerfilCargo_idAspirante' => $request['PerfilCargo_idAspirante_Educacion'][$i],
                'calificacionEntrevistaEducacion' => $request['calificacionEntrevistaEducacion'][$i]);
            $guardar = \App\EntrevistaEducacion::updateOrCreate($indice, $data);
        } 



             $idsEliminar = explode("," , $request['eliminarcompetencia']);
        //Eliminar registros de la multiregistro
        \App\EntrevistaCompetencia::whereIn('idEntrevistaCompetencia', $idsEliminar)->delete();
        // Guardamos el detalle de los modulos
        for($i = 0; $i < count($request['idEntrevistaCompetencia']); $i++)
        {
             $indice = array(
                'idEntrevistaCompetencia' => $request['idEntrevistaCompetencia'][$i]);

            $data = array(
                'Entrevista_idEntrevista' => $id,
                'CompetenciaPregunta_idCompetenciaPregunta' => $request['CompetenciaPregunta_idCompetenciaPregunta'][$i],
                'CompetenciaRespuesta_idCompetenciaRespuesta' => $request['CompetenciaRespuesta_idCompetenciaRespuesta'][$i]);
            $guardar = \App\EntrevistaCompetencia::updateOrCreate($indice, $data);
        } 


             $idsEliminar = explode("," , $request['eliminarFormacionEntrevista']);
        //Eliminar registros de la multiregistro
        \App\EntrevistaFormacion::whereIn('idEntrevistaFormacion', $idsEliminar)->delete();
        // Guardamos el detalle de los modulos
        for($i = 0; $i < count($request['idEntrevistaFormacion']); $i++)
        {
             $indice = array(
                'idEntrevistaFormacion' => $request['idEntrevistaFormacion'][$i]);

            $data = array(
                'Entrevista_idEntrevista' => $id,
                'PerfilCargo_idRequerido' => $request['PerfilCargo_idRequerido_Formacion'][$i],
                'PerfilCargo_idAspirante' => $request['PerfilCargo_idAspirante_Formacion'][$i],
                'calificacionEntrevistaFormacion' => $request['calificacionEntrevistaFormacion'][$i]);
            $guardar = \App\EntrevistaFormacion::updateOrCreate($indice, $data);
        } 

        return redirect('entrevista');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         \App\entrevista::destroy($id);
        return redirect('/entrevista');
    }
}

