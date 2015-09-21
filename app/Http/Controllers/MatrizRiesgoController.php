<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class MatrizRiesgoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    
    public function index()
    {
        return view('matrizriesgogrid');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $idProceso = \App\Proceso::All()->lists('idProceso');
        $nombreProceso = \App\Proceso::All()->lists('nombreProceso');
        $idClasificacionRiesgo = \App\ClasificacionRiesgo::All()->lists('idClasificacionRiesgo');
        $nombreClasificacionRiesgo = \App\ClasificacionRiesgo::All()->lists('nombreClasificacionRiesgo');
        $idListaGeneral = \App\ListaGeneral::All()->lists('idListaGeneral');
        $nombreListaGeneral = \App\ListaGeneral::All()->lists('nombreListaGeneral');

        return view('matrizriesgo',compact('idProceso','nombreProceso','idClasificacionRiesgo','nombreClasificacionRiesgo','idListaGeneral','nombreListaGeneral'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        /*$image = Input::file('imagenTercero');
        $imageName = $request->file('imagenTercero')->getClientOriginalName();
        $manager = new ImageManager();
        $manager->make($image->getRealPath())->heighten(56)->save('images/terceros/'. $imageName);*/

        \App\MatrizRiesgo::create([
            'nombreMatrizRiesgo' => $request['nombreMatrizRiesgo'],
            'fechaElaboracionMatrizRiesgo' => $request['fechaElaboracionMatrizRiesgo'],
            'Users_id' => 1
            ]);
        
        $matrizRiesgo = \App\MatrizRiesgo::All()->last();
        $contadorDetalle = count($request['Proceso_idProceso']);
        for($i = 0; $i < $contadorDetalle; $i++)
        {
            \App\MatrizRiesgoDetalle::create([
             'MatrizRiesgo_idMatrizRiesgo' => $matrizRiesgo->idMatrizRiesgo,
              'Proceso_idProceso' => $request['Proceso_idProceso'][$i],
              'rutinariaMatrizRiesgoDetalle' => $request['rutinariaMatrizRiesgoDetalle'][$i],
              'ClasificacionRiesgo_idClasificacionRiesgo' => $request['ClasificacionRiesgo_idClasificacionRiesgo'][$i],
              'TipoRiesgo_idTipoRiesgo' => $request['TipoRiesgo_idTipoRiesgo'][$i],
              'TipoRiesgoDetalle_idTipoRiesgoDetalle' => $request['TipoRiesgoDetalle_idTipoRiesgoDetalle'][$i],
              'TipoRiesgoSalud_idTipoRiesgoSalud' => $request['TipoRiesgoSalud_idTipoRiesgoSalud'][$i],
              'vinculadosMatrizRiesgoDetalle' => $request['vinculadosMatrizRiesgoDetalle'][$i],
              'temporalesMatrizRiesgoDetalle' => $request['temporalesMatrizRiesgoDetalle'][$i],
              'independientesMatrizRiesgoDetalle' => $request['independientesMatrizRiesgoDetalle'][$i],
              'totalExpuestosMatrizRiesgoDetalle' => $request['totalExpuestosMatrizRiesgoDetalle'][$i],
              'fuenteMatrizRiesgoDetalle' => $request['fuenteMatrizRiesgoDetalle'][$i],
              'medioMatrizRiesgoDetalle' => $request['medioMatrizRiesgoDetalle'][$i],
              'personaMatrizRiesgoDetalle' => $request['personaMatrizRiesgoDetalle'][$i],
              'nivelDeficienciaMatrizRiesgoDetalle' => $request['nivelDeficienciaMatrizRiesgoDetalle'][$i],
              'nivelExposicionMatrizRiesgoDetalle' => $request['nivelExposicionMatrizRiesgoDetalle'][$i],
              'nivelProbabilidadMatrizRiesgoDetalle' => $request['nivelProbabilidadMatrizRiesgoDetalle'][$i],
              'nombreProbabilidadMatrizRiesgoDetalle' => $request['nombreProbabilidadMatrizRiesgoDetalle'][$i],
              'nivelConsecuenciaMatrizRiesgoDetalle' => $request['nivelConsecuenciaMatrizRiesgoDetalle'][$i],
              'nivelRiesgoMatrizRiesgoDetalle' => $request['nivelRiesgoMatrizRiesgoDetalle'][$i],
              'nombreRiesgoMatrizRiesgoDetalle' => $request['nombreRiesgoMatrizRiesgoDetalle'][$i],
              'aceptacionRiesgoMatrizRiesgoDetalle' => $request['aceptacionRiesgoMatrizRiesgoDetalle'][$i],
              'ListaGeneral_idEliminacionRiesgo' => $request['ListaGeneral_idEliminacionRiesgo'][$i],
              'ListaGeneral_idSustitucionRiesgo' => $request['ListaGeneral_idSustitucionRiesgo'][$i],
              'ListaGeneral_idControlAdministrativo' => $request['ListaGeneral_idControlAdministrativo'][$i],
              'ListaGeneral_idElementoProteccion' => $request['ListaGeneral_idElementoProteccion'][$i],
              'imagenMatrizRiesgoDetalle' => $request['imagenMatrizRiesgoDetalle'][$i],
              'observacionMatrizRiesgoDetalle' => $request['observacionMatrizRiesgoDetalle'][$i]   
            ]);
        }
        
        return redirect('/matrizriesgo');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id, Request $request)
    {
        if(isset($request['clasificacionRiesgo']))
        {
            $idTipoRiesgo = \App\TipoRiesgo::where('ClasificacionRiesgo_idClasificacionRiesgo',$request['clasificacionRiesgo'])
                                            ->select('idTipoRiesgo')
                                            ->get();
            $nombreTipoRiesgo = \App\TipoRiesgo::where('ClasificacionRiesgo_idClasificacionRiesgo',$request['clasificacionRiesgo'])
                                            ->select('nombreTipoRiesgo')
                                            ->get();                                
        
            if($request->ajax())
            {
                return response()->json([
                    $idTipoRiesgo,
                    $nombreTipoRiesgo
                ]);
            }
        }

        if(isset($request['tipoRiesgo']))
        {
            $idTipoRiesgoSalud = \App\TipoRiesgoSalud::where('TipoRiesgo_idTipoRiesgo',$request['tipoRiesgo'])
                                        ->select('idTipoRiesgoSalud')
                                        ->get();

            $nombreTipoRiesgoSalud = \App\TipoRiesgoSalud::where('TipoRiesgo_idTipoRiesgo',$request['tipoRiesgo'])
                                        ->select('nombreTipoRiesgoSalud')
                                        ->get();                            

            $idTipoRiesgoDetalle = \App\TipoRiesgoDetalle::where('TipoRiesgo_idTipoRiesgo',$request['tipoRiesgo'])
                                        ->select('idTipoRiesgoDetalle')
                                        ->get();

            $nombreTipoRiesgoDetalle = \App\TipoRiesgoDetalle::where('TipoRiesgo_idTipoRiesgo',$request['tipoRiesgo'])
                                        ->select('nombreTipoRiesgoDetalle')
                                        ->get();                                                                                                             

            if($request->ajax())
            {
                return response()->json([
                    $idTipoRiesgoDetalle,
                    $nombreTipoRiesgoDetalle,
                    $idTipoRiesgoSalud,
                    $nombreTipoRiesgoSalud,
                ]);
            }                            
            

        }
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $idProceso = \App\Proceso::All()->lists('idProceso');
        $nombreProceso = \App\Proceso::All()->lists('nombreProceso');
        $idClasificacionRiesgo = \App\ClasificacionRiesgo::All()->lists('idClasificacionRiesgo');
        $nombreClasificacionRiesgo = \App\ClasificacionRiesgo::All()->lists('nombreClasificacionRiesgo');
        $idListaGeneral = \App\ListaGeneral::All()->lists('idListaGeneral');
        $nombreListaGeneral = \App\ListaGeneral::All()->lists('nombreListaGeneral');

        $matrizRiesgo = \App\MatrizRiesgo::find($id);
        return view('matrizriesgo',compact('idProceso','nombreProceso','idClasificacionRiesgo','nombreClasificacionRiesgo','idListaGeneral','nombreListaGeneral'),['matrizRiesgo'=>$matrizRiesgo]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $matrizRiesgo = \App\MatrizRiesgo::find($id);
        $matrizRiesgo->fill($request->all());

        /*if(null !== Input::file('imagenTercero') )
        {
            $image = Input::file('imagenTercero');
            $imageName = $request->file('imagenTercero')->getClientOriginalName();
            $manager = new ImageManager();
            $manager->make($image->getRealPath())->heighten(56)->save('images/terceros/'. $imageName);

            $tercero->imagenTercero = 'terceros\\'. $imageName;
        } */  

        $matrizRiesgo->save();

        \App\MatrizRiesgoDetalle::where('MatrizRiesgo_idMatrizRiesgo',$id)->delete();
        
        $contadorDetalle = count($request['Proceso_idProceso']);
        for($i = 0; $i < $contadorDetalle; $i++)
        {
            \App\MatrizRiesgoDetalle::create([
             'MatrizRiesgo_idMatrizRiesgo' => $id,
              'Proceso_idProceso' => $request['Proceso_idProceso'][$i],
              'rutinariaMatrizRiesgoDetalle' => $request['rutinariaMatrizRiesgoDetalle'][$i],
              'ClasificacionRiesgo_idClasificacionRiesgo' => $request['ClasificacionRiesgo_idClasificacionRiesgo'][$i],
              'TipoRiesgo_idTipoRiesgo' => $request['TipoRiesgo_idTipoRiesgo'][$i],
              'TipoRiesgoDetalle_idTipoRiesgoDetalle' => $request['TipoRiesgoDetalle_idTipoRiesgoDetalle'][$i],
              'TipoRiesgoSalud_idTipoRiesgoSalud' => $request['TipoRiesgoSalud_idTipoRiesgoSalud'][$i],
              'vinculadosMatrizRiesgoDetalle' => $request['vinculadosMatrizRiesgoDetalle'][$i],
              'temporalesMatrizRiesgoDetalle' => $request['temporalesMatrizRiesgoDetalle'][$i],
              'independientesMatrizRiesgoDetalle' => $request['independientesMatrizRiesgoDetalle'][$i],
              'totalExpuestosMatrizRiesgoDetalle' => $request['totalExpuestosMatrizRiesgoDetalle'][$i],
              'fuenteMatrizRiesgoDetalle' => $request['fuenteMatrizRiesgoDetalle'][$i],
              'medioMatrizRiesgoDetalle' => $request['medioMatrizRiesgoDetalle'][$i],
              'personaMatrizRiesgoDetalle' => $request['personaMatrizRiesgoDetalle'][$i],
              'nivelDeficienciaMatrizRiesgoDetalle' => $request['nivelDeficienciaMatrizRiesgoDetalle'][$i],
              'nivelExposicionMatrizRiesgoDetalle' => $request['nivelExposicionMatrizRiesgoDetalle'][$i],
              'nivelProbabilidadMatrizRiesgoDetalle' => $request['nivelProbabilidadMatrizRiesgoDetalle'][$i],
              'nombreProbabilidadMatrizRiesgoDetalle' => $request['nombreProbabilidadMatrizRiesgoDetalle'][$i],
              'nivelConsecuenciaMatrizRiesgoDetalle' => $request['nivelConsecuenciaMatrizRiesgoDetalle'][$i],
              'nivelRiesgoMatrizRiesgoDetalle' => $request['nivelRiesgoMatrizRiesgoDetalle'][$i],
              'nombreRiesgoMatrizRiesgoDetalle' => $request['nombreRiesgoMatrizRiesgoDetalle'][$i],
              'aceptacionRiesgoMatrizRiesgoDetalle' => $request['aceptacionRiesgoMatrizRiesgoDetalle'][$i],
              'ListaGeneral_idEliminacionRiesgo' => $request['ListaGeneral_idEliminacionRiesgo'][$i],
              'ListaGeneral_idSustitucionRiesgo' => $request['ListaGeneral_idSustitucionRiesgo'][$i],
              'ListaGeneral_idControlAdministrativo' => $request['ListaGeneral_idControlAdministrativo'][$i],
              'ListaGeneral_idElementoProteccion' => $request['ListaGeneral_idElementoProteccion'][$i],
              'imagenMatrizRiesgoDetalle' => AB,
              'observacionMatrizRiesgoDetalle' => $request['observacionMatrizRiesgoDetalle'][$i]   
            ]);
        }
        
        return redirect('/matrizriesgo');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        \App\MatrizRiesgo::destroy($id);
        return redirect('/matrizriesgo');
    }
}
