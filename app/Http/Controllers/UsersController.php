<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\UsersRequest;
use App\Http\Controllers\Controller;
use App\Http\Controllers\CompaniaController;
// Indicamos que usamos el Modelo User.
use App\User;
// Hash de contraseñas.
use Hash;
 
// Redireccionamientos.
use Redirect;
use DB;
include public_path().'/ajax/consultarPermisos.php';

class UsersController extends Controller
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
            return view('usersgrid', compact('datos'));
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
        // $compania = \App\Compania::All()->lists('nombreCompania','idCompania');
        $rol = \App\Rol::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('nombreRol','idRol');
        $tercero = \App\Tercero::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('nombreCompletoTercero','idTercero');
        return view('users',compact('compania','selected','rol', 'tercero'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(UsersRequest $request)
    {
        \App\User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => $request['password'],
            'Compania_idCompania'=> \Session::get('idCompania'),
            'Rol_idRol' => $request['Rol_idRol'],
            'Tercero_idTercero' => ($request['Tercero_idTercero'] == 0 ? null : $request['Tercero_idTercero'])
            ]);
        
        return redirect('/users');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $usuario = \App\User::find($id);
        // $compania = \App\Compania::All()->lists('nombreCompania','idCompania');
        $rol = \App\Rol::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('nombreRol','idRol');
        $tercero = \App\Tercero::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('nombreCompletoTercero','idTercero');
        return view('users',compact('compania', 'rol','tercero'),['usuario'=>$usuario]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update($id,UsersRequest $request)
    {
        
        $usuario = \App\User::find($id);
        $usuario->fill($request->all());

        $usuario->Tercero_idTercero = ($request['Tercero_idTercero'] == 0 ? null : $request['Tercero_idTercero']);

        $usuario->save();

        return redirect('/users');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    

    public function destroy($id)
    {
        \App\User::destroy($id);
        return redirect('/users');
    }
}
