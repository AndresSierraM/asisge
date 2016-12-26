<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
include public_path().'/ajax/consultarPermisos.php';

class EntrevistaController extends Controller
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
          return view('entrevistagrid', compact('datos'));
         else
            return view('accesodenegado');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $Ciudad = \App\Ciudad::All()->lists('nombreCiudad','idCiudad');
         $Tercero = \App\Tercero::where('Tercero_idEmpleadorContratista', "=", \Session::get('idTercero'))->lists('nombreCompletoTercero','idTercero'); 
        $cargo = \App\Cargo::where('Compania_idCompania', "=", \Session::get('idCompania'))->lists('nombreCargo','idCargo'); 


          return view('entrevista',compact('cargo','Tercero','Ciudad'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
          \App\Entrevista::create([
            'documentoAspiranteEntrevista' => $request['documentoAspiranteEntrevista'],
            'estadoEntrevista' => $request['estadoEntrevista'],
            'nombreAspiranteEntrevista' => $request['nombreAspiranteEntrevista'],
            'fechaEntrevista' => $request['fechaEntrevista'],
            'Tercero_idEntrevistador' => $request['Tercero_idEntrevistador'],
            'Cargo_idCargo' => $request['Cargo_idCargo'],
            'experienciaRequeridaEntrevista' => $request['experienciaRequeridaEntrevista']    
            ]);



     $Tercero = \App\Tercero::All()->last();
            
            //---------------------------------
            // guardamos las tablas de detalle
            //---------------------------------
            $this->grabarDetalle($Tercero->idTercero, $request);

        return redirect('/entrevista');
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

         $Ciudad = \App\Ciudad::All()->lists('nombreCiudad','idCiudad');;

         $entrevista = \App\Entrevista::find($id);
         $Tercero = \App\Tercero::where('Tercero_idEmpleadorContratista', "=", \Session::get('idTercero'))->lists('nombreCompletoTercero','idTercero'); 
          $cargo = \App\Cargo::where('Compania_idCompania', "=", \Session::get('idCompania'))->lists('nombreCargo','idCargo'); 

          return view('entrevista',compact('cargo','Tercero','Ciudad'),['entrevista'=>$entrevista]);

          
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
