<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\MovimientoCRMRequest;

use Illuminate\Routing\Route;

class MovimientoCRMController extends Controller
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
        $this->movimientocrm = \App\MovimientoCRM::find($route->getParameter('movimientocrm'));
        return $this->movimientocrm;
    }

    public function index()
    {
        return view('movimientocrmgrid');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $solicitante = \App\Tercero::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('nombreCompletoTercero','idTercero');
        $supervisor = \App\Tercero::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('nombreCompletoTercero','idTercero');
        $asesor = \App\Tercero::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('nombreCompletoTercero','idTercero');
        $categoria = \App\CategoriaCRM::All()->lists('nombreCategoriaCRM','idCategoriaCRM');
        $documento = \App\DocumentoCRM::All()->lists('nombreCompletoTercero','idTercero');
        $lineanegocio = \App\LineaNegocio::All()->lists('nombreLineaNegocio','idLineaNegocio');
        $origen = \App\OrigenCRM::All()->lists('nombreOrigenCRM','idOrigenCRM');
        $estado = \App\EstadoCRM::All()->lists('nombreEstadoCRM','idEstadoCRM');
        $acuerdoservicio = \App\AcuerdoServicio::All()->lists('nombreAcuerdoServicio','idAcuerdoServicio');

       return view('movimientocrm',compact('solicitante','supervisor','asesor','categoria','documento','lineanegocio','origen','estado','acuerdoservicio'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(MovimientoCRMRequest $request)
    {
        \App\MovimientoCRM::create([
            'numeroMovimientoCRM' => $request['numeroMovimientoCRM'],
            'asuntoMovimientoCRM' => $request['asuntoMovimientoCRM'],
            'fechaSolicitudMovimientoCRM' => $request['fechaSolicitudMovimientoCRM'],
            'fechaEstimadaSolucionMovimientoCRM' => $request['fechaEstimadaSolucionMovimientoCRM'],
            'fechaVencimientoMovimientoCRM' => $request['fechaVencimientoMovimientoCRM'],
            'fechaRealSolucionMovimientoCRM' => $request['fechaRealSolucionMovimientoCRM'],
            'prioridadMovimientoCRM' => $request['prioridadMovimientoCRM'],
            'diasEstimadosSolucionMovimientoCRM' => $request['diasEstimadosSolucionMovimientoCRM'],
            'diasRealesSolucionMovimientoCRM' => $request['diasRealesSolucionMovimientoCRM'],
            'Tercero_idSolicitante' => $request['Tercero_idSolicitante'],
            'Tercero_idSupervisor' => $request['Tercero_idSupervisor'],
            'Tercero_idAsesor' => $request['Tercero_idAsesor'],
            'CategoriaCRM_idCategoriaCRM' => $request['CategoriaCRM_idCategoriaCRM'],
            'DocumentoCRM_idDocumentoCRM' => $request['DocumentoCRM_idDocumentoCRM'],
            'LineaNegocio_idLineaNegocio' => $request['LineaNegocio_idLineaNegocio'],
            'OrigenCRM_idOrigenCRM' => $request['OrigenCRM_idOrigenCRM'],
            'EstadoCRM_idEstadoCRM' => $request['EstadoCRM_idEstadoCRM'],
            'AcuerdoServicio_idAcuerdoServicio' => $request['AcuerdoServicio_idAcuerdoServicio']
            ]);
        return redirect('/movimientocrm');
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
        $movimientocrm = \App\MovimientoCRM::find($id);

        $solicitante = \App\Tercero::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('nombreCompletoTercero','idTercero');
        $supervisor = \App\Tercero::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('nombreCompletoTercero','idTercero');
        $asesor = \App\Tercero::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('nombreCompletoTercero','idTercero');
        $categoria = \App\CategoriaCRM::All()->lists('nombreCategoriaCRM','idCategoriaCRM');
        $documento = \App\DocumentoCRM::All()->lists('nombreCompletoTercero','idTercero');
        $lineanegocio = \App\LineaNegocio::All()->lists('nombreLineaNegocio','idLineaNegocio');
        $origen = \App\OrigenCRM::All()->lists('nombreOrigenCRM','idOrigenCRM');
        $estado = \App\EstadoCRM::All()->lists('nombreEstadoCRM','idEstadoCRM');
        $acuerdoservicio = \App\AcuerdoServicio::All()->lists('nombreAcuerdoServicio','idAcuerdoServicio');

       return view('movimientocrm',compact('solicitante','supervisor','asesor','categoria','documento','lineanegocio','origen','estado','acuerdoservicio'),['movimientocrm'=>$movimientocrm]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(MovimientoCRMRequest $request, $id)
    {
        $movimientocrm = \App\MovimientoCRM::find($id);
        $movimientocrm->fill($request->all());
        $movimientocrm->save();

        return redirect('/movimientocrm');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        \App\MovimientoCRM::destroy($id);
        return redirect('/movimientocrm');
    }
}
