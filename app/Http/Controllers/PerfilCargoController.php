<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\PerfilCargoRequest;
use App\Http\Controllers\Controller;

include public_path().'/ajax/consultarPermisos.php';

class PerfilCargoController extends Controller
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
          return view('perfilcargogrid', compact('datos'));
         else
            return view('accesodenegado');
        
        // return view('perfilcargogrid');

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
    
         
        return view ('perfilcargo', compact('idModulo','nombreModulo'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PerfilCargoRequest $request)
    {
    
         \App\PerfilCargo::create([
            'tipoPerfilCargo' => $request['tipoPerfilCargo'],
            'nombrePerfilCargo' => $request['nombrePerfilCargo'],
            'observacionPerfilCargo' => $request['observacionPerfilCargo'],
            'Compania_idCompania' => \Session::get('idCompania')
            ]);

        return redirect('/perfilcargo');
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
        
        $perfilcargo = \App\PerfilCargo::find($id);
         $idModulo= \App\Modulo::All()->lists('idModulo');
         $nombreModulo= \App\Modulo::All()->lists('nombreModulo');

        return view ('perfilcargo',['perfilcargo'=>$perfilcargo], compact('idModulo','nombreModulo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PerfilCargoRequest $request, $id)
    {
        $perfilcargo = \App\PerfilCargo::find($id);
        $perfilcargo->fill($request->all());

        $perfilcargo->save();

        return redirect('perfilcargo');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        \App\PerfilCargo::destroy($id);
        return redirect('/perfilcargo');
    }
}
