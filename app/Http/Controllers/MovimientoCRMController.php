<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\MovimientoCRMRequest;

use Illuminate\Routing\Route;
use DB;


class MovimientoCRMController extends Controller
{
    public function _construct(){
        $this->beforeFilter('@find',['only'=>['edit','update','destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function find(Route $route){
        $this->movimientocrm = \App\MovimientoCRM::find($route->getParameter('movimientocrm'));
        return $this->movimientocrm;
    }

    public function index()
    {
        return view('movimientocrmgrid');
    }


    //Funcion para subir archivos con dropzone
    public function uploadFiles(Request $request) 
    {
 
        $input = Input::all();
 
        $rules = array(
        );
 
        $validation = Validator::make($input, $rules);
 
        if ($validation->fails()) {
            return Response::make($validation->errors->first(), 400);
        }
        
        $destinationPath = public_path() . '/imagenes/repositorio/temporal'; //Guardo en la carpeta  temporal

        $extension = Input::file('file')->getClientOriginalExtension(); 
        $fileName = Input::file('file')->getClientOriginalName(); // nombre de archivo
        $upload_success = Input::file('file')->move($destinationPath, $fileName);
 
        if ($upload_success) {
            return Response::json('success', 200);
        } 
        else {
            return Response::json('error', 400);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $idDocumento = $_GET["idDocumentoCRM"];
        $documento = \App\DocumentoCRM::where('idDocumentoCRM','=',$idDocumento)->lists('GrupoEstado_idGrupoEstado');
        
        $solicitante = \App\Tercero::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('nombreCompletoTercero','idTercero');
        $supervisor = \App\Tercero::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('nombreCompletoTercero','idTercero');
        $asesor = \App\Tercero::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('nombreCompletoTercero','idTercero');
        $categoria = \App\CategoriaCRM::All()->lists('nombreCategoriaCRM','idCategoriaCRM');
        $lineanegocio = \App\LineaNegocio::All()->lists('nombreLineaNegocio','idLineaNegocio');
        $origen = \App\OrigenCRM::All()->lists('nombreOrigenCRM','idOrigenCRM');
        $estado = \App\EstadoCRM::where('GrupoEstado_idGrupoEstado','=',$documento[0])->lists('nombreEstadoCRM','idEstadoCRM');
        $acuerdoservicio = \App\AcuerdoServicio::All()->lists('nombreAcuerdoServicio','idAcuerdoServicio');
        $evento = \App\EventoCRM::All()->lists('nombreEventoCRM','idEventoCRM');

       return view('movimientocrm',compact('solicitante','supervisor','asesor','categoria','documento','lineanegocio','origen','estado','acuerdoservicio', 'evento'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(MovimientoCRMRequest $request)
    {

        \App\MovimientoCRM::create([
            'numeroMovimientoCRM' => $request['numeroMovimientoCRM'],
            'asuntoMovimientoCRM' => $request['asuntoMovimientoCRM'],
            'fechaSolicitudMovimientoCRM' => $request['fechaSolicitudMovimientoCRM'],
            'fechaEstimadaSolucionMovimientoCRM' => $request['fechaEstimadaSolucionMovimientoCRM'],
            'fechaVencimientoMovimientoCRM' => $request['fechaVencimientoMovimientoCRM'],
            'fechaRealSolucionMovimientoCRM' => $request['fechaRealSolucionMovimientoCRM'],
            'prioridadMovimientoCRM' => $request['prioridadMovimientoCRM'],
            'diasEstimadosSolucionMovimientoCRM' => $request['diasEstimadosSolucionMovimientoCRM'],
            'diasRealesSolucionMovimientoCRM' => $request['diasRealesSolucionMovimientoCRM'],
            'valorMovimientoCRM' => $request['valorMovimientoCRM'],
            'Tercero_idSolicitante' => $request['Tercero_idSolicitante'],
            'Tercero_idSupervisor' => $request['Tercero_idSupervisor'],
            'Tercero_idAsesor' => $request['Tercero_idAsesor'],
            'CategoriaCRM_idCategoriaCRM' => $request['CategoriaCRM_idCategoriaCRM'],
            'DocumentoCRM_idDocumentoCRM' => $request['DocumentoCRM_idDocumentoCRM'],
            'LineaNegocio_idLineaNegocio' => $request['LineaNegocio_idLineaNegocio'],
            'OrigenCRM_idOrigenCRM' => $request['OrigenCRM_idOrigenCRM'],
            'EstadoCRM_idEstadoCRM' => $request['EstadoCRM_idEstadoCRM'],
            'AcuerdoServicio_idAcuerdoServicio' => $request['AcuerdoServicio_idAcuerdoServicio']
            ]);

        $movimientocrm = \App\MovimientoCRM::All()->last();

        $this->grabarDetalle($movimientocrm->idMovimientoCRM, $request);

        $arrayImage = $request['archivoMovimientoCRMArray'];
        $arrayImage = substr($arrayImage, 0, strlen($arrayImage)-1);
        $arrayImage = explode(",", $arrayImage);
        $ruta = '';
        for ($i=0; $i <count($arrayImage) ; $i++) 
        { 
            if ($arrayImage[$i] != '' || $arrayImage[$i] != 0) 
            {
                $origen = public_path() . '/imagenes/repositorio/temporal/'.$arrayImage[$i];
                $destinationPath = public_path() . '/imagenes/movimientocrm/'.$arrayImage[$i];
                $ruta = '/movimientocrm/'.$arrayImage[$i];
               
                if (file_exists($origen))
                {
                    copy($origen, $destinationPath);
                    unlink($origen);
                }   
                else
                {
                    echo "No existe el archivo";
                }
            }

            \App\MovimientoCRMArchivo::create([
            'MovimientoCRM_idMovimientoCRM' => $movimientocrm->idMovimientoCRM,
            'rutaMovimientoCRMArchivo' => $ruta
           ]);
        }

        return redirect('/movimientocrm?idDocumentoCRM='.$request['DocumentoCRM_idDocumentoCRM']);
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
        $movimientocrm = \App\MovimientoCRM::find($id);

        $idDocumento = $_GET["idDocumentoCRM"];
        $documento = \App\DocumentoCRM::where('idDocumentoCRM','=',$idDocumento)->lists('GrupoEstado_idGrupoEstado');
        
        $solicitante = \App\Tercero::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('nombreCompletoTercero','idTercero');
        $supervisor = \App\Tercero::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('nombreCompletoTercero','idTercero');
        $asesor = \App\Tercero::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('nombreCompletoTercero','idTercero');
        $categoria = \App\CategoriaCRM::All()->lists('nombreCategoriaCRM','idCategoriaCRM');
        $lineanegocio = \App\LineaNegocio::All()->lists('nombreLineaNegocio','idLineaNegocio');
        $origen = \App\OrigenCRM::All()->lists('nombreOrigenCRM','idOrigenCRM');
        $estado = \App\EstadoCRM::where('GrupoEstado_idGrupoEstado','=',$documento[0])->lists('nombreEstadoCRM','idEstadoCRM');
        $acuerdoservicio = \App\AcuerdoServicio::All()->lists('nombreAcuerdoServicio','idAcuerdoServicio');
        $evento = \App\EventoCRM::All()->lists('nombreEventoCRM','idEventoCRM');

       return view('movimientocrm',compact('solicitante','supervisor','asesor','categoria','documento','lineanegocio','origen','estado','acuerdoservicio', 'evento'),['movimientocrm'=>$movimientocrm]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(MovimientoCRMRequest $request, $id)
    {
        $movimientocrm = \App\MovimientoCRM::find($id);
        $movimientocrm->fill($request->all());
        $movimientocrm->save();

        $this->grabarDetalle($id, $request);
        // HAGO UN INSERT A LOS NUEVOS ARCHIVOS SUBIDOS EN EL DROPZONE
        if ($request['archivoMovimientoCRMArray'] != '') 
        {
            $arrayImage = $request['archivoMovimientoCRMArray'];
            $arrayImage = substr($arrayImage, 0, strlen($arrayImage)-1);
            $arrayImage = explode(",", $arrayImage);
            $ruta = '';

            for($i = 0; $i < count($arrayImage); $i++)
            {
                if ($arrayImage[$i] != '' || $arrayImage[$i] != 0) 
                {
                    $origen = public_path() . '/imagenes/repositorio/temporal/'.$arrayImage[$i];
                    $destinationPath = public_path() . '/imagenes/movimientocrm/'.$arrayImage[$i];
                    
                    if (file_exists($origen))
                    {
                        copy($origen, $destinationPath);
                        unlink($origen);
                        $ruta = '/movimientocrm/'.$arrayImage[$i];

                        DB::table('movimientocrmarchivo')->insert([
                            'idMovimientoCRMArchivo' => '0', 
                            'MovimientoCRM_idMovimientoCRM' =>$id,
                            'rutaMovimientoCRMArchivo' => $ruta]);
                    }   
                    else
                    {
                        echo "No existe el archivo";
                    }
                }
            }
        }

        // ELIMINO LOS ARCHIVOS
        $idsEliminar = $request['eliminarArchivo'];
        $idsEliminar = substr($idsEliminar, 0, strlen($idsEliminar)-1);
        if($idsEliminar != '')
        {
            $idsEliminar = explode(',',$idsEliminar);
            \App\MovimientoCRMArchivo::whereIn('MovimientoCRM_idMovimientoCRM',$idsEliminar)->delete();
        }

        return redirect('/movimientocrm?idDocumentoCRM='.$request['DocumentoCRM_idDocumentoCRM']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        \App\MovimientoCRM::destroy($id);
        return redirect('/movimientocrm');
    }

    public function grabarDetalle($id, $request)
    {
        $contadorAsistente = count($request['nombreMovimientoCRMAsistente']);
        for($i = 0; $i < $contadorAsistente; $i++)
        {

            $indice = array(
                'idMovimientoCRMAsistente' => $request['idMovimientoCRMAsistente'][$i]);

            $data = array(
                'MovimientoCRM_idMovimientoCRM' => $id,
            'nombreMovimientoCRMAsistente' => $request['nombreMovimientoCRMAsistente'][$i],
            'cargoMovimientoCRMAsistente' => $request['cargoMovimientoCRMAsistente'][$i],
            'telefonoMovimientoCRMAsistente' => $request['telefonoMovimientoCRMAsistente'][$i],
            'correoElectronicoMovimientoCRMAsistente' => $request['correoElectronicoMovimientoCRMAsistente'][$i]);

            $respuesta = \App\MovimientoCRMAsistente::updateOrCreate($indice, $data);

        }
    }
}
