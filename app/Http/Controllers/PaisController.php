<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class PaisController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $pais = \App\Pais::All();
        return view('paisindex',compact('pais'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('pais');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        \App\Pais::create([
            'codigoPais' => $request['codigoPais'],
            'nombrePais' => $request['nombrePais'],
            ]);

        return redirect('/pais');
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
        $pais = \App\Pais::find($id);
        return view('pais',['pais'=>$pais]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update($id,Request $request)
    {
        
        $pais = \App\Pais::find($id);
        $pais->fill($request->all());
        $pais->save();

        return redirect('/pais');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    

    public function destroy($id)
    {
        \App\Pais::destroy($id);
        return redirect('/pais');
    }
}
