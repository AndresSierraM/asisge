<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ExamenMedico;
use App\Http\Requests;
use App\Http\Requests\ExamenMedicoRequest;
use App\Http\Controllers\Controller;
use DB;
include public_path().'/ajax/consultarPermisos.php';
include public_path().'/ajax/guardarReporteAcpm.php';
use Validator;
use Input;
use File;
// include composer autoload
// require '../vendor/autoload.php';
// import the Intervention Image Manager Class
use Intervention\Image\ImageManager ;

class ExamenMedicoController extends Controller
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
            return view('examenmedicogrid', compact('datos'));
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

        $idTipoExamenMedico = \App\TipoExamenMedico::All()->lists('idTipoExamenMedico');
        $nombreTipoExamenMedico = \App\TipoExamenMedico::All()->lists('nombreTipoExamenMedico');

        $tercero = \App\Tercero::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('nombreCompletoTercero','idTercero');


        return view('examenmedico',compact('idTipoExamenMedico','nombreTipoExamenMedico','tercero'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(ExamenMedicoRequest $request)
    {
        if($request['respuesta'] != 'falso')
        {
            \App\ExamenMedico::create([
                'Tercero_idTercero' => $request['Tercero_idTercero'],
                'fechaExamenMedico' => $request['fechaExamenMedico'],
                'tipoExamenMedico' => $request['tipoExamenMedico'],
                'Compania_idCompania' => \Session::get('idCompania')
                ]); 

            $examenmedico = \App\ExamenMedico::All()->last();

            $this->grabarDetalle($request, $examenmedico->idExamenMedico);
            return redirect('/examenmedico');
            
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
        

        // si recibe el tipo de examen medico (no el id sino la lista que indica si es de ingreso, retiro o periodico)
        // entonces devolvemos una consulta de los nombres de examenes medicos que coninciden con dicha información
        if(isset($request['consulta']))
        {
            $cargo = DB::table('tercero')
                    ->leftJoin('cargo', 'tercero.Cargo_idCargo', '=', 'cargo.idCargo')
                    ->select(DB::raw('idCargo, nombreCargo'))
                    ->where('tercero.idTercero','=',$request["idTercero"])
                    ->get();
            if($request['consulta'] == 'Examen')
            {
                
                $examenmedicotercero = DB::table('terceroexamenmedico')
                    ->leftJoin('tipoexamenmedico', 'terceroexamenmedico.TipoExamenMedico_idTipoExamenMedico', '=', 'tipoexamenmedico.idTipoExamenMedico')
                    ->select(DB::raw('idTipoExamenMedico as TipoExamenMedico_idTipoExamenMedico, nombreTipoExamenMedico, "" as resultadoExamenMedicoDetalle, "" as observacionExamenMedicoDetalle'))
                    ->orderBy('nombreTipoExamenMedico', 'ASC')
                    ->where('terceroexamenmedico.Tercero_idTercero','=',$request["idTercero"])
                    ->where('terceroexamenmedico.'.$request["tipoExamenMedico"].'TerceroExamenMedico','=',1)
                    ->get();

                $examenmedicocargo = DB::table('cargoexamenmedico')
                    ->leftJoin('tipoexamenmedico', 'cargoexamenmedico.TipoExamenMedico_idTipoExamenMedico', '=', 'tipoexamenmedico.idTipoExamenMedico')
                    ->select(DB::raw('idTipoExamenMedico as TipoExamenMedico_idTipoExamenMedico, nombreTipoExamenMedico, "" as resultadoExamenMedicoDetalle, "" as observacionExamenMedicoDetalle'))
                    ->orderBy('nombreTipoExamenMedico', 'ASC')
                    ->where('cargoexamenmedico.Cargo_idCargo','=',$request["idCargo"])
                    ->where('cargoexamenmedico.'.$request["tipoExamenMedico"].'CargoExamenMedico','=',1)
                    ->get();

                if($request->ajax())
                {
                    return response()->json([$examenmedicotercero, $examenmedicocargo, $cargo]);
                }
            }
            else
            {
                if($request->ajax())
                {
                    return response()->json([$cargo]);
                }
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

        $idTipoExamenMedico = \App\TipoExamenMedico::All()->lists('idTipoExamenMedico');
        $nombreTipoExamenMedico = \App\TipoExamenMedico::All()->lists('nombreTipoExamenMedico');

        $tercero = \App\Tercero::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('nombreCompletoTercero','idTercero');

        $examenmedico = \App\ExamenMedico::find($id);
        $examenesmedicos = DB::table('examenmedicodetalle')
            ->leftJoin('tipoexamenmedico', 'examenmedicodetalle.TipoExamenMedico_idTipoExamenMedico', '=', 'tipoexamenmedico.idTipoExamenMedico')
            ->select(DB::raw('idExamenMedicoDetalle, TipoExamenMedico_idTipoExamenMedico, nombreTipoExamenMedico, limiteInferiorTipoExamenMedico, limiteSuperiorTipoExamenMedico, resultadoExamenMedicoDetalle, fotoExamenMedicoDetalle, observacionExamenMedicoDetalle'))
            ->orderBy('nombreTipoExamenMedico', 'ASC')
            ->where('ExamenMedico_idExamenMedico','=',$id)
            ->get();

       return view('examenmedico',compact('idTipoExamenMedico','nombreTipoExamenMedico','tercero'),['examenesmedicos'=>$examenesmedicos, 'examenmedico' => $examenmedico]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update($id, ExamenMedicoRequest $request)
    {
        if($request['respuesta'] != 'falso')
        {
            $examenmedico = \App\ExamenMedico::find($id);
            $examenmedico->fill($request->all());
            $examenmedico->save();

            
            $this->grabarDetalle($request, $id);
            return redirect('/examenmedico');
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

        \App\ExamenMedico::destroy($id);
        return redirect('/examenmedico');
    }

    public function grabarDetalle($request, $id)
    {
        $files = Input::file('archivoExamenMedicoDetalle');

        $contadorDetalle = count($request['TipoExamenMedico_idTipoExamenMedico']);
        for($i = 0; $i < $contadorDetalle; $i++)
        {

            $indice = array(
                'idExamenMedicoDetalle' => $request['idExamenMedicoDetalle'][$i]);

            $data = array(
               'ExamenMedico_idExamenMedico' => $id,
                'TipoExamenMedico_idTipoExamenMedico' => $request['TipoExamenMedico_idTipoExamenMedico'][$i],
                'resultadoExamenMedicoDetalle' => $request['resultadoExamenMedicoDetalle'][$i],
                'observacionExamenMedicoDetalle' => $request['observacionExamenMedicoDetalle'][$i]
                );


            $file = $files[$i] ;
            $rutaImagen = '';
            $destinationPath = '/examenmedico/';
            if(isset($file))
            {
                // $byte = filesize($file);

                // $kb = $byte/1024;

                // if ($kb >= '2.5') 
                // {
                //     echo "<script type='text/javascript'>alert('El archivo supera el tamaño maximo permitido.');</script>";
                // }
                // else
                // {
                //     echo "<script type='text/javascript'>alert('Guardar archivo.');</script>";
                    $filename = $destinationPath . $file->getClientOriginalName();
                     
                //     $manager = new ImageManager();
                //     $manager->make($file->getRealPath())->save($filename);
                    \Storage::disk('local')->put($filename, \File::get($file));
                    $rutaImagen = 'examenmedico/'.$file->getClientOriginalName();

                    
                    $data['fotoExamenMedicoDetalle'] =  $rutaImagen;
                // }
                // print_r($file);
                // $validacion = Validator::make($request->all(), [
                //         'archivoExamenMedicoDetalle' => 'max:2560',//indicamos el valor maximo
                // ]);

                // if ($validacion->fails()) 
                // {
                //     return ('Supera el tamaño máximo permitido.'); 
                // } 
                // else 
                // {
                //     $manager = new ImageManager();
                //     $manager->make($file->getRealPath())->save($filename);
                //     \Storage::disk('local')->put($filename, \File::get($file));
                //     $rutaImagen = 'examenmedico/'.$file->getClientOriginalName();

                    
                //     $data['fotoExamenMedicoDetalle'] =  $rutaImagen;
                // }
            }
            else
            {
                $rutaImagen = $request['fotoExamenMedicoDetalle'][$i];
            }
            
        
            $respuesta = \App\ExamenMedicoDetalle::updateOrCreate($indice, $data);
            
            
            // verificamos si NO es APTO, insertamos un registro en el ACPM (Accion Correctiva)
            if($request['resultadoExamenMedicoDetalle'][$i] == 'No Apto')
            {


                    //Consultamos el nombre del tercero empleado
                    $nombreTercero = \App\Tercero::find($request['Tercero_idTercero']);

                    //COnsultamos el nombre del tercero empleado
                    $nombreTercero = \App\Tercero::find($request['Tercero_idTercero']);

                    //************************************************
                    //
                    //  R E P O R T E   A C C I O N E S   
                    //  C O R R E C T I V A S,  P R E V E N T I V A S 
                    //  Y   D E   M E J O R A 
                    //
                    //************************************************
                    // todos los accidentes o incidentes los  insertamos un registro en el ACPM (Accion Correctiva)

                    //COnsultamos el nombre del tercero empleado
                    $nombreTercero = \App\Tercero::find($request['Tercero_idTercero']);

                    guardarReporteACPM(
                            $fechaAccion = date("Y-m-d"), 
                            $idModulo = 22, 
                            $tipoAccion = 'Correctiva', 
                            $descripcionAccion = 'El Examen Medico '.$request['nombreTipoExamenMedico'][$i].' de '.$nombreTercero->nombreCompletoTercero.', no esta dentro de los limites (Resultado '.$request['resultadoExamenMedicoDetalle'][$i].' Rango de '. $request['limiteInferiorTipoExamenMedico'][$i].' a '.$request['limiteSuperiorTipoExamenMedico'][$i].')'
                            );   

                    
            }
        }

    }

}
