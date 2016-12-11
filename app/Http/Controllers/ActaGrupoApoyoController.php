<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\ActaGrupoApoyoRequest;
use App\Http\Controllers\Controller;
use DB;
include public_path().'/ajax/consultarPermisos.php';

class ActaGrupoApoyoController extends Controller
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
            return view('actagrupoapoyogrid', compact('datos'));
        else
            return view('accesodenegado');
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

        $idDocumento = \App\Documento::All()->lists('idDocumento');
        $nombreDocumento = \App\Documento::All()->lists('nombreDocumento');

        return view('actagrupoapoyo', compact('grupoapoyo','idTercero','nombreCompletoTercero','nombreDocumento', 'idDocumento'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(ActaGrupoApoyoRequest $request)
    {
        if($request['respuesta'] != 'falso')
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
        

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id, Request $request)
    {
         if(isset($request['accion']) and $request['accion'] == 'imprimir')
        {
            $actagrupoapoyo = DB::select ("SELECT nombreGrupoApoyo,fechaActaGrupoApoyo,horaInicioActaGrupoApoyo,horaFinActaGrupoApoyo,observacionActaGrupoApoyo FROM actagrupoapoyo ac LEFT JOIN grupoapoyo ga ON ga.idGrupoApoyo  = ac.GrupoApoyo_idGrupoApoyo WHERE idActaGrupoApoyo = ".$id."
              AND ac.Compania_idCompania = ".\Session::get('idCompania'));

             $actagrupoapoyotercero = DB::select("SELECT nombreCompletoTercero,firmaActaGrupoApoyoTercero FROM actagrupoapoyotercero at LEFT JOIN tercero t on t.idTercero = at.Tercero_idParticipante WHERE ActaGrupoApoyo_idActaGrupoApoyo = ".$id);

          
            $actagrupoapoyodetalle = DB::select("SELECT actividadGrupoApoyoDetalle,nombreCompletoTercero,fechaPlaneadaActaGrupoApoyoDetalle,nombreDocumento,recursoPlaneadoActaGrupoApoyoDetalle,recursoEjecutadoActaGrupoApoyoDetalle,  fechaEjecucionGrupoApoyoDetalle,observacionGrupoApoyoDetalle FROM actagrupoapoyodetalle ad LEFT JOIN tercero t ON ad.Tercero_idResponsableDetalle = t.idTercero LEFT JOIN documento d ON d.idDocumento = ad.Documento_idDocumento WHERE ActaGrupoApoyo_idActaGrupoApoyo = ".$id);

            
            return view('formatos.actagrupoapoyoimpresion',compact('actagrupoapoyo','actagrupoapoyotercero','actagrupoapoyodetalle'));
       } 
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

        $idDocumento = \App\Documento::All()->lists('idDocumento');
        $nombreDocumento = \App\Documento::All()->lists('nombreDocumento');

        return view('actagrupoapoyo', compact('grupoapoyo','idTercero','nombreCompletoTercero', 'nombreDocumento', 'idDocumento'), ['actaGrupoApoyo'=>$actaGrupoApoyo])
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
        if($request['respuesta'] != 'falso')
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


            $idsEliminar = explode(',', $request['eliminarActividad']);
            \App\ActaGrupoApoyoDetalle::where('ActaGrupoApoyo_idActaGrupoApoyo',$id)->delete();

            $contadorDetalle = count($request['actividadGrupoApoyoDetalle']);
            for($i = 0; $i < $contadorDetalle; $i++)
            {
                 $indice = array(
             'idActaGrupoApoyoDetalle' => $request['idActaGrupoApoyoDetalle'][$i]);

             $data = array(
                'ActaGrupoApoyo_idActaGrupoApoyo' => $id,
                'actividadGrupoApoyoDetalle' => $request['actividadGrupoApoyoDetalle'][$i],
                'Tercero_idResponsableDetalle' => $request['Tercero_idResponsableDetalle'][$i],
                'fechaPlaneadaActaGrupoApoyoDetalle' => $request['fechaPlaneadaActaGrupoApoyoDetalle'][$i],
                'Documento_idDocumento' => $request['Documento_idDocumento'][$i],
                'recursoPlaneadoActaGrupoApoyoDetalle' => $request['recursoPlaneadoActaGrupoApoyoDetalle'][$i],
                'recursoEjecutadoActaGrupoApoyoDetalle' => $request['recursoEjecutadoActaGrupoApoyoDetalle'][$i],
                'fechaEjecucionGrupoApoyoDetalle' => $request['fechaEjecucionGrupoApoyoDetalle'][$i],
                'observacionGrupoApoyoDetalle' => $request['observacionGrupoApoyoDetalle'][$i]);

                $preguntas = \App\ActaGrupoApoyoDetalle::updateOrCreate($indice, $data);

            }
    }
}
