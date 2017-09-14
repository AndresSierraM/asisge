<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\CargoRequest;
use App\Http\Controllers\Controller;
use DB;
include public_path().'/ajax/consultarPermisos.php';

class CargoController extends Controller
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
            return view('cargogrid', compact('datos'));
        else
            return view('accesodenegado');
    }

    public function indexEducacionGrid()
    {
        return view('educaciongridselect');
        
    }

      public function indexFormacionGrid()
    {
        return view('formaciongridselect');
        
    }



      public function indexHabilidadGrid()
    {
        return view('habilidadgridselect');
        
    }

       public function indexCompetenciaGrid()
    {
        return view('competenciagridselect');
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $idListaTarea = \App\ListaGeneral::where('tipoListaGeneral','TareaAltoRiesgo')->lists('idListaGeneral');
        $nombreListaTarea = \App\ListaGeneral::where('tipoListaGeneral','TareaAltoRiesgo')->lists('nombreListaGeneral');
        
        $idTipoExamen = \App\TipoExamenMedico::All()->lists('idTipoExamenMedico');
        $nombreTipoExamen = \App\TipoExamenMedico::All()->lists('nombreTipoExamenMedico');

        $idListaVacuna = \App\ListaGeneral::where('tipoListaGeneral','Vacuna')->lists('idListaGeneral');
        $nombreListaVacuna = \App\ListaGeneral::where('tipoListaGeneral','Vacuna')->lists('nombreListaGeneral');

        $idListaElemento = \App\ElementoProteccion::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('idElementoProteccion');
        $nombreListaElemento = \App\ElementoProteccion::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('nombreElementoProteccion');

        $idFrecuenciaMedicion = \App\FrecuenciaMedicion::All()->lists('idFrecuenciaMedicion');
        $nombreFrecuenciaMedicion = \App\FrecuenciaMedicion::All()->lists('nombreFrecuenciaMedicion');

        $cargoPadre = \App\Cargo::where('Compania_idCompania', "=", \Session::get('idCompania'))->lists('nombreCargo','idCargo'); 
        
        return view('cargo',compact('idListaTarea','nombreListaTarea','idTipoExamen','nombreTipoExamen','idListaVacuna','nombreListaVacuna','idListaElemento','nombreListaElemento','idFrecuenciaMedicion','nombreFrecuenciaMedicion','idFrecuenciaMedicion','nombreFrecuenciaMedicion', 'cargoPadre'));



    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(CargoRequest $request)
    {
        if($request['respuesta'] != 'falso')
        {    
            \App\Cargo::create([
                'codigoCargo' => $request['codigoCargo'],
                'nombreCargo' => $request['nombreCargo'],
                'salarioBaseCargo' => $request['salarioBaseCargo'],
                'nivelRiesgoCargo' => $request['nivelRiesgoCargo'],
                //campos adicionales
                'Cargo_idDepende' => ($request['Cargo_idDepende'] == '' or $request['Cargo_idDepende'] == 0) ? null : $request['Cargo_idDepende'],
                'aniosExperienciaCargo' => $request['aniosExperienciaCargo'],
                'porcentajeCargoEducacion' => $request['porcentajeCargoEducacion'],
                'porcentajeCargoFormacion' => $request['porcentajeCargoFormacion'],
                'porcentajeCargoHabilidad' => $request['porcentajeCargoHabilidad'],
                //campos Porcentaje encabezado
                'porcentajeEducacionCargo' => $request['porcentajeEducacionCargo'],
                'experienciaCargo' => $request['experienciaCargo'],
                
                'porcentajeCargoEducacion' => $request['porcentajeCargoEducacion'],
                'porcentajeExperienciaCargo' => $request['porcentajeExperienciaCargo'],
                'porcentajeFormacionCargo' => $request['porcentajeFormacionCargo'],
                'porcentajeHabilidadCargo' => $request['porcentajeHabilidadCargo'],
                'porcentajeResponsabilidadCargo' => $request['porcentajeResponsabilidadCargo'],
                //
                'objetivoCargo' => $request['objetivoCargo'],
                'posicionPredominanteCargo' => $request['posicionPredominanteCargo'],
                'restriccionesCargo' => $request['restriccionesCargo'],
                'habilidadesCargo' => $request['habilidadesCargo'],
                'autoridadesCargo' => $request['autoridadesCargo'],
                'Compania_idCompania' => \Session::get('idCompania')
                ]);

            $cargo = \App\Cargo::All()->last();
            
            //---------------------------------
            // guardamos las tablas de detalle
            //---------------------------------
            $this->grabarDetalle($cargo->idCargo, $request);

            return redirect('/cargo');


        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
         if($_GET['accion'] == 'imprimir')
         {
            $cargo = \App\Cargo::find($id);

            // tabla Encabezado Cargo 
            $Cargo = DB::select('
             SELECT idCargo,codigoCargo,nombreCargo as nombreCargop,salarioBaseCargo,nivelRiesgoCargo,Cargo_idDepende as nombreDepende,objetivoCargo,porcentajeEducacionCargo,
             porcentajeExperienciaCargo,porcentajeFormacionCargo,porcentajeHabilidadCargo,porcentajeResponsabilidadCargo,posicionPredominanteCargo
             ,restriccionesCargo,autoridadesCargo,aniosExperienciaCargo,experienciaCargo
             FROM cargo
             WHERE idCargo = '.$id);

            $cargoeducacion = DB::select(
            "SELECT idCargoEducacion, PerfilCargo_idPerfilCargo as PerfilCargo_idEducacion, nombrePerfilCargo as  nombreEducacion, porcentajeCargoEducacion
            FROM cargoeducacion  CE
            LEFT JOIN perfilcargo  PC
            ON CE.PerfilCargo_idPerfilCargo = PC.idPerfilCargo
            WHERE Cargo_idCargo = ".$id);

            $cargoformacion = DB::select(
            "SELECT idCargoFormacion,PerfilCargo_idPerfilCargo as PerfilCargo_idFormacion, nombrePerfilCargo as  nombreFormacion,porcentajeCargoFormacion
            FROM cargoformacion CF
            LEFT JOIN perfilcargo PC
            ON CF.PerfilCargo_idPerfilCargo = PC.idPerfilCargo
            WHERE Cargo_idCargo = ".$id);

             $cargohabilidad = DB::select(
            "SELECT idCargoHabilidad,PerfilCargo_idPerfilCargo as PerfilCargo_idHabilidad, nombrePerfilCargo as nombreHabilidad,porcentajeCargoHabilidad
            FROM cargohabilidad CH
            LEFT JOIN perfilcargo PC
            ON CH.PerfilCargo_idPerfilCargo = PC.idPerfilCargo
            WHERE Cargo_idCargo = ".$id);

            $cargoresponsabilidad = DB::select(
            "SELECT cr.descripcionCargoResponsabilidad,cr.Cargo_idCargo,cr.porcentajeCargoResponsabilidad,c.idCargo,cr.idCargoResponsabilidad
            FROM cargo c
            LEFT JOIN cargoresponsabilidad cr
            ON cr.Cargo_idCargo =  c.idCargo
            WHERE  Cargo_idCargo = ".$id);

           $cargocompetencia = DB::select(
            "SELECT idCargoCompetencia,Competencia_idCompetencia,nombreCompetencia
            FROM cargocompetencia CC
            LEFT JOIN competencia CP
            ON CC.Competencia_idCompetencia = CP.idCompetencia
            WHERE Cargo_idCargo = ".$id);


            $TareaRiesgo = DB::select(
            "SELECT ctr.Cargo_idCargo,ctr.ListaGeneral_idTareaAltoRiesgo,c.idCargo,lg.nombreListaGeneral
            FROM cargotareariesgo ctr
            LEFT JOIN cargo c
            ON  ctr.Cargo_idCargo = c.idCargo
            LEFT JOIN  listageneral lg
            ON  ctr.ListaGeneral_idTareaAltoRiesgo = lg.idListageneral 
            WHERE ctr.Cargo_idCargo = ".$id);

            $ExamenMedico = DB::select(
            "SELECT cem.periodicoCargoExamenMedico,IF(periodicoCargoExamenMedico = '1','Si','No') as periodicoCargoExamenMedicoL,cem.retiroCargoExamenMedico,IF(retiroCargoExamenMedico = '1','Si','No') as retiroCargoExamenMedicoL,cem.ingresoCargoExamenMedico,IF(ingresoCargoExamenMedico = '1','Si','No') as ingresoCargoExamenMedicoL,cem.TipoExamenMedico_idTipoExamenMedico,cem.FrecuenciaMedicion_idFrecuenciaMedicion,cem.Cargo_idCargo,tem.nombreTipoExamenMedico,fmed.nombreFrecuenciaMedicion
            FROM cargoexamenmedico cem
            LEFT JOIN cargo  c
            ON cem.Cargo_idCargo = c.idCargo
            LEFT JOIN tipoexamenmedico tem
            ON cem.TipoExamenMedico_idTipoExamenMedico = tem.idTipoExamenMedico
            LEFT JOIN frecuenciamedicion fmed
            ON cem.FrecuenciaMedicion_idFrecuenciaMedicion = fmed.idFrecuenciaMedicion
            WHERE Cargo_idCargo = ".$id);

            $CargoVacuna = DB::select(
            "SELECT cvna.Cargo_idCargo,cvna.ListaGeneral_idVacuna,lgnal.nombreListaGeneral
            FROM
            cargovacuna cvna
            LEFT JOIN listageneral lgnal
            ON cvna.ListaGeneral_idVacuna = lgnal.idListaGeneral
            LEFT JOIN cargo c
            ON cvna.Cargo_idCargo = c.idCargo
            WHERE Cargo_idCargo = ".$id);

          $elementoproteccion = DB::select(
          "SELECT cep.Cargo_idCargo,cep.ElementoProteccion_idElementoProteccion,ep.nombreElementoProteccion
          FROM
          cargoelementoproteccion cep
          LEFT JOIN cargo c
          ON cep.Cargo_idCargo = c.idCargo
          LEFT JOIN elementoproteccion ep
          ON cep.ElementoProteccion_idElementoProteccion = ep.idElementoProteccion
          where Cargo_idCargo = ".$id);

          $Cargodepende = DB::select(
          "SELECT cs.nombreCargo
           FROM cargo cp
           LEFT JOIN cargo cs 
           ON cp.Cargo_idDepende = cs.idCargo
           WHERE cp.idCargo = ".$id);

           
  
  
  


            
         }

         return view('formatos.imprimirCargo',compact('Cargo','cargoeducacion','cargoformacion','cargohabilidad','cargoresponsabilidad','cargocompetencia','TareaRiesgo','ExamenMedico','CargoVacuna','elementoproteccion','Cargodepende'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $idListaTarea = \App\ListaGeneral::where('tipoListaGeneral','TareaAltoRiesgo')->lists('idListaGeneral');
        $nombreListaTarea = \App\ListaGeneral::where('tipoListaGeneral','TareaAltoRiesgo')->lists('nombreListaGeneral');
        
        $idTipoExamen = \App\TipoExamenMedico::All()->lists('idTipoExamenMedico');
        $nombreTipoExamen = \App\TipoExamenMedico::All()->lists('nombreTipoExamenMedico');

        $idListaVacuna = \App\ListaGeneral::where('tipoListaGeneral','Vacuna')->lists('idListaGeneral');
        $nombreListaVacuna = \App\ListaGeneral::where('tipoListaGeneral','Vacuna')->lists('nombreListaGeneral');

        $idListaElemento = \App\ElementoProteccion::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('idElementoProteccion');
        $nombreListaElemento = \App\ElementoProteccion::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('nombreElementoProteccion');

        $idFrecuenciaMedicion = \App\FrecuenciaMedicion::All()->lists('idFrecuenciaMedicion');
        $nombreFrecuenciaMedicion = \App\FrecuenciaMedicion::All()->lists('nombreFrecuenciaMedicion');

        $cargoPadre = \App\Cargo::where('Compania_idCompania', "=", \Session::get('idCompania'))->lists('nombreCargo','idCargo'); 
        $cargo = \App\Cargo::find($id);


        // Cuando editamos el cargo, debemos enviar los datos de las multiregistros que se deben cargar
        // Consultamos la multiregistro de EDUCACION (tabla cargoeducacion )
        $cargoeducacion = DB::select(
            "SELECT idCargoEducacion, PerfilCargo_idPerfilCargo as PerfilCargo_idEducacion, nombrePerfilCargo as  nombreEducacion, porcentajeCargoEducacion
            FROM cargoeducacion  CE
            LEFT JOIN perfilcargo  PC
            ON CE.PerfilCargo_idPerfilCargo = PC.idPerfilCargo
            WHERE Cargo_idCargo = ".$id);
        

       // para editar el cargo de formacion 
        $cargoformacion = DB::select(
            "SELECT idCargoFormacion,PerfilCargo_idPerfilCargo as PerfilCargo_idFormacion, nombrePerfilCargo as  nombreFormacion,porcentajeCargoFormacion
            FROM cargoformacion CF
            LEFT JOIN perfilcargo PC
            ON CF.PerfilCargo_idPerfilCargo = PC.idPerfilCargo
            WHERE Cargo_idCargo = ".$id);



        // $cargoHabilidad

        $cargohabilidad = DB::select(
            "SELECT idCargoHabilidad,PerfilCargo_idPerfilCargo as PerfilCargo_idHabilidad, nombrePerfilCargo as nombreHabilidad,porcentajeCargoHabilidad
            FROM cargohabilidad CH
            LEFT JOIN perfilcargo PC
            ON CH.PerfilCargo_idPerfilCargo = PC.idPerfilCargo
            WHERE Cargo_idCargo = ".$id);


        // $cargocompetencia

        $cargocompetencia = DB::select(
            "SELECT idCargoCompetencia,Competencia_idCompetencia,nombreCompetencia
            FROM cargocompetencia CC
            LEFT JOIN competencia CP
            ON CC.Competencia_idCompetencia = CP.idCompetencia
            WHERE Cargo_idCargo = ".$id);





         // Se retorna todas las consultas
        return view('cargo',compact('idListaTarea','nombreListaTarea','idTipoExamen','nombreTipoExamen','idListaVacuna','nombreListaVacuna','idListaElemento','nombreListaElemento','idFrecuenciaMedicion','nombreFrecuenciaMedicion','idFrecuenciaMedicion','nombreFrecuenciaMedicion','cargoeducacion','cargoformacion','cargohabilidad','cargocompetencia', 'cargoPadre'),['cargo'=>$cargo]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(CargoRequest $request, $id)
    {
        if($request['respuesta'] != 'falso')
        {    
            $cargo = \App\Cargo::find($id);
            $cargo->fill($request->all());
            $cargo->Cargo_idDepende = ($request['Cargo_idDepende'] == '' or $request['Cargo_idDepende'] == 0) ? null : $request['Cargo_idDepende'];

            $cargo->save();

            //---------------------------------
            // guardamos las tablas de detalle
            //---------------------------------
            $this->grabarDetalle($cargo->idCargo, $request);

            return redirect('/cargo');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        \App\Cargo::destroy($id);
        return redirect('/cargo');
    }

    protected function grabarDetalle($id, $request)
    {
        // en el formulario hay un campo oculto en el que almacenamos los id que se eliminan separados por coma
        // en este proceso lo convertimos en array y eliminamos dichos id de la tabla de detalle
        $idsEliminar = explode(',', $request['eliminarElemento']);
        \App\CargoElementoProteccion::whereIn('idCargoElementoProteccion',$idsEliminar)->delete();

        $contadorElemento = count($request['ElementoProteccion_idElementoProteccion']);
        for($i = 0; $i < $contadorElemento; $i++)
        {

            $indice = array(
             'idCargoElementoProteccion' => $request['idCargoElementoProteccion'][$i]);

            $data = array(
             'Cargo_idCargo' => $id,
             'ElementoProteccion_idElementoProteccion' => $request['ElementoProteccion_idElementoProteccion'][$i],
             'FrecuenciaMedicion_idFrecuenciaMedicion' => $request['FrecuenciaMedicion_idElemento'][$i],
             );

            $preguntas = \App\CargoElementoProteccion::updateOrCreate($indice, $data);

        }


        // en el formulario hay un campo oculto en el que almacenamos los id que se eliminan separados por coma
        // en este proceso lo convertimos en array y eliminamos dichos id de la tabla de detalle
        $idsEliminar = explode(',', $request['eliminarTarea']);
        \App\CargoTareaRiesgo::whereIn('idCargoTareaRiesgo',$idsEliminar)->delete();
        
        $contadorRiesgo = count($request['ListaGeneral_idTareaAltoRiesgo']);
        for($i = 0; $i < $contadorRiesgo; $i++)
        {
            $indice = array(
             'idCargoTareaRiesgo' => $request['idCargoTareaRiesgo'][$i]);

            $data = array(
             'Cargo_idCargo' => $id,
             'ListaGeneral_idTareaAltoRiesgo' => $request['ListaGeneral_idTareaAltoRiesgo'][$i]);

            $preguntas = \App\CargoTareaRiesgo::updateOrCreate($indice, $data);

        }


        // en el formulario hay un campo oculto en el que almacenamos los id que se eliminan separados por coma
        // en este proceso lo convertimos en array y eliminamos dichos id de la tabla de detalle
        $idsEliminar = explode(',', $request['eliminarVacuna']);
        \App\CargoVacuna::whereIn('idCargoVacuna',$idsEliminar)->delete();
        
        $contadorVacuna = count($request['ListaGeneral_idVacuna']);
        for($i = 0; $i < $contadorVacuna; $i++)
        {

            $indice = array(
             'idCargoVacuna' => $request['idCargoVacuna'][$i]);

            $data = array(
             'Cargo_idCargo' => $id,
             'ListaGeneral_idVacuna' => $request['ListaGeneral_idVacuna'][$i]);

            $preguntas = \App\CargoVacuna::updateOrCreate($indice, $data);

        }


        // en el formulario hay un campo oculto en el que almacenamos los id que se eliminan separados por coma
        // en este proceso lo convertimos en array y eliminamos dichos id de la tabla de detalle
        $idsEliminar = explode(',', $request['eliminarExamen']);
        \App\CargoExamenMedico::whereIn('idCargoExamenMedico',$idsEliminar)->delete();

        $contadorExamen = count($request['TipoExamenMedico_idTipoExamenMedico']);
        
        for($i = 0; $i < $contadorExamen; $i++)
        {

            $indice = array(
             'idCargoExamenMedico' => $request['idCargoExamenMedico'][$i]);

            $data = array(
             'Cargo_idCargo' => $id,
            'TipoExamenMedico_idTipoExamenMedico' => $request['TipoExamenMedico_idTipoExamenMedico'][$i], 
            'ingresoCargoExamenMedico' => $request['ingresoCargoExamenMedico'][$i], 
            'retiroCargoExamenMedico' => $request['retiroCargoExamenMedico'][$i], 
            'periodicoCargoExamenMedico' => $request['periodicoCargoExamenMedico'][$i], 
            'FrecuenciaMedicion_idFrecuenciaMedicion' => $request['FrecuenciaMedicion_idFrecuenciaMedicion'][$i] );

            $preguntas = \App\CargoExamenMedico::updateOrCreate($indice, $data);

           
        }

         // en el formulario hay un campo oculto en el que almacenamos los id que se eliminan separados por coma
         // en este proceso lo convertimos en array y eliminamos dichos id de la tabla de detalle
        //Descripcion Responsabilidad 
         $idsEliminar = explode(',', $request['eliminarResponsabilidades']);
         \App\CargoResponsabilidad::whereIn('idCargoResponsabilidad',$idsEliminar)->delete();


         for ($i=0; $i < count($request['descripcionCargoResponsabilidad']); $i++) 
         { 
            $indice = array(
             'idCargoResponsabilidad' => $request['idCargoResponsabilidad'][$i]);

            $data = array(
            'Cargo_idCargo' => $id,
            'descripcionCargoResponsabilidad' => $request['descripcionCargoResponsabilidad'][$i],
            'porcentajeCargoResponsabilidad' => $request['porcentajeCargoResponsabilidad'][$i] );

            $preguntas = \App\CargoResponsabilidad::updateOrCreate($indice, $data);

            
         }


         // en el formulario hay un campo oculto en el que almacenamos los id que se eliminan separados por coma
         // en este proceso lo convertimos en array y eliminamos dichos id de la tabla de detalle
        //Descripcion  
         //
         $idsEliminar = explode(',', $request['eliminarEducacion']);
         \App\CargoEducacion::whereIn('idCargoEducacion',$idsEliminar)->delete();


         for ($i=0; $i < count($request['idCargoEducacion']); $i++) 
         { 
            $indice = array(
             'idCargoEducacion' => $request['idCargoEducacion'][$i]);

            $data = array(
            'Cargo_idCargo' => $id,
            'PerfilCargo_idPerfilCargo' => $request['PerfilCargo_idEducacion'][$i],
            'porcentajeCargoEducacion' => $request['porcentajeCargoEducacion'][$i], );

            $preguntas = \App\CargoEducacion::updateOrCreate($indice, $data);
         }



         // en el formulario hay un campo oculto en el que almacenamos los id que se eliminan separados por coma
         // en este proceso lo convertimos en array y eliminamos dichos id de la tabla de detalle
        //Formacion
         //


           $idsEliminar = explode(',', $request['eliminarFormacion']);
         \App\CargoFormacion::whereIn('idCargoFormacion',$idsEliminar)->delete();


         for ($i=0; $i < count($request['idCargoFormacion']); $i++) 
         { 
            $indice = array(
             'idCargoFormacion' => $request['idCargoFormacion'][$i]);

            $data = array(
            'Cargo_idCargo' => $id,
            'PerfilCargo_idPerfilCargo' => $request['PerfilCargo_idFormacion'][$i],
            'porcentajeCargoFormacion' => $request['porcentajeCargoFormacion'][$i], );

            $preguntas = \App\CargoFormacion::updateOrCreate($indice, $data);
         }




         // en el formulario hay un campo oculto en el que almacenamos los id que se eliminan separados por coma
         // en este proceso lo convertimos en array y eliminamos dichos id de la tabla de detalle
        //Hablidad 
         //


           $idsEliminar = explode(',', $request['eliminarHabilidad']);
         \App\CargoHabilidad::whereIn('idCargoHabilidad',$idsEliminar)->delete();


         for ($i=0; $i < count($request['idCargoHabilidad']); $i++) 
         { 
            $indice = array(
             'idCargoHabilidad' => $request['idCargoHabilidad'][$i]);

            $data = array(
            'Cargo_idCargo' => $id,
            'PerfilCargo_idPerfilCargo' => $request['PerfilCargo_idHabilidad'][$i],
            'porcentajeCargoHabilidad' => $request['porcentajeCargoHabilidad'][$i], );

            $preguntas = \App\CargoHabilidad::updateOrCreate($indice, $data);
         }





         // en el formulario hay un campo oculto en el que almacenamos los id que se eliminan separados por coma
         // en este proceso lo convertimos en array y eliminamos dichos id de la tabla de detalle
        //Competencia 
         //


           $idsEliminar = explode(',', $request['eliminarCompetencia']);
         \App\CargoCompetencia::whereIn('idCargoCompetencia',$idsEliminar)->delete();


         for ($i=0; $i < count($request['idCargoCompetencia']); $i++) 
         { 
            $indice = array(
             'idCargoCompetencia' => $request['idCargoCompetencia'][$i]);

            $data = array(
            'Cargo_idCargo' => $id,
            'Competencia_idCompetencia' => $request['Competencia_idCompetencia'][$i]);

            $preguntas = \App\CargoCompetencia::updateOrCreate($indice, $data);
         }




}
}