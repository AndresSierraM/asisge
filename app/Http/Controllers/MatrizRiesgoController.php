<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\MatrizRiesgoRequest;
use App\Http\Controllers\Controller;
use DB;
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
        $frecuenciaMedicion = \App\frecuenciaMedicion::All()->lists('nombreFrecuenciaMedicion','idFrecuenciaMedicion');
        $idProceso = \App\Proceso::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('idProceso');
        $nombreProceso = \App\Proceso::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('nombreProceso');
        $idClasificacionRiesgo = \App\ClasificacionRiesgo::All()->lists('idClasificacionRiesgo');
        $nombreClasificacionRiesgo = \App\ClasificacionRiesgo::All()->lists('nombreClasificacionRiesgo');
        
        // lista de Eliminacion del riesgo (EliminacionRiesgo)
        $idEliminacionRiesgo = \App\ListaGeneral::where('tipoListaGeneral','EliminacionRiesgo')->lists('idListaGeneral');
        $nombreEliminacionRiesgo = \App\ListaGeneral::where('tipoListaGeneral','EliminacionRiesgo')->lists('nombreListaGeneral');

        // lista de Sustitucion del riesgo (SustitucionRiesgo)
        $idSustitucionRiesgo = \App\ListaGeneral::where('tipoListaGeneral','SustitucionRiesgo')->lists('idListaGeneral');
        $nombreSustitucionRiesgo = \App\ListaGeneral::where('tipoListaGeneral','SustitucionRiesgo')->lists('nombreListaGeneral');

        // lista de Control del riesgo (ControlRiesgo)
        $idControlRiesgo = \App\ListaGeneral::where('tipoListaGeneral','ControlRiesgo')->lists('idListaGeneral');
        $nombreControlRiesgo = \App\ListaGeneral::where('tipoListaGeneral','ControlRiesgo')->lists('nombreListaGeneral');

        $idElementoProteccion = \App\ElementoProteccion::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('idElementoProteccion');
        $nombreElementoProteccion = \App\ElementoProteccion::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('nombreElementoProteccion');

        return view('matrizriesgo',compact('idProceso','nombreProceso','idClasificacionRiesgo','nombreClasificacionRiesgo','idListaGeneral','nombreListaGeneral', 'idEliminacionRiesgo', 'nombreEliminacionRiesgo' , 'idSustitucionRiesgo', 'nombreSustitucionRiesgo' , 'idControlRiesgo', 'nombreControlRiesgo', 'idElementoProteccion', 'nombreElementoProteccion','frecuenciaMedicion'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(MatrizRiesgoRequest $request)
    {
        /*$image = Input::file('imagenTercero');
        $imageName = $request->file('imagenTercero')->getClientOriginalName();
        $manager = new ImageManager();
        $manager->make($image->getRealPath())->heighten(56)->save('images/terceros/'. $imageName);*/

        if($request['respuesta'] != 'falso')
        {  

          \App\MatrizRiesgo::create([
              'nombreMatrizRiesgo' => $request['nombreMatrizRiesgo'],
              'fechaElaboracionMatrizRiesgo' => $request['fechaElaboracionMatrizRiesgo'],
              'FrecuenciaMedicion_idFrecuenciaMedicion' => $request['FrecuenciaMedicion_idFrecuenciaMedicion'],
              'fechaActualizacionMatrizRiesgo' => date("Y-m-d"),
              'Compania_idCompania' => \Session::get('idCompania'),
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
                'ElementoProteccion_idElementoProteccion' => $request['ElementoProteccion_idElementoProteccion'][$i],
                'imagenMatrizRiesgoDetalle' => $request['imagenMatrizRiesgoDetalle'][$i],
                'observacionMatrizRiesgoDetalle' => $request['observacionMatrizRiesgoDetalle'][$i]   
              ]);
          }
        
          return redirect('/matrizriesgo');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id, Request $request)
    {
        if(isset($request['accion']) and $request['accion'] == 'imprimir')
        {

          $matrizRiesgo = \App\MatrizRiesgo::find($id);
          
          $matrizRiesgoDetalle = DB::table('matrizriesgodetalle as mrd')
            ->leftJoin('proceso as p', 'mrd.Proceso_idProceso', '=', 'p.idProceso')
            ->leftJoin('clasificacionriesgo as cr', 'mrd.ClasificacionRiesgo_idClasificacionRiesgo', '=', 'cr.idClasificacionRiesgo')
            ->leftJoin('tiporiesgo as tr', 'mrd.TipoRiesgo_idTipoRiesgo', '=', 'tr.idTipoRiesgo')
            ->leftJoin('tiporiesgodetalle as trd', 'mrd.TipoRiesgoDetalle_idTipoRiesgoDetalle', '=', 'trd.idTipoRiesgoDetalle')
            ->leftJoin('tiporiesgosalud as trs', 'mrd.TipoRiesgoSalud_idTipoRiesgoSalud', '=', 'trs.idTipoRiesgoSalud')
            ->leftJoin('listageneral as lse', 'mrd.ListaGeneral_idEliminacionRiesgo', '=', 'lse.idListaGeneral')
            ->leftJoin('listageneral as lss', 'mrd.ListaGeneral_idSustitucionRiesgo', '=', 'lss.idListaGeneral')
            ->leftJoin('listageneral as lsc', 'mrd.ListaGeneral_idControlAdministrativo', '=', 'lsc.idListaGeneral')
            ->leftJoin('elementoproteccion as epp', 'mrd.ElementoProteccion_idElementoProteccion', '=', 'epp.idElementoProteccion')
            ->select(DB::raw('mrd.idMatrizRiesgoDetalle, mrd.MatrizRiesgo_idMatrizRiesgo, mrd.Proceso_idProceso, p.nombreProceso, mrd.rutinariaMatrizRiesgoDetalle, mrd.ClasificacionRiesgo_idClasificacionRiesgo, cr.nombreClasificacionRiesgo, mrd.TipoRiesgo_idTipoRiesgo, tr.nombreTipoRiesgo, mrd.TipoRiesgoDetalle_idTipoRiesgoDetalle, trd.nombreTipoRiesgoDetalle, mrd.TipoRiesgoSalud_idTipoRiesgoSalud, trs.nombreTipoRiesgoSalud, mrd.vinculadosMatrizRiesgoDetalle, mrd.temporalesMatrizRiesgoDetalle, mrd.independientesMatrizRiesgoDetalle, mrd.totalExpuestosMatrizRiesgoDetalle, mrd.fuenteMatrizRiesgoDetalle, mrd.medioMatrizRiesgoDetalle, mrd.personaMatrizRiesgoDetalle, mrd.nivelDeficienciaMatrizRiesgoDetalle, mrd.nivelExposicionMatrizRiesgoDetalle, mrd.nivelProbabilidadMatrizRiesgoDetalle, mrd.nombreProbabilidadMatrizRiesgoDetalle, mrd.nivelConsecuenciaMatrizRiesgoDetalle, mrd.nivelRiesgoMatrizRiesgoDetalle, mrd.nombreRiesgoMatrizRiesgoDetalle, mrd.aceptacionRiesgoMatrizRiesgoDetalle, mrd.ListaGeneral_idEliminacionRiesgo, lse.nombreListaGeneral as nombreEliminacionRiesgo, mrd.ListaGeneral_idSustitucionRiesgo, lss.nombreListaGeneral as nombreSustitucionRiesgo, mrd.ListaGeneral_idControlAdministrativo, lsc.nombreListaGeneral as nombreControlAdministrativo, mrd.ElementoProteccion_idElementoProteccion, epp.nombreElementoProteccion, mrd.imagenMatrizRiesgoDetalle, mrd.observacionMatrizRiesgoDetalle'))
            ->orderBy('idMatrizRiesgoDetalle', 'ASC')
            ->where('MatrizRiesgo_idMatrizRiesgo','=',$id)
            ->get();

            
            return view('formatos.matrizriesgoimpresion',['matrizRiesgo'=>$matrizRiesgo], compact('matrizRiesgoDetalle'));
        }

        if(isset($request['clasificacionRiesgo']))
        {

            $ids = \App\MatrizRiesgoDetalle::where('idMatrizRiesgoDetalle',$id)
                                        ->select('TipoRiesgo_idTipoRiesgo')
                                        ->get();

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
                    $nombreTipoRiesgo,
                    $ids
                ]);
            }
        }

        if(isset($request['tipoRiesgo']))
        {
            $ids = \App\MatrizRiesgoDetalle::where('idMatrizRiesgoDetalle',$id)
                                        ->select('TipoRiesgoDetalle_idTipoRiesgoDetalle','TipoRiesgoSalud_idTipoRiesgoSalud')
                                        ->get();
            
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
                    $ids
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
        $frecuenciaMedicion = \App\frecuenciaMedicion::All()->lists('nombreFrecuenciaMedicion','idFrecuenciaMedicion');
        $idProceso = \App\Proceso::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('idProceso');
        $nombreProceso = \App\Proceso::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('nombreProceso');
        $idClasificacionRiesgo = \App\ClasificacionRiesgo::All()->lists('idClasificacionRiesgo');
        $nombreClasificacionRiesgo = \App\ClasificacionRiesgo::All()->lists('nombreClasificacionRiesgo');

        // lista de Eliminacion del riesgo (EliminacionRiesgo)
        $idEliminacionRiesgo = \App\ListaGeneral::where('tipoListaGeneral','EliminacionRiesgo')->lists('idListaGeneral');
        $nombreEliminacionRiesgo = \App\ListaGeneral::where('tipoListaGeneral','EliminacionRiesgo')->lists('nombreListaGeneral');

        // lista de Sustitucion del riesgo (SustitucionRiesgo)
        $idSustitucionRiesgo = \App\ListaGeneral::where('tipoListaGeneral','SustitucionRiesgo')->lists('idListaGeneral');
        $nombreSustitucionRiesgo = \App\ListaGeneral::where('tipoListaGeneral','SustitucionRiesgo')->lists('nombreListaGeneral');

        // lista de Control del riesgo (ControlRiesgo)
        $idControlRiesgo = \App\ListaGeneral::where('tipoListaGeneral','ControlRiesgo')->lists('idListaGeneral');
        $nombreControlRiesgo = \App\ListaGeneral::where('tipoListaGeneral','ControlRiesgo')->lists('nombreListaGeneral');

        $idElementoProteccion = \App\ElementoProteccion::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('idElementoProteccion');
        $nombreElementoProteccion = \App\ElementoProteccion::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('nombreElementoProteccion');

        $matrizRiesgo = \App\MatrizRiesgo::find($id);
        return view('matrizriesgo',compact('idProceso','nombreProceso','idClasificacionRiesgo','nombreClasificacionRiesgo','idListaGeneral','nombreListaGeneral', 'idEliminacionRiesgo', 'nombreEliminacionRiesgo' , 'idSustitucionRiesgo', 'nombreSustitucionRiesgo' , 'idControlRiesgo', 'nombreControlRiesgo', 'idElementoProteccion', 'nombreElementoProteccion', 'frecuenciaMedicion'),['matrizRiesgo'=>$matrizRiesgo]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(MatrizRiesgoRequest $request, $id)
    {


        if($request['respuesta'] != 'falso')
        {
          $matrizRiesgo = \App\MatrizRiesgo::find($id);
          $matrizRiesgo->fill($request->all());
          $matrizRiesgo->fechaActualizacionMatrizRiesgo = date("Y-m-d");


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
                'ElementoProteccion_idElementoProteccion' => $request['ElementoProteccion_idElementoProteccion'][$i],
                'imagenMatrizRiesgoDetalle' => '',
                'observacionMatrizRiesgoDetalle' => $request['observacionMatrizRiesgoDetalle'][$i]   
              ]);
          }
          
          return redirect('/matrizriesgo');
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
        \App\MatrizRiesgo::destroy($id);
        return redirect('/matrizriesgo');
    }
}
