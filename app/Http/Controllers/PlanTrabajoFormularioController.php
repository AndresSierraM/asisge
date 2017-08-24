<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\PlanTrabajoFormularioRequest;
use App\Http\Controllers\Controller;
use DB;
include public_path().'/ajax/consultarPermisos.php';

class PlanTrabajoFormularioController extends Controller
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
            return view('plantrabajogrid', compact('datos'));
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
        $Tercero_idAuditor = \App\Tercero::where('Compania_idCompania','=', \Session::get('idCompania'))->where('tipoTercero','like','%*01*%')->lists('nombreCompletoTercero','idTercero');

        $Cargo_idResponsable = \App\Cargo::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('nombreCargo','idCargo');
        
        return view('plantrabajoformulario', compact('Tercero_idAuditor', 'Cargo_idResponsable'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PlanTrabajoFormularioRequest $request)
    {
        if($request['respuesta'] != 'falso')
        {    
            \App\PlanTrabajo::create([
            'numeroPlanTrabajo' => $request['numeroPlanTrabajo'],
            'asuntoPlanTrabajo' => $request['asuntoPlanTrabajo'],
            'fechaPlanTrabajo' => $request['fechaPlanTrabajo'],
            'Tercero_idAuditor' => $request['Tercero_idAuditor'],
            'firmaAuditorPlanTrabajo' => $request['firmaAuditorPlanTrabajo'],
            'Compania_idCompania' => \Session::get('idCompania')
            ]);

            $plantrabajoformulario = \App\PlanTrabajo::All()->last();
            
            // armamos una ruta para el archivo de imagen y volvemos a actualizar el registro
            // esto es porque la creamos con el ID del plan de trabajo y debiamos grabar primero para obtenerlo
            $ruta = 'plantrabajo/firmaAuditorPlanTrabajo_'.$plantrabajoformulario->idPlanTrabajo.'.png';
            $plantrabajoformulario->firmaAuditorPlanTrabajo = $ruta;

            $plantrabajoformulario->save();

            //----------------------------
            // Guardamos la imagen de la firma como un archivo en disco
            if (isset($request['firmabase64']) and $request['firmabase64'] != '') 
            {
                $data = $request['firmabase64'];

                list($type, $data) = explode(';', $data);
                list(, $data)      = explode(',', $data);
                $data = base64_decode($data);

                file_put_contents('imagenes/'.$ruta, $data);
            }

            //----------------------------
            //---------------------------------
            // guardamos las tablas de detalle
            //---------------------------------
            $this->grabarDetalle($plantrabajoformulario->idPlanTrabajo, $request);

            return redirect('/plantrabajoformulario');    
        }
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
        $cargoR = \App\Cargo::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('nombreCargo','idCargo');
        $Tercero_idAuditor = \App\Tercero::where('Compania_idCompania','=', \Session::get('idCompania'))->where('tipoTercero','like','%*01*%')->lists('nombreCompletoTercero','idTercero');
        $plantrabajoformulario = \App\PlanTrabajo::find($id);

        $Cargo_idResponsable = \App\Cargo::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('nombreCargo','idCargo');

        // $accidente = \App\Accidente::where('Compania_idCompania', "=", \Session::get('idCompania'));
        // $auditoria = \App\PlanAuditoria::where('Compania_idCompania', "=", \Session::get('idCompania'));
        // $capacitacion = \App\PlanCapacitacion::where('Compania_idCompania', "=", \Session::get('idCompania'));
        // $programa = \App\Programa::where('Compania_idCompania', "=", \Session::get('idCompania'));
        // $examen = \App\ExamenMedico::where('Compania_idCompania', "=", \Session::get('idCompania'));
        // $inspeccion = \App\TipoInspeccion::where('Compania_idCompania', "=", \Session::get('idCompania'));
        // $matrizlegal = \App\MatrizLegal::where('Compania_idCompania', "=", \Session::get('idCompania'));
        // $grupoapoyo = \App\GrupoApoyo::where('Compania_idCompania', "=", \Session::get('idCompania'));

        $plantrabajodetalle = DB::Select('
        SELECT PlanTrabajo_idPlantrabajo, idPlanTrabajoDetalle,Modulo_idModulo, nombreModulo, PlanTrabajo_idPlanTrabajo,idConcepto,TipoExamenMedico_idTipoExamenMedico,nombreConceptoPlanTrabajoDetalle,eneroPlanTrabajoDetalle,febreroPlanTrabajoDetalle,marzoPlanTrabajoDetalle,abrilPlanTrabajoDetalle, mayoPlanTrabajoDetalle, junioPlanTrabajoDetalle, julioPlanTrabajoDetalle, agostoPlanTrabajoDetalle, septiembrePlanTrabajoDetalle, octubrePlanTrabajoDetalle, noviembrePlanTrabajoDetalle, diciembrePlanTrabajoDetalle, cumplimientoPlanTrabajoDetalle, metaPlanTrabajoDetalle, nombreCargo, idCargo, presupuestoPlanTrabajoDetalle, costoRealPlanTrabajoDetalle, observacionPlanTrabajoDetalle 

        from plantrabajodetalle ptd 
        left join cargo c on c.idCargo = ptd.Cargo_idResponsable
        left join modulo m on ptd.Modulo_idModulo = m.idModulo
        Where PlanTrabajo_idPlanTrabajo = '.$id.' 
        order by nombreModulo');

        return view('plantrabajoformulario', compact('Tercero_idAuditor','Cargo_idResponsable','plantrabajodetalle'),['plantrabajoformulario'=>$plantrabajoformulario]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PlanTrabajoFormularioRequest $request, $id)
    {
        if($request['respuesta'] != 'falso')
        {    
            $plantrabajoformulario = \App\PlanTrabajo::find($id);
            $plantrabajoformulario->fill($request->all());
            
            // armamos una ruta para el archivo de imagen y volvemos a actualizar el registro
            // esto es porque la creamos con el ID del plan de trabajo y debiamos grabar primero para obtenerlo
            $ruta = 'plantrabajo/firmaAuditorPlanTrabajo_'.$plantrabajoformulario->idPlanTrabajo.'.png';
            $plantrabajoformulario->firmaAuditorPlanTrabajo = $ruta;

            $plantrabajoformulario->save();

            //----------------------------
            // Guardamos la imagen de la firma como un archivo en disco
            if (isset($request['firmabase64']) and $request['firmabase64'] != '') 
            {
                $data = $request['firmabase64'];

                list($type, $data) = explode(';', $data);
                list(, $data)      = explode(',', $data);
                $data = base64_decode($data);

                file_put_contents('imagenes/'.$ruta, $data);
            }

            //----------------------------

            //---------------------------------
            // guardamos las tablas de detalle
            //---------------------------------
            $this->grabarDetalle($plantrabajoformulario->idPlanTrabajo, $request);

            return redirect('/plantrabajoformulario');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        \App\PlanTrabajo::destroy($id);
        return redirect('/plantrabajoformulario');
    }

    protected function grabarDetalle($id, $request)
    {

        $contadorPlanTrabajo = count($request['observacionPlanTrabajoDetalle']);
        
        for($i = 0; $i < $contadorPlanTrabajo; $i++)
        {
            $indice = array(
             'idPlanTrabajoDetalle' => @$request['idPlanTrabajoDetalle'][$i]);

            $data = array(
            'PlanTrabajo_idPlanTrabajo' => $id,
            'Modulo_idModulo' => (empty($request['Modulo_idModulo'][$i]) ? 0 : $request['Modulo_idModulo'][$i]),
            'idConcepto' => (empty($request['idConcepto'][$i]) ? 0 : $request['idConcepto'][$i]),
            'TipoExamenMedico_idTipoExamenMedico' => (empty($request['TipoExamenMedico_idTipoExamenMedico'][$i]) ? 0 : $request['TipoExamenMedico_idTipoExamenMedico'][$i]),
            'nombreConceptoPlanTrabajoDetalle' => (empty($request['nombreConceptoPlanTrabajoDetalle'][$i]) ? 0 : $request['nombreConceptoPlanTrabajoDetalle'][$i]),
            'eneroPlanTrabajoDetalle' => (empty($request['eneroPlanTrabajoDetalle'][$i]) ? null : $request['eneroPlanTrabajoDetalle'][$i]),
            'febreroPlanTrabajoDetalle' => (empty($request['febreroPlanTrabajoDetalle'][$i]) ? null : $request['febreroPlanTrabajoDetalle'][$i]),
            'marzoPlanTrabajoDetalle' => (empty($request['marzoPlanTrabajoDetalle'][$i]) ? null : $request['marzoPlanTrabajoDetalle'][$i]),
            'abrilPlanTrabajoDetalle' => (empty($request['abrilPlanTrabajoDetalle'][$i]) ? null : $request['abrilPlanTrabajoDetalle'][$i]),
            'mayoPlanTrabajoDetalle' => (empty($request['mayoPlanTrabajoDetalle'][$i]) ? null : $request['mayoPlanTrabajoDetalle'][$i]),
            'junioPlanTrabajoDetalle' => (empty($request['junioPlanTrabajoDetalle'][$i]) ? null : $request['junioPlanTrabajoDetalle'][$i]),
            'julioPlanTrabajoDetalle' => (empty($request['julioPlanTrabajoDetalle'][$i]) ? null : $request['julioPlanTrabajoDetalle'][$i]),
            'agostoPlanTrabajoDetalle' => (empty($request['agostoPlanTrabajoDetalle'][$i]) ? null : $request['agostoPlanTrabajoDetalle'][$i]),
            'septiembrePlanTrabajoDetalle' => (empty($request['septiembrePlanTrabajoDetalle'][$i]) ? null : $request['septiembrePlanTrabajoDetalle'][$i]),
            'octubrePlanTrabajoDetalle' => (empty($request['octubrePlanTrabajoDetalle'][$i]) ? null : $request['octubrePlanTrabajoDetalle'][$i]),
            'noviembrePlanTrabajoDetalle' => (empty($request['noviembrePlanTrabajoDetalle'][$i]) ? null : $request['noviembrePlanTrabajoDetalle'][$i]),
            'diciembrePlanTrabajoDetalle' => (empty($request['diciembrePlanTrabajoDetalle'][$i]) ? null : $request['diciembrePlanTrabajoDetalle'][$i]),
            'presupuestoPlanTrabajoDetalle' => (empty($request['presupuestoPlanTrabajoDetalle'][$i]) ? 0 : $request['presupuestoPlanTrabajoDetalle'][$i]),
            'costoRealPlanTrabajoDetalle' => (empty($request['costoRealPlanTrabajoDetalle'][$i]) ? 0 : $request['costoRealPlanTrabajoDetalle'][$i]),
            'cumplimientoPlanTrabajoDetalle' => (empty($request['cumplimientoPlanTrabajoDetalle'][$i]) ? 0 : $request['cumplimientoPlanTrabajoDetalle'][$i]),
            'metaPlanTrabajoDetalle' => (empty($request['metaPlanTrabajoDetalle'][$i]) ? 0 : $request['metaPlanTrabajoDetalle'][$i]),
            'Cargo_idResponsable' => null,
            'observacionPlanTrabajoDetalle' => (empty($request['observacionPlanTrabajoDetalle'][$i]) ? 0 : $request['observacionPlanTrabajoDetalle'][$i])
            );

            $preguntas = \App\PlanTrabajoDetalle::updateOrCreate($indice, $data);
        }
        
    }
}
