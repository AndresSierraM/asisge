<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\UsuarioRequest;
use App\Http\Controllers\Controller;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $usuario = \App\Usuario::All();
        return view('usuariogrid',compact('usuario'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('usuario');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(UsuarioRequest $request)
    {
        \App\Usuario::create([
            'loginUsuario' => $request['loginUsuario'],
            'nombreUsuario' => $request['nombreUsuario'],
            'correoUsuario' => $request['correoUsuario'],
            'claveUsuario' => md5($request['claveUsuario']),
            ]);

        return redirect('/usuario');
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
        $usuario = \App\Usuario::find($id);
        return view('usuario',['usuario'=>$usuario]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update($id,UsuarioRequest $request)
    {
        
        $usuario = \App\Usuario::find($id);
        $usuario->fill($request->all());
        $usuario->claveUsuario = md5($request['claveUsuario']);
        $usuario->save();

        return redirect('/usuario');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    

    public function destroy($id)
    {
        \App\Usuario::destroy($id);
        return redirect('/usuario');
    }
}
