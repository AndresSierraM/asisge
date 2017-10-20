<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// use App\Http\Requests\PerfilCargoRequest;
use App\Http\Controllers\Controller;
use DB;

include public_path().'/ajax/consultarPermisos.php';

class PlanEmergenciaController extends Controller
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
          return view('planemergenciagrid', compact('datos'));
         else
            return view('accesodenegado');
        
        // return view('perfilcargogrid');

     }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       
        $centrocosto = \App\CentroCosto::where('Compania_idCompania', "=", \Session::get('idCompania'))->lists('nombreCentroCosto','idCentroCosto');
        $tercero = \App\Tercero::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('nombreCompletoTercero','idTercero');
         
        return view ('planemergencia', compact('centrocosto','tercero'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
     if($request['respuesta'] != 'falso')
        {  
         \App\PlanEmergencia::create([
         'fechaElaboracionPlanEmergencia' => $request['fechaElaboracionPlanEmergencia'],
         'nombrePlanEmergencia' => $request['nombrePlanEmergencia'],
         'CentroCosto_idCentroCosto'=> $request['CentroCosto_idCentroCosto'], 
         'justificacionPlanEmergencia'=> $request['justificacionPlanEmergencia'],
         'marcoLegalPlanEmergencia'=> $request['marcoLegalPlanEmergencia'],
         'definicionesPlanEmergencia'=> $request['definicionesPlanEmergencia'],
         'generalidadesPlanEmergencia'=> $request['generalidadesPlanEmergencia'],
         'objetivosPlanEmergencia'=> $request['objetivosPlanEmergencia'],
         'alcancePlanEmergencia'=> $request['alcancePlanEmergencia'],
         'nitPlanEmergencia'=> $request['nitPlanEmergencia'],
         'direccionPlanEmergencia'=> $request['direccionPlanEmergencia'],
         'telefonoPlanEmergencia'=> $request['telefonoPlanEmergencia'],
         'ubicacionPlanEmergencia'=> $request['ubicacionPlanEmergencia'],
         'personalOperativoPlanEmergencia'=> $request['personalOperativoPlanEmergencia'],
         'personalAdministrativoPlanEmergencia'=> $request['personalAdministrativoPlanEmergencia'],
         'turnoOperativoPlanEmergencia'=> $request['turnoOperativoPlanEmergencia'],
         'turnoAdministrativoPlanEmergencia'=> $request['turnoAdministrativoPlanEmergencia'],
         'visitasDiaPlanEmergencia'=> $request['visitasDiaPlanEmergencia'],
         // 'procedimientoEmergenciaPlanEmergencia'=> $request['procedimientoEmergenciaPlanEmergencia'],
         // 'sistemaAlertaPlanEmergencia'=> $request['sistemaAlertaPlanEmergencia'],
         // 'notificacionInternaPlanEmergencia'=> $request['notificacionInternaPlanEmergencia'],
         // 'rutasEvacuacionPlanEmergencia'=> $request['rutasEvacuacionPlanEmergencia'],
         // 'sistemaComunicacionPlanEmergencia'=> $request['sistemaComunicacionPlanEmergencia'],
         // 'coordinacionSocorroPlanEmergencia'=> $request['coordinacionSocorroPlanEmergencia'],
         // 'cesePeligroPlanEmergencia'=> $request['cesePeligroPlanEmergencia'],
         // 'capacitacionSimulacroPlanEmergencia'=> $request['capacitacionSimulacroPlanEmergencia'],
         // 'analisisVulnerabilidadPlanEmergencia'=> $request['analisisVulnerabilidadPlanEmergencia'],
         // 'listaAnexosPlanEmergencia'=> $request['listaAnexosPlanEmergencia'],
         'Tercero_idRepresentanteLegal'=> $request['Tercero_idRepresentanteLegal'],
         // 'firmaRepresentantePlanEmergencia'=> $request['firmaRepresentantePlanEmergencia'],
         'Compania_idCompania' => \Session::get('idCompania')
        ]);

            // en esta parte es el guardado de la multiregistro descripcion
           //Primero consultar el ultimo id guardado
       $planemergencia = \App\PlanEmergencia::All()->last();
           //for para guardar cada registro de la multiregistro



       // Multiregistro limite Guardado
        for ($i=0; $i < count($request['sedePlanEmergenciaLimite']); $i++) 
           { 
            \App\PlanEmergenciaLimite::create([
            'PlanEmergencia_idPlanEmergencia' => $planemergencia->idPlanEmergencia,
            'sedePlanEmergenciaLimite' => $request['sedePlanEmergenciaLimite'][$i],
            'nortePlanEmergenciaLimite' => $request['nortePlanEmergenciaLimite'][$i], 
            'surPlanEmergenciaLimite' => $request['surPlanEmergenciaLimite'][$i],
            'orientePlanEmergenciaLimite' => $request['orientePlanEmergenciaLimite'][$i],
            'occidentePlanEmergenciaLimite' => $request['occidentePlanEmergenciaLimite'][$i]
              ]);
           }

           // Multiregistro inventario Guardado
           for ($i=0; $i < count($request['sedePlanEmergenciaInventario']); $i++) 
           { 
            \App\PlanEmergenciaInventario::create([
            'PlanEmergencia_idPlanEmergencia' => $planemergencia->idPlanEmergencia,
            'sedePlanEmergenciaInventario' => $request['sedePlanEmergenciaInventario'][$i],
            'recursoPlanEmergenciaInventario' => $request['recursoPlanEmergenciaInventario'][$i], 
            'cantidadPlanEmergenciaInventario' => $request['cantidadPlanEmergenciaInventario'][$i],
            'ubicacionPlanEmergenciaInventario' => $request['ubicacionPlanEmergenciaInventario'][$i],
            'observacionPlanEmergenciaInventario' => $request['observacionPlanEmergenciaInventario'][$i]
              ]);
           }


           
     }
            

         return redirect('/planemergencia');
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
        $planemergencia = \App\PlanEmergencia::find($id);
        $centrocosto = \App\CentroCosto::where('Compania_idCompania', "=", \Session::get('idCompania'))->lists('nombreCentroCosto','idCentroCosto');
        $tercero = \App\Tercero::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('nombreCompletoTercero','idTercero');


      $PlanEmergenciaLimite = DB::SELECT('
        SELECT pel.idPlanEmergenciaLimite,pel.PlanEmergencia_idPlanEmergencia,pel.sedePlanEmergenciaLimite,pel.nortePlanEmergenciaLimite,pel.surPlanEmergenciaLimite,pel.orientePlanEmergenciaLimite,pel.occidentePlanEmergenciaLimite
        FROM planemergencialimite pel
        LEFT JOIN planemergencia pe
        ON pel.PlanEmergencia_idPlanEmergencia = pe.idPlanEmergencia
        WHERE pel.PlanEmergencia_idPlanEmergencia ='.$id);


      $PlanEmergenciaInventario = DB::SELECT('
         SELECT pei.idPlanEmergenciaInventario, pei.PlanEmergencia_idPlanEmergencia,pei.sedePlanEmergenciaInventario,pei.recursoPlanEmergenciaInventario,pei.cantidadPlanEmergenciaInventario,pei.ubicacionPlanEmergenciaInventario,pei.observacionPlanEmergenciaInventario
        FROM planemergenciainventario pei
        LEFT JOIN planemergencia pe
        ON pei.PlanEmergencia_idPlanEmergencia = pe.idPlanEmergencia
        WHERE pei.PlanEmergencia_idPlanEmergencia ='.$id);


        return view('planemergencia',compact('PlanEmergenciaInventario','PlanEmergenciaLimite','centrocosto','tercero'),['planemergencia'=>$planemergencia]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $planemergencia = \App\PlanEmergencia::find($id);
        $planemergencia->fill($request->all());
        $planemergencia->CentroCosto_idCentroCosto = (($request['CentroCosto_idCentroCosto'] == '' or $request['CentroCosto_idCentroCosto'] == 0) ? null : $request['CentroCosto_idCentroCosto'
                ]);

        $planemergencia->Tercero_idRepresentanteLegal = (($request['Tercero_idRepresentanteLegal'] == '' or $request['Tercero_idRepresentanteLegal'] == 0) ? null : $request['Tercero_idRepresentanteLegal'
                ]);

        $planemergencia->save();

              // Update para el detalle de  limite
             $idsEliminar = explode("," , $request['eliminarlimite']);
            //Eliminar registros de la multiregistro
            \App\PlanEmergenciaLimite::whereIn('idPlanEmergenciaLimite', $idsEliminar)->delete();
            // Guardamos el detalle de los modulos
            for($i = 0; $i < count($request['idPlanEmergenciaLimite']); $i++)
            {
                 $indice = array(
                    'idPlanEmergenciaLimite' => $request['idPlanEmergenciaLimite'][$i]);

                $data = array(
                'PlanEmergencia_idPlanEmergencia' => $planemergencia->idPlanEmergencia,
                'sedePlanEmergenciaLimite' => $request['sedePlanEmergenciaLimite'][$i],
                'nortePlanEmergenciaLimite' => $request['nortePlanEmergenciaLimite'][$i], 
                'surPlanEmergenciaLimite' => $request['surPlanEmergenciaLimite'][$i],
                'orientePlanEmergenciaLimite' => $request['orientePlanEmergenciaLimite'][$i],
                'occidentePlanEmergenciaLimite' => $request['occidentePlanEmergenciaLimite'][$i]
                  );

                $guardar = \App\PlanEmergenciaLimite::updateOrCreate($indice, $data);
            } 



                   // Update para el detalle de  limite
             $idsEliminar = explode("," , $request['eliminarInventario']);
            //Eliminar registros de la multiregistro
            \App\PlanEmergenciaInventario::whereIn('idPlanEmergenciaInventario', $idsEliminar)->delete();
            // Guardamos el detalle de los modulos
            for($i = 0; $i < count($request['idPlanEmergenciaInventario']); $i++)
            {
                 $indice = array(
                    'idPlanEmergenciaInventario' => $request['idPlanEmergenciaInventario'][$i]);

                $data = array(
                'PlanEmergencia_idPlanEmergencia' => $planemergencia->idPlanEmergencia,
                'sedePlanEmergenciaInventario' => $request['sedePlanEmergenciaInventario'][$i],
                'recursoPlanEmergenciaInventario' => $request['recursoPlanEmergenciaInventario'][$i], 
                'cantidadPlanEmergenciaInventario' => $request['cantidadPlanEmergenciaInventario'][$i],
                'ubicacionPlanEmergenciaInventario' => $request['ubicacionPlanEmergenciaInventario'][$i],
                'observacionPlanEmergenciaInventario' => $request['observacionPlanEmergenciaInventario'][$i]
                  );

                $guardar = \App\PlanEmergenciaInventario::updateOrCreate($indice, $data);
            } 

        return redirect('planemergencia');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        \App\PlanEmergencia::destroy($id);
        return redirect('/planemergencia');
    }
}
