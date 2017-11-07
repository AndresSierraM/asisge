<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// use App\Http\Requests\Request;
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
    public function store(Request $request)
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
         
            return view('formatos.planemergenciaimpresion',compact('PlanEmergenciaEncabezado','PlanEmergenciaLimie','PlanEmergenciaIventario','PlanEmergenciaNivel','PlanEmergenciaArchivo'));
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



        return view('manualgestion',compact('tercero'),['manualgestion'=>$manualgestion]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
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
