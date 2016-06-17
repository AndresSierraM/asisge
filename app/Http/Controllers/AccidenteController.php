<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\AccidenteRequest;
use App\Http\Controllers\ReporteACPMController;

use Illuminate\Routing\Route;
use DB;

// use traitSisoft;


class AccidenteController extends Controller
{
    public function _construct(){
        $this->beforeFilter('@find',['only'=>['edit','update','destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function find(Route $route){
        $this->accidente = \App\Accidente::find($route->getParameter('accidente'));
        return $this->accidente;
    }

    public function index()
    {
        return view('accidentegrid');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $terceroCoord = \App\Tercero::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('nombreCompletoTercero','idTercero');
        $terceroEmple = \App\Tercero::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('nombreCompletoTercero','idTercero');
        

        $ausentismo  = \App\Ausentismo::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('nombreAusentismo','idAusentismo');
         
        $proceso  = \App\Proceso::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('nombreProceso','idProceso');
        $idProceso  = \App\Proceso::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('idProceso');
        $nombreProceso  = \App\Proceso::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('nombreProceso');
        $idTercero = \App\Tercero::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('idTercero');
        $nombreCompletoTercero = \App\Tercero::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('nombreCompletoTercero');
        return view('accidente',compact('terceroCoord','terceroEmple','ausentismo',
            'proceso','idProceso','nombreProceso','idTercero','nombreCompletoTercero'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(AccidenteRequest $request)
    {
        
        \App\Accidente::create([
            'numeroAccidente' => $request['numeroAccidente'],
            'nombreAccidente' => $request['nombreAccidente'],
            'clasificacionAccidente' => $request['clasificacionAccidente'],
            'Ausentismo_idAusentismo' => (($request['Ausentismo_idAusentismo'] == '') ? null : $request['Ausentismo_idAusentismo']),
            'Tercero_idCoordinador' => $request['Tercero_idCoordinador'],
            'Tercero_idEmpleado' => $request['Tercero_idEmpleado'],
            'edadEmpleadoAccidente' => $request['edadEmpleadoAccidente'],
            'tiempoServicioAccidente' => $request['tiempoServicioAccidente'],
            'Proceso_idProceso' => $request['Proceso_idProceso'],
            'enSuLaborAccidente' => (($request['enSuLaborAccidente'] !== null) ? 1 : 0),
            'laborAccidente' => $request['laborAccidente'],
            'enLaEmpresaAccidente' => (($request['enLaEmpresaAccidente'] !== null) ? 1 : 0),
            'lugarAccidente' => $request['lugarAccidente'],
            'fechaOcurrenciaAccidente' => $request['fechaOcurrenciaAccidente'],
            'tiempoEnLaborAccidente' => $request['tiempoEnLaborAccidente'],
            'tareaDesarrolladaAccidente' => $request['tareaDesarrolladaAccidente'],
            'descripcionAccidente' => $request['descripcionAccidente'],
            'observacionTrabajadorAccidente' => $request['observacionTrabajadorAccidente'],
            'observacionEmpresaAccidente' => $request['observacionEmpresaAccidente'],
            'agenteYMecanismoAccidente' => $request['agenteYMecanismoAccidente'],
            'naturalezaLesionAccidente' => $request['naturalezaLesionAccidente'],
            'parteCuerpoAfectadaAccidente' => $request['parteCuerpoAfectadaAccidente'],
            'tipoAccidente' => $request['tipoAccidente'],
            'observacionAccidente'  => $request['observacionAccidente'],
            'Compania_idCompania' => \Session::get('idCompania')
            ]);


        $accidente = \App\Accidente::All()->last();

        // armamos una ruta para el archivo de imagen y volvemos a actualizar el registro
        // esto es porque la creamos con el ID del accidente y debiamos grabar primero para obtenerlo
        $accidente->firmaCoordinadorAccidente = 'accidente/firmaaccidente_'.$accidente->idAccidente.'.png';

        $accidente->save();

        //----------------------------
        // Guardamos la imagen de la firma como un archivo en disco
        $data = $request['firmabase64'];

        list($type, $data) = explode(';', $data);
        list(, $data)      = explode(',', $data);
        $data = base64_decode($data);

        file_put_contents('imagenes/accidente/firmaaccidente_'.$accidente->idAccidente.'.png', $data);
        //----------------------------

        //---------------------------------
        // guardamos las tablas de detalle
        //---------------------------------
        $this->grabarDetalle($accidente->idAccidente, $request);
        

        return redirect('/accidente');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $accidente = \App\Accidente::find($id);
        $terceroCoord = \App\Tercero::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('nombreCompletoTercero','idTercero');
        $terceroEmple = \App\Tercero::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('nombreCompletoTercero','idTercero');
        $ausentismo  = \App\Ausentismo::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('nombreAusentismo','idAusentismo');
        $proceso  = \App\Proceso::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('nombreProceso','idProceso');
        $idProceso  = \App\Proceso::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('idProceso');
        $nombreProceso  = \App\Proceso::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('nombreProceso');
        $idTercero = \App\Tercero::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('idTercero');
        $nombreCompletoTercero = \App\Tercero::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('nombreCompletoTercero');
        

        
        return view('accidente',compact('terceroCoord','terceroEmple','ausentismo',
            'proceso','idProceso','nombreProceso','idTercero','nombreCompletoTercero'),['accidente'=>$accidente]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(AccidenteRequest $request, $id)
    {
        $accidente = \App\Accidente::find($id);
        $accidente->fill($request->all());
        $accidente->enSuLaborAccidente = (($request['enSuLaborAccidente'] !== null) ? 1 : 0);
        $accidente->enLaEmpresaAccidente = (($request['enLaEmpresaAccidente'] !== null) ? 1 : 0);
        $accidente->Ausentismo_idAusentismo = (($request['Ausentismo_idAusentismo'] == '') ? null : $request['Ausentismo_idAusentismo']);
        $accidente->firmaCoordinadorAccidente = 'accidente/firmaaccidente_'.$id.'.png';

        $accidente->save();

        //----------------------------
        // Guardamos la imagen de la firma como un archivo en disco
        $data = $request['firmabase64'];
        if($data != '')
        {
            list($type, $data) = explode(';', $data);
            list(, $data)      = explode(',', $data);
            $data = base64_decode($data);

            file_put_contents('imagenes/accidente/firmaaccidente_'.$id.'.png', $data);
        }
        //----------------------------


        //---------------------------------
        // guardamos las tablas de detalle
        //---------------------------------
        $this->grabarDetalle($id, $request);
       

       return redirect('/accidente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        \App\Accidente::destroy($id);
        return redirect('/accidente');
    }

    protected function grabarDetalle($id, $request)
    {
        // en el formulario hay un campo oculto en el que almacenamos los id que se eliminan separados por coma
        // en este proceso lo convertimos en array y eliminamos dichos id de la tabla de detalle
        $idsEliminar = explode(',', $request['eliminarRecomendacion']);
        \App\AccidenteRecomendacion::whereIn('idAccidenteRecomendacion',$idsEliminar)->delete();

        $contadorDetalle = count($request['idAccidenteRecomendacion']);
        $causas = '';
        
        for($i = 0; $i < $contadorDetalle; $i++)
        {

            $indice = array(
                'idAccidenteRecomendacion' => $request['idAccidenteRecomendacion'][$i]);

            $data = array(
                'Accidente_idAccidente' => $id, 
                'controlAccidenteRecomendacion' => $request['controlAccidenteRecomendacion'][$i], 
                'fuenteAccidenteRecomendacion' => $request['fuenteAccidenteRecomendacion'][$i], 
                'medioAccidenteRecomendacion' => $request['medioAccidenteRecomendacion'][$i], 
                'personaAccidenteRecomendacion' => $request['personaAccidenteRecomendacion'][$i], 
                'fechaVerificacionAccidenteRecomendacion' => $request['fechaVerificacionAccidenteRecomendacion'][$i], 
                'medidaEfectivaAccidenteRecomendacion' => $request['medidaEfectivaAccidenteRecomendacion'][$i], 
                'Proceso_idResponsable' => $request['Proceso_idResponsable'][$i]);

            $respuesta = \App\AccidenteRecomendacion::updateOrCreate($indice, $data);

            $causas .= $request['controlAccidenteRecomendacion'][$i].', ';
        }

        $causas = substr($causas, 0, strlen($causas)-2);

        
        //************************************************
        //
        //  R E P O R T E   A C C I O N E S   
        //  C O R R E C T I V A S,  P R E V E N T I V A S 
        //  Y   D E   M E J O R A 
        //
        //************************************************
        // todos los accidentes o incidentes los  insertamos un registro en el ACPM (Accion Correctiva)

        //COnsultamos el nombre del tercero empleado
        $nombreTercero = \App\Tercero::find($request['Tercero_idEmpleado']);

        $this->guardarReporteACPM(
                $fechaAccion = date("Y-m-d"), 
                $idModulo = 3, 
                $tipoAccion = 'Correctiva', 
                $descripcionAccion = 'Para el '.$request['clasificacionAccidente'].' de '.$nombreTercero->nombreCompletoTercero.', se recomienda implementar controles por las siguientes causas: '.$causas
                );   

                
        // en el formulario hay un campo oculto en el que almacenamos los id que se eliminan separados por coma
        // en este proceso lo convertimos en array y eliminamos dichos id de la tabla de detalle
        $idsEliminar = explode(',', $request['eliminarEquipo']);
        \App\AccidenteEquipo::whereIn('idAccidenteEquipo',$idsEliminar)->delete();
        
        $contadorDetalle = count($request['idAccidenteEquipo']);
        
        for($i = 0; $i < $contadorDetalle; $i++)
        {
            $indice = array(
                'idAccidenteEquipo' => $request['idAccidenteEquipo'][$i]);

            $data = array(
                'Accidente_idAccidente' => $id, 
                'Tercero_idInvestigador' => $request['Tercero_idInvestigador'][$i]);

            $respuesta = \App\AccidenteEquipo::updateOrCreate($indice, $data);

        }
    }

    protected function guardarReporteACPM($fechaAccion, $idModulo, $tipoAccion, $descripcionAccion)
    {   

        $reporteACPM = \App\ReporteACPM::All()->last();
        
        $indice = array(
            'ReporteACPM_idReporteACPM' => $reporteACPM->idReporteACPM, 
            'fechaReporteACPMDetalle' => $fechaAccion,
            'Modulo_idModulo' => $idModulo,
            'tipoReporteACPMDetalle' => $tipoAccion,
            'descripcionReporteACPMDetalle' => $descripcionAccion);

        $data = array(
            'ReporteACPM_idReporteACPM' => $reporteACPM->idReporteACPM,
            'ordenReporteACPMDetalle' => 0,
            'fechaReporteACPMDetalle' => $fechaAccion,
            'Proceso_idProceso' => NULL,
            'Modulo_idModulo' => $idModulo,
            'tipoReporteACPMDetalle' => $tipoAccion,
            'descripcionReporteACPMDetalle' => $descripcionAccion,
            'analisisReporteACPMDetalle' => '',
            'correccionReporteACPMDetalle' => '',
            'Tercero_idResponsableCorrecion' => NULL,
            'planAccionReporteACPMDetalle' => '',
            'Tercero_idResponsablePlanAccion' => NULL,
            'fechaEstimadaCierreReporteACPMDetalle' => '0000-00-00',
            'estadoActualReporteACPMDetalle' => '',
            'fechaCierreReporteACPMDetalle' => '0000-00-00',
            'eficazReporteACPMDetalle' => 0);

        $respuesta = \App\ReporteACPMDetalle::updateOrCreate($indice, $data);
    }
}
