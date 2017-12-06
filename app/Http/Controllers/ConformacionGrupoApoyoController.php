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

        // Se envia parametros parecidos con la diferencia de que los que se van a utilizar con los de tipo Emplado = 01 
        $idTerceroEmpleado = \App\Tercero::where('tipoTercero', "like", "%*01*%")->where('Compania_idCompania', "=", \Session::get('idCompania'))->lists('idTercero');
        $NombreTerceroEmpleado = \App\Tercero::where('tipoTercero', "like", "%*01*%")->where('Compania_idCompania', "=", \Session::get('idCompania'))->lists('nombreCompletoTercero');

        return view('conformaciongrupoapoyo',compact('grupoApoyo','tercero','idTercero','nombreCompletoTercero','idTerceroEmpleado','NombreTerceroEmpleado'));
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


              // Guardado del dropzone
                $arrayImage = $request['archivoConformaciongrupoApoyoArray'];
                $arrayImage = substr($arrayImage, 0, strlen($arrayImage)-1);
                $arrayImage = explode(",", $arrayImage);
                $ruta = '';
                for ($i=0; $i < count($arrayImage) ; $i++) 
                { 
                    if ($arrayImage[$i] != '' || $arrayImage[$i] != 0) 
                    {
                        $origen = public_path() . '/imagenes/repositorio/temporal/'.$arrayImage[$i];
                        $destinationPath = public_path() . '/imagenes/conformaciongrupoapoyo/'.$arrayImage[$i];
                        $ruta = '/conformaciongrupoapoyo/'.$arrayImage[$i];
                       
                        if (file_exists($origen))
                        {
                            copy($origen, $destinationPath);
                            unlink($origen);
                        }   
                        else
                        {
                            echo "No existe el archivo";
                        }
                        \App\ConformacionGrupoApoyoArchivo::create([
                        'ConformacionGrupoApoyo_idConformacionGrupoApoyo' => $conformacionGrupoApoyo->idConformacionGrupoApoyo,
                        'rutaConformacionGrupoApoyoArchivo' => $ruta
                       ]);
                    }

                }
            
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
        SELECT ga.nombreGrupoApoyo,cga.nombreConformacionGrupoApoyo,cga.fechaConformacionGrupoApoyo,cga.fechaConvocatoriaConformacionGrupoApoyo,tr.nombreCompletoTercero as representante,cga.fechaVotacionConformacionGrupoApoyo,tg.nombreCompletoTercero as gerente,cga.fechaActaConformacionGrupoApoyo,cga.horaActaConformacionGrupoApoyo,cga.fechaInicioConformacionGrupoApoyo,cga.fechaFinConformacionGrupoApoyo,cga.fechaConstitucionConformacionGrupoApoyo,tp.nombreCompletoTercero as presidente,ts.nombreCompletoTercero as secretario,cga.convocatoriaVotacionConformacionGrupoApoyo,cga.actaEscrutinioConformacionGrupoApoyo,cga.actaCierreConformacionGrupoApoyo,cga.actaConformacionConformacionGrupoApoyo,cga.funcionesPresidenteConformacionGrupoApoyo,cga.funcionesSecretarioConformacionGrupoApoyo,cga.funcionesGrupoConformacionGrupoApoyo
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


        $conformacongrupoapooinscrito = DB::SELECT("
        SELECT t.nombreCompletoTercero,c.nombreCargo,cc.nombreCentroCosto
        FROM conformaciongrupoapoyoinscrito cgai
        LEFT JOIN conformaciongrupoapoyo cga
        ON cgai.ConformacionGrupoApoyo_idConformacionGrupoApoyo = cga.idConformacionGrupoApoyo
        LEFT JOIN tercero t 
        ON cgai.Tercero_idInscrito = t.idTercero
        LEFT JOIN cargo c 
        ON t.Cargo_idCargo = c.idCargo
        LEFT JOIN centrocosto  cc
        ON t.CentroCosto_idCentroCosto = cc.idCentroCosto
        WHERE cgai.ConformacionGrupoApoyo_idConformacionGrupoApoyo = ".$id);

        $conformaciongrupoapoyoarchivo = DB::SELECT("
        SELECT cgaar.idConformacionGrupoApoyoArchivo,cgaar.ConformacionGrupoApoyo_idConformacionGrupoApoyo,cgaar.rutaConformacionGrupoApoyoArchivo
        FROM conformaciongrupoapoyoarchivo cgaar
        LEFT JOIN conformaciongrupoapoyo cga
        ON cgaar.ConformacionGrupoApoyo_idConformacionGrupoApoyo = cga.idConformacionGrupoApoyo
        WHERE cgaar.ConformacionGrupoApoyo_idConformacionGrupoApoyo = ".$id);


        return view('formatos.conformaciongrupoapoyoimpresion',compact('conformaciongrupoapoyoarchivo','conformacongrupoapooinscrito','conformaciongrupoapoyoS','conformaciongrupoapoyojuradoS','conformaciongrupoapoyoresultadoS','conformaciongrupoapoyocomiteS'));
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

             // Se envia parametros parecidos con la diferencia de que los que se van a utilizar con los de tipo Emplado = 01 
        $idTerceroEmpleado = \App\Tercero::where('tipoTercero', "like", "%*01*%")->where('Compania_idCompania', "=", \Session::get('idCompania'))->lists('idTercero');
        $NombreTerceroEmpleado = \App\Tercero::where('tipoTercero', "like", "%*01*%")->where('Compania_idCompania', "=", \Session::get('idCompania'))->lists('nombreCompletoTercero');


        $conformacionGrupoApoyo = \App\ConformacionGrupoApoyo::find($id);


        $ConformacionGrupoApoyoInscrito = DB::SELECT('
            SELECT cgai.idConformacionGrupoApoyoInscrito,cgai.ConformacionGrupoApoyo_idConformacionGrupoApoyo,cgai.Tercero_idInscrito
            FROM conformaciongrupoapoyoinscrito cgai
            LEFT JOIN conformaciongrupoapoyo cga
            ON cgai.ConformacionGrupoApoyo_idConformacionGrupoApoyo = cga.idConformacionGrupoApoyo
            WHERE cgai.ConformacionGrupoApoyo_idConformacionGrupoApoyo ='.$id);


        return view('conformaciongrupoapoyo',compact('NombreTerceroEmpleado','idTerceroEmpleado','ConformacionGrupoApoyoInscrito','grupoApoyo','tercero','idTercero','nombreCompletoTercero'),['conformacionGrupoApoyo'=>$conformacionGrupoApoyo]);
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




                 //Para sobreescribir  el archivo 
            // HAGO UN INSERT A LOS NUEVOS ARCHIVOS SUBIDOS EN EL DROPZONE
            if ($request['archivoConformaciongrupoApoyoArray'] != '') 
            {
                $arrayImage = $request['archivoConformaciongrupoApoyoArray'];
                $arrayImage = substr($arrayImage, 0, strlen($arrayImage)-1);
                $arrayImage = explode(",", $arrayImage);
                $ruta = '';

                for($i = 0; $i < count($arrayImage); $i++)
                {
                    if ($arrayImage[$i] != '' || $arrayImage[$i] != 0) 
                    {
                        $origen = public_path() . '/imagenes/repositorio/temporal/'.$arrayImage[$i];
                        $destinationPath = public_path() . '/imagenes/conformaciongrupoapoyo/'.$arrayImage[$i];
                        
                        if (file_exists($origen))
                        {
                            copy($origen, $destinationPath);
                            unlink($origen);
                            $ruta = '/conformaciongrupoapoyo/'.$arrayImage[$i];

                            DB::table('conformaciongrupoapoyoarchivo')->insert(['idConformacionGrupoApoyoArchivo' => '0', 'ConformacionGrupoApoyo_idConformacionGrupoApoyo' =>$id,'rutaConformacionGrupoApoyoArchivo' => $ruta]);
                        }   
                        else
                        {
                            echo "No existe el archivo";
                        }
                    }
                }
            }
               // Para eliminar los archivos que se muestran en el preview del archivo cargado.Se hace una funcion en el JS para eliminar el div 
            // ELIMINO LOS ARCHIVOS
            $idsEliminar = $request['eliminarArchivo'];
            $idsEliminar = substr($idsEliminar, 0, strlen($idsEliminar)-1);
            if($idsEliminar != '')
            {
                $idsEliminar = explode(',',$idsEliminar);
                \App\ConformacionGrupoApoyoArchivo::whereIn('idConformacionGrupoApoyoArchivo',$idsEliminar)->delete();
            }

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


         // en el formulario hay un campo oculto en el que almacenamos los id que se eliminan separados por coma
        // en este proceso lo convertimos en array y eliminamos dichos id de la tabla de detalle
        $idsEliminar = explode(',', $request['eliminarInscrito']);
        \App\ConformacionGrupoApoyoInscrito::whereIn('idConformacionGrupoApoyoInscrito',$idsEliminar)->delete();

        $contadorInscrito = count($request['Tercero_idInscrito']);
        for($i = 0; $i < $contadorInscrito; $i++)
        {

            $indice = array(
             'idConformacionGrupoApoyoInscrito' => $request['idConformacionGrupoApoyoInscrito'][$i]);

            $data = array(
             'ConformacionGrupoApoyo_idConformacionGrupoApoyo' => $id,
            'Tercero_idInscrito' => $request['Tercero_idInscrito'][$i]);

            $preguntas = \App\ConformacionGrupoApoyoInscrito::updateOrCreate($indice, $data);

        }


       

    }
}
