<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

 use App\Http\Requests\ActoInseguroRequest;
use App\Http\Controllers\Controller;
use DB;
include public_path().'/ajax/consultarPermisos.php';
include public_path().'/ajax/guardarReporteAcpm.php';

class ActoInseguroController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $vista = basename($_SERVER["PHP_SELF"]);
       $datos = consultarPermisos($vista);

         if($datos != null)
        //  cambiar por grid 
          return view('actoinsegurogrid', compact('datos'));
         else
            return view('accesodenegado');
    }


    /**
     * Show the form for creating a new resource.
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
    public function create()
    {
        $TerceroReporta = \App\Tercero::where('tipoTercero', "like", "%*01*%")->where('Compania_idCompania', "=", \Session::get('idCompania'))->lists('nombreCompletoTercero','idTercero');
        $TerceroSoluciona = \App\Tercero::where('tipoTercero', "like", "%*01*%")->where('Compania_idCompania', "=", \Session::get('idCompania'))->lists('nombreCompletoTercero','idTercero');
    

          return view('/actoinseguro',compact('TerceroReporta','TerceroSoluciona'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ActoInseguroRequest $request)
    {
         \App\ActoInseguro::create([
                'Tercero_idEmpleadoReporta' => ($request['Tercero_idEmpleadoReporta'] == '' ? NULL : $request['Tercero_idEmpleadoReporta']),
                'fechaElaboracionActoInseguro' => $request['fechaElaboracionActoInseguro'],
                'descripcionActoInseguro' => $request['descripcionActoInseguro'],
                'consecuenciasActoInseguro' => $request['consecuenciasActoInseguro'],
                'estadoActoInseguro' => $request['estadoActoInseguro'],
                'fechaSolucionActoInseguro' => $request['fechaSolucionActoInseguro'],
                'Tercero_idEmpleadoSoluciona' => ($request['Tercero_idEmpleadoSoluciona'] == '' ? NULL : $request['Tercero_idEmpleadoSoluciona'])
                ]);

         $actoinseguro = \App\ActoInseguro::All()->last();


            // Guardado del dropzone
                $arrayImage = $request['archivoActoInseguroArray'];
                $arrayImage = substr($arrayImage, 0, strlen($arrayImage)-1);
                $arrayImage = explode(",", $arrayImage);
                $ruta = '';
                for ($i=0; $i < count($arrayImage) ; $i++) 
                { 
                    if ($arrayImage[$i] != '' || $arrayImage[$i] != 0) 
                    {
                        $origen = public_path() . '/imagenes/repositorio/temporal/'.$arrayImage[$i];
                        $destinationPath = public_path() . '/imagenes/actoinseguro/'.$arrayImage[$i];
                        $ruta = '/actoinseguro/'.$arrayImage[$i];
                       
                        if (file_exists($origen))
                        {
                            copy($origen, $destinationPath);
                            unlink($origen);
                        }   
                        else
                        {
                            echo "No existe el archivo";
                        }
                        \App\ActoInseguroArchivo::create([
                        'ActoInseguro_idActoInseguro' => $actoinseguro->idActoInseguro,
                        'rutaActoInseguroArchivo' => $ruta
                       ]);
                    }

                }


             // verificamos si es un plan de acción, insertamos un registro en el ACPM (Accion Correctiva)
            if($request['estadoActoInseguro'] == 'PLANACCION')
            {

                    //************************************************
                    //
                    //  R E P O R T E   A C C I O N E S   
                    //  C O R R E C T I V A S,  P R E V E N T I V A S 
                    //  Y   D E   M E J O R A 
                    //
                    //************************************************
                    // todos los accidentes o incidentes los  insertamos un registro en el ACPM (Accion Correctiva)

                    //COnsultamos el nombre del tercero empleado
                    $nombreTercero = \App\Tercero::find($request['Tercero_idEmpleadoSoluciona']);

                    guardarReporteACPM(
                            $fechaAccion = $request['fechaElaboracionActoInseguro'], 
                            $idModulo = 44, //acá me queda la duda, creo que hay que crear un nuevo módulo 
                            $tipoAccion = 'Correctiva', 
                            $descripcionAccion = $request['descripcionActoInseguro']
                            );   

                    
            }
               
         return redirect('/actoinseguro'); 
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {   
        $actoinseguro = \App\ActoInseguro::find($id);
        $TerceroReporta = \App\Tercero::where('tipoTercero', "like", "%*01*%")->where('Compania_idCompania', "=", \Session::get('idCompania'))->lists('nombreCompletoTercero','idTercero');
        $TerceroSoluciona = \App\Tercero::where('tipoTercero', "like", "%*01*%")->where('Compania_idCompania', "=", \Session::get('idCompania'))->lists('nombreCompletoTercero','idTercero');

          return view('actoinseguro',compact('TerceroReporta','TerceroSoluciona'),['actoinseguro'=>$actoinseguro]);
  
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ActoInseguroRequest $request, $id)
    {
        $actoinseguro = \App\ActoInseguro::find($id);
        $actoinseguro->fill($request->all());
        $actoinseguro->Tercero_idEmpleadoReporta = ($request['Tercero_idEmpleadoReporta'] == '' ? NULL : $request['Tercero_idEmpleadoReporta']);
        $actoinseguro->Tercero_idEmpleadoSoluciona = ($request['Tercero_idEmpleadoSoluciona'] == '' ? NULL : $request['Tercero_idEmpleadoSoluciona']);
        $actoinseguro->save();




          //Para sobreescribir  el archivo 
            // HAGO UN INSERT A LOS NUEVOS ARCHIVOS SUBIDOS EN EL DROPZONE
            if ($request['archivoActoInseguroArray'] != '') 
            {
                $arrayImage = $request['archivoActoInseguroArray'];
                $arrayImage = substr($arrayImage, 0, strlen($arrayImage)-1);
                $arrayImage = explode(",", $arrayImage);
                $ruta = '';

                for($i = 0; $i < count($arrayImage); $i++)
                {
                    if ($arrayImage[$i] != '' || $arrayImage[$i] != 0) 
                    {
                        $origen = public_path() . '/imagenes/repositorio/temporal/'.$arrayImage[$i];
                        $destinationPath = public_path() . '/imagenes/actoinseguro/'.$arrayImage[$i];
                        
                        if (file_exists($origen))
                        {
                            copy($origen, $destinationPath);
                            unlink($origen);
                            $ruta = '/actoinseguro/'.$arrayImage[$i];

                            DB::table('actoinseguroarchivo')->insert(['idActoInseguroArchivo' => '0', 'ActoInseguro_idActoInseguro' =>$id,'rutaActoInseguroArchivo' => $ruta]);
                        }   
                        else
                        {
                            echo "No existe el archivo";
                        }
                    }
                }
            }

            // verificamos si es un plan de acción, insertamos un registro en el ACPM (Accion Correctiva)
            if($request['estadoActoInseguro'] == 'PLANACCION')
            {

                    //************************************************
                    //
                    //  R E P O R T E   A C C I O N E S   
                    //  C O R R E C T I V A S,  P R E V E N T I V A S 
                    //  Y   D E   M E J O R A 
                    //
                    //************************************************
                    // todos los accidentes o incidentes los  insertamos un registro en el ACPM (Accion Correctiva)

                    //COnsultamos el nombre del tercero empleado
                    $nombreTercero = \App\Tercero::find($request['Tercero_idEmpleadoSoluciona']);

                    guardarReporteACPM(
                            $fechaAccion = $request['fechaElaboracionActoInseguro'], 
                            $idModulo = 44, //acá me queda la duda, creo que hay que crear un nuevo módulo 
                            $tipoAccion = 'Correctiva', 
                            $descripcionAccion = $request['descripcionActoInseguro']
                            );   

                    
            }
        
        return redirect('actoinseguro');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         \App\ActoInseguro::destroy($id);
        return redirect('/actoinseguro');
    }
}

