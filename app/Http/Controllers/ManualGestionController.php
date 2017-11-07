<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\ManualGestionRequest;
use App\Http\Controllers\Controller;
use DB;

include public_path().'/ajax/consultarPermisos.php';

class ManualGestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
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


    public function index()
    {
         $vista = basename($_SERVER["PHP_SELF"]);
         $datos = consultarPermisos($vista);

         if($datos != null)
          return view('manualgestiongrid', compact('datos'));
         else
            return view('accesodenegado');
        
        // return view('manualgestion');

     }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tercero = \App\Tercero::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('nombreCompletoTercero','idTercero');

         
        return view ('manualgestion', compact('tercero'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ManualGestionRequest $request)
    {
     if($request['respuesta'] != 'falso')
        {  
            \App\ManualGestion::create([
                'codigoManualGestion' => $request['codigoManualGestion'],
                'nombreManualGestion' => $request['nombreManualGestion'],
                'fechaManualGestion' => $request['fechaManualGestion'],
                'Tercero_idEmpleador' => $request['Tercero_idEmpleador'],
                'generalidadesManualGestion' => $request['generalidadesManualGestion'],
                'misionManualGestion' => $request['misionManualGestion'],
                'visionManualGestion' => $request['visionManualGestion'],
                'valoresManualGestion' => $request['valoresManualGestion'],
                'politicasManualGestion' => $request['politicasManualGestion'],
                'principiosManualGestion' => $request['principiosManualGestion'],
                'metasManualGestion' => $request['metasManualGestion'],
                'objetivosManualGestion' => $request['objetivosManualGestion'],
                'objetivoCalidadManualGestion' => $request['objetivoCalidadManualGestion'],
                'alcanceManualGestion' => $request['alcanceManualGestion'],
                'exclusionesManualGestion' => $request['exclusionesManualGestion'],
                'Compania_idCompania' => \Session::get('idCompania')
            ]);


           //Primero consultar el ultimo id guardado
        $manualgestion = \App\ManualGestion::All()->last();

          // armamos una ruta para el archivo de imagen y volvemos a actualizar el registro
            // esto es porque la creamos con el ID del accidente y debiamos grabar primero para obtenerlo
            $ruta = 'manualgestion/firmamanualgestion_'.$manualgestion->idManualGestion.'.png';
            $manualgestion->firmaEmpleadorManualGestion = $ruta;

            $manualgestion->save();

            //----------------------------
            // Guardamos la imagen de la firma como un archivo en disco
            if (isset($request['firmabase64']) and $request['firmabase64'] != '') 
            {
                $data = $request['firmabase64'];

                list($type, $data) = explode(';', $data);
                list(, $data)      = explode(',', $data);
                $data = base64_decode($data);

                file_put_contents('imagenes/'.$ruta, $data);
            }




             // Multiregistro Manual Gestion Parte Guardado
            for ($i=0; $i < count($request['interesadoManualGestionParte']); $i++) 
               { 
                \App\ManualGestionParte::create([
                'ManualGestion_idManualGestion' => $manualgestion->idManualGestion,
                'interesadoManualGestionParte' => $request['interesadoManualGestionParte'][$i],
                'necesidadManualGestionParte' => $request['necesidadManualGestionParte'][$i], 
                'cumplimientoManualGestionParte' => $request['cumplimientoManualGestionParte'][$i]
                  ]);
               }

            // Guardado del dropzone para Interaccion proceso
                $arrayImage = $request['InteraccionProcesoArray'];
                $arrayImage = substr($arrayImage, 0, strlen($arrayImage)-1);
                $arrayImage = explode(",", $arrayImage);
                $ruta = '';
                for ($i=0; $i < count($arrayImage) ; $i++) 
                { 
                    if ($arrayImage[$i] != '' || $arrayImage[$i] != 0) 
                    {
                        $origen = public_path() . '/imagenes/repositorio/temporal/'.$arrayImage[$i];
                        $destinationPath = public_path() . '/imagenes/manualgestion/'.$arrayImage[$i];
                        $ruta = '/manualgestion/'.$arrayImage[$i];
                       
                        if (file_exists($origen))
                        {
                            copy($origen, $destinationPath);
                            unlink($origen);
                        }   
                        else
                        {
                            echo "No existe el archivo";
                        }
                        \App\ManualGestionProceso::create([
                        'ManualGestion_idManualGestion' => $manualgestion->idManualGestion,
                        'rutaManualGestionProceso' => $ruta
                       ]);
                    }

                }

                        // Guardado del dropzone para Estructura
                $arrayImage = $request['EstructuraOrganizacionalArray'];
                $arrayImage = substr($arrayImage, 0, strlen($arrayImage)-1);
                $arrayImage = explode(",", $arrayImage);
                $ruta = '';
                for ($i=0; $i < count($arrayImage) ; $i++) 
                { 
                    if ($arrayImage[$i] != '' || $arrayImage[$i] != 0) 
                    {
                        $origen = public_path() . '/imagenes/repositorio/temporal/'.$arrayImage[$i];
                        $destinationPath = public_path() . '/imagenes/manualgestion/'.$arrayImage[$i];
                        $ruta = '/manualgestion/'.$arrayImage[$i];
                       
                        if (file_exists($origen))
                        {
                            copy($origen, $destinationPath);
                            unlink($origen);
                        }   
                        else
                        {
                            echo "No existe el archivo";
                        }
                        \App\ManualGestionEstructura::create([
                        'ManualGestion_idManualGestion' => $manualgestion->idManualGestion,
                        'rutaManualGestionEstructura' => $ruta
                       ]);
                    }

                }

                            // Guardado del dropzone para Adjuntos
                $arrayImage = $request['ManualGestionAdjuntoArray'];
                $arrayImage = substr($arrayImage, 0, strlen($arrayImage)-1);
                $arrayImage = explode(",", $arrayImage);
                $ruta = '';
                for ($i=0; $i < count($arrayImage) ; $i++) 
                { 
                    if ($arrayImage[$i] != '' || $arrayImage[$i] != 0) 
                    {
                        $origen = public_path() . '/imagenes/repositorio/temporal/'.$arrayImage[$i];
                        $destinationPath = public_path() . '/imagenes/manualgestion/'.$arrayImage[$i];
                        $ruta = '/manualgestion/'.$arrayImage[$i];
                       
                        if (file_exists($origen))
                        {
                            copy($origen, $destinationPath);
                            unlink($origen);
                        }   
                        else
                        {
                            echo "No existe el archivo";
                        }
                        \App\ManualGestionAdjunto::create([
                        'ManualGestion_idManualGestion' => $manualgestion->idManualGestion,
                        'rutaManualGestionAdjunto' => $ruta
                       ]);
                    }

                }



           
        }
            

         return redirect('/manualgestion');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
           if($_GET['accion'] == 'imprimir')
        {
            // Se llama los registros para saber  cual es  la que va a imprimir el usuario
           $manualgestion = \App\ManualGestion::find($id);



            $ManualGestionEncabezado = DB::select('
            SELECT mg.codigoManualGestion,mg.nombreManualGestion,mg.fechaManualGestion,
            t.nombreCompletoTercero,mg.firmaEmpleadorManualGestion
            FROM manualgestion mg
            LEFT JOIN tercero t
            ON mg.Tercero_idEmpleador = t.idTercero
            WHERE mg.idManualGestion = '.$id);


            return view('formatos.manualgestionimpresion',compact('ManualGestionEncabezado'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $manualgestion = \App\ManualGestion::find($id);
        $tercero = \App\Tercero::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('nombreCompletoTercero','idTercero');


        $ManualGestionParte = DB::SELECT('
        SELECT mgp.idManualGestionParte,mgp.ManualGestion_idManualGestion,mgp.interesadoManualGestionParte,mgp.necesidadManualGestionParte,mgp.cumplimientoManualGestionParte
        FROM manualgestionparte mgp
        LEFT JOIN manualgestion mg
        ON mgp.ManualGestion_idManualGestion = mg.idManualGestion
        WHERE mgp.ManualGestion_idManualGestion ='.$id);


        return view('manualgestion',compact('tercero','ManualGestionParte'),['manualgestion'=>$manualgestion]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ManualGestionRequest $request, $id)
    {
        if($request['respuesta'] != 'falso')
        {
            $manualgestion = \App\ManualGestion::find($id);
            $manualgestion->fill($request->all());
            $manualgestion->Tercero_idEmpleador = (($request['Tercero_idEmpleador'] == '' or $request['Tercero_idEmpleador'] == 0) ? null : $request['Tercero_idEmpleador'
                    ]);

            $manualgestion->save();




             // armamos una ruta para el archivo de imagen y volvemos a actualizar el registro
            // esto es porque la creamos con el ID del accidente y debiamos grabar primero para obtenerlo
            $ruta = 'manualgestion/firmamanualgestion_'.$manualgestion->idManualGestion.'.png';
            $manualgestion->firmaEmpleadorManualGestion = $ruta;

            $manualgestion->save();

            //----------------------------
            // Guardamos la imagen de la firma como un archivo en disco
            $data = $request['firmabase64'];

            if($data != '')
            {
                list($type, $data) = explode(';', $data);
                list(, $data)      = explode(',', $data);
                $data = base64_decode($data);

                file_put_contents('imagenes/'.$ruta, $data);
            }


            
                       // Update para el detalle de  limite
                 $idsEliminar = explode("," , $request['eliminarparteinteresada']);
                //Eliminar registros de la multiregistro
                \App\ManualGestionParte::whereIn('idManualGestionParte', $idsEliminar)->delete();
                // Guardamos el detalle de los modulos
                for($i = 0; $i < count($request['idManualGestionParte']); $i++)
                {
                     $indice = array(
                        'idManualGestionParte' => $request['idManualGestionParte'][$i]);

                    $data = array(
                    'ManualGestion_idManualGestion' => $manualgestion->idManualGestion,
                    'interesadoManualGestionParte' => $request['interesadoManualGestionParte'][$i],
                    'necesidadManualGestionParte' => $request['necesidadManualGestionParte'][$i], 
                    'cumplimientoManualGestionParte' => $request['cumplimientoManualGestionParte'][$i]
                      );

                    $guardar = \App\ManualGestionParte::updateOrCreate($indice, $data);
                } 



                 //Para sobreescribir  el archivo 
            // HAGO UN INSERT A LOS NUEVOS ARCHIVOS SUBIDOS EN EL DROPZONE de 
            if ($request['InteraccionProcesoArray'] != '') 
            {
                $arrayImage = $request['InteraccionProcesoArray'];
                $arrayImage = substr($arrayImage, 0, strlen($arrayImage)-1);
                $arrayImage = explode(",", $arrayImage);
                $ruta = '';

                for($i = 0; $i < count($arrayImage); $i++)
                {
                    if ($arrayImage[$i] != '' || $arrayImage[$i] != 0) 
                    {
                        $origen = public_path() . '/imagenes/repositorio/temporal/'.$arrayImage[$i];
                        $destinationPath = public_path() . '/imagenes/manualgestion/'.$arrayImage[$i];
                        
                        if (file_exists($origen))
                        {
                            copy($origen, $destinationPath);
                            unlink($origen);
                            $ruta = '/manualgestion/'.$arrayImage[$i];

                            DB::table('manualgestionproceso')->insert(['idManualGestionProceso' => '0', 'ManualGestion_idManualGestion' =>$id,'rutaManualGestionProceso' => $ruta]);
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
            $idsEliminar = $request['eliminarProceso'];
            $idsEliminar = substr($idsEliminar, 0, strlen($idsEliminar)-1);
            if($idsEliminar != '')
            {
                $idsEliminar = explode(',',$idsEliminar);
                \App\ManualGestionProceso::whereIn('idManualGestionProceso',$idsEliminar)->delete();
            }



                             //Para sobreescribir  el archivo 
            // HAGO UN INSERT A LOS NUEVOS ARCHIVOS SUBIDOS EN EL DROPZONE de 
            if ($request['EstructuraOrganizacionalArray'] != '') 
            {
                $arrayImage = $request['EstructuraOrganizacionalArray'];
                $arrayImage = substr($arrayImage, 0, strlen($arrayImage)-1);
                $arrayImage = explode(",", $arrayImage);
                $ruta = '';

                for($i = 0; $i < count($arrayImage); $i++)
                {
                    if ($arrayImage[$i] != '' || $arrayImage[$i] != 0) 
                    {
                        $origen = public_path() . '/imagenes/repositorio/temporal/'.$arrayImage[$i];
                        $destinationPath = public_path() . '/imagenes/manualgestion/'.$arrayImage[$i];
                        
                        if (file_exists($origen))
                        {
                            copy($origen, $destinationPath);
                            unlink($origen);
                            $ruta = '/manualgestion/'.$arrayImage[$i];

                            DB::table('manualgestionestructura')->insert(['idManualGestionEstructura' => '0', 'ManualGestion_idManualGestion' =>$id,'rutaManualGestionEstructura' => $ruta]);
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
            $idsEliminar = $request['eliminarEstructura'];
            $idsEliminar = substr($idsEliminar, 0, strlen($idsEliminar)-1);
            if($idsEliminar != '')
            {
                $idsEliminar = explode(',',$idsEliminar);
                \App\ManualGestionEstructura::whereIn('idManualGestionEstructura',$idsEliminar)->delete();
            }


                       //Para sobreescribir  el archivo 
            // HAGO UN INSERT A LOS NUEVOS ARCHIVOS SUBIDOS EN EL DROPZONE de 
            if ($request['ManualGestionAdjuntoArray'] != '') 
            {
                $arrayImage = $request['ManualGestionAdjuntoArray'];
                $arrayImage = substr($arrayImage, 0, strlen($arrayImage)-1);
                $arrayImage = explode(",", $arrayImage);
                $ruta = '';

                for($i = 0; $i < count($arrayImage); $i++)
                {
                    if ($arrayImage[$i] != '' || $arrayImage[$i] != 0) 
                    {
                        $origen = public_path() . '/imagenes/repositorio/temporal/'.$arrayImage[$i];
                        $destinationPath = public_path() . '/imagenes/manualgestion/'.$arrayImage[$i];
                        
                        if (file_exists($origen))
                        {
                            copy($origen, $destinationPath);
                            unlink($origen);
                            $ruta = '/manualgestion/'.$arrayImage[$i];

                            DB::table('manualgestionadjunto')->insert(['idManualGestionAdjunto' => '0', 'ManualGestion_idManualGestion' =>$id,'rutaManualGestionAdjunto' => $ruta]);
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
            $idsEliminar = $request['eliminarAdjunto'];
            $idsEliminar = substr($idsEliminar, 0, strlen($idsEliminar)-1);
            if($idsEliminar != '')
            {
                $idsEliminar = explode(',',$idsEliminar);
                \App\ManualGestionAdjunto::whereIn('idManualGestionAdjunto',$idsEliminar)->delete();
            }




        }

        return redirect('manualgestion');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        \App\ManualGestion::destroy($id);
        return redirect('/manualgestion');
    }
}
