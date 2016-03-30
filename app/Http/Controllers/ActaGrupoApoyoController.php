<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\ActaGrupoApoyoRequest;
use App\Http\Controllers\Controller;

class ActaGrupoApoyoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('actagrupoapoyogrid');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $grupoapoyo = \App\GrupoApoyo::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('nombreGrupoApoyo','idGrupoApoyo');
        
        $idTercero = \App\Tercero::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('idTercero');
        $nombreCompletoTercero = \App\Tercero::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('nombreCompletoTercero');

        return view('actagrupoapoyo', compact('grupoapoyo','idTercero','nombreCompletoTercero'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(ActaGrupoApoyoRequest $request)
    {
            \App\ActaGrupoApoyo::create([
                'GrupoApoyo_idGrupoApoyo' => $request['GrupoApoyo_idGrupoApoyo'],
                'fechaActaGrupoApoyo' => $request['fechaActaGrupoApoyo'],
                'horaInicioActaGrupoApoyo' => $request['horaInicioActaGrupoApoyo'],
                'horaFinActaGrupoApoyo' => $request['horaFinActaGrupoApoyo'],
                'observacionActaGrupoApoyo' => $request['observacionActaGrupoApoyo'],
                'Compania_idCompania' => \Session::get('idCompania')
                ]);

            $actagrupoapoyo = \App\ActaGrupoApoyo::All()->last();

            //---------------------------------
            // guardamos las tablas de detalle
            //---------------------------------
            $this->grabarDetalle($actagrupoapoyo->idActaGrupoApoyo, $request);

            return redirect('/actagrupoapoyo');
        

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
        
        $actaGrupoApoyo = \App\ActaGrupoApoyo::find($id);
        $grupoapoyo = \App\GrupoApoyo::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('nombreGrupoApoyo','idGrupoApoyo');
        
        $idTercero = \App\Tercero::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('idTercero');
        $nombreCompletoTercero = \App\Tercero::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('nombreCompletoTercero');

        return view('actagrupoapoyo', compact('grupoapoyo','idTercero','nombreCompletoTercero'), ['actaGrupoApoyo'=>$actaGrupoApoyo])
        ;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(ActaGrupoApoyoRequest $request, $id)
    {
           
            $actagrupoapoyo = \App\ActaGrupoApoyo::find($id);
            $actagrupoapoyo->fill($request->all());

            $actagrupoapoyo->save();

            //---------------------------------
            // guardamos las tablas de detalle
            //---------------------------------
            $this->grabarDetalle($actagrupoapoyo->idActaGrupoApoyo, $request);

            
            return redirect('/actagrupoapoyo');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        \App\ActaGrupoApoyo::destroy($id);
        return redirect('/actagrupoapoyo');
    }

    protected function grabarDetalle($id, $request)
    {

        // en el formulario hay un campo oculto en el que almacenamos los id que se eliminan separados por coma
        // en este proceso lo convertimos en array y eliminamos dichos id de la tabla de detalle
        $idsEliminar = explode(',', $request['eliminarTercero']);
        \App\ActaGrupoApoyoTercero::whereIn('idActaGrupoApoyoTercero',$idsEliminar)->delete();

        for($i = 0; $i < count($request['Tercero_idParticipante']); $i++)
        {
            // armamos una ruta para el archivo de imagen y volvemos a actualizar el registro
            // esto es porque la creamos con el ID del acta y el id del participante y debiamos grabar primero para obtenerlo
            $ruta = 'actagrupoapoyo/firmaactagrupoapoyo_'.$id.'_'.$request['Tercero_idParticipante'][$i].'.png';


            $indice = array(
             'idActaGrupoApoyoTercero' => $request['idActaGrupoApoyoTercero'][$i]);

             $data = array(
             'Tercero_idParticipante' => $request['Tercero_idParticipante'][$i],
             'ActaGrupoApoyo_idActaGrupoApoyo' => $id,
             'firmaActaGrupoApoyoTercero' => $ruta);

            $preguntas = \App\ActaGrupoApoyoTercero::updateOrCreate($indice, $data);
            
            //----------------------------
            // Guardamos la imagen de la firma como un archivo en disco
            $data = $request['firmabase64'][$i];
            if($data != '')
            {
                list($type, $data) = explode(';', $data);
                list(, $data)      = explode(',', $data);
                $data = base64_decode($data);

                file_put_contents('imagenes/'.$ruta, $data);
            }
            //----------------------------
        }
        
        // en el formulario hay un campo oculto en el que almacenamos los id que se eliminan separados por coma
        // en este proceso lo convertimos en array y eliminamos dichos id de la tabla de detalle
        $idsEliminar = explode(',', $request['eliminarTema']);
        \App\ActaGrupoApoyoTema::whereIn('idActaGrupoApoyoTema',$idsEliminar)->delete();

        for($i = 0; $i < count($request['temaActaGrupoApoyoTema']); $i++)
        {
            $indice = array(
             'idActaGrupoApoyoTema' => $request['idActaGrupoApoyoTema'][$i]);

             $data = array(
                'temaActaGrupoApoyoTema' => $request['temaActaGrupoApoyoTema'][$i],
                'desarrolloActaGrupoApoyoTema' => $request['desarrolloActaGrupoApoyoTema'][$i],
                'Tercero_idResponsable' => $request['Tercero_idResponsable'][$i],
                'observacionActaGrupoApoyoTema' => $request['observacionActaGrupoApoyoTema'][$i],
                'ActaGrupoApoyo_idActaGrupoApoyo' => $id);

            $preguntas = \App\ActaGrupoApoyoTema::updateOrCreate($indice, $data);
        }
    }
}
