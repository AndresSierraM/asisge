<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// use App\Http\Requests\PerfilCargoRequest;
use App\Http\Controllers\Controller;
use Carbon;

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
        
        $fechahora = Carbon\Carbon::now();

         \App\EntrevistaResultado::create([
            'Cargo_idCargo' => $request['Cargo_idCargo'],
            'fechaInicialEntrevistaResultado' => $request['fechaInicialEntrevistaResultado'],
            'fechaFinalEntrevistaResultado' => $request['fechaFinalEntrevistaResultado'],
            'Tercero_idEntrevistador' => $request['Tercero_idEntrevistador'],
            'fechaElaboracionEntrevistaResultado' => $fechahora,
            'Users_idCrea'=> \Session::get("idUsuario"),
            'Compania_idCompania' => \Session::get('idCompania')
            
            
            ]);

      

        // return redirect('/entrevistaresultado');
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
