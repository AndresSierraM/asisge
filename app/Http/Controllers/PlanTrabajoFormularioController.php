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
        Where PlanTrabajo_idPlanTrabajo = '.$id.' and Modulo_idModulo != 22
        order by nombreModulo');

        $plantrabajodetalleexamen = DB::Select('
        SELECT 
        nombreTipoExamenMedico, idTipoExamenMedico as TipoExamenMedico_idTipoExamenMedico, PlanTrabajo_idPlanTrabajo, idPlanTrabajoDetalle, Modulo_idModulo, nombreModulo, idConcepto, nombreConceptoPlanTrabajoDetalle, eneroPlanTrabajoDetalle, febreroPlanTrabajoDetalle, marzoPlanTrabajoDetalle, abrilPlanTrabajoDetalle, mayoPlanTrabajoDetalle, junioPlanTrabajoDetalle, julioPlanTrabajoDetalle, agostoPlanTrabajoDetalle, septiembrePlanTrabajoDetalle, octubrePlanTrabajoDetalle, noviembrePlanTrabajoDetalle,diciembrePlanTrabajoDetalle, cumplimientoPlanTrabajoDetalle,    metaPlanTrabajoDetalle, te.nombreCompletoTercero, te.idTercero, presupuestoPlanTrabajoDetalle,    costoRealPlanTrabajoDetalle, observacionPlanTrabajoDetalle

        FROM
            plantrabajodetalle ptd
                LEFT JOIN
            tipoexamenmedico TET ON ptd.TipoExamenMedico_idTipoExamenMedico = TET.idTipoExamenMedico
                LEFT JOIN

            tercero te ON ptd.Tercero_idResponsable = te.idTercero
            cargo c ON ptd.Cargo_idResponsable = c.idCargo
                LEFT JOIN
            modulo m ON ptd.Modulo_idModulo = m.idModulo
        WHERE
            PlanTrabajo_idPlanTrabajo = '.$id.'
                AND Modulo_idModulo = 22
                group by idPlanTrabajoDetalle
        ORDER BY nombreTipoExamenMedico');

        return view('plantrabajoformulario', compact('Tercero_idAuditor','Cargo_idResponsable','plantrabajodetalle','plantrabajodetalleexamen'),['plantrabajoformulario'=>$plantrabajoformulario]);
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
             'idPlanTrabajoDetalle' => $request['idPlanTrabajoDetalle'][$i]);

            $data = array(
            'PlanTrabajo_idPlanTrabajo' => $id,
            'Modulo_idModulo' => $request['Modulo_idModulo'][$i],
            'idConcepto' => $request['idConcepto'][$i],
            'TipoExamenMedico_idTipoExamenMedico' => ($request['TipoExamenMedico_idTipoExamenMedico'][$i] == '' ? NULL : $request['TipoExamenMedico_idTipoExamenMedico'][$i]),
            'nombreConceptoPlanTrabajoDetalle' => $request['nombreConceptoPlanTrabajoDetalle'][$i],
            'eneroPlanTrabajoDetalle' => ($request['eneroPlanTrabajoDetalle'][$i] == '' ? NULL : $request['eneroPlanTrabajoDetalle'][$i]),
            'febreroPlanTrabajoDetalle' => ($request['febreroPlanTrabajoDetalle'][$i] == '' ? NULL : $request['febreroPlanTrabajoDetalle'][$i]),
            'marzoPlanTrabajoDetalle' => ($request['marzoPlanTrabajoDetalle'][$i] == '' ? NULL : $request['marzoPlanTrabajoDetalle'][$i]),
            'abrilPlanTrabajoDetalle' => ($request['abrilPlanTrabajoDetalle'][$i] == '' ? NULL : $request['abrilPlanTrabajoDetalle'][$i]),
            'mayoPlanTrabajoDetalle' => ($request['mayoPlanTrabajoDetalle'][$i] == '' ? NULL : $request['mayoPlanTrabajoDetalle'][$i]),
            'junioPlanTrabajoDetalle' => ($request['junioPlanTrabajoDetalle'][$i] == '' ? NULL : $request['junioPlanTrabajoDetalle'][$i]),
            'julioPlanTrabajoDetalle' => ($request['julioPlanTrabajoDetalle'][$i] == '' ? NULL : $request['julioPlanTrabajoDetalle'][$i]),
            'agostoPlanTrabajoDetalle' => ($request['agostoPlanTrabajoDetalle'][$i] == '' ? NULL : $request['agostoPlanTrabajoDetalle'][$i]),
            'septiembrePlanTrabajoDetalle' => ($request['septiembrePlanTrabajoDetalle'][$i] == '' ? NULL : $request['septiembrePlanTrabajoDetalle'][$i]),
            'octubrePlanTrabajoDetalle' => ($request['octubrePlanTrabajoDetalle'][$i] == '' ? NULL : $request['octubrePlanTrabajoDetalle'][$i]),
            'noviembrePlanTrabajoDetalle' => ($request['noviembrePlanTrabajoDetalle'][$i] == '' ? NULL : $request['noviembrePlanTrabajoDetalle'][$i]),
            'diciembrePlanTrabajoDetalle' => ($request['diciembrePlanTrabajoDetalle'][$i] == '' ? NULL : $request['diciembrePlanTrabajoDetalle'][$i]),
            'presupuestoPlanTrabajoDetalle' => $request['presupuestoPlanTrabajoDetalle'][$i],
            'costoRealPlanTrabajoDetalle' => $request['costoRealPlanTrabajoDetalle'][$i],
            'cumplimientoPlanTrabajoDetalle' => $request['cumplimientoPlanTrabajoDetalle'][$i],
            'metaPlanTrabajoDetalle' => $request['metaPlanTrabajoDetalle'][$i],
            'Cargo_idResponsable' => ($request['Cargo_idResponsable'][$i] == '' ? NULL : $request['Cargo_idResponsable'][$i]),
            'observacionPlanTrabajoDetalle' => $request['observacionPlanTrabajoDetalle'][$i] 
            );

            $preguntas = \App\PlanTrabajoDetalle::updateOrCreate($indice, $data);
        }
    }
}
