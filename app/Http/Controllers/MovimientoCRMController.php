<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\MovimientoCRMRequest;

use Illuminate\Routing\Route;
use DB;
use Mail;
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
        $documento = \App\DocumentoCRM::where('idDocumentoCRM','=',$idDocumento)->lists('GrupoEstado_idGrupoEstado');

        $vista = basename($_SERVER["PHP_SELF"]);
        $datos = consultarPermisosCRM($idDocumento);
        
        $supervisor = \App\Tercero::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('nombreCompletoTercero','idTercero');
        $asesor = \App\Tercero::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('nombreCompletoTercero','idTercero');
        $acuerdoservicio = \App\AcuerdoServicio::where('GrupoEstado_idGrupoEstado','=',$documento[0])->lists('nombreAcuerdoServicio','idAcuerdoServicio');

        if($datos != null)
            return view('movimientocrmgrid', compact('datos','supervisor','asesor','acuerdoservicio'));
        else
            return view('movimientocrmgrid', compact('supervisor','asesor','acuerdoservicio'));
    }


    public function indexSelect()
    {
        //$idDoc = (isset($_GET["idDocumentoCRM"]) ? $_GET["idDocumentoCRM"] : 0 );
        return view('movimientocrmgridselect');
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
        $documentobase = \App\DocumentoCRMBase::leftjoin('documentocrm','DocumentoCRM_idBase','=','idDocumentoCRM')
                            ->where('DocumentoCRM_idDocumentoCRM','=',$idDocumento)
                            ->lists('nombreDocumentoCRM','idDocumentoCRM');
         

        $documentoTercero = \App\DocumentoCRM::where('idDocumentoCRM','=',$idDocumento)->lists('tipoDocumentoCRM');
        $filtroSolicitante = \App\DocumentoCRM::where('idDocumentoCRM','=',$idDocumento)
                            ->lists('filtroSolicitanteDocumentoCRM');
        // consultamos los maestros asociados a la compania
        // tomamos el campos de filtro de solicitante del DocumentoCRM para aplicar los filtros
        // $filtroSolicitante contiene un valor asi "*01*,*03*,*02*", lo podemos utilizar con un whereIN
        
        $solicitante = \App\Tercero::where('Compania_idCompania','=', \Session::get('idCompania'))
            ->whereIn('tipoTercero',explode(",",$filtroSolicitante[0]))->lists('nombreCompletoTercero','idTercero');
        $asesor = \App\Tercero::where('Compania_idCompania','=', \Session::get('idCompania'))
            ->where('tipoTercero','=','*01*')
            ->lists('nombreCompletoTercero','idTercero');

        $lineanegocio = \App\LineaNegocio::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('nombreLineaNegocio','idLineaNegocio');
        
        // consultamos las tablas maestras que estan asociadas al grupo de estados, filtrando por el IDde grupo asociado al documentoCRM
        $estado = \App\EstadoCRM::where('GrupoEstado_idGrupoEstado','=',$documento[0])->lists('nombreEstadoCRM','idEstadoCRM');
        $evento = \App\EventoCRM::where('GrupoEstado_idGrupoEstado','=',$documento[0])->lists('nombreEventoCRM','idEventoCRM');
        $categoria = \App\CategoriaCRM::where('GrupoEstado_idGrupoEstado','=',$documento[0])->lists('nombreCategoriaCRM','idCategoriaCRM');
        $origen = \App\OrigenCRM::where('GrupoEstado_idGrupoEstado','=',$documento[0])->lists('nombreOrigenCRM','idOrigenCRM');

        // Consultamos el tercero a mostrar en el formulario (si hace parte de los campos a mostrar) dependiendo del tipo de Documento CRM
        $proveedor = ($documentoTercero[0] == 'Compras' ? \App\Tercero::where('tipoTercero','like','%*02*%')->where('Compania_idCompania', '=', \Session::get('idCompania'))->lists('nombreCompletoTercero', 'idTercero') : ($documentoTercero[0] == 'Comercial') ? \App\Tercero::where('tipoTercero','like','%*03*%')->where('Compania_idCompania', '=', \Session::get('idCompania'))->lists('nombreCompletoTercero', 'idTercero') : Array());        

       return view('movimientocrm',compact('documentobase', 'solicitante', 'asesor', 'categoria','documento','lineanegocio','origen','estado', 'evento', 'proveedor'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        $numero = DB::select(
            "SELECT CONCAT(REPEAT('0', longitudDocumentoCRM - LENGTH(ultimo+1)), (ultimo+1)) as nuevo
            FROM 
            (
                SELECT IFNULL( MAX(numeroMovimientoCRM) , 0) as ultimo, longitudDocumentoCRM
                FROM  documentocrm D 
                LEFT JOIN movimientocrm M
                on D.idDocumentoCRM = M.DocumentoCRM_idDocumentoCRM
                where   M.Compania_idCompania = ".\Session::get('idCompania')." and 
                        DocumentoCRM_idDocumentoCRM = ".$request['DocumentoCRM_idDocumentoCRM']."
            ) temp");

        $numero = get_object_vars($numero[0])["nuevo"];

        $estado = ($request['porcentajeCumplimientoAgendaTarea'] == 100 ? 5 : ($request['EstadoCRM_idEstadoCRM'] != '' ? $request['EstadoCRM_idEstadoCRM'] : null));

        // Se hace un replace para que reemplace las comas por un vacio para que  pueda grabar en BD sin problemas 
        $valor = str_replace(',', '', $request['valorMovimientoCRM']);

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
            'valorMovimientoCRM' => $valor,
            'Tercero_idSolicitante' => ($request['Tercero_idSolicitante'] != ''  ? $request['Tercero_idSolicitante'] : null),
            'Tercero_idSupervisor' => ($request['Tercero_idSupervisor'] != '' ? $request['Tercero_idSupervisor'] : null),
            'Tercero_idAsesor' => ($request['Tercero_idAsesor'] != '' ? $request['Tercero_idAsesor'] : null),
            'Tercero_idProveedor' => ($request['Tercero_idProveedor'] != '' ? $request['Tercero_idProveedor'] : null),
            'CategoriaCRM_idCategoriaCRM' => ($request['CategoriaCRM_idCategoriaCRM'] != '' ? $request['CategoriaCRM_idCategoriaCRM'] : null),
            'DocumentoCRM_idDocumentoCRM' => ($request['DocumentoCRM_idDocumentoCRM'] != '' ? $request['DocumentoCRM_idDocumentoCRM'] : null),
            'LineaNegocio_idLineaNegocio' => ($request['LineaNegocio_idLineaNegocio'] != '' ? $request['LineaNegocio_idLineaNegocio'] : null),
            'OrigenCRM_idOrigenCRM' => ($request['OrigenCRM_idOrigenCRM'] != '' ? $request['OrigenCRM_idOrigenCRM'] : null),
            'EstadoCRM_idEstadoCRM' => $estado,
            'AcuerdoServicio_idAcuerdoServicio' => ($request['AcuerdoServicio_idAcuerdoServicio'] != '' ? $request['AcuerdoServicio_idAcuerdoServicio'] : null),
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
        for ($i=0; $i < count($arrayImage) ; $i++) 
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
                \App\MovimientoCRMArchivo::create([
                'MovimientoCRM_idMovimientoCRM' => $movimientocrm->idMovimientoCRM,
                'rutaMovimientoCRMArchivo' => $ruta
               ]);
            }

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


        //********************************
        //
        // Envio de Correo con movimiento crm
        //
        //********************************
        // consultamos el correo del usuario logueado y los correos de los usuarios aprobadores de este documento
        $condSolic = $request['Tercero_idSolicitante'] != '' ? ' T.idTercero = '.$request['Tercero_idSolicitante'].' ' : '';
        $condAses = $request['Tercero_idAsesor'] != '' ? ' T.idTercero = '.$request['Tercero_idAsesor'].' ' : '';
        $condTercero = '('. $condSolic . (($condSolic != '' and $condAses != '') ? ' or ' : ''). $condAses.')';

        $correos = DB::select(
            ($request['Tercero_idSolicitante'] != '' ? 
                'SELECT  correoElectronicoTercero
                FROM    users U 
                LEFT JOIN tercero T 
                ON U.Tercero_idTercero = T.idTercero
                WHERE   '.$condTercero. ($condTercero != '' ? ' and ' : '' ). ' 
                        correoElectronicoTercero != "" 
            UNION DISTINCT' : '').
            ' SELECT  correoElectronicoTercero 
                FROM documentocrmrol DR
                LEFT JOIN users U
                ON DR.Rol_idRol = U.Rol_idRol
                LEFT JOIN  tercero T
                ON U.Tercero_idTercero = T.idTercero
                WHERE   aprobarDocumentoCRMRol = 1 and 
                        DocumentoCRM_idDocumentoCRM = '.$request['DocumentoCRM_idDocumentoCRM'].' and 
                        T.idTercero IS NOT NULL and 
                        correoElectronicoTercero IS NOT NULL and 
                        correoElectronicoTercero != "" and 
                        U.Compania_idCompania = '.\Session::get("idCompania"));
        $datos['correos'] = array();
        for($c = 0; $c < count($correos); $c++)
        {
            $datos['correos'][] = get_object_vars($correos[$c])['correoElectronicoTercero'];
        }


        if(count($correos) > 0)
        {

            $datos['asunto'] = 'Nuevo Caso CRM: '.$request['asuntoMovimientoCRM'];
            $datos['mensaje'] = $request['detallesMovimientoCRM']. '  
                <a href="http://'.$_SERVER["HTTP_HOST"].'/movimientocrm/'.$movimientocrm->idMovimientoCRM.'?idDocumentoCRM='.$request['DocumentoCRM_idDocumentoCRM'].'&accion=imprimir">Ver Caso</a>';
            

            Mail::send('emails.contact',$datos,function($msj) use ($datos)
            {
                $msj->to($datos['correos']);
                $msj->subject($datos['asunto']);
                // $msj->attach(public_path().'/plantrabajo.html');
            });
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
            //$movimientocrm = \App\MovimientoCRM::find($id);

            $movimientocrm = DB::select(
            "SELECT 
                solicitante.documentoTercero AS documentoSolicitante,
                solicitante.nombreCompletoTercero nombreSolicitante,
                supervisor.documentoTercero AS documentoSupervisor,
                supervisor.nombreCompletoTercero AS nombreSupervisor,
                asesor.documentoTercero AS documentoAsesor,
                asesor.nombreCompletoTercero AS nombreAsesor,
                categoriacrm.nombreCategoriaCRM,
                documentocrm.nombreDocumentoCRM,
                origencrm.nombreOrigenCRM,
                estadocrm.nombreEstadoCRM,
                lineanegocio.nombreLineaNegocio,
                acuerdoservicio.nombreAcuerdoServicio,
                acuerdoservicio.tiempoAcuerdoServicio,
                acuerdoservicio.unidadTiempoAcuerdoServicio,
                eventocrm.nombreEventoCRM,
                movimientocrm.numeroMovimientoCRM,
                movimientocrm.asuntoMovimientoCRM,
                movimientocrm.fechaSolicitudMovimientoCRM,
                movimientocrm.fechaEstimadaSolucionMovimientoCRM,
                movimientocrm.fechaVencimientoMovimientoCRM,
                movimientocrm.fechaRealSolucionMovimientoCRM,
                movimientocrm.prioridadMovimientoCRM,
                movimientocrm.diasEstimadosSolucionMovimientoCRM,
                movimientocrm.diasRealesSolucionMovimientoCRM,
                movimientocrm.detallesMovimientoCRM,
                movimientocrm.solucionMovimientoCRM,
                movimientocrm.valorMovimientoCRM
            FROM
                movimientocrm
                    LEFT JOIN
                tercero solicitante ON movimientocrm.Tercero_idSolicitante = solicitante.idTercero
                    LEFT JOIN
                tercero supervisor ON movimientocrm.Tercero_idSupervisor = supervisor.idTercero
                    LEFT JOIN
                tercero asesor ON movimientocrm.Tercero_idAsesor = asesor.idTercero
                    LEFT JOIN
                categoriacrm ON movimientocrm.CategoriaCRM_idCategoriaCRM = categoriacrm.idCategoriaCRM
                    LEFT JOIN
                documentocrm ON movimientocrm.DocumentoCRM_idDocumentoCRM = documentocrm.idDocumentoCRM
                    LEFT JOIN
                lineanegocio ON movimientocrm.LineaNegocio_idLineaNegocio = lineanegocio.idLineaNegocio
                    LEFT JOIN
                origencrm ON movimientocrm.OrigenCRM_idOrigenCRM = origencrm.idOrigenCRM
                    LEFT JOIN
                estadocrm ON movimientocrm.EstadoCRM_idEstadoCRM = estadocrm.idEstadoCRM
                    LEFT JOIN
                acuerdoservicio ON movimientocrm.AcuerdoServicio_idAcuerdoServicio = acuerdoservicio.idAcuerdoServicio
                    LEFT JOIN
                eventocrm ON movimientocrm.EventoCRM_idEventoCRM = eventocrm.idEventoCRM
                WHERE idMovimientoCRM = $id");

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
        $documentoTercero = \App\DocumentoCRM::where('idDocumentoCRM','=',$idDocumento)->lists('tipoDocumentoCRM');
        $filtroSolicitante = \App\DocumentoCRM::where('idDocumentoCRM','=',$idDocumento)
                            ->lists('filtroSolicitanteDocumentoCRM');
        // consultamos los maestros asociados a la compania
        // tomamos el campos de filtro de solicitante del DocumentoCRM para aplicar los filtros
        // $filtroSolicitante contiene un valor asi "*01*,*03*,*02*", lo podemos utilizar con un whereIN
        
        $solicitante = \App\Tercero::where('Compania_idCompania','=', \Session::get('idCompania'))
            ->whereIn('tipoTercero',explode(",",$filtroSolicitante[0]))->lists('nombreCompletoTercero','idTercero');
        $asesor = \App\Tercero::where('Compania_idCompania','=', \Session::get('idCompania'))
            ->where('tipoTercero','=','*01*')
            ->lists('nombreCompletoTercero','idTercero');

        $lineanegocio = \App\LineaNegocio::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('nombreLineaNegocio','idLineaNegocio');
        
        // consultamos las tablas maestras que estan asociadas al grupo de estados, filtrando por el IDde grupo asociado al documentoCRM
        $estado = \App\EstadoCRM::where('GrupoEstado_idGrupoEstado','=',$documento[0])->lists('nombreEstadoCRM','idEstadoCRM');
        $evento = \App\EventoCRM::where('GrupoEstado_idGrupoEstado','=',$documento[0])->lists('nombreEventoCRM','idEventoCRM');
        $categoria = \App\CategoriaCRM::where('GrupoEstado_idGrupoEstado','=',$documento[0])->lists('nombreCategoriaCRM','idCategoriaCRM');
        $origen = \App\OrigenCRM::where('GrupoEstado_idGrupoEstado','=',$documento[0])->lists('nombreOrigenCRM','idOrigenCRM');

        // Consulto  los necesarios el FROM en la tabla principal movimientocrmcargo, luego los envio al blade para llenar los respectivos Datos
        $movimientocrmcargo = DB::Select('
            SELECT idMovimientoCRMCargo,nombreCargo,Cargo_idCargo,vacantesMovimientoCRMCargo,salarioBaseCargo,fechaEstimadaMovimientoCRMCargo
            FROM movimientocrmcargo MC 
            left join  movimientocrm M 
            on MC.MovimientoCRM_idMovimientoCRM = M.idMovimientoCRM 
            left join cargo C  
            on MC.Cargo_idCargo = C.idCargo
            WHERE idMovimientoCRM = '.$id);

        $movimientoCRMTarea = DB::Select('
                SELECT 
                    CategoriaAgenda_idCategoriaAgenda,
                    nombreCategoriaAgenda as nombreCategoriaAgendaTarea,
                    asuntoAgenda as asuntoAgendaTarea,
                    ubicacionAgenda as ubicacionAgendaTarea,
                    fechaHoraInicioAgenda as fechaInicioAgendaTarea,
                    fechaHoraFinAgenda as fechaFinAgendaTarea,
                    horasAgenda as horasAgendaTarea,
                    Tercero_idResponsable,
                    nombreCompletoTercero as nombreResponsableAgenda,
                    porcentajeEjecucionAgenda as ejecuionAgendaTarea,
                    estadoAgenda as estadoAgendaTarea,
                    idAgenda
                FROM agenda a
                    LEFT JOIN 
                categoriaagenda ca ON a.CategoriaAgenda_idCategoriaAgenda = ca.idCategoriaAgenda
                    LEFT JOIN 
                tercero t ON a.Tercero_idResponsable = t.idTercero
                WHERE MovimientoCRM_idMovimientoCRM = '.$id.' 
                    AND a.Compania_idCompania = '.\Session::get('idCompania'));  

        // Consultamos el tercero a mostrar en el formulario (si hace parte de los campos a mostrar) dependiendo del tipo de Documento CRM
        $proveedor = ($documentoTercero[0] == 'Compras' ? \App\Tercero::where('tipoTercero','like','%*02*%')->where('Compania_idCompania', '=', \Session::get('idCompania'))->lists('nombreCompletoTercero', 'idTercero') : ($documentoTercero[0] == 'Comercial') ? \App\Tercero::where('tipoTercero','like','%*03*%')->where('Compania_idCompania', '=', \Session::get('idCompania'))->lists('nombreCompletoTercero', 'idTercero') : Array());     

        $movimientoCRMProductoServicio = DB::Select('
            SELECT idMovimientoCRMProducto, FichaTecnica_idFichaTecnica, referenciaFichaTecnica as referenciaMovimientoCRMProducto, nombreFichaTecnica as descripcionMovimientoCRMProducto, cantidadMovimientoCRMProducto, valorUnitarioMovimientoCRMProducto
            FROM movimientocrmproducto mcrmp
            LEFT JOIN fichatecnica ft ON mcrmp.FichaTecnica_idFichaTecnica = ft.idFichaTecnica
            WHERE MovimientoCRM_idMovimientoCRM = '.$id);

        // print_r($movimientoCRMTarea);


        // print_r($movimientocrmcargo);



        return view('movimientocrm',compact('solicitante', 'asesor', 'categoria','documento','lineanegocio','origen','estado', 'evento','movimientocrmcargo', 'movimientoCRMTarea', 'proveedor', 'movimientoCRMProductoServicio'),['movimientocrm'=>$movimientocrm]);
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

        $estado = ($request['porcentajeCumplimientoAgendaTarea'] == 100 ? 5 : ($request['EstadoCRM_idEstadoCRM'] != '' ? $request['EstadoCRM_idEstadoCRM'] : null));
        // Se hace un replace para que reemplace las comas por un vacio para que  pueda grabar en BD sin problemas 
        $valor = str_replace(',', '', $request['valorMovimientoCRM']);

        $movimientocrm = \App\MovimientoCRM::find($id);
        $movimientocrm->fill($request->all());
        // Luego que busca todos los campos del request se busca valorMoviendto para hacer el replace
        $movimientocrm->valorMovimientoCRM = $valor;
        $movimientocrm->Tercero_idSolicitante = ($request['Tercero_idSolicitante'] != ''  ? $request['Tercero_idSolicitante'] : null);
        $movimientocrm->Tercero_idSupervisor = ($request['Tercero_idSupervisor'] != '' ? $request['Tercero_idSupervisor'] : null);
        $movimientocrm->Tercero_idAsesor = ($request['Tercero_idAsesor'] != '' ? $request['Tercero_idAsesor'] : null);
        $movimientocrm->Tercero_idProveedor = ($request['Tercero_idProveedor'] != '' ? $request['Tercero_idProveedor'] : null);
        $movimientocrm->CategoriaCRM_idCategoriaCRM = ($request['CategoriaCRM_idCategoriaCRM'] != '' ? $request['CategoriaCRM_idCategoriaCRM'] : null);
        $movimientocrm->DocumentoCRM_idDocumentoCRM = ($request['DocumentoCRM_idDocumentoCRM'] != '' ? $request['DocumentoCRM_idDocumentoCRM'] : null);
        $movimientocrm->LineaNegocio_idLineaNegocio = ($request['LineaNegocio_idLineaNegocio'] != '' ? $request['LineaNegocio_idLineaNegocio'] : null);
        $movimientocrm->OrigenCRM_idOrigenCRM = ($request['OrigenCRM_idOrigenCRM'] != '' ? $request['OrigenCRM_idOrigenCRM'] : null);
        $movimientocrm->EstadoCRM_idEstadoCRM = $estado;
        $movimientocrm->AcuerdoServicio_idAcuerdoServicio = ($request['AcuerdoServicio_idAcuerdoServicio'] != '' ? $request['AcuerdoServicio_idAcuerdoServicio'] : null);

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
            \App\MovimientoCRMArchivo::whereIn('idMovimientoCRMArchivo',$idsEliminar)->delete();
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

        // por Solicitud de Juan Erasmo, al modificar un documento solo se envia correo
        // al asesor y al solicitante, se quitó la consulta de los supervisores
        $condSolic = $request['Tercero_idSolicitante'] != '' ? ' T.idTercero = '.$request['Tercero_idSolicitante'].' ' : '';
        $condAses = $request['Tercero_idAsesor'] != '' ? ' T.idTercero = '.$request['Tercero_idAsesor'].' ' : '';
        $condTercero = '('. $condSolic . (($condSolic != '' and $condAses != '') ? ' or ' : ''). $condAses.')';

        $correos = DB::select('
            SELECT  correoElectronicoTercero
                FROM    users U 
                LEFT JOIN tercero T 
                ON U.Tercero_idTercero = T.idTercero
                WHERE   '.$condTercero. ($condTercero != '' ? ' and ' : '' ). ' 
                        correoElectronicoTercero != ""');
       
        $datos['correos'] = array();
        for($c = 0; $c < count($correos); $c++)
        {
            $datos['correos'][] = get_object_vars($correos[$c])['correoElectronicoTercero'];
        }

        if(count($correos) > 0)
        {

            $datos['asunto'] = 'Modificación de Caso CRM: '.$request['asuntoMovimientoCRM'];
            $datos['mensaje'] = $request['detallesMovimientoCRM']. '  
                <a href="http://'.$_SERVER["HTTP_HOST"].'/movimientocrm/'.$movimientocrm->idMovimientoCRM.'?idDocumentoCRM='.$request['DocumentoCRM_idDocumentoCRM'].'&accion=imprimir">Ver Caso</a>';
            

            Mail::send('emails.contact',$datos,function($msj) use ($datos)
            {
                $msj->to($datos['correos']);
                $msj->subject($datos['asunto']);
                // $msj->attach(public_path().'/archivo.html');
            });
        }
        

        //return redirect('/movimientocrm?idDocumentoCRM='.$request['DocumentoCRM_idDocumentoCRM']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        // con el id de movimiento consultamos que documento crm es 
        // para ponerlo en el parametro del redirect
        $documentocrm = DB::select(
                    'SELECT DocumentoCRM_idDocumentoCRM
                    FROM movimientocrm
                    WHERE idMovimientoCRM = '.$id);

        $documentocrm = get_object_vars($documentocrm[0]);
        
        \App\MovimientoCRM::destroy($id);
        return redirect('/movimientocrm?idDocumentoCRM='.$documentocrm['DocumentoCRM_idDocumentoCRM']);
    }

    public function grabarDetalle($id, $request)
    {

        $diasEstimados = DB::update(
            "UPDATE
             movimientocrm 
            SET diasEstimadosSolucionMovimientoCRM = HOUR(SEC_TO_TIME(TIMESTAMPDIFF(SECOND, fechaSolicitudMovimientoCRM, fechaEstimadaSolucionMovimientoCRM)))/24 
            WHERE fechaEstimadaSolucionMovimientoCRM != '0000-00-00 00:00:00' AND 
                idMovimientoCRM = ".$id);

        $diasReales = DB::update(
            "UPDATE
             movimientocrm 
            LEFT JOIN estadocrm ON EstadoCRM_idEstadoCRM = idEstadoCRM
            SET fechaRealSolucionMovimientoCRM = NOW(),
                diasRealesSolucionMovimientoCRM = HOUR(SEC_TO_TIME(TIMESTAMPDIFF(SECOND, fechaSolicitudMovimientoCRM, NOW())))/24 
            WHERE tipoEstadoCRM IN ('Exitoso','Fallido','Cancelado') AND 
                diasRealesSolucionMovimientoCRM = 0 AND 
                idMovimientoCRM = ".$id);

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

        // ************************
        // A  G  E  N  D  A
        // ************************
        
        $destinatarioAgenda = '';

        $idsEliminar = explode(',', $request['eliminarAgenda']);
        \App\Agenda::whereIn('idAgenda',$idsEliminar)->delete();

        for ($i=0; $i < count($request['CategoriaAgenda_idCategoriaAgenda']); $i++) 
        { 
            $fechaInicio =  strtotime(substr($request['fechaInicioAgendaTarea'][$i], 6, 4)."-".substr($request['fechaInicioAgendaTarea'][$i], 3, 2)."-".substr($request['fechaInicioAgendaTarea'][$i], 0, 2)." " .substr($request['fechaInicioAgendaTarea'][$i], 10, 6)) * 1000;

            $fechaFin =  strtotime(substr($request['fechaFinAgendaTarea'][$i], 6, 4)."-".substr($request['fechaFinAgendaTarea'][$i], 3, 2)."-".substr($request['fechaFinAgendaTarea'][$i], 0, 2)." " .substr($request['fechaFinAgendaTarea'][$i], 10, 6)) * 1000;

            $indice = array(
                'idAgenda' => $request['idAgenda'][$i]);

            $data = array(
                'CategoriaAgenda_idCategoriaAgenda' => $request['CategoriaAgenda_idCategoriaAgenda'][$i],
                'asuntoAgenda' => $request['asuntoAgendaTarea'][$i],
                'horasAgenda' => $request['horasDiaAgenda'][$i],
                'fechaHoraInicioAgenda' => $fechaInicio,
                'fechaHoraFinAgenda' => $fechaFin,
                'Tercero_idSupervisor' => ($request['Tercero_idSupervisor'] != '' ? $request['Tercero_idSupervisor'] : null),
                'Tercero_idResponsable' => $request['Tercero_idResponsable'][$i],
                'MovimientoCRM_idMovimientoCRM' => $id,
                'ubicacionAgenda' => $request['ubicacionAgendaTarea'][$i],
                'porcentajeEjecucionAgenda' => $request['ejecuionAgendaTarea'][$i],
                'estadoAgenda' => $request['estadoAgendaTarea'][$i],
                'Compania_idCompania' => \Session::get('idCompania'));

            $respuesta = \App\Agenda::updateOrCreate($indice, $data); 

            if ($request['idAgenda'][$i] == 0) 
            {
                $agenda = \App\Agenda::All()->last();
                DB::update('UPDATE agenda SET urlAgenda = "http://'.$_SERVER["HTTP_HOST"].'/eventoagenda?id='.$agenda->idAgenda.'" WHERE idAgenda = '.$agenda->idAgenda);
            } 

            $destinatarioAgenda .= $request['Tercero_idResponsable'][$i].',';
        }

        if ($destinatarioAgenda != '') 
        {
            $destinatarioAgenda = substr($destinatarioAgenda, 0, -1);
            $destinatario = $destinatarioAgenda;
            $correos = DB::Select('
                SELECT  GROUP_CONCAT(correoElectronicoTercero) AS correoElectronicoTercero
                FROM    users U 
                LEFT JOIN tercero T 
                ON U.Tercero_idTercero = T.idTercero
                WHERE idTercero IN ('.$destinatario.')');

            $correoTercero = get_object_vars($correos[0])['correoElectronicoTercero'];

            $mail = array();
            $mail['asuntoCorreoCRM'] = 'Tareas programadas - Agenda CRM';
            $mail['mensaje'] = "Se han realizado movimientos en la agenda del CRM.<br><br>
            Para visualizarlo mejor <a href='http://".$_SERVER['HTTP_HOST']."/agenda'>ve directamente</a> a la agenda.";
            $mail['destinatarioCorreoCRM'] = explode(',', $correoTercero);
            Mail::send('emails.contact',$mail,function($msj) use ($mail)
            {
                $msj->to($mail['destinatarioCorreoCRM']);
                $msj->subject($mail['asuntoCorreoCRM']);
            }); 
        }

        // ************************
        // P R O D U C T O S 
        // ************************

        $idsEliminar = explode(',', $request['eliminarMovimientoCRMPRoducto']);
        \App\MovimientoCRMProducto::whereIn('idMovimientoCRMProducto',$idsEliminar)->delete();

        echo count($request['cantidadMovimientoCRMProducto']);
        

        for ($i=0; $i < count($request['cantidadMovimientoCRMProducto']); $i++) 
        { 
            $indice = array(
                'idMovimientoCRMProducto' => $request['idMovimientoCRMProducto'][$i]);

            $data = array(
                'FichaTecnica_idFichaTecnica' => $request['FichaTecnica_idFichaTecnica'][$i],
                'cantidadMovimientoCRMProducto' => $request['cantidadMovimientoCRMProducto'][$i],
                'valorUnitarioMovimientoCRMProducto' => $request['valorUnitarioMovimientoCRMProducto'][$i],
                'MovimientoCRM_idMovimientoCRM' => $id);

            $respuesta = \App\MovimientoCRMProducto::updateOrCreate($indice, $data); 
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

        // consultamos los campos del movimiento necesarios apra enviar correo
        $movimiento = DB::select('
            SELECT  idMovimientoCRM, asuntoMovimientoCRM, detallesMovimientoCRM,
                    Tercero_idSolicitante, Tercero_idAsesor, DocumentoCRM_idDocumentoCRM
                FROM  movimientocrm
                WHERE idMovimientoCRM = '.$_POST["idMovimientoCRM"]);

        
        $datosmovimiento[] = get_object_vars($movimiento[0]);
        

        // consultamos los correos a quienes se debe enviar el mensaje
        $correos = DB::select('
            SELECT  correoElectronicoTercero
                FROM    users U 
                LEFT JOIN tercero T 
                ON U.Tercero_idTercero = T.idTercero
                WHERE   (T.idTercero = '.$datosmovimiento[0]['Tercero_idSolicitante'].' '.
                        ($datosmovimiento[0]['Tercero_idAsesor'] != '' ? ' or T.idTercero = '.$datosmovimiento[0]['Tercero_idAsesor'] : '').
                        ') and
                        correoElectronicoTercero != "" 
            UNION DISTINCT
            SELECT  correoElectronicoTercero 
                FROM documentocrmrol DR
                LEFT JOIN users U
                ON DR.Rol_idRol = U.Rol_idRol
                LEFT JOIN  tercero T
                ON U.Tercero_idTercero = T.idTercero
                WHERE   aprobarDocumentoCRMRol = 1 and 
                        DocumentoCRM_idDocumentoCRM = '.$datosmovimiento[0]['DocumentoCRM_idDocumentoCRM'].' and 
                        T.idTercero IS NOT NULL and 
                        correoElectronicoTercero IS NOT NULL and 
                        correoElectronicoTercero != ""  and 
                        U.Compania_idCompania = '.\Session::get("idCompania"));

        $datos['correos'] = array();
        for($c = 0; $c < count($correos); $c++)
        {
            $datos['correos'][] = get_object_vars($correos[$c])['correoElectronicoTercero'];
        }

        if(count($correos) > 0)
        {

            $datos['asunto'] = 'Asignación de Asesor CRM: '.$datosmovimiento[0]['asuntoMovimientoCRM'];
            $datos['mensaje'] = $datosmovimiento[0]['detallesMovimientoCRM']. '  
                <a href="http://'.$_SERVER["HTTP_HOST"].'/movimientocrm/'.$datosmovimiento[0]['idMovimientoCRM'].'?idDocumentoCRM='.$datosmovimiento[0]['DocumentoCRM_idDocumentoCRM'].'&accion=imprimir">Ver Caso</a>';

            Mail::send('emails.contact',$datos,function($msj) use ($datos)
            {
                $msj->to($datos['correos']);
                $msj->subject($datos['asunto']);
            });
        }
        


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


    public function consultarMovimientoCRMBase()
    {
        $datos = \App\MovimientoCRM::where('idMovimientoCRM','=',$_POST["idBase"])
                    ->get();
       
        echo json_encode($datos);
    }

        
       
}
