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


    // Esta funcion es para que cuando suba el archvio vaya al repositorio/temporal y guarde una copia mientras le dan guardar al registro 
    //Funcion para subir archivos con dropzone
    public function uploadFiles(Request $request) 
    {
 
        $input = Input::all();
 
        $rules = array(
        );
 
        $validation = Validator::make($input, $rules);
 
        if ($validation->fails()) {
            return Response::make($validation->errors->first(), 400);
        }
        
        $destinationPath = public_path() . '/imagenes/repositorio/temporal'; //Guardo en la carpeta  temporal

        $extension = Input::file('file')->getClientOriginalExtension(); 
        $fileName = Input::file('file')->getClientOriginalName(); // nombre de archivo
        $upload_success = Input::file('file')->move($destinationPath, $fileName);
 
        if ($upload_success) {
            return Response::json('success', 200);
        } 
        else {
            return Response::json('error', 400);
        }
    }

    public function create()
    {
        $grupoapoyo = \App\GrupoApoyo::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('nombreGrupoApoyo','idGrupoApoyo');
        
        $idTercero = \App\Tercero::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('idTercero');
        $nombreCompletoTercero = \App\Tercero::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('nombreCompletoTercero');

        $idDocumentoSoporte = \App\DocumentoSoporte::All()->lists('idDocumentoSoporte');
        $nombreDocumentoSoporte = \App\DocumentoSoporte::All()->lists('nombreDocumentoSoporte');

        return view('actagrupoapoyo', compact('grupoapoyo','idTercero','nombreCompletoTercero','nombreDocumentoSoporte', 'idDocumentoSoporte'));
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


             // Guardado del dropzone
                $arrayImage = $request['archivoActaGrupoApoyoArray'];
                $arrayImage = substr($arrayImage, 0, strlen($arrayImage)-1);
                $arrayImage = explode(",", $arrayImage);
                $ruta = '';
                for ($i=0; $i < count($arrayImage) ; $i++) 
                { 
                    if ($arrayImage[$i] != '' || $arrayImage[$i] != 0) 
                    {
                        $origen = public_path() . '/imagenes/repositorio/temporal/'.$arrayImage[$i];
                        $destinationPath = public_path() . '/imagenes/actagrupoapoyo/'.$arrayImage[$i];
                        $ruta = '/actagrupoapoyo/'.$arrayImage[$i];
                       
                        if (file_exists($origen))
                        {
                            copy($origen, $destinationPath);
                            unlink($origen);
                        }   
                        else
                        {
                            echo "No existe el archivo";
                        }
                        \App\ActaGrupoApoyoArchivo::create([
                        'ActaGrupoApoyo_idActaGrupoApoyo' => $actagrupoapoyo->idActaGrupoApoyo,
                        'rutaActaGrupoApoyoArchivo' => $ruta
                       ]);
                    }

                }


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

          
            $actagrupoapoyodetalle = DB::select("SELECT actividadGrupoApoyoDetalle,nombreCompletoTercero,fechaPlaneadaActaGrupoApoyoDetalle,nombreDocumentoSoporte,recursoPlaneadoActaGrupoApoyoDetalle,recursoEjecutadoActaGrupoApoyoDetalle,  fechaEjecucionGrupoApoyoDetalle,observacionGrupoApoyoDetalle FROM actagrupoapoyodetalle ad LEFT JOIN tercero t ON ad.Tercero_idResponsableDetalle = t.idTercero LEFT JOIN documentosoporte d ON d.idDocumentoSoporte = ad.DocumentoSoporte_idDocumentoSoporte WHERE ActaGrupoApoyo_idActaGrupoApoyo = ".$id);

            // Nuevo campo Temas tratados 
            $actagrupoapoyotema = DB::select("SELECT agat.temaActaGrupoApoyoTema,agat.desarrolloActaGrupoApoyoTema,
            agat.observacionActaGrupoApoyoTema,t.nombreCompletoTercero
            FROM actagrupoapoyotema agat
            LEFT JOIN tercero t
            ON agat.Tercero_idResponsable = t.idTercero
            WHERE  ActaGrupoApoyo_idActaGrupoApoyo = ".$id);

            
            return view('formatos.actagrupoapoyoimpresion',compact('actagrupoapoyo','actagrupoapoyotercero','actagrupoapoyodetalle','actagrupoapoyotema'));
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

        $idDocumentoSoporte = \App\DocumentoSoporte::All()->lists('idDocumentoSoporte');
        $nombreDocumentoSoporte = \App\DocumentoSoporte::All()->lists('nombreDocumentoSoporte');

        return view('actagrupoapoyo', compact('grupoapoyo','idTercero','nombreCompletoTercero', 'nombreDocumentoSoporte', 'idDocumentoSoporte'), ['actaGrupoApoyo'=>$actaGrupoApoyo])
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

             //Para sobreescribir  el archivo 
            // HAGO UN INSERT A LOS NUEVOS ARCHIVOS SUBIDOS EN EL DROPZONE
            if ($request['archivoActaGrupoApoyoArray'] != '') 
            {
                $arrayImage = $request['archivoActaGrupoApoyoArray'];
                $arrayImage = substr($arrayImage, 0, strlen($arrayImage)-1);
                $arrayImage = explode(",", $arrayImage);
                $ruta = '';

                for($i = 0; $i < count($arrayImage); $i++)
                {
                    if ($arrayImage[$i] != '' || $arrayImage[$i] != 0) 
                    {
                        $origen = public_path() . '/imagenes/repositorio/temporal/'.$arrayImage[$i];
                        $destinationPath = public_path() . '/imagenes/actagrupoapoyo/'.$arrayImage[$i];
                        
                        if (file_exists($origen))
                        {
                            copy($origen, $destinationPath);
                            unlink($origen);
                            $ruta = '/actagrupoapoyo/'.$arrayImage[$i];

                            DB::table('actagrupoapoyoarchivo')->insert(['idActaGrupoApoyoArchivo' => '0', 'ActaGrupoApoyo_idActaGrupoApoyo' =>$id,'rutaActaGrupoApoyoArchivo' => $ruta]);
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
                \App\ActaGrupoApoyoArchivo::whereIn('idActaGrupoApoyoArchivo',$idsEliminar)->delete();
            }



            
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
                'DocumentoSoporte_idDocumentoSoporte' => $request['DocumentoSoporte_idDocumentoSoporte'][$i],
                'recursoPlaneadoActaGrupoApoyoDetalle' => $request['recursoPlaneadoActaGrupoApoyoDetalle'][$i],
                'recursoEjecutadoActaGrupoApoyoDetalle' => $request['recursoEjecutadoActaGrupoApoyoDetalle'][$i],
                'fechaEjecucionGrupoApoyoDetalle' => $request['fechaEjecucionGrupoApoyoDetalle'][$i],
                'observacionGrupoApoyoDetalle' => $request['observacionGrupoApoyoDetalle'][$i]);

                $preguntas = \App\ActaGrupoApoyoDetalle::updateOrCreate($indice, $data);

            }
    }
}
