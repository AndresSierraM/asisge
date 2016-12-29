<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\MovimientoCRMRequest;

use Illuminate\Routing\Route;
use DB;
include public_path().'/ajax/consultarPermisosCRM.php';



class MovimientoCRMController extends Controller
{
    public function indexMovimientocrmVacantegridselect()
    {
        return view('MovimientocrmVacantegridselect');
        
    }


    public function index()
    {
        $idDocumento = $_GET["idDocumentoCRM"];
        
        $vista = basename($_SERVER["PHP_SELF"]);
        $datos = consultarPermisosCRM($idDocumento);
        
        $supervisor = \App\Tercero::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('nombreCompletoTercero','idTercero');
        $asesor = \App\Tercero::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('nombreCompletoTercero','idTercero');
        $acuerdoservicio = \App\AcuerdoServicio::All()->lists('nombreAcuerdoServicio','idAcuerdoServicio');
        if($datos != null)
            return view('movimientocrmgrid', compact('datos','supervisor','asesor','acuerdoservicio'));
        else
            return view('movimientocrmgrid', compact('supervisor','asesor','acuerdoservicio'));
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
        
        $categoria = \App\CategoriaCRM::All()->lists('nombreCategoriaCRM','idCategoriaCRM');
        $lineanegocio = \App\LineaNegocio::All()->lists('nombreLineaNegocio','idLineaNegocio');
        $origen = \App\OrigenCRM::All()->lists('nombreOrigenCRM','idOrigenCRM');
        $estado = \App\EstadoCRM::where('GrupoEstado_idGrupoEstado','=',$documento[0])->lists('nombreEstadoCRM','idEstadoCRM');
        
        $evento = \App\EventoCRM::All()->lists('nombreEventoCRM','idEventoCRM');

       return view('movimientocrm',compact('solicitante', 'categoria','documento','lineanegocio','origen','estado', 'evento'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(MovimientoCRMRequest $request)
    {
        $numero = DB::select(
            "SELECT CONCAT(REPEAT('0', longitudDocumentoCRM - LENGTH(ultimo+1)), (ultimo+1)) as nuevo
            FROM 
            (
                SELECT IFNULL( MAX(numeroMovimientoCRM) , 0) as ultimo, longitudDocumentoCRM
                FROM  documentocrm D 
                LEFT JOIN movimientocrm M
                on D.idDocumentoCRM = M.DocumentoCRM_idDocumentoCRM
                where   Compania_idCompania = ".\Session::get('idCompania')." and 
                        DocumentoCRM_idDocumentoCRM = ".$request['DocumentoCRM_idDocumentoCRM']."
            ) temp");

        $numero = get_object_vars($numero[0])["nuevo"];
        \App\MovimientoCRM::create([
            'numeroMovimientoCRM' => $numero,
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
            'AcuerdoServicio_idAcuerdoServicio' => $request['AcuerdoServicio_idAcuerdoServicio'],
            'detallesMovimientoCRM' => $request['detallesMovimientoCRM'],
            'solucionMovimientoCRM' => $request['solucionMovimientoCRM'],
            'Compania_idCompania' => \Session::get('idCompania')
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

             // en esta parte es el guardado de la multiregistro VACANTES
         //Primero consultar el ultimo id guardado
         // $MovimientoCRM = \App\MovimientoCRM::All()->last();
         //for para guardar cada registro de la multiregistro

         for ($i=0; $i < count($request['nombreCargo']); $i++) 
         { 
             \App\MovimientoCRMCargos::create([
            'MovimientoCRM_idMovimientoCRM' => $movimientocrm->idMovimientoCRM,
            'Cargo_idCargo' => $request['Cargo_idCargo'][$i],
            'vacantesMovimientoCRMCargo' => $request['vacantesMovimientoCRMCargo'][$i],
            'fechaEstimadaMovimientoCRMCargo' => $request['fechaEstimadaMovimientoCRMCargo'][$i]
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
        if(isset($_GET['accion']) and $_GET['accion'] == 'imprimir')
        {
            $movimientocrm = \App\MovimientoCRM::find($id);
            $idDocumentoCRM= $_GET['idDocumentoCRM'];
            

            return view('formatos.formatomovimientocrm',['movimientocrm'=>$movimientocrm], compact('idDocumentoCRM'));
        }
    
        if(isset($_GET['accion']) and $_GET['accion'] == 'dashboard')
        {
            
            $idDocumentoCRM= $_GET['idDocumentoCRM'];

            return view('dashboardcrm',compact('idDocumentoCRM'));
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
        $movimientocrm = \App\MovimientoCRM::find($id);

        $idDocumento = $_GET["idDocumentoCRM"];
        $documento = \App\DocumentoCRM::where('idDocumentoCRM','=',$idDocumento)->lists('GrupoEstado_idGrupoEstado');
       
        $solicitante = \App\Tercero::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('nombreCompletoTercero','idTercero');
        
        $categoria = \App\CategoriaCRM::All()->lists('nombreCategoriaCRM','idCategoriaCRM');
        $lineanegocio = \App\LineaNegocio::All()->lists('nombreLineaNegocio','idLineaNegocio');
        $origen = \App\OrigenCRM::All()->lists('nombreOrigenCRM','idOrigenCRM');
        $estado = \App\EstadoCRM::where('GrupoEstado_idGrupoEstado','=',$documento[0])->lists('nombreEstadoCRM','idEstadoCRM');
        
        $evento = \App\EventoCRM::All()->lists('nombreEventoCRM','idEventoCRM');



        // Consulto  los necesarios el FROM en la tabla principal movimientocrmcargo, luego los envio al blade para llenar los respectivos Datos
        $movimientocrmcargo = DB::Select('
            SELECT idMovimientoCRMCargo,nombreCargo,Cargo_idCargo,vacantesMovimientoCRMCargo,salarioBaseCargo,fechaEstimadaMovimientoCRMCargo
            FROM movimientocrmcargo MC 
            left join  movimientocrm M 
            on MC.MovimientoCRM_idMovimientoCRM = M.idMovimientoCRM 
            left join cargo C  
            on MC.Cargo_idCargo = C.idCargo
            WHERE idMovimientoCRM = '.$id);


        // print_r($movimientocrmcargo);



        return view('movimientocrm',compact('solicitante', 'categoria','documento','lineanegocio','origen','estado', 'evento','movimientocrmcargo'),['movimientocrm'=>$movimientocrm]);
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

        //  .. .. .. .. .. .. .. .. .. ... .. .. .. .. ... ... ... ... . .. . .. . .. . . .. . . . . . .
        $idsEliminar = explode("," , $request['eliminardocumentocrmcargo']);
        //Eliminar registros de la multiregistro
        \App\MovimientoCRMCargos::whereIn('idMovimientoCRMCargo', $idsEliminar)->delete();
        // Guardamos el detalle de los modulos
        for($i = 0; $i < count($request['idMovimientoCRMCargo']); $i++)
        {
             $indice = array(
                'idMovimientoCRMCargo' => $request['idMovimientoCRMCargo'][$i]);

            $data = array(
                'MovimientoCRM_idMovimientoCRM' => $id,
                'Cargo_idCargo' => $request['Cargo_idCargo'][$i],
                'vacantesMovimientoCRMCargo' => $request['vacantesMovimientoCRMCargo'][$i],
                'fechaEstimadaMovimientoCRMCargo' => $request['fechaEstimadaMovimientoCRMCargo'][$i]);


            $guardar = \App\MovimientoCRMCargos::updateOrCreate($indice, $data);
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

    public function guardarAsesorMovimientoCRM()
    {
        $movimientocrm = \App\MovimientoCRM::find($_POST["idMovimientoCRM"]);
        $movimientocrm->Tercero_idSupervisor = $_POST["idSupervisor"];
        $movimientocrm->Tercero_idAsesor = $_POST["idAsesor"];
        $movimientocrm->AcuerdoServicio_idAcuerdoServicio = $_POST["idAcuerdo"];
        $movimientocrm->diasEstimadosSolucionMovimientoCRM = $_POST["diasAcuerdo"];
        $movimientocrm->save();

        echo json_encode(array(true, 'Se ha guardado exitosamente'));
    }

    public function consultarAsesorMovimientoCRM()
    {
        $movimientocrm = DB::select(
            'SELECT Tercero_idSupervisor, 
                    nombreCompletoTercero as nombreCompletoSupervisor,
                    Tercero_idAsesor, 
                    AcuerdoServicio_idAcuerdoServicio, 
                    diasEstimadosSolucionMovimientoCRM
            FROM movimientocrm M
            LEFT JOIN tercero T
            ON M.Tercero_idSupervisor = T.idTercero
            WHERE idMovimientoCRM = '.$_POST["idMovimientoCRM"]);

        $movimientocrm = get_object_vars($movimientocrm[0]);

        echo json_encode($movimientocrm);
    }

    public function consultarDiasAcuerdoServicio()
    {
        $acuerdo = DB::select(
            'SELECT tiempoAcuerdoServicio
            FROM acuerdoservicio
            WHERE idAcuerdoServicio = '.$_POST["idAcuerdo"]);

        $acuerdo = get_object_vars($acuerdo[0]);

        echo json_encode($acuerdo);
    }

        
       
}
