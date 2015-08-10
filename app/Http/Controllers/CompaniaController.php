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
        $compania = \App\Compania::All();
        return view('companiagrid',compact('compania'));
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
        $companiaObjetivo = \App\CompaniaObjetivo::select('idCompaniaObjetivo','nombreCompaniaObjetivo')
                                                    ->where('Compania_idCompania',$id)
                                                    ->get();

        return view('compania',['compania'=>$compania],compact('companiaObjetivo'));
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
        echo $compania.' ---- ';
        $compania->fill($request->all());
        echo $compania.' ??? ';
        //$compania->save();

        $companiaObjetivo = \App\CompaniaObjetivo::select('idCompaniaObjetivo','nombreCompaniaObjetivo')
                                                    ->where('Compania_idCompania',$id)
                                                    ->get();
        echo $companiaObjetivo.' ---- ';
        $contador = count($request['nombreCompaniaObjetivo']);
        //return redirect('/compania');
        for($i = 0; $i < $contador; $i++)
        {
            echo $request['nombreCompaniaObjetivo'][$i].' ----- campos';
            
        }
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
        return redirect('/compania');
    }
}
