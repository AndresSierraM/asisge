<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// use App\Http\Requests\PerfilCargoRequest;
use App\Http\Controllers\Controller;
use Carbon;
use DB;

include public_path().'/ajax/consultarPermisos.php';

class EntrevistaResultadoController extends Controller
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
          return view('EntrevistaResultadogrid', compact('datos'));
         else
            return view('accesodenegado');
        
        // return view('EntrevistaResultadogrid');

     }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       
       $idModulo= \App\Modulo::All()->lists('idModulo');
       $nombreModulo= \App\Modulo::All()->lists('nombreModulo');

        $cargo = \App\Cargo::where('Compania_idCompania', "=", \Session::get('idCompania'))->lists('nombreCargo','idCargo');

       $tercero = \App\Tercero::where('tipoTercero', "like", "%*01*%")->where('Compania_idCompania', "=", \Session::get('idCompania'))->lists('nombreCompletoTercero','idTercero');


         
        return view ('entrevistaresultado', compact('idModulo','nombreModulo','cargo','tercero'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(isset($request['idEntrevista']))
        {
            for ($i=0; $i < count($request['idEntrevista']); $i++) 
            { 
                
              $indice = array(
                'idEntrevista' => $request['idEntrevista'][$i]);

                $data = array(
                    'Cargo_idCargo' => $request['Cargo_idCargo'],
                    'Tercero_idEntrevistador' => $request['Tercero_idEntrevistador'],
                    'TipoIdentificacion_idTipoIdentificacion' => $request['TipoIdentificacion_idTipoIdentificacion'][$i],
                    'observacionEntrevista' => $request['observacionInformeEntrevista'][$i],
                    'estadoEntrevista' => $request['seleccionInformeEntrevista'][$i]);
             
                $Entrevista = \App\Entrevista::updateOrCreate($indice, $data);
            }
        }


            $fechahora = Carbon\Carbon::now();

             \App\EntrevistaResultado::create([
                'Cargo_idCargo' => $request['Cargo_idCargo'],
                'fechaInicialEntrevistaResultado' => $request['fechaInicialEntrevistaResultado'],
                'fechaFinalEntrevistaResultado' => $request['fechaFinalEntrevistaResultado'],
                'Tercero_idEntrevistador' => $request['Tercero_idEntrevistador'],
                'estadoEntrevistaResultado' => $request['estadoEntrevistaResultado'],
                'fechaElaboracionEntrevistaResultado' => $fechahora,
                'Users_idCrea'=> \Session::get("idUsuario"),
                'Compania_idCompania' => \Session::get('idCompania')
                
                
                ]);
 
    
      

          return redirect('/entrevistaresultado');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if($_GET['accion'] == 'imprimir')
        {
            $entrevistaresultado = \App\EntrevistaResultado::find($id);

            $consulta = DB::Select('
            SELECT idEntrevista,e.Cargo_idCargo,e.Tercero_idEntrevistador,fechaEntrevista,c.porcentajeEducacionCargo,c.porcentajeExperienciaCargo,c.porcentajeFormacionCargo,c.porcentajeResponsabilidadCargo,c.porcentajeHabilidadCargo,Competencia_idCompetencia,nombre1AspiranteEntrevista,nombre2AspiranteEntrevista,apellido1AspiranteEntrevista,apellido2AspiranteEntrevista,t.nombreCompletoTercero,e.calificacionEducacionEntrevista,e.calificacionFormacionEntrevista,e.calificacionHabilidadCargoEntrevista,e.calificacionHabilidadActitudinalEntrevista,e.experienciaAspiranteEntrevista,e.experienciaRequeridaEntrevista,e.estadoEntrevista,e.TipoIdentificacion_idTipoIdentificacion,e.observacionEntrevista
            FROM entrevista e
            Left Join cargo c
            On e.Cargo_idCargo = c.idCargo
            left join cargocompetencia cc
            On cc.Cargo_idCargo = c.idCargo
            left join tercero t
            On e.Tercero_idEntrevistador = t.idTercero 
            WHERE e.Cargo_idCargo = '.$entrevistaresultado->Cargo_idCargo.' and  Tercero_idEntrevistador = '.$entrevistaresultado->Tercero_idEntrevistador.'  and  fechaEntrevista >= "'.$entrevistaresultado->fechaInicialEntrevistaResultado.'" and  fechaEntrevista <= "'.$entrevistaresultado->fechaFinalEntrevistaResultado.'"');





            return view('formatos.entrevistaresultadoimpresion',compact('consulta'));
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

         $entrevistaresultado = \App\EntrevistaResultado::find($id);
        $cargo = \App\Cargo::where('Compania_idCompania', "=", \Session::get('idCompania'))->lists('nombreCargo','idCargo');

       $tercero = \App\Tercero::where('tipoTercero', "like", "%*01*%")->where('Compania_idCompania', "=", \Session::get('idCompania'))->lists('nombreCompletoTercero','idTercero');
        
         $idModulo= \App\Modulo::All()->lists('idModulo');
         $nombreModulo= \App\Modulo::All()->lists('nombreModulo');
         

        return view ('entrevistaresultado',['entrevistaresultado'=>$entrevistaresultado], compact('idModulo','nombreModulo','cargo','tercero'));
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
        $fechahora = Carbon\Carbon::now();
         $entrevistaresultado = \App\EntrevistaResultado::find($id);
         $entrevistaresultado->fill($request->all());

         $entrevistaresultado->save();
        return redirect('entrevistaresultado');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         \App\EntrevistaResultado::destroy($id);
        return redirect('/entrevistaresultado');
    }
}
