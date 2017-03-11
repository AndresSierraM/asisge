<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class AgendaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('agenda');
    }

    public function indexAgendaEvento()
    {
        $categoriaagenda = \App\CategoriaAgenda::All()->lists('nombreCategoriaAgenda','idCategoriaAgenda');
        $casocrm = \App\MovimientoCRM::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('asuntoMovimientoCRM','idMovimientoCRM');
        $supervisor = \App\Tercero::where('tipoTercero','like','%*01*%')->where('Compania_idCompania','=',\Session::get('idCompania'))->lists('nombreCompletoTercero','idTercero');
        $responsable = \App\Tercero::where('tipoTercero','like','%*01*%')->where('Compania_idCompania','=',\Session::get('idCompania'))->lists('nombreCompletoTercero','idTercero');
        return view('agregareventocalendario',compact('categoriaagenda','supervisor','casocrm','responsable'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $indice = array(
            'idAgenda' => $request['idAgenda']);

        $data = array(
            'CategoriaAgenda_idCategoriaAgenda' => $request['CategoriaAgenda_idCategoriaAgenda'],
            'asuntoAgenda' => ($request['asuntoAgenda'] == ''  ? NULL : $request['asuntoAgenda']),
            'fechaHoraInicioAgenda' => ($request['fechaHoraInicioAgenda'] == '' ? NULL : $request['fechaHoraInicioAgenda']),
            'fechaHoraFinAgenda' => ($request['fechaHoraFinAgenda'] == '' ? NULL : $request['fechaHoraFinAgenda']),
            'Tercero_idSupervisor' => ($request['Tercero_idSupervisor'] == '' or $request['Tercero_idSupervisor'] == 0 ? NULL : $request['Tercero_idSupervisor']),
            'Tercero_idResponsable' => ($request['Tercero_idResponsable'] == '' or $request['Tercero_idResponsable'] == 0 ? NULL : $request['Tercero_idResponsable']),
            'MovimientoCRM_idMovimientoCRM' => ($request['MovimientoCRM_idMovimientoCRM'] == '' or $request['MovimientoCRM_idMovimientoCRM'] == 0 ? NULL : $request['MovimientoCRM_idMovimientoCRM']),
            'ubicacionAgenda' => ($request['ubicacionAgenda'] == '' ? NULL : $request['ubicacionAgenda']),
            'porcentajeEjecucionAgenda' => ($request['porcentajeEjecucionAgenda'] == '' ? NULL : $request['porcentajeEjecucionAgenda']),
            'detallesAgenda' => ($request['detallesAgenda'] == '' ? NULL : $request['detallesAgenda']));

        $preguntas = \App\Agenda::updateOrCreate($indice, $data);

        if ($request['idAgenda'] != '') 
        {
            $this->grabarDetalle($request['idAgenda'],$request);
        }
        else
        {
            $agenda = \App\Agenda::All()->last();
            $this->grabarDetalle($agenda->idAgenda,$request);
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
        //
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
        $agenda = \App\Agenda::find($id);
        $agenda->fill($request->all());
        $agenda->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function grabarDetalle($id, $request)
    {
        $idsEliminar = explode(',', $request['eliminarAgendaSeguimiento']);
        \App\AgendaSeguimiento::whereIn('idAgendaSeguimiento',$idsEliminar)->delete();

        $contador = count($request['idAgendaSeguimiento']);

        for($i = 0; $i < $contador; $i++)
        {

            $indice = array(
             'idAgendaSeguimiento' => $request['idAgendaSeguimiento'][$i]);

            $data = array(
            'Agenda_idAgenda' => $id,
            'fechaHoraAgendaSeguimiento' => $request['fechaHoraAgendaSeguimiento'][$i],
            'Users_idCrea' => \Session::get('idUsuario'),
            'detallesAgendaSeguimiento' => $request['detallesAgendaSeguimiento'][$i]);

             $preguntas = \App\AgendaSeguimiento::updateOrCreate($indice, $data);

        }

        $idsEliminar = explode(',', $request['eliminarAgendaAsistente']);
        \App\AgendaAsistente::whereIn('idAgendaSeguimiento',$idsEliminar)->delete();

        $contador = count($request['idAgendaAsistente']);

        for($i = 0; $i < $contador; $i++)
        {

            $indice = array(
             'idAgendaAsistente' => $request['idAgendaAsistente'][$i]);

            $data = array(
            'Agenda_idAgenda' => $id,
            'Tercero_idAsistente' => ($request['Tercero_idAsistente'][$i] == '' or $request['Tercero_idAsistente'][$i] == 0 ? NULL : $request['Tercero_idAsistente'][$i]),
            'nombreAgendaAsistente' => ($request['nombreAgendaAsistente'][$i] == '' ? NULL : $request['nombreAgendaAsistente'][$i]),
            'correoElectronicoAgendaAsistente' => ($request['correoElectronicoAgendaAsistente'][$i] == '' ? NULL : $request['correoElectronicoAgendaAsistente'][$i]));

             $preguntas = \App\AgendaAsistente::updateOrCreate($indice, $data);

        }

        if($request->ajax()) 
        {
            return response()->json('Evento creado correctamente');
        }
        return redirect('/agenda');
    }
}
