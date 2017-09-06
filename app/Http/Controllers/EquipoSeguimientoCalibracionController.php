<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\EquipoSeguimientoCalibracionRequest;
use App\Http\Controllers\Controller;
use DB;
use Input;
use File;

include public_path().'/ajax/consultarPermisos.php';

class EquipoSeguimientoCalibracionController extends Controller
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
            return view('equiposeguimientocalibraciongrid', compact('datos'));
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

         $EquipoSeguimientoE = \App\EquipoSeguimiento::where('Compania_idCompania', "=", \Session::get('idCompania'))->lists('nombreEquipoSeguimiento','idEquipoSeguimiento'); 

         $TerceroProveedor = \App\Tercero::where('tipoTercero', "like", "%*02*%")->where('Compania_idCompania', "=", \Session::get('idCompania'))->lists('nombreCompletoTercero','idTercero'); 
        
         return view('equiposeguimientocalibracion',compact('EquipoSeguimientoE','TerceroProveedor'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(EquipoSeguimientoCalibracionRequest $request)
    {
       if($request['respuesta'] != 'falso')
        {  
          \App\EquipoSeguimientoCalibracion::create([
                'fechaEquipoSeguimientoCalibracion' => $request['fechaEquipoSeguimientoCalibracion'],
                'EquipoSeguimiento_idEquipoSeguimiento' => $request['EquipoSeguimiento_idEquipoSeguimiento'],
                'EquipoSeguimientoDetalle_idEquipoSeguimientoDetalle' => $request['EquipoSeguimientoDetalle_idEquipoSeguimientoDetalle'],
                'errorEncontradoEquipoSeguimientoCalibracion' => $request['errorEncontradoEquipoSeguimientoCalibracion'],
                'resultadoEquipoSeguimientoCalibracion' => $request['resultadoEquipoSeguimientoCalibracion'],
                'Tercero_idProveedor' => $request['Tercero_idProveedor'],                
                'accionEquipoSeguimientoCalibracion' => $request['accionEquipoSeguimientoCalibracion']
                ]);

           $equiposeguimientocalibracion = \App\EquipoSeguimientoCalibracion::All()->last();
           // Guardado del dropzone
                $arrayImage = $request['archivoEquipoSeguimientoCalibracionArray'];
                $arrayImage = substr($arrayImage, 0, strlen($arrayImage)-1);
                $arrayImage = explode(",", $arrayImage);
                $ruta = '';
                for ($i=0; $i < count($arrayImage) ; $i++) 
                { 
                    if ($arrayImage[$i] != '' || $arrayImage[$i] != 0) 
                    {
                        $origen = public_path() . '/imagenes/repositorio/temporal/'.$arrayImage[$i];
                        $destinationPath = public_path() . '/imagenes/equiposeguimientocalibracion/'.$arrayImage[$i];
                        $ruta = '/equiposeguimientocalibracion/'.$arrayImage[$i];
                       
                        if (file_exists($origen))
                        {
                            copy($origen, $destinationPath);
                            unlink($origen);
                        }   
                        else
                        {
                            echo "No existe el archivo";
                        }
                        \App\EquipoSeguimientoCalibracionArchivo::create([
                        'EquipoSeguimientoCalibracion_idEquipoSeguimientoCalibracion' => $equiposeguimientocalibracion->idEquipoSeguimientoCalibracion,
                        'rutaEquipoSeguimientoCalibracionArchivo' => $ruta
                       ]);
                    }

                }


        }
          return redirect('/equiposeguimientocalibracion');
    }
    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id, Request $request)
    {
      
      if($_GET['accion'] == 'imprimir')
        {


            // Se llama los registros para saber  cual es  la que va a imprimir el usuario
           $equiposeguimientocalibracion = \App\EquipoSeguimientoCalibracion::find($id);


              $EquipoSeguimientoCalibracionEncabezadoS = DB::select('
                SELECT esc.idEquipoSeguimientoCalibracion,esc.fechaEquipoSeguimientoCalibracion,es.nombreEquipoSeguimiento,t.nombreCompletoTercero,
                esd.identificacionEquipoSeguimientoDetalle,tp.nombreCompletoTercero as NombreCompletoTerceroProveedor,esc.errorEncontradoEquipoSeguimientoCalibracion,
                esc.resultadoEquipoSeguimientoCalibracion,esc.accionEquipoSeguimientoCalibracion
                FROM equiposeguimientocalibracion esc
                LEFT JOIN equiposeguimiento es
                ON esc.EquipoSeguimiento_idEquipoSeguimiento = es.idEquipoSeguimiento
                LEFT JOIN equiposeguimientodetalle esd
                ON esc.EquipoSeguimientoDetalle_idEquipoSeguimientoDetalle = esd.idEquipoSeguimientoDetalle
                LEFT JOIN tercero t
                ON es.Tercero_idResponsable = t.idTercero                
                LEFT JOIN tercero tp
                ON esc.Tercero_idProveedor = tp.idTercero
                WHERE esc.idEquipoSeguimientoCalibracion = '.$id);

              $adjuntoCalibracion = DB::select('
                SELECT esca.rutaEquipoSeguimientoCalibracionArchivo
                FROM equiposeguimientocalibracion esc
                LEFT JOIN equiposeguimientocalibracionarchivo esca
                ON esca.EquipoSeguimientoCalibracion_idEquipoSeguimientoCalibracion = esc.idEquipoSeguimientoCalibracion
                where esc.idEquipoSeguimientoCalibracion = '.$id);
               


             return view('formatos.equiposeguimientocalibracionimpresion',compact('EquipoSeguimientoCalibracionEncabezadoS','adjuntoCalibracion'));
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
        $equiposeguimientocalibracion = \App\EquipoSeguimientoCalibracion::find($id);
         $EquipoSeguimientoE = \App\EquipoSeguimiento::where('Compania_idCompania', "=", \Session::get('idCompania'))->lists('nombreEquipoSeguimiento','idEquipoSeguimiento'); 

         $TerceroProveedor = \App\Tercero::where('tipoTercero', "like", "%*02*%")->where('Compania_idCompania', "=", \Session::get('idCompania'))->lists('nombreCompletoTercero','idTercero');   

        return view('equiposeguimientocalibracion',compact('EquipoSeguimientoE','TerceroProveedor'),['equiposeguimientocalibracion'=>$equiposeguimientocalibracion]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(EquipoSeguimientoCalibracionRequest $request, $id)
    {
       if($request['respuesta'] != 'falso')
        {
       
          $equiposeguimientocalibracion = \App\EquipoSeguimientoCalibracion::find($id);
          $equiposeguimientocalibracion->fill($request->all());      
          $equiposeguimientocalibracion->EquipoSeguimiento_idEquipoSeguimiento = (($request['EquipoSeguimiento_idEquipoSeguimiento'] == '' or $request['EquipoSeguimiento_idEquipoSeguimiento'] == 0) ? null : $request['EquipoSeguimiento_idEquipoSeguimiento'
                ]);
          $equiposeguimientocalibracion->Tercero_idProveedor = (($request['Tercero_idProveedor'] == '' or $request['Tercero_idProveedor'] == 0) ? null : $request['Tercero_idProveedor'
                ]);
          $equiposeguimientocalibracion->save();






             //Para sobreescribir  el archivo 
            // HAGO UN INSERT A LOS NUEVOS ARCHIVOS SUBIDOS EN EL DROPZONE
            if ($request['archivoEquipoSeguimientoCalibracionArray'] != '') 
            {
                $arrayImage = $request['archivoEquipoSeguimientoCalibracionArray'];
                $arrayImage = substr($arrayImage, 0, strlen($arrayImage)-1);
                $arrayImage = explode(",", $arrayImage);
                $ruta = '';

                for($i = 0; $i < count($arrayImage); $i++)
                {
                    if ($arrayImage[$i] != '' || $arrayImage[$i] != 0) 
                    {
                        $origen = public_path() . '/imagenes/repositorio/temporal/'.$arrayImage[$i];
                        $destinationPath = public_path() . '/imagenes/equiposeguimientocalibracion/'.$arrayImage[$i];
                        
                        if (file_exists($origen))
                        {
                            copy($origen, $destinationPath);
                            unlink($origen);
                            $ruta = '/equiposeguimientocalibracion/'.$arrayImage[$i];

                            DB::table('equiposeguimientocalibracionarchivo')->insert(['idEquipoSeguimientoCalibracionArchivo' => '0', 'EquipoSeguimientoCalibracion_idEquipoSeguimientoCalibracion' =>$id,'rutaEquipoSeguimientoCalibracionArchivo' => $ruta]);
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
                \App\EquipoSeguimientoCalibracionArchivo::whereIn('idEquipoSeguimientoCalibracionArchivo',$idsEliminar)->delete();
            }


            
        }
  
          
      return redirect('/equiposeguimientocalibracion');
    }
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        \App\EquipoSeguimientoCalibracion::destroy($id);
        return redirect('/equiposeguimientocalibracion');
    }

    

}

