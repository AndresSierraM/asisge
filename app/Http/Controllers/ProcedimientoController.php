<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Procedimiento;
use App\Http\Requests;
use App\Http\Requests\ProcedimientoRequest;
use App\Http\Controllers\Controller;
use DB;
include public_path().'/ajax/consultarPermisos.php';

class ProcedimientoController extends Controller
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
            return view('procedimientogrid', compact('datos'));
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
        // cuando se crea un nuevo procedimiento, enviamos los procesos para el encabezado y los documentos 
        //  y los terceros que son la base para el llenado del detalle
        
        $procesos = \App\Proceso::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('nombreProceso','idProceso');

        $idTercero = \App\Tercero::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('idTercero');
        $nombreCompletoTercero = \App\Tercero::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('nombreCompletoTercero');

        $idDocumentoSoporte = \App\DocumentoSoporte::All()->lists('idDocumentoSoporte');
        $nombreDocumentoSoporte = \App\DocumentoSoporte::All()->lists('nombreDocumentoSoporte');

        return view('procedimiento',compact('procesos','idTercero','nombreCompletoTercero','idDocumentoSoporte','nombreDocumentoSoporte'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(ProcedimientoRequest $request)
    {
        
        \App\Procedimiento::create([
            'Proceso_idProceso' => $request['Proceso_idProceso'],
            'nombreProcedimiento' => $request['nombreProcedimiento'],
            'fechaElaboracionProcedimiento' => $request['fechaElaboracionProcedimiento'],
            'objetivoProcedimiento' => $request['objetivoProcedimiento'],
            'alcanceProcedimiento' => $request['alcanceProcedimiento'],
            'responsabilidadProcedimiento' => $request['responsabilidadProcedimiento'],
            'generalidadProcedimiento' => $request['generalidadProcedimiento'],
            'Compania_idCompania' => \Session::get('idCompania')
            ]); 

        $procedimiento = \App\Procedimiento::All()->last();
        $contadorDetalle = count($request['Documento_idDocumento']);
        for($i = 0; $i < $contadorDetalle; $i++)
        {
            \App\ProcedimientoDetalle::create([
            'Procedimiento_idProcedimiento' => $procedimiento->idProcedimiento,
            'Documento_idDocumento' => $request['Documento_idDocumento'][$i],
            'Tercero_idResponsable' => $request['Tercero_idResponsable'][$i],
            'actividadProcedimientoDetalle' => $request['actividadProcedimientoDetalle'][$i]
           ]);
        }



        // Guardado del dropzone
                $arrayImage = $request['archivoProcedimientoArray'];
                $arrayImage = substr($arrayImage, 0, strlen($arrayImage)-1);
                $arrayImage = explode(",", $arrayImage);
                $ruta = '';
                for ($i=0; $i < count($arrayImage) ; $i++) 
                { 
                    if ($arrayImage[$i] != '' || $arrayImage[$i] != 0) 
                    {
                        $origen = public_path() . '/imagenes/repositorio/temporal/'.$arrayImage[$i];
                        $destinationPath = public_path() . '/imagenes/procedimiento/'.$arrayImage[$i];
                        $ruta = '/procedimiento/'.$arrayImage[$i];
                       
                        if (file_exists($origen))
                        {
                            copy($origen, $destinationPath);
                            unlink($origen);
                        }   
                        else
                        {
                            echo "No existe el archivo";
                        }
                        \App\ProcedimientoArchivo::create([
                        'Procedimiento_idProcedimiento' => $procedimiento->idProcedimiento,
                        'rutaProcedimientoArchivo' => $ruta
                       ]);
                    }

                }

        return redirect('/procedimiento');
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
            $procedimiento = DB::select ("SELECT nombreProceso,nombreProcedimiento,fechaElaboracionProcedimiento,objetivoProcedimiento,alcanceProcedimiento,responsabilidadProcedimiento from procedimiento p LEFT JOIN proceso pr ON pr.idProceso = p.Proceso_idProceso WHERE idProcedimiento = ".$id." AND p.Compania_idCompania = ".\Session::get("idCompania"));

          
            $procedimientoDetalle = DB::select("SELECT actividadProcedimientoDetalle,nombreCompletoTercero,nombreDocumentoSoporte from procedimientodetalle pd LEFT JOIN tercero t ON t.idTercero = pd.Tercero_idResponsable LEFT JOIN documentosoporte d ON d.idDocumentoSoporte = pd.Documento_idDocumento WHERE Procedimiento_idProcedimiento =  ".$id);

            
            return view('formatos.procedimientoimpresion',compact('procedimiento','procedimientoDetalle'));
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
        // cuando se modifica un procedimiento, enviamos los procesos para el encabezado y los documentos 
        //  y los terceros que son la base para el llenado del detalle
        $procedimiento = \App\Procedimiento::find($id);
        $procesos = \App\Proceso::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('nombreProceso','idProceso');

        $idTercero = \App\Tercero::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('idTercero');
        $nombreCompletoTercero = \App\Tercero::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('nombreCompletoTercero');

       $idDocumentoSoporte = \App\DocumentoSoporte::All()->lists('idDocumentoSoporte');
        $nombreDocumentoSoporte = \App\DocumentoSoporte::All()->lists('nombreDocumentoSoporte');
       
        return view('procedimiento',compact('procesos','idTercero','nombreCompletoTercero','idDocumentoSoporte','nombreDocumentoSoporte'),['procedimiento'=>$procedimiento]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update($id,ProcedimientoRequest $request)
    {
        
        $procedimiento = \App\Procedimiento::find($id);
        $procedimiento->fill($request->all());
        $procedimiento->save();


        \App\ProcedimientoDetalle::where('Procedimiento_idProcedimiento',$id)->delete();

        $contadorDetalle = count($request['Documento_idDocumento']);
        for($i = 0; $i < $contadorDetalle; $i++)
        {
            \App\ProcedimientoDetalle::create([
            'Procedimiento_idProcedimiento' => $id,
            'Documento_idDocumento' => $request['Documento_idDocumento'][$i],
            'Tercero_idResponsable' => $request['Tercero_idResponsable'][$i],
            'actividadProcedimientoDetalle' => $request['actividadProcedimientoDetalle'][$i]
           ]);
        }

        //Para sobreescribir  el archivo 
            // HAGO UN INSERT A LOS NUEVOS ARCHIVOS SUBIDOS EN EL DROPZONE
            if ($request['archivoProcedimientoArray'] != '') 
            {
                $arrayImage = $request['archivoProcedimientoArray'];
                $arrayImage = substr($arrayImage, 0, strlen($arrayImage)-1);
                $arrayImage = explode(",", $arrayImage);
                $ruta = '';

                for($i = 0; $i < count($arrayImage); $i++)
                {
                    if ($arrayImage[$i] != '' || $arrayImage[$i] != 0) 
                    {
                        $origen = public_path() . '/imagenes/repositorio/temporal/'.$arrayImage[$i];
                        $destinationPath = public_path() . '/imagenes/procedimiento/'.$arrayImage[$i];
                        
                        if (file_exists($origen))
                        {
                            copy($origen, $destinationPath);
                            unlink($origen);
                            $ruta = '/procedimiento/'.$arrayImage[$i];

                            DB::table('actacapacitacionarchivo')->insert(['idActaCapacitacionArchivo' => '0', 'ActaCapacitacion_idActaCapacitacion' =>$id,'rutaActaCapacitacionArchivo' => $ruta]);
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
                \App\ProcedimientoArchivo::whereIn('idProcedimientoArchivo',$idsEliminar)->delete();
            }

            // 
        return redirect('/procedimiento');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    

    public function destroy($id)
    {

        \App\Procedimiento::destroy($id);
        return redirect('/procedimiento');
    }
}
