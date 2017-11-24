<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\ConformacionGrupoApoyoRequest;

use App\Http\Controllers\Controller;
use DB;
include public_path().'/ajax/consultarPermisos.php';

class ConformacionGrupoApoyoController extends Controller
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
            return view('conformaciongrupoapoyogrid', compact('datos'));
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
        $idTercero = \App\Tercero::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('idTercero');
        $nombreCompletoTercero = \App\Tercero::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('nombreCompletoTercero');
        $tercero = \App\Tercero::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('nombreCompletoTercero','idTercero');
        $grupoApoyo = \App\GrupoApoyo::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('nombreGrupoApoyo','idGrupoApoyo');
        return view('conformaciongrupoapoyo',compact('grupoApoyo','tercero','idTercero','nombreCompletoTercero'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(ConformacionGrupoApoyoRequest $request)
    {
            \App\ConformacionGrupoApoyo::create([
                'GrupoApoyo_idGrupoApoyo' => $request['GrupoApoyo_idGrupoApoyo'],
                'nombreConformacionGrupoApoyo' => $request['nombreConformacionGrupoApoyo'],
                'fechaConformacionGrupoApoyo' => $request['fechaConformacionGrupoApoyo'],
                'fechaConvocatoriaConformacionGrupoApoyo' => $request['fechaConvocatoriaConformacionGrupoApoyo'],
                'Tercero_idRepresentante' => $request['Tercero_idRepresentante'],
                'fechaVotacionConformacionGrupoApoyo' => $request['fechaVotacionConformacionGrupoApoyo'],
                'Tercero_idGerente' => $request['Tercero_idGerente'],
                'convocatoriaVotacionConformacionGrupoApoyo' => $request['convocatoriaVotacionConformacionGrupoApoyo'],
                 'actaEscrutinioConformacionGrupoApoyo' => $request['actaEscrutinioConformacionGrupoApoyo'],
                 'actaCierreConformacionGrupoApoyo' => $request['actaCierreConformacionGrupoApoyo'],
                 'actaConformacionConformacionGrupoApoyo' => $request['actaConformacionConformacionGrupoApoyo'],
                 'funcionesGrupoConformacionGrupoApoyo' => $request['funcionesGrupoConformacionGrupoApoyo'],
                 'funcionesPresidenteConformacionGrupoApoyo' => $request['funcionesPresidenteConformacionGrupoApoyo'],
                 'funcionesSecretarioConformacionGrupoApoyo' => $request['funcionesSecretarioConformacionGrupoApoyo'],


                'fechaActaConformacionGrupoApoyo' => $request['fechaActaConformacionGrupoApoyo'],
                'horaActaConformacionGrupoApoyo' => $request['horaActaConformacionGrupoApoyo'],
                'fechaInicioConformacionGrupoApoyo' => $request['fechaInicioConformacionGrupoApoyo'],
                'fechaFinConformacionGrupoApoyo' => $request['fechaFinConformacionGrupoApoyo'],
                'fechaConstitucionConformacionGrupoApoyo' => $request['fechaConstitucionConformacionGrupoApoyo'],
                'Tercero_idPresidente' => $request['Tercero_idPresidente'],
                'Tercero_idSecretario' => $request['Tercero_idSecretario'],
                'Compania_idCompania' => \Session::get('idCompania')
                ]);

            $conformacionGrupoApoyo = \App\ConformacionGrupoApoyo::All()->last();
            
            //---------------------------------
            // guardamos las tablas de detalle
            //---------------------------------
            $this->grabarDetalle($conformacionGrupoApoyo->idConformacionGrupoApoyo, $request);

            return redirect('/conformaciongrupoapoyo');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id, Request $request)
    {

        $conformaciongrupoapoyoS = DB::SELECT("
        SELECT ga.nombreGrupoApoyo,cga.nombreConformacionGrupoApoyo,cga.fechaConformacionGrupoApoyo,cga.fechaConvocatoriaConformacionGrupoApoyo,tr.nombreCompletoTercero as representante,cga.fechaVotacionConformacionGrupoApoyo,tg.nombreCompletoTercero as gerente,cga.fechaActaConformacionGrupoApoyo,cga.horaActaConformacionGrupoApoyo,cga.fechaInicioConformacionGrupoApoyo,cga.fechaFinConformacionGrupoApoyo,cga.fechaConstitucionConformacionGrupoApoyo,tp.nombreCompletoTercero as presidente,ts.nombreCompletoTercero as secretario
        FROM conformaciongrupoapoyo cga
        LEFT JOIN grupoapoyo ga
        ON cga.GrupoApoyo_idGrupoApoyo = ga.idGrupoApoyo
        LEFT JOIN tercero tr
        ON cga.Tercero_idRepresentante = tr.idTercero
        LEFT JOIN tercero tg
        ON cga.Tercero_idGerente = tg.idTercero
        LEFT JOIN tercero tp
        ON cga.Tercero_idPresidente = tp.idTercero
        LEFT JOIN tercero ts
        ON cga.Tercero_idSecretario = ts.idTercero
        WHERE cga.idConformacionGrupoApoyo = ".$id);


        $conformaciongrupoapoyojuradoS = DB::SELECT ("
        SELECT t.nombreCompletoTercero,cgaj.firmaActaConformacionGrupoApoyoTercero
        FROM conformaciongrupoapoyo cga
        LEFT JOIN conformaciongrupoapoyojurado cgaj
        ON cgaj.ConformacionGrupoApoyo_idConformacionGrupoApoyo = cga.idConformacionGrupoApoyo
        LEFT JOIN tercero t
        ON cgaj.Tercero_idJurado = t.idTercero
        WHERE cgaj.ConformacionGrupoApoyo_idConformacionGrupoApoyo =".$id);

        $conformaciongrupoapoyoresultadoS = DB::SELECT ("
        SELECT t.nombreCompletoTercero,cgar.votosConformacionGrupoApoyoResultado
        FROM conformaciongrupoapoyo cga
        LEFT JOIN conformaciongrupoapoyoresultado cgar
        ON cgar.ConformacionGrupoApoyo_idConformacionGrupoApoyo = cga.idConformacionGrupoApoyo
        LEFT JOIN tercero t
        ON cgar.Tercero_idCandidato = t.idTercero
        WHERE cgar.ConformacionGrupoApoyo_idConformacionGrupoApoyo =".$id);

        $conformaciongrupoapoyocomiteS = DB::SELECT("
            SELECT cgac.nombradoPorConformacionGrupoApoyoComite,IF(nombradoPorConformacionGrupoApoyoComite = 'E','Empresa','Trabajadores') as nombradoPor,t.nombreCompletoTercero as principal,ts.nombreCompletoTercero as suplente
            FROM conformaciongrupoapoyo cga
            LEFT JOIN conformaciongrupoapoyocomite cgac
            ON cgac.ConformacionGrupoApoyo_idConformacionGrupoApoyo = cga.idConformacionGrupoApoyo
            LEFT JOIN tercero t
            ON cgac.Tercero_idPrincipal = t.idTercero
            LEFT JOIN tercero ts
            ON cgac.Tercero_idSuplente = ts.idTercero
            WHERE cgac.ConformacionGrupoApoyo_idConformacionGrupoApoyo = ".$id);

        return view('formatos.conformaciongrupoapoyoimpresion',compact('conformaciongrupoapoyoS','conformaciongrupoapoyojuradoS','conformaciongrupoapoyoresultadoS','conformaciongrupoapoyocomiteS'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $idTercero = \App\Tercero::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('idTercero');
        $nombreCompletoTercero = \App\Tercero::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('nombreCompletoTercero');
        $tercero = \App\Tercero::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('nombreCompletoTercero','idTercero');
        $grupoApoyo = \App\GrupoApoyo::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('nombreGrupoApoyo','idGrupoApoyo');
        $conformacionGrupoApoyo = \App\ConformacionGrupoApoyo::find($id);
        return view('conformaciongrupoapoyo',compact('grupoApoyo','tercero','idTercero','nombreCompletoTercero'),['conformacionGrupoApoyo'=>$conformacionGrupoApoyo]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(ConformacionGrupoApoyoRequest $request, $id)
    {
            $conformacionGrupoApoyo = \App\ConformacionGrupoApoyo::find($id);
            $conformacionGrupoApoyo->fill($request->all());

            $conformacionGrupoApoyo->save();

            //---------------------------------
            // guardamos las tablas de detalle
            //---------------------------------
            $this->grabarDetalle($conformacionGrupoApoyo->idConformacionGrupoApoyo, $request);

            return redirect('/conformaciongrupoapoyo');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        \App\ConformacionGrupoApoyo::destroy($id);
        return redirect('/conformaciongrupoapoyo');
    }

    protected function grabarDetalle($id, $request)
    {
        // en el formulario hay un campo oculto en el que almacenamos los id que se eliminan separados por coma
        // en este proceso lo convertimos en array y eliminamos dichos id de la tabla de detalle
        $idsEliminar = explode(',', $request['eliminarComite']);
        \App\ConformacionGrupoApoyoComite::whereIn('idConformacionGrupoApoyoComite',$idsEliminar)->delete();

        $contadorComite = count($request['Tercero_idPrincipal']);
        for($i = 0; $i < $contadorComite; $i++)
        {

            $indice = array(
             'idConformacionGrupoApoyoComite' => $request['idConformacionGrupoApoyoComite'][$i]);

            $data = array(
             'ConformacionGrupoApoyo_idConformacionGrupoApoyo' => $id,
            'nombradoPorConformacionGrupoApoyoComite' => $request['nombradoPorConformacionGrupoApoyoComite'][$i],
            'Tercero_idPrincipal' => ($request['Tercero_idPrincipal'][$i] == '' ? null : $request['Tercero_idPrincipal'][$i]),
            'Tercero_idSuplente' => ($request['Tercero_idSuplente'][$i] == '' ? null : $request['Tercero_idSuplente'][$i]));

            $preguntas = \App\ConformacionGrupoApoyoComite::updateOrCreate($indice, $data);
        }

        
        // en el formulario hay un campo oculto en el que almacenamos los id que se eliminan separados por coma
        // en este proceso lo convertimos en array y eliminamos dichos id de la tabla de detalle
        $idsEliminar = explode(',', $request['eliminarJurado']);
        \App\ConformacionGrupoApoyoJurado::whereIn('idConformacionGrupoApoyoJurado',$idsEliminar)->delete();

        $contadorJurado = count($request['Tercero_idJurado']);
        for($i = 0; $i < $contadorJurado; $i++)
        {
            // armamos una ruta para el archivo de imagen y volvemos a actualizar el registro
            // esto es porque la creamos con el ID del acta y el id del participante y debiamos grabar primero para obtenerlo
            $ruta = 'conformaciongrupoapoyo/firmaconformaciongrupoapoyo'.$id.'_'.$request['Tercero_idJurado'][$i].'.png';

            $indice = array(
             'idConformacionGrupoApoyoJurado' => $request['idConformacionGrupoApoyoJurado'][$i]);

            $data = array(
             'ConformacionGrupoApoyo_idConformacionGrupoApoyo' => $id,
            'Tercero_idJurado' => $request['Tercero_idJurado'][$i],
            'firmaActaConformacionGrupoApoyoTercero' => $ruta);

            $preguntas = \App\ConformacionGrupoApoyoJurado::updateOrCreate($indice, $data);

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
        $idsEliminar = explode(',', $request['eliminarResultado']);
        \App\ConformacionGrupoApoyoResultado::whereIn('idConformacionGrupoApoyoResultado',$idsEliminar)->delete();

        $contadorResultado = count($request['Tercero_idCandidato']);
        for($i = 0; $i < $contadorResultado; $i++)
        {

            $indice = array(
             'idConformacionGrupoApoyoResultado' => $request['idConformacionGrupoApoyoResultado'][$i]);

            $data = array(
             'ConformacionGrupoApoyo_idConformacionGrupoApoyo' => $id,
            'Tercero_idCandidato' => $request['Tercero_idCandidato'][$i],
            'votosConformacionGrupoApoyoResultado' => $request['votosConformacionGrupoApoyoResultado'][$i] );

            $preguntas = \App\ConformacionGrupoApoyoResultado::updateOrCreate($indice, $data);

        }

    }
}
