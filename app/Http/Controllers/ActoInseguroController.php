<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// use App\Http\Requests\EntrevistaRequest;
use App\Http\Controllers\Controller;
use DB;
include public_path().'/ajax/consultarPermisos.php';

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
    public function store(Request $request)
    {
        
         \App\ActoInseguro::create([
                'Tercero_idEmpleadoReporta' => $request['Tercero_idEmpleadoReporta'],
                'fechaElaboracionActoInseguro' => $request['fechaElaboracionActoInseguro'],
                'descripcionActoInseguro' => $request['descripcionActoInseguro'],
                'consecuenciasActoInseguro' => $request['consecuenciasActoInseguro'],
                'estadoActoInseguro' => $request['estadoActoInseguro'],
                'fechaSolucionActoInseguro' => $request['fechaSolucionActoInseguro'],
                'Tercero_idEmpleadoSoluciona' => $request ['Tercero_idEmpleadoSoluciona']
                ]);

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
    public function update(Request $request, $id)
    {
        $actoinseguro = \App\ActoInseguro::find($id);
        $actoinseguro->fill($request->all());
        $actoinseguro->TerceroReporta = ($request['Tercero_idAspirante'] == '' ? NULL : $request['Tercero_idAspirante']);
        $actoinseguro->TerceroSoluciona = ($request['Encuesta_idEncuesta'] == '' ? NULL : $request['Encuesta_idEncuesta']);
        $actoinseguro->save();
        
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

