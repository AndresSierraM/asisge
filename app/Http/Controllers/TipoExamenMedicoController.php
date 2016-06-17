<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\TipoExamenMedicoRequest;
use App\Http\Controllers\Controller;

class TipoExamenMedicoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('tipoexamenmedicogrid');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('tipoexamenmedico');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(TipoExamenMedicoRequest $request)
    {
        \App\TipoExamenMedico::create([
            'codigoTipoExamenMedico' => $request['codigoTipoExamenMedico'],
            'nombreTipoExamenMedico' => $request['nombreTipoExamenMedico'],
            'limiteInferiorTipoExamenMedico' => $request['limiteInferiorTipoExamenMedico'],
            'limiteSuperiorTipoExamenMedico' => $request['limiteSuperiorTipoExamenMedico'],
            'observacionTipoExamenMedico' => $request['observacionTipoExamenMedico']

            ]);

        return redirect('/tipoexamenmedico');
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
        $tipoexamenmedico = \App\TipoExamenMedico::find($id);
        return view('tipoexamenmedico',['tipoexamenmedico'=>$tipoexamenmedico]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update($id,TipoExamenMedicoRequest $request)
    {
        
        $tipoexamenmedico = \App\TipoExamenMedico::find($id);
        $tipoexamenmedico->fill($request->all());
        $tipoexamenmedico->save();

        return redirect('/tipoexamenmedico');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    

    public function destroy($id)
    {
        \App\TipoExamenMedico::destroy($id);
        return redirect('/tipoexamenmedico');
    }
}
