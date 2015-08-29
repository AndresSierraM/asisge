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

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('usersgrid');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $compania = \App\Compania::All()->lists('nombreCompania','idCompania');
        return view('users',compact('compania','selected'));
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
             'Compania_idCompania'=> $request['Compania_idCompania']
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
        $compania = \App\Compania::All()->lists('nombreCompania','idCompania');
        return view('users',compact('compania'),['usuario'=>$usuario]);
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
        $usuario->Compania_idCompania = 1;
        //$usuario->password = Hash::make($request['password']);
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
