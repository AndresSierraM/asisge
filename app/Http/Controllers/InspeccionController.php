<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Inspeccion;
use App\Http\Requests;
use App\Http\Requests\InspeccionRequest;
use App\Http\Controllers\Controller;
use DB;
include public_path().'/ajax/consultarPermisos.php';
include public_path().'/ajax/guardarReporteAcpm.php';

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

        if($datos != null)
            return view('inspecciongrid', compact('datos'));
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
            if (isset($request['firmabase64']) and $request['firmabase64'] != '') 
            {
                $data = $request['firmabase64'];

                list($type, $data) = explode(';', $data);
                list(, $data)      = explode(',', $data);
                $data = base64_decode($data);

                file_put_contents('imagenes/'.$ruta, $data);
            }

            //----------------------------
            $this->grabarDetalle($request, $inspeccion->idInspeccion);

           //  $contadorDetalle = count($request['TipoInspeccionPregunta_idTipoInspeccionPregunta']);
           //  for($i = 0; $i < $contadorDetalle; $i++)
           //  {
           //      \App\InspeccionDetalle::create([
           //      'Inspeccion_idInspeccion' => $inspeccion->idInspeccion,
           //      'TipoInspeccionPregunta_idTipoInspeccionPregunta' => $request['TipoInspeccionPregunta_idTipoInspeccionPregunta'][$i],
           //      'situacionInspeccionDetalle' => $request['situacionInspeccionDetalle'][$i],
           //      'fotoInspeccionDetalle' => $request['fotoInspeccionDetalle'][$i],
           //      'ubicacionInspeccionDetalle' => $request['ubicacionInspeccionDetalle'][$i],
           //      'accionMejoraInspeccionDetalle' => $request['accionMejoraInspeccionDetalle'][$i],
           //      'Tercero_idResponsable' => ($request['Tercero_idResponsable'][$i] == '' || $request['Tercero_idResponsable'][$i] == 0) ? null : $request['Tercero_idResponsable'][$i],
           //      'fechaInspeccionDetalle' => $request['fechaInspeccionDetalle'][$i],
           //      'observacionInspeccionDetalle' => $request['observacionInspeccionDetalle'][$i]
           //     ]);


           //      // verificamos si tiene texto en el campos de accion de mejora, insertamos un registro en el ACPM (Accion Correctiva)
           //      if($request['accionMejoraInspeccionDetalle'][$i] != '' )
           //      {
           //              //************************************************
           //              //
           //              //  R E P O R T E   A C C I O N E S   
           //              //  C O R R E C T I V A S,  P R E V E N T I V A S 
           //              //  Y   D E   M E J O R A 
           //              //
           //              //************************************************
           //              // todos los accidentes o incidentes los  insertamos un registro en el ACPM (Accion Correctiva)

           //              guardarReporteACPM(
           //                      $fechaAccion = date("Y-m-d"), 
           //                      $idModulo = 24, 
           //                      $tipoAccion = 'Correctiva', 
           //                      $descripcionAccion = $request['accionMejoraInspeccionDetalle'][$i]
           //                      );   
           //      }
                
           //  }

            return redirect('/inspeccion');
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

          $inspeccion = DB::Select('SELECT nombreTipoInspeccion, nombreCompletoTercero, firmaRealizadaPorInspeccion, fechaElaboracionInspeccion, observacionesInspeccion from inspeccion i left join tipoinspeccion ti on ti.idTipoInspeccion = i.TipoInspeccion_idTipoInspeccion left join tercero t on t.idTercero = i.Tercero_idRealizadaPor where idInspeccion = '.$id.' and i.Compania_idCompania = '.\Session::get('idCompania'));

          $inspeccionResumen = DB::select('select contenidoTipoInspeccionPregunta, situacionInspeccionDetalle, fotoInspeccionDetalle, ubicacionInspeccionDetalle,   accionMejoraInspeccionDetalle, nombreCompletoTercero, fechaInspeccionDetalle, observacionInspeccionDetalle from inspecciondetalle ipd left join tipoinspeccionpregunta tip on tip.idTipoInspeccionPregunta = ipd.TipoInspeccionPregunta_idTipoInspeccionPregunta left join tercero t on t.idTercero = ipd.Tercero_idResponsable where Inspeccion_idInspeccion = '.$id);

            return view('formatos.inspeccionimpresion',['inspeccion'=>$inspeccion], compact('inspeccion','inspeccionResumen'));
        }

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
            ->select(DB::raw('idInspeccionDetalle,TipoInspeccionPregunta_idTipoInspeccionPregunta, numeroTipoInspeccionPregunta, contenidoTipoInspeccionPregunta, 
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
            $this->grabarDetalle($request, $id);
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

    public function grabarDetalle($request, $id)
    {
        //\App\InspeccionDetalle::where('Inspeccion_idInspeccion',$id)->delete();
            $files = Input::file('archivoInspeccionDetalle');

            $contadorDetalle = count($request['TipoInspeccionPregunta_idTipoInspeccionPregunta']);
            for($i = 0; $i < $contadorDetalle; $i++)
            {

                $indice = array(
                    'idInspeccionDetalle' => $request['idInspeccionDetalle'][$i]);

                $data = array(
                    'Inspeccion_idInspeccion' => $id,
                    'TipoInspeccionPregunta_idTipoInspeccionPregunta' => $request['TipoInspeccionPregunta_idTipoInspeccionPregunta'][$i],
                    'situacionInspeccionDetalle' => $request['situacionInspeccionDetalle'][$i],
                    'ubicacionInspeccionDetalle' => $request['ubicacionInspeccionDetalle'][$i],
                    'accionMejoraInspeccionDetalle' => $request['accionMejoraInspeccionDetalle'][$i],
                    'Tercero_idResponsable' => ($request['Tercero_idResponsable'][$i] == '' || $request['Tercero_idResponsable'][$i] == 0) ? null : $request['Tercero_idResponsable'][$i],
                    'fechaInspeccionDetalle' => $request['fechaInspeccionDetalle'][$i],
                    'observacionInspeccionDetalle' => $request['observacionInspeccionDetalle'][$i]
                    );


                $file = $files[$i] ;
                $rutaImagen = '';
                $destinationPath = 'imagenes/inspeccion/';
                if(isset($file))
                {
                    $filename = $destinationPath .$id.'_'.$i.'_'. $file->getClientOriginalName();
                     
                    $manager = new ImageManager();
                    $manager->make($file->getRealPath())->save($filename);
                    $rutaImagen = 'inspeccion/'.$id.'_'.$i.'_'.$file->getClientOriginalName();

                    
                    $data['fotoInspeccionDetalle'] =  $rutaImagen;

                }
                else
                {
                    $rutaImagen = $request['fotoInspeccionDetalle'][$i];
                }
                
            
                $respuesta = \App\InspeccionDetalle::updateOrCreate($indice, $data);
                
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

                        guardarReporteACPM(
                                $fechaAccion = date("Y-m-d"), 
                                $idModulo = 24, 
                                $tipoAccion = 'Correctiva', 
                                $descripcionAccion = $request['accionMejoraInspeccionDetalle'][$i]
                                );   

                        
                }
            }

    }

}
