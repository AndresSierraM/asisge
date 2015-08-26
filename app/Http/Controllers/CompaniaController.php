<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\CompaniaRequest;
use App\Http\Controllers\Controller;
use App\Http\Controllers\CompaniaObjetivo;

class CompaniaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('companiagrid');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('compania');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(CompaniaRequest $request)
    {
        \App\Compania::create([
            'codigoCompania' => $request['codigoCompania'],
            'nombreCompania' => $request['nombreCompania'],
            'misionCompania' => $request['misionCompania'],
            'visionCompania' => $request['visionCompania'],
            'valoresCompania' => $request['valoresCompania'],
            'politicasCompania' => $request['politicasCompania'],
            'principiosCompania' => $request['principiosCompania'],
            'metasCompania' => $request['metasCompania']
            ]);

        $compania = \App\Compania::All()->last();

        $contador = count($request['nombreCompaniaObjetivo']);

        for($i = 0; $i < $contador; $i++)
        {
            \App\CompaniaObjetivo::create([
            'Compania_idCompania' => $compania->idCompania,
            'nombreCompaniaObjetivo' => $request['nombreCompaniaObjetivo'][$i]
           ]);
        }

        return redirect('/compania');
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
        $compania = \App\Compania::find($id);
        
        return view('compania',['compania'=>$compania]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update($id,CompaniaRequest $request)
    {
        $compania = \App\Compania::find($id);
        
        $compania->fill($request->all());
        $compania->save();
        
        \App\CompaniaObjetivo::where('Compania_idCompania',$id)->delete();
        
        $contador = count($request['nombreCompaniaObjetivo']);

        for($i = 0; $i < $contador; $i++)
        {
            \App\CompaniaObjetivo::create([
            'Compania_idCompania' => $id,
            'nombreCompaniaObjetivo' => $request['nombreCompaniaObjetivo'][$i]
           ]);
        }
        
        return redirect('/compania');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    

    public function destroy($id)
    {
        \App\Compania::destroy($id);
        \App\CompaniaObjetivo::where('Compania_idCompania',$id)->delete();
        return redirect('/compania');
    }
}