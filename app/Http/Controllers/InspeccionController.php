<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Inspeccion;
use App\Http\Requests;
use App\Http\Requests\InspeccionRequest;
use App\Http\Controllers\Controller;
use DB;
include public_path().'/ajax/consultarPermisos.php';

use Input;
use File;
// include composer autoload
// require '../vendor/autoload.php';
// import the Intervention Image Manager Class
use Intervention\Image\ImageManager ;


class InspeccionController extends Controller
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

        return view('inspecciongrid', compact('datos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $tipoinspeccion = \App\TipoInspeccion::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('nombreTipoInspeccion','idTipoInspeccion');
        $tercero = \App\Tercero::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('nombreCompletoTercero','idTercero');
        
        $idTercero = \App\Tercero::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('idTercero');
        $nombreCompletoTercero = \App\Tercero::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('nombreCompletoTercero');

        return view('inspeccion',compact('tipoinspeccion','tercero','idTercero','nombreCompletoTercero'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(InspeccionRequest $request)
    {
        if($request['respuesta'] != 'falso')
        {
            \App\Inspeccion::create([
                'TipoInspeccion_idTipoInspeccion' => $request['TipoInspeccion_idTipoInspeccion'],
                'Tercero_idRealizadaPor' => $request['Tercero_idRealizadaPor'],
                'fechaElaboracionInspeccion' => $request['fechaElaboracionInspeccion'],
                'observacionesInspeccion' => $request['observacionesInspeccion'],
                'Compania_idCompania' => \Session::get('idCompania')
                ]); 

            $inspeccion = \App\Inspeccion::All()->last();

            // armamos una ruta para el archivo de imagen y volvemos a actualizar el registro
            // esto es porque la creamos con el ID del accidente y debiamos grabar primero para obtenerlo
            $ruta = 'inspeccion/firmainspeccion_'.$inspeccion->idInspeccion.'.png';
            $inspeccion->firmaRealizadaPorInspeccion = $ruta;

            $inspeccion->save();

            //----------------------------
            // Guardamos la imagen de la firma como un archivo en disco
            $data = $request['firmabase64'];

            list($type, $data) = explode(';', $data);
            list(, $data)      = explode(',', $data);
            $data = base64_decode($data);

            file_put_contents('imagenes/'.$ruta, $data);

            //----------------------------


            $contadorDetalle = count($request['TipoInspeccionPregunta_idTipoInspeccionPregunta']);
            for($i = 0; $i < $contadorDetalle; $i++)
            {
                \App\InspeccionDetalle::create([
                'Inspeccion_idInspeccion' => $inspeccion->idInspeccion,
                'TipoInspeccionPregunta_idTipoInspeccionPregunta' => $request['TipoInspeccionPregunta_idTipoInspeccionPregunta'][$i],
                'situacionInspeccionDetalle' => $request['situacionInspeccionDetalle'][$i],
                'fotoInspeccionDetalle' => $request['fotoInspeccionDetalle'][$i],
                'ubicacionInspeccionDetalle' => $request['ubicacionInspeccionDetalle'][$i],
                'accionMejoraInspeccionDetalle' => $request['accionMejoraInspeccionDetalle'][$i],
                'Tercero_idResponsable' => $request['Tercero_idResponsable'][$i],
                'fechaInspeccionDetalle' => $request['fechaInspeccionDetalle'][$i],
                'observacionInspeccionDetalle' => $request['observacionInspeccionDetalle'][$i]
               ]);


                // verificamos si tiene texto en el campos de accion de mejora, insertamos un registro en el ACPM (Accion Correctiva)
                if($request['accionMejoraInspeccionDetalle'][$i] != '' )
                {
                        //************************************************
                        //
                        //  R E P O R T E   A C C I O N E S   
                        //  C O R R E C T I V A S,  P R E V E N T I V A S 
                        //  Y   D E   M E J O R A 
                        //
                        //************************************************
                        // todos los accidentes o incidentes los  insertamos un registro en el ACPM (Accion Correctiva)

                        $this->guardarReporteACPM(
                                $fechaAccion = date("Y-m-d"), 
                                $idModulo = 24, 
                                $tipoAccion = 'Correctiva', 
                                $descripcionAccion = $request['accionMejoraInspeccionDetalle'][$i]
                                );   
                }
                
            }

           return redirect('/inspeccion');
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show(Request $request)
    {
        /*if(isset($request['accion']) and $request['accion'] == 'imprimir')
        {

          $inspeccion = \App\Inspeccion::find($id);
          
          $inspeccionDetalle = DB::table('inspecciondetalle as dd')
            ->leftJoin('inspeccionpregunta as dp', 'dd.InspeccionPregunta_idInspeccionPregunta', '=', 'dp.idInspeccionPregunta')
            ->leftJoin('tipoinspeccion as dg', 'dp.TipoInspeccion_idTipoInspeccion', '=', 'dg.idTipoInspeccion')
            ->select(DB::raw('dd.idInspeccionDetalle, dg.nombreTipoInspeccion, dp.idInspeccionPregunta, dp.ordenInspeccionPregunta, dp.detalleInspeccionPregunta, dd.puntuacionInspeccionDetalle, dd.resultadoInspeccionDetalle, dd.mejoraInspeccionDetalle'))
            ->orderBy('dg.nombreTipoInspeccion', 'ASC')
            ->orderBy('dp.ordenInspeccionPregunta', 'ASC')
            ->where('Inspeccion_idInspeccion','=',$id)
            ->get();

          $inspeccionResumen = DB::table('inspecciondetalle as dd')
            ->leftJoin('inspeccionpregunta as dp', 'dd.InspeccionPregunta_idInspeccionPregunta', '=', 'dp.idInspeccionPregunta')
            ->leftJoin('tipoinspeccion as dg', 'dp.TipoInspeccion_idTipoInspeccion', '=', 'dg.idTipoInspeccion')
            ->select(DB::raw('dg.nombreTipoInspeccion, AVG(dd.resultadoInspeccionDetalle) as resultadoInspeccionDetalle'))
            ->orderBy('dg.nombreTipoInspeccion', 'ASC')
            ->groupBy('dg.nombreTipoInspeccion')
            ->where('Inspeccion_idInspeccion','=',$id)
            ->get();

            return view('formatos.inspeccionimpresion',['inspeccion'=>$inspeccion], compact('inspeccionDetalle','inspeccionResumen'));
        }*/

        if(isset($request['idTipoInspeccion']))
        {
         
            $ids = \App\TipoInspeccionPregunta::where('TipoInspeccion_idTipoInspeccion',$request['idTipoInspeccion'])
                                        ->select('idTipoInspeccionPregunta', 'numeroTipoInspeccionPregunta', 'contenidoTipoInspeccionPregunta')
                                        ->get();

            if($request->ajax())
            {
                return response()->json([$ids]);
            }
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

        $tipoinspeccion = \App\TipoInspeccion::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('nombreTipoInspeccion','idTipoInspeccion');
        $tercero = \App\Tercero::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('nombreCompletoTercero','idTercero');
        
        $idTercero = \App\Tercero::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('idTercero');
        $nombreCompletoTercero = \App\Tercero::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('nombreCompletoTercero');


        $inspeccion = \App\Inspeccion::find($id);

        $preguntas = DB::table('inspecciondetalle')
            ->leftJoin('tipoinspeccionpregunta', 'inspecciondetalle.TipoInspeccionPregunta_idTipoInspeccionPregunta', '=', 'tipoinspeccionpregunta.idTipoInspeccionPregunta')
            ->leftJoin('tipoinspeccion', 'tipoinspeccionpregunta.TipoInspeccion_idTipoInspeccion', '=', 'tipoinspeccion.idTipoInspeccion')
            ->select(DB::raw('TipoInspeccionPregunta_idTipoInspeccionPregunta, numeroTipoInspeccionPregunta, contenidoTipoInspeccionPregunta, 
                              situacionInspeccionDetalle,   fotoInspeccionDetalle, ubicacionInspeccionDetalle,
                              accionMejoraInspeccionDetalle, Tercero_idResponsable, fechaInspeccionDetalle,
                              observacionInspeccionDetalle'))
            ->orderBy('numeroTipoInspeccionPregunta', 'ASC')
            ->where('Inspeccion_idInspeccion','=',$id)
            ->get();

       return view('inspeccion',compact('tipoinspeccion','tercero','idTercero','nombreCompletoTercero', 'preguntas'),['inspeccion'=>$inspeccion]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update($id, InspeccionRequest $request)
    {
        if($request['respuesta'] != 'falso')
        {
            $inspeccion = \App\Inspeccion::find($id);
            $inspeccion->fill($request->all());

            // armamos una ruta para el archivo de imagen y volvemos a actualizar el registro
            // esto es porque la creamos con el ID del accidente y debiamos grabar primero para obtenerlo
            $ruta = 'inspeccion/firmainspeccion_'.$inspeccion->idInspeccion.'.png';
            $inspeccion->firmaRealizadaPorInspeccion = $ruta;

            $inspeccion->save();

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

            //----------------------------

            \App\InspeccionDetalle::where('Inspeccion_idInspeccion',$id)->delete();
             $files = Input::file('fotoInspeccionDetalle');

            $contadorDetalle = count($request['TipoInspeccionPregunta_idTipoInspeccionPregunta']);
            for($i = 0; $i < $contadorDetalle; $i++)
            {
                

               
                $file = $files[$i] ;
                $rutaImagen = '';
                $destinationPath = 'imagenes/inspeccion/';
                if(isset($file))
                {
                    $filename = $destinationPath . $file->getClientOriginalName();
                     
                    $manager = new ImageManager();
                    $manager->make($file->getRealPath())->save($filename);
                    $rutaImagen = 'inspeccion/'.$file->getClientOriginalName();


                    // recorrer todos los archivos para guardarlos en la carpeta
                    // luego de almacenar la información, guardamos los archivos en la carpeta de inpecciones
                    // $files = Input::file('fotoInspeccionDetalle');
                    // foreach($files as $file) {

                    //     $destinationPath = 'imagenes/inspeccion/';
                    //     if(isset($file))
                    //     {
                    //         $filename = $destinationPath . $file->getClientOriginalName();
                             
                    //         $manager = new ImageManager();
                    //         $manager->make($file->getRealPath())->save($filename);
                    //         echo 'Si entra ' . $filename.'<br>';
                    //     }
                    // }


                    // mostrar los archivos en un formulario
                    //  Route::get('storage/{id}/{archivo}', function ($archivo) {
                    //  $public_path = public_path();
                    //  $url = $public_path.'/storage/id/'.$archivo;

                    // //verificamos si el archivo existe y lo retornamos
                    //  if (Storage::exists($archivo))
                    //  {
                    //  return response()->download($url);
                    //  }
                    //  //si no se encuentra lanzamos un error 404.
                    //  abort(404);
                    //  });

                }
                
            
                \App\InspeccionDetalle::create([
                'Inspeccion_idInspeccion' => $id,
                'TipoInspeccionPregunta_idTipoInspeccionPregunta' => $request['TipoInspeccionPregunta_idTipoInspeccionPregunta'][$i],
                'situacionInspeccionDetalle' => $request['situacionInspeccionDetalle'][$i],
                'ubicacionInspeccionDetalle' => $request['ubicacionInspeccionDetalle'][$i],
                'accionMejoraInspeccionDetalle' => $request['accionMejoraInspeccionDetalle'][$i],
                'Tercero_idResponsable' => $request['Tercero_idResponsable'][$i],
                'fechaInspeccionDetalle' => $request['fechaInspeccionDetalle'][$i],
                'observacionInspeccionDetalle' => $request['observacionInspeccionDetalle'][$i],
                'fotoInspeccionDetalle' =>  $rutaImagen
               ]);

                
                // verificamos si tiene texto en el campos de accion de mejora, insertamos un registro en el ACPM (Accion Correctiva)
                if($request['accionMejoraInspeccionDetalle'][$i] != '' )
                {
                        //************************************************
                        //
                        //  R E P O R T E   A C C I O N E S   
                        //  C O R R E C T I V A S,  P R E V E N T I V A S 
                        //  Y   D E   M E J O R A 
                        //
                        //************************************************
                        // todos los accidentes o incidentes los  insertamos un registro en el ACPM (Accion Correctiva)

                        $this->guardarReporteACPM(
                                $fechaAccion = date("Y-m-d"), 
                                $idModulo = 24, 
                                $tipoAccion = 'Correctiva', 
                                $descripcionAccion = $request['accionMejoraInspeccionDetalle'][$i]
                                );   

                        
                }
            }

            
            return redirect('/inspeccion');
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

        \App\Inspeccion::destroy($id);
        return redirect('/inspeccion');
    }


    protected function guardarReporteACPM($fechaAccion, $idModulo, $tipoAccion, $descripcionAccion)
    {   

        $reporteACPM = \App\ReporteACPM::All()->last();
        
        $indice = array(
            'ReporteACPM_idReporteACPM' => $reporteACPM->idReporteACPM, 
            'fechaReporteACPMDetalle' => $fechaAccion,
            'Modulo_idModulo' => $idModulo,
            'tipoReporteACPMDetalle' => $tipoAccion,
            'descripcionReporteACPMDetalle' => $descripcionAccion);

        $data = array(
            'ReporteACPM_idReporteACPM' => $reporteACPM->idReporteACPM,
            'ordenReporteACPMDetalle' => 0,
            'fechaReporteACPMDetalle' => $fechaAccion,
            'Proceso_idProceso' => NULL,
            'Modulo_idModulo' => $idModulo,
            'tipoReporteACPMDetalle' => $tipoAccion,
            'descripcionReporteACPMDetalle' => $descripcionAccion,
            'analisisReporteACPMDetalle' => '',
            'correccionReporteACPMDetalle' => '',
            'Tercero_idResponsableCorrecion' => NULL,
            'planAccionReporteACPMDetalle' => '',
            'Tercero_idResponsablePlanAccion' => NULL,
            'fechaEstimadaCierreReporteACPMDetalle' => '0000-00-00',
            'estadoActualReporteACPMDetalle' => '',
            'fechaCierreReporteACPMDetalle' => '0000-00-00',
            'eficazReporteACPMDetalle' => 0);

        $respuesta = \App\ReporteACPMDetalle::updateOrCreate($indice, $data);
    }
}
