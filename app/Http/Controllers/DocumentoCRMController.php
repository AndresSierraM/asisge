<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\DocumentoCRMRequest;
use App\Http\Controllers\Controller;
use App\Http\Controllers\DocumentoCRMCampo;

class DocumentoCRMController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('documentocrmgrid');
    }


    public function indexCampoCRMGrid()
    {
        return view('campocrmgridselect'); 
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('documentocrm');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(DocumentoCRMRequest $request)
    {
        \App\DocumentoCRM::create([
            'codigoDocumentoCRM' => $request['codigoDocumentoCRM'], 
            'nombreDocumentoCRM' => $request['nombreDocumentoCRM'], 
            'tipoDocumentoCRM' => $request['tipoDocumentoCRM'], 
            'numeracionDocumentoCRM' => $request['numeracionDocumentoCRM'], 
            'longitudDocumentoCRM' => $request['longitudDocumentoCRM'], 
            'desdeDocumentoCRM' => $request['desdeDocumentoCRM'], 
            'hastaDocumentoCRM' => $request['hastaDocumentoCRM'], 
            'actualDocumentoCRM' => $request['desdeDocumentoCRM']-1, 
            'Compania_idCompania' => \Session::get("idCompania"), 
            'GrupoEstado_idGrupoEstado' => $request['GrupoEstado_idGrupoEstado']
            ]);

        $documentocrm = \App\DocumentoCRM::All()->last();

        //---------------------------------
        // guardamos las tablas de detalle
        //---------------------------------
        $this->grabarDetalle($documentocrm->idDocumentoCRM, $request);

        return redirect('/documentocrm');
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
        $documentocrm = \App\DocumentoCRM::find($id);
        
        return view('documentocrm',['documentocrm'=>$documentocrm]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update($id,DocumentoCRMRequest $request)
    {
        $documentocrm = \App\DocumentoCRM::find($id);
        
        $documentocrm->fill($request->all());
        $documentocrm->save();
        
        //---------------------------------
        // guardamos las tablas de detalle
        //---------------------------------
        $this->grabarDetalle($documentocrm->idDocumentoCRM, $request);
        
        return redirect('/documentocrm');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    

    public function destroy($id)
    {
        \App\DocumentoCRM::destroy($id);
        return redirect('/documentocrm');
    }

    protected function grabarDetalle($id, $request)
    {

        // en el formulario hay un campo oculto en el que almacenamos los id que se eliminan separados por coma
        // en este proceso lo convertimos en array y eliminamos dichos id de la tabla de detalle
        $idsEliminar = explode(',', $request['eliminarCampo']);
        \App\DocumentoCRMCampo::whereIn('idDocumentoCRMCampo',$idsEliminar)->delete();

        $contador = count($request['idDocumentoCRMCampo']);

        for($i = 0; $i < $contador; $i++)
        {

            $indice = array(
             'idDocumentoCRMCampo' => $request['idDocumentoCRMCampo'][$i]);

            $data = array(
             'DocumentoCRM_idDocumentoCRM' => $id,
            'CampoCRM_idCampoCRM' => $request['CampoCRM_idCampoCRM'][$i],
            'mostrarGridDocumentoCRMCampo' => $request['mostrarGridDocumentoCRMCampo'][$i],
            'mostrarVistaDocumentoCRMCampo' => $request['mostrarVistaDocumentoCRMCampo'][$i],
            'obligatorioDocumentoCRMCampo' => $request['obligatorioDocumentoCRMCampo'][$i] );

             $preguntas = \App\DocumentoCRMCampo::updateOrCreate($indice, $data);

        }


        // // en el formulario hay un campo oculto en el que almacenamos los id que se eliminan separados por coma
        // // en este proceso lo convertimos en array y eliminamos dichos id de la tabla de detalle
        // $idsEliminar = explode(',', $request['eliminarCompania']);
        // \App\DocumentoCRMCompania::whereIn('idDocumentoCRMCompania',$idsEliminar)->delete();

        // $contador = count($request['idDocumentoCRMCompania']);

        // for($i = 0; $i < $contador; $i++)
        // {

        //     $indice = array(
        //      'idDocumentoCRMCompania' => $request['idDocumentoCRMCompania'][$i]);

        //     $data = array(
        //      'DocumentoCRM_idDocumentoCRM' => $id,
        //     'Compania_idCompania' => $request['Compania_idCompania'][$i] );

        //     $preguntas = \App\DocumentoCRMCompania::updateOrCreate($indice, $data);

        // }

        // // en el formulario hay un campo oculto en el que almacenamos los id que se eliminan separados por coma
        // // en este proceso lo convertimos en array y eliminamos dichos id de la tabla de detalle
        // $idsEliminar = explode(',', $request['eliminarRol']);
        // \App\DocumentoCRMRol::whereIn('idDocumentoCRMRol',$idsEliminar)->delete();

        // $contador = count($request['idDocumentoCRMRol']);

        // for($i = 0; $i < $contador; $i++)
        // {

        //     $indice = array(
        //      'idDocumentoCRMRol' => $request['idDocumentoCRMRol'][$i]);

        //     $data = array(
        //     'DocumentoCRM_idDocumentoCRM' => $id,
        //     'Rol_idRol' => $request['Rol_idRol'][$i],
        //     'adicionarDocumentoCRMRol' => $request['adicionarDocumentoCRMRol'][$i],
        //     'modificarDocumentoCRMRol' => $request['modificarDocumentoCRMRol'][$i],
        //     'eliminarDocumentoCRMRol' => $request['eliminarDocumentoCRMRol'][$i],
        //     'consultarDocumentoCRMRol' => $request['consultarDocumentoCRMRol'][$i]);
        //     $preguntas = \App\DocumentoCRMRol::updateOrCreate($indice, $data);

        // }

    }
}
