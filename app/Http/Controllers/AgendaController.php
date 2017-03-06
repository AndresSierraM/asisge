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
        $supervisor = \App\Tercero::where('tipoTercero','like','%*01*%')->where('Compania_idCompania','=',\Session::get('idCompania'))->lists('nombreCompletoTercero','idTercero');
        return view('agregareventocalendario',compact('categoriaagenda','supervisor'));
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
        \App\Agenda::create([
            'CategoriaAgenda_idCategoriaAgenda' => $request['CategoriaAgenda_idCategoriaAgenda'],
            'asuntoAgenda' => $request['asuntoAgenda'],
            'fechaHoraInicioAgenda' => $request['fechaHoraInicioAgenda'],
            'fechaHoraFinAgenda' => $request['fechaHoraFinAgenda'],
            'Tercero_idSupervisor' => $request['Tercero_idSupervisor'],
            'Tercero_idResponsable' => ($request['Tercero_idResponsable'] == '' or $request['Tercero_idResponsable'] == 0 ? NULL : $request['Tercero_idResponsable']),
            'MovimientoCRM_idMovimientoCRM' => $request['MovimientoCRM_idMovimientoCRM'],
            'ubicacionAgenda' => $request['ubicacionAgenda'],
            'porcentajeEjecucionAgenda' => $request['porcentajeEjecucionAgenda'],
            'detallesAgenda' => $request['detallesAgenda']
        ]);

        $agenda = \App\Agenda::All()->last();

        // $this->grabarDetalle($agenda->idAgenda,$request);

        if($request->ajax()) 
        {
            return response()->json('Evento creado correctamente');
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
        // en el formulario hay un campo oculto en el que almacenamos los id que se eliminan separados por coma
        // en este proceso lo convertimos en array y eliminamos dichos id de la tabla de detalle
        $idsEliminar = explode(',', $request['eliminarCategoriaAgenda']);
        \App\CategoriaAgendaCampo::whereIn('idCategoriaAgendaCampo',$idsEliminar)->delete();

        $contador = count($request['idCategoriaAgendaCampo']);

        for($i = 0; $i < $contador; $i++)
        {

            $indice = array(
             'idCategoriaAgendaCampo' => $request['idCategoriaAgendaCampo'][$i]);

            $data = array(
            'CategoriaAgenda_idCategoriaAgenda' => $id,
            'CampoCRM_idCampoCRM' => $request['CampoCRM_idCampoCRM'][$i],
            'obligatorioCategoriaAgendaCampo' => $request['obligatorioCategoriaAgendaCampo'][$i]);

             $preguntas = \App\CategoriaAgendaCampo::updateOrCreate($indice, $data);

        }

        if($request->ajax()) 
        {
            return response()->json('Evento creado correctamente');
        }
        return redirect('/agenda');
    }
}
