<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\CategoriaAgendaRequest;
use App\Http\Controllers\Controller;
use DB;
include public_path().'/ajax/consultarPermisos.php';

class CategoriaAgendaController extends Controller
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
            return view('categoriaagendagrid', compact('datos'));
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
        return view('categoriaagenda');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        \App\CategoriaAgenda::create([
            'codigoCategoriaAgenda' => $request['codigoCategoriaAgenda'],
            'nombreCategoriaAgenda' => $request['nombreCategoriaAgenda'],
            'colorCategoriaAgenda' => $request['colorCategoriaAgenda']
        ]);

        $categoriaagenda = \App\CategoriaAgenda::All()->last();

        //---------------------------------
        // guardamos las tablas de detalle
        //---------------------------------
        $this->grabarDetalle($categoriaagenda->idCategoriaAgenda, $request);

        return redirect('/categoriaagenda');
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
        $categoriaagenda = \App\CategoriaAgenda::find($id);
        return view('categoriaagenda',['categoriaagenda'=>$categoriaagenda]);
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
        $categoriaagenda = \App\CategoriaAgenda::find($id);
        
        $categoriaagenda->fill($request->all());
        $categoriaagenda->save();
        //---------------------------------
        // guardamos las tablas de detalle
        //---------------------------------
        $this->grabarDetalle($categoriaagenda->idCategoriaAgenda, $request);
        
        return redirect('/categoriaagenda');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        \App\CategoriaAgenda::destroy($id);
        return redirect('/categoriaagenda');
    }

    protected function grabarDetalle($id, $request)
    {

        // en el formulario hay un campo oculto en el que almacenamos los id que se eliminan separados por coma
        // en este proceso lo convertimos en array y eliminamos dichos id de la tabla de detalle
        $idsEliminar = explode(',', $request['eliminarCategoriaAgenda']);
        \App\CategoriaAgendaCampo::whereIn('idCategoriaAgendaCampo',$idsEliminar)->delete();

        $contador = count($request['idCategoriaAgendaCampo']);

        for($i = 0; $i < $contador; $i++)
        {

            $indice = array(
             'idCategoriaAgendaCampo' => $request['idCategoriaAgendaCampo'][$i]);

            $data = array(
            'CategoriaAgenda_idCategoriaAgenda' => $id,
            'CampoCRM_idCampoCRM' => $request['CampoCRM_idCampoCRM'][$i],
            'obligatorioCategoriaAgendaCampo' => $request['obligatorioCategoriaAgendaCampo'][$i]);

             $preguntas = \App\CategoriaAgendaCampo::updateOrCreate($indice, $data);

        }
    }
}
