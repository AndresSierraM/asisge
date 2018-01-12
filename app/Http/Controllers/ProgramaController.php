<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Programa;
use App\Http\Requests;
use App\Http\Requests\ProgramaRequest;
use App\Http\Controllers\Controller;
use DB;
include public_path().'/ajax/consultarPermisos.php';

class ProgramaController extends Controller
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
            return view('programagrid', compact('datos'));
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
        // cuando se crea un nuevo programa, enviamos los maestros requeridos para el encabezado         
        $clasificacionriesgo = \App\ClasificacionRiesgo::All()->lists('nombreClasificacionRiesgo','idClasificacionRiesgo');
        $terceros = \App\Tercero::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('nombreCompletoTercero', 'idTercero');
        $companiaobjetivo = \App\CompaniaObjetivo::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('nombreCompaniaObjetivo','idCompaniaObjetivo');

        $idTercero = \App\Tercero::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('idTercero');
        $nombreCompletoTercero = \App\Tercero::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('nombreCompletoTercero');

        $idDocumentoSoporte = \App\DocumentoSoporte::All()->lists('idDocumentoSoporte');
        $nombreDocumentoSoporte = \App\DocumentoSoporte::All()->lists('nombreDocumentoSoporte');

        return view('programa',compact('clasificacionriesgo','terceros','companiaobjetivo', 'nombreCompletoTercero', 'idTercero', 'nombreDocumentoSoporte', 'idDocumentoSoporte'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(ProgramaRequest $request)
    {
        if($request['respuesta'] != 'falso')
        { 
            \App\Programa::create([
                'nombrePrograma' => $request['nombrePrograma'],
                'fechaElaboracionPrograma' => $request['fechaElaboracionPrograma'],
                'ClasificacionRiesgo_idClasificacionRiesgo' => $request['ClasificacionRiesgo_idClasificacionRiesgo'],
                'alcancePrograma' => $request['alcancePrograma'],
                'CompaniaObjetivo_idCompaniaObjetivo' => $request['CompaniaObjetivo_idCompaniaObjetivo'],
                'objetivoEspecificoPrograma' => $request['objetivoEspecificoPrograma'],
                'Tercero_idElabora' => $request['Tercero_idElabora'],
                'generalidadPrograma' => $request['generalidadPrograma'],
                'Compania_idCompania' => \Session::get('idCompania')
                ]); 

            $programa = \App\Programa::All()->last();
            $contadorDetalle = count($request['actividadProgramaDetalle']);
            for($i = 0; $i < $contadorDetalle; $i++)
            {
                \App\ProgramaDetalle::create([
                'Programa_idPrograma' => $programa->idPrograma,
                'actividadProgramaDetalle' => $request['actividadProgramaDetalle'][$i],
                'Tercero_idResponsable' => $request['Tercero_idResponsable'][$i],
                'fechaPlaneadaProgramaDetalle' => $request['fechaPlaneadaProgramaDetalle'][$i],
                'Documento_idDocumento' => $request['Documento_idDocumento'][$i],
                'recursoPlaneadoProgramaDetalle' => $request['recursoPlaneadoProgramaDetalle'][$i],
                'recursoEjecutadoProgramaDetalle' => $request['recursoEjecutadoProgramaDetalle'][$i],
                'fechaEjecucionProgramaDetalle' => $request['fechaEjecucionProgramaDetalle'][$i],
                'observacionProgramaDetalle' => $request['observacionProgramaDetalle'][$i]
               ]);
            }


                }

                            // Guardado del dropzone para Adjuntos
                $arrayImage = $request['ProgramaArchivoArray'];
                $arrayImage = substr($arrayImage, 0, strlen($arrayImage)-1);
                $arrayImage = explode(",", $arrayImage);
                $ruta = '';
                for ($i=0; $i < count($arrayImage) ; $i++) 
                { 
                    if ($arrayImage[$i] != '' || $arrayImage[$i] != 0) 
                    {
                        $origen = public_path() . '/imagenes/repositorio/temporal/'.$arrayImage[$i];
                        $destinationPath = public_path() . '/imagenes/programa/'.$arrayImage[$i];
                        $ruta = '/programa/'.$arrayImage[$i];
                       
                        if (file_exists($origen))
                        {
                            copy($origen, $destinationPath);
                            unlink($origen);
                        }   
                        else
                        {
                            echo "No existe el archivo";
                        }
                        \App\ProgramaArchivo::create([
                        'Programa_idPrograma' => $programa->idPrograma,
                        'rutaProgramaArchivo' => $ruta
                       ]);
                    }

                }
        return redirect('/programa');
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
            $programa = DB::select ("
            SELECT
              nombrePrograma,
              fechaElaboracionPrograma,
              nombreClasificacionRiesgo,
              alcancePrograma,
              nombreCompaniaObjetivo,
              objetivoEspecificoPrograma,
              nombreCompletoTercero
            FROM
              programa pr
            LEFT JOIN
              clasificacionriesgo cl ON cl.idClasificacionRiesgo = pr.ClasificacionRiesgo_idClasificacionRiesgo
            LEFT JOIN
              companiaobjetivo co ON co.idCompaniaObjetivo = pr.CompaniaObjetivo_idCompaniaObjetivo
            LEFT JOIN
              tercero t ON t.idTercero = pr.Tercero_idElabora
            WHERE
              idPrograma = ".$id."
              AND pr.Compania_idCompania = ".\Session::get('idCompania'));

          
            $programaDetalle = DB::select("SELECT actividadProgramaDetalle,nombreCompletoTercero,fechaPlaneadaProgramaDetalle,nombreDocumentoSoporte,recursoPlaneadoProgramaDetalle,recursoEjecutadoProgramaDetalle,fechaEjecucionProgramaDetalle,observacionProgramaDetalle from programadetalle pd LEFT JOIN tercero t ON t.idTercero = pd.Tercero_idResponsable LEFT JOIN documentosoporte d ON d.idDocumentoSoporte = pd.Documento_idDocumento WHERE Programa_idPrograma =  ".$id);

              // Se llama los registros para saber  cual es  la que va a imprimir el usuario
            $Programa = \App\Programa::find($id);

            $ProgramaArchivo = DB::SELECT("
                SELECT pa.idProgramaArchivo,pa.Programa_idPrograma,pa.rutaProgramaArchivo
                FROM programaarchivo pa
                LEFT JOIN programa p
                ON pa.Programa_idPrograma = p.idPrograma
                WHERE pa.Programa_idPrograma = ".$id);

            
            return view('formatos.programaimpresion',compact('ProgramaArchivo','programa','programaDetalle'));
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

        $programa = \App\Programa::find($id);

        // cuando se modifica  un programa, enviamos los maestros requeridos para el encabezado         
        $clasificacionriesgo = \App\ClasificacionRiesgo::All()->lists('nombreClasificacionRiesgo','idClasificacionRiesgo');
        $terceros = \App\Tercero::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('nombreCompletoTercero', 'idTercero');
        $companiaobjetivo = \App\CompaniaObjetivo::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('nombreCompaniaObjetivo','idCompaniaObjetivo');

        $idTercero = \App\Tercero::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('idTercero');
        $nombreCompletoTercero = \App\Tercero::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('nombreCompletoTercero');

        $idDocumentoSoporte = \App\DocumentoSoporte::All()->lists('idDocumentoSoporte');
        $nombreDocumentoSoporte = \App\DocumentoSoporte::All()->lists('nombreDocumentoSoporte');

        return view('programa',
                    compact('clasificacionriesgo','terceros','companiaobjetivo', 'nombreCompletoTercero', 'idTercero', 'nombreDocumentoSoporte', 'idDocumentoSoporte'),
                    ['programa'=>$programa]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(ProgramaRequest $request, $id)
    {
        if($request['respuesta'] != 'falso')
        { 
            $programa = \App\Programa::find($id);
            $programa->fill($request->all());
            $programa->save();

            \App\ProgramaDetalle::where('Programa_idPrograma',$id)->delete();

            $contadorDetalle = count($request['actividadProgramaDetalle']);
            for($i = 0; $i < $contadorDetalle; $i++)
            {
                \App\ProgramaDetalle::create([
                'Programa_idPrograma' => $id,
                'actividadProgramaDetalle' => $request['actividadProgramaDetalle'][$i],
                'Tercero_idResponsable' => $request['Tercero_idResponsable'][$i],
                'fechaPlaneadaProgramaDetalle' => $request['fechaPlaneadaProgramaDetalle'][$i],
                'Documento_idDocumento' => $request['Documento_idDocumento'][$i],
                'recursoPlaneadoProgramaDetalle' => $request['recursoPlaneadoProgramaDetalle'][$i],
                'recursoEjecutadoProgramaDetalle' => $request['recursoEjecutadoProgramaDetalle'][$i],
                'fechaEjecucionProgramaDetalle' => $request['fechaEjecucionProgramaDetalle'][$i],
                'observacionProgramaDetalle' => $request['observacionProgramaDetalle'][$i]
               ]);
            }



                        //Para sobreescribir  el archivo 
            // HAGO UN INSERT A LOS NUEVOS ARCHIVOS SUBIDOS EN EL DROPZONE de 
            if ($request['ProgramaArchivoArray'] != '') 
            {
                $arrayImage = $request['ProgramaArchivoArray'];
                $arrayImage = substr($arrayImage, 0, strlen($arrayImage)-1);
                $arrayImage = explode(",", $arrayImage);
                $ruta = '';

                for($i = 0; $i < count($arrayImage); $i++)
                {
                    if ($arrayImage[$i] != '' || $arrayImage[$i] != 0) 
                    {
                        $origen = public_path() . '/imagenes/repositorio/temporal/'.$arrayImage[$i];
                        $destinationPath = public_path() . '/imagenes/programa/'.$arrayImage[$i];
                        
                        if (file_exists($origen))
                        {
                            copy($origen, $destinationPath);
                            unlink($origen);
                            $ruta = '/programa/'.$arrayImage[$i];

                            DB::table('programaarchivo')->insert(['idProgramaArchivo' => '0', 'Programa_idPrograma' =>$id,'rutaProgramaArchivo' => $ruta]);
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
                \App\ProgramaArchivo::whereIn('idProgramaArchivo',$idsEliminar)->delete();
            }


            return redirect('/programa');
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

        \App\Programa::destroy($id);
        return redirect('/programa');
    }
}
