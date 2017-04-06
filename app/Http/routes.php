<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

// ---------------------------------
// Opciones del modulo de seguridad
// ---------------------------------

Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', ['as' =>'auth/login', 'uses' => 'Auth\AuthController@postLogin']);
Route::get('auth/logout', ['as' => 'auth/logout', 'uses' => 'Auth\AuthController@getLogout']);
 
// ---------------------------------
// Ruta de acceso denegado
// ---------------------------------
Route::get('accesodenegado', function () {
    return view('accesodenegado');
    });

Route::group(['middleware' => 'auth'], function () 
{

    Route::get('dashboard', function()
    {
        return view('layouts.tablero');
    });

    Route::get('firma', function()
    {
        return view('signaturepad');
    });

    
    // Creamos un Controlador para gestionar la autenticación en HomeController.
    //Route::controller('/','HomeController');

    //Route::get('datosasisge', 'HomeController@index');
    /*Route::controllers([
            "auth"      => "Auth\AuthController",
            "password"  => "Auth\PasswordController"
        ]); */


    

    // Registration routes...
    // Route::get('auth/register', 'Auth\AuthController@getRegister');
    // Route::post('auth/register', ['as' => 'auth/register', 'uses' => 'Auth\AuthController@postRegister']);



    // // Nos indica que las rutas que están dentro de él sólo serán mostradas si antes el usuario se ha autenticado.
    // Route::group(array('before' => 'auth'), function()
    // {
    //     // Esta será nuestra ruta de bienvenida.
    //     Route::get('/', function()
    //     {
    //         return View::make('hello');
    //     });
    //     // Esta ruta nos servirá para cerrar sesión.
    //     Route::get('logout', 'AuthController@logOut');
    // });
    Route::resource ('centrocosto','CentroCostoController');
    Route::resource ('parametrogestionhumana','ParametroGestionHumanaController');
    Route::resource ('evaluaciondesempenio','EvaluacionDesempenioController');
    Route::resource ('entrevistaresultado','EntrevistaResultadoController');
    Route::resource ('competenciarespuesta','CompetenciaRespuestaController');
    Route::resource ('entrevista','EntrevistaController');
    Route::resource ('competencia','CompetenciaController');   
    Route::resource ('perfilcargo','PerfilCargoController');
    Route::resource('users','UsersController');
    Route::resource('paquete','PaqueteController');
    Route::resource('opcion','OpcionController');
    Route::resource('opcionselect','OpcionController@select');
    Route::resource('rol','RolController');


    Route::resource('dashboard','DashboardController');
    Route::resource('pais','PaisController');
    Route::resource('departamento','DepartamentoController');
    Route::resource('ciudad','CiudadController');
    Route::resource('tipoidentificacion','TipoIdentificacionController');
    Route::resource('frecuenciamedicion','FrecuenciaMedicionController');
    Route::resource('proceso','ProcesoController');
    Route::resource('compania','CompaniaController');
    Route::resource('tercero','TerceroController');
    Route::resource('cargo','CargoController');
    Route::resource('clasificacionriesgo','ClasificacionRiesgoController');
    Route::resource('tiporiesgo','TipoRiesgoController');
    Route::resource('listageneral','ListaGeneralController');
    Route::resource('tiponormalegal','TipoNormaLegalController');
    Route::resource('expidenormalegal','ExpideNormaLegalController');
    Route::resource('documentosoporte','DocumentoSoporteController');
    Route::resource('tipoinspeccion','TipoInspeccionController');
    Route::resource('tipoexamenmedico','TipoExamenMedicoController');
    Route::resource('tipoelementoproteccion','TipoElementoProteccionController');
    Route::resource('elementoproteccion','ElementoProteccionController');
    Route::resource('movimientocrm','MovimientoCRMController');



    Route::resource('diagnostico','DiagnosticoController');
    Route::resource('cuadromando','CuadroMandoController');
    Route::resource('matrizriesgo','MatrizRiesgoController');
    Route::resource('matrizlegal','MatrizLegalController');
    Route::resource('procedimiento','ProcedimientoController');
    Route::resource('programa','ProgramaController');
    Route::resource('actacapacitacion','ActaCapacitacionController');
    Route::resource('plancapacitacion','PlanCapacitacionController');
    Route::resource('inspeccion','InspeccionController');
    Route::resource('examenmedico','ExamenMedicoController');
    Route::resource('ausentismo','AusentismoController');
    Route::resource('accidente','AccidenteController');
    Route::resource('grupoapoyo','GrupoApoyoController');
    Route::resource('conformaciongrupoapoyo','ConformacionGrupoApoyoController');
    Route::resource('actagrupoapoyo','ActaGrupoApoyoController');
    Route::resource('entregaelementoproteccion','EntregaElementoProteccionController');
    Route::resource('planauditoria','PlanAuditoriaController');
    Route::resource('preguntalistachequeo','PreguntasListaChequeoController');
    Route::resource('listachequeo','ListaChequeoController');
    Route::resource('reporteacpm','ReporteACPMController');
    Route::resource('plantrabajo','PlanTrabajoController');
    Route::resource('plantrabajoformulario','PlanTrabajoFormularioController');
    Route::resource('plantrabajoalerta','PlanTrabajoAlertaController');


    // *************************************
    // Rutas del CRM
    // *************************************
    Route::resource('sectorempresa','SectorEmpresaController');
    Route::resource('lineanegocio','LineaNegocioController');
    Route::resource('origencrm','OrigenCRMController');
    Route::resource('zona','ZonaController');
    Route::resource('categoriacrm','CategoriaCRMController');
    Route::resource('eventocrm','EventoCRMController');
    Route::resource('acuerdoservicio','AcuerdoServicioController');
    Route::resource('grupoestado','GrupoEstadoController');
    Route::resource('documentocrm','DocumentoCRMController');
    Route::resource('movimientocrm','MovimientoCRMController');
    Route::resource('presupuesto','PresupuestoController');

    Route::resource('categoriaagenda','CategoriaAgendaController');
    Route::resource('agenda','AgendaController');

    Route::get('eventoagenda','AgendaController@indexAgendaEvento');
    Route::get('getAll','AgendaController@getAll');
    Route::get('eliminarAgenda/delete/{id}', 'AgendaController@destroy');

    Route::resource('perfilcliente','PerfilClienteController');

    
    // *************************************
    // Rutas de Encuestas
    // *************************************
    Route::resource('encuesta','EncuestaController');
    Route::resource('encuestapublicacion','EncuestaPublicacionController');

    Route::post('grabarRespuesta', [
            'as' => 'grabarRespuesta', 
            'uses' => 'EncuestaPublicacionController@grabarRespuesta']);
    

    // *************************************
    // Rutas de Produccion
    // *************************************
    Route::resource('lineaproducto','LineaProductoController');
    Route::resource('sublineaproducto','SublineaProductoController');

    // *************************************************
    //
    //  D I S E Ñ A D O R   D E   I N F O R M E S 
    //
    // *************************************************
    Route::get('/disenadorinforme', function () {
        return view('disenadorinforme');
    });
    Route::get('/visorinforme', function () {
        return view('visorinforme');
    });


});



{
    Route::get('calcularCuadroMando', function()
    {
        include public_path().'/ajax/calcularCuadroMando.php';
    });

    Route::post('consultarPlanTrabajo', function()
    {
        include public_path().'/ajax/consultarPlanTrabajo.php';
    });


    Route::post('importarTerceroProveedor', [
            'as' => 'importarTerceroProveedor', 
            'uses' => 'TerceroController@importarTerceroProveedor']);

    Route::post('importarTerceroEmpleado', [
            'as' => 'importarTerceroEmpleado', 
            'uses' => 'TerceroController@importarTerceroEmpleado']);

    Route::post('importarMatrizRiesgo', [
        'as' => 'importarMatrizRiesgo', 
        'uses' => 'MatrizRiesgoController@importarMatrizRiesgo']);

    Route::post('importarMatrizLegal', [
        'as' => 'importarMatrizLegal', 
        'uses' => 'MatrizLegalController@importarMatrizLegal']);


    Route::get('datosUsers', function()
    {
        include public_path().'/ajax/datosUsers.php';
    });

    Route::get('datosPaquete', function()
    {
        include public_path().'/ajax/datosPaquete.php';
    });

    Route::get('datosOpcion', function()
    {
        include public_path().'/ajax/datosOpcion.php';
    });

    /*Route::get('datosopciongridselect', function()
    {
        include public_path().'/ajax/datosopciongridphpselect');
    });
    */
    Route::get('datosRol', function()
    {
        include public_path().'/ajax/datosRol.php';
    });
    // ---------------------------------
    // Archivos Maestros
    // ---------------------------------
    Route::get('datosPais', function()
    {
        include public_path().'/ajax/datosPais.php';
    });

    Route::get('datosDepartamento', function()
    {
        include public_path().'/ajax/datosDepartamento.php';
    });


    Route::get('datosCiudad', function()
    {
        include public_path().'/ajax/datosCiudad.php';
    });

    Route::get('datosTipoIdentificacion', function()
    {
        include public_path().'/ajax/datosTipoIdentificacion.php';
    });

    Route::get('datosFrecuenciaMedicion', function()
    {
        include public_path().'/ajax/datosFrecuenciaMedicion.php';
    });

    Route::get('datosProceso', function()
    {
        include public_path().'/ajax/datosProceso.php';
    });
    Route::get('datosCentroCosto', function()
    {
        include public_path().'/ajax/datosCentroCosto.php';
    });

    Route::get('datosCompania', function()
    {
        include public_path().'/ajax/datosCompania.php';
    });

    Route::get('datosTercero', function()
    {
        include public_path().'/ajax/datosTercero.php';
    });

    Route::get('datosCargo', function()
    {
        include public_path().'/ajax/datosCargo.php';
    });

    Route::get('datosClasificacionRiesgo', function()
    {
        include public_path().'/ajax/datosClasificacionRiesgo.php';
    });

    Route::get('datosTipoRiesgo', function()
    {
        include public_path().'/ajax/datosTipoRiesgo.php';
    });

    Route::get('datosListaGeneral', function()
    {
        include public_path().'/ajax/datosListaGeneral.php';
    });

    Route::get('datosTipoNormaLegal', function()
    {
        include public_path().'/ajax/datosTipoNormaLegal.php';
    });

    Route::get('datosExpideNormaLegal', function()
    {
        include public_path().'/ajax/datosExpideNormaLegal.php';
    });

    Route::get('datosDocumentoSoporte', function()
    {
        include public_path().'/ajax/datosDocumentoSoporte.php';
    });

    Route::get('datosTipoInspeccion', function()
    {
        include public_path().'/ajax/datosTipoInspeccion.php';
    });

    Route::get('datosTipoExamenMedico', function()
    {
        include public_path().'/ajax/datosTipoExamenMedico.php';
    });

    Route::get('datosTipoElementoProteccion', function()
    {
        include public_path().'/ajax/datosTipoElementoProteccion.php';
    });

    Route::get('datosElementoProteccion', function()
    {
        include public_path().'/ajax/datosElementoProteccion.php';
    });

        Route::get('datosEntrevista', function()
    {
        include public_path().'/ajax/datosEntrevista.php';
    });
        Route::get('datosEntrevistaResultado', function()
    {
    include public_path().'/ajax/datosEntrevistaResultado.php';
    });

    Route::get('datosCompetencia', function()
    {
        include public_path().'/ajax/datosCompetencia.php';
    });

    Route::get('datosCompetenciaSelect', function()
    {
        include public_path().'/ajax/datosCompetenciaSelect.php';
    });

    Route::get('datosHabilidadSelect', function()
    {
        include public_path().'/ajax/datosHabilidadSelect.php';
    });

    Route::get('datosFormacionSelect', function()
    {
        include public_path().'/ajax/datosFormacionSelect.php';
    });

    Route::get('datosEducacionSelect', function()
    {
        include public_path().'/ajax/datosEducacionSelect.php';
    });



    Route::post('dashboardConsultarProgramas', function()
    {
        include public_path().'/ajax/dashboardConsultarProgramas.php';
    });
    Route::post('dashboardConsultarCapacitaciones', function()
    {
        include public_path().'/ajax/dashboardConsultarCapacitaciones.php';
    });
    Route::post('dashboardConsultarInspecciones', function()
    {
        include public_path().'/ajax/dashboardConsultarInspecciones.php';
    });
    Route::post('dashboardConsultarExamenes', function()
    {
        include public_path().'/ajax/dashboardConsultarExamenes.php';
    });
    Route::post('dashboardConsultarActas', function()
    {
        include public_path().'/ajax/dashboardConsultarActas.php';
    });
    Route::post('dashboardConsultarAccidentes', function()
    {
        include public_path().'/ajax/dashboardConsultarAccidentes.php';
    });
    Route::post('dashboardConsultarGrupos', function()
    {
        include public_path().'/ajax/dashboardConsultarGrupos.php';
    });

    Route::get('datosPlanTrabajo', function()
    {
        include public_path().'/ajax/datosPlanTrabajo.php';
    });

    Route::get('datosPlanTrabajoAlerta', function()
    {
        include public_path().'/ajax/datosPlanTrabajoAlerta.php';
    });
    Route::get('datosPerfilCargo', function()
    {
        include public_path().'/ajax/datosPerfilCargo.php';
    });

    // *************************************
    // Rutas de Produccion
    // *************************************
    Route::get('datosLineaProducto', function()
    {
        include public_path().'/ajax/datosLineaProducto.php';
    });    
    Route::get('datosSublineaProducto', function()
    {
        include public_path().'/ajax/datosSublineaProducto.php';
    });    


    Route::post('consultarPermisos', function()
    {
        include public_path().'/ajax/consultarPermisos.php';
    });
    //Ajax de Maestros
    Route::post('llenarCargo', function()
    {
        include public_path().'/ajax/llenarCargo.php';
    });

    Route::post('llenarElementoProteccion', function()
    {
        include public_path().'/ajax/llenarElementoProteccion.php';
    });

    Route::post('llenarDescripcion', function()
    {
        include public_path().'/ajax/llenarDescripcion.php';
    });

    Route::post('llenarObjetivo', function()
    {
        include public_path().'/ajax/llenarObjetivo.php';
    });

    Route::post('llenarPlanCapacitacionTema', function()
    {
        include public_path().'/ajax/llenarPlanCapacitacionTema.php';
    });

    Route::post('llenarAusentismo', function()
    {
        include public_path().'/ajax/llenarAusentismo.php';
    });

    Route::post('consultarFechaEmpleadoAccidente', function()
    {
        include public_path().'/ajax/consultarFechaEmpleadoAccidente.php';
    });

    Route::post('CuadroMandoConsultarCampos', function()
    {
        include public_path().'/ajax/CuadroMandoConsultarCampos.php';
    });
    Route::post('CuadroMandoConsultarCamposFecha', function()
    {
        include public_path().'/ajax/CuadroMandoConsultarCamposFecha.php';
    });
    Route::post('CuadroMandoConsultarCalculos', function()
    {
        include public_path().'/ajax/CuadroMandoConsultarCalculos.php';
    });
    Route::post('llenarFormacionCargo', function()
    {
        include public_path().'/ajax/llenarFormacionCargo.php';
    });
    Route::post('llenarEducacionCargo', function()
    {
        include public_path().'/ajax/llenarEducacionCargo.php';
    });
    Route::post('llenarEntrevistaCompetencia', function()
    {
        include public_path().'/ajax/llenarEntrevistaCompetencia.php';
    });
    Route::post('llenarHabilidadCargo', function()
    {
    include public_path().'/ajax/llenarHabilidadCargo.php';
    });
    Route::post('llenarEvaluacionEducacion', function()
    {
    include public_path().'/ajax/llenarEvaluacionEducacion.php';
    });
    Route::post('llenarEvaluacionFormacion', function()
    {
    include public_path().'/ajax/llenarEvaluacionFormacion.php';
    });
    Route::post('llenarEvaluacionHabilidad', function()
    {
    include public_path().'/ajax/llenarEvaluacionHabilidad.php';
    });

    Route::post('llenarHabilidadesActitudinales', function()
    {
        include public_path().'/ajax/llenarHabilidadesActitudinales.php';
    });

    Route::post('CargarEntrevista', function()
    {
        include public_path().'/ajax/CargarEntrevista.php';
    });

    // ---------------------------------
    // Inspecciones
    // ---------------------------------

        Route::post('consultarImagenInspeccion', function()
        {
            include public_path().'/ajax/consultarImagenInspeccion.php';
        });
        
    // ---------------------------------
    // Documentos
    // ---------------------------------


    Route::get('datosDiagnostico', function()
    {
        include public_path().'/ajax/datosDiagnostico.php';
    });

    Route::get('datosMatrizRiesgo', function()
    {
        include public_path().'/ajax/datosMatrizRiesgo.php';
    });

    Route::get('datosMatrizLegal', function()
    {
        include public_path().'/ajax/datosMatrizLegal.php';
    });

    Route::get('datosProcedimiento', function()
    {
        include public_path().'/ajax/datosProcedimiento.php';
    });


    Route::get('datosPrograma', function()
    {
        include public_path().'/ajax/datosPrograma.php';
    });


    Route::get('datosActaCapacitacion', function()
    {
        include public_path().'/ajax/datosActaCapacitacion.php';
    });

    Route::get('datosActaCapacitacionSelect', function()
    {
        include public_path().'/ajax/datosActaCapacitacionSelect.php';
    });

    Route::get('datosPlanCapacitacion', function()
    {
        include public_path().'/ajax/datosPlanCapacitacion.php';
    });

    Route::get('datosPlanAuditoria', function()
    {
        include public_path().'/ajax/datosPlanAuditoria.php';
    });

    Route::get('datosListaChequeo', function()
    {
        include public_path().'/ajax/datosListaChequeo.php';
    });

    Route::get('datosReporteACPM', function()
    {
        include public_path().'/ajax/datosReporteACPM.php';
    });

    Route::get('datosInspeccion', function()
    {
        include public_path().'/ajax/datosInspeccion.php';
    });

    Route::get('datosInspeccionSelect', function()
    {
        include public_path().'/ajax/datosInspeccionSelect.php';
    });

    Route::get('datosExamenMedico', function()
    {
        include public_path().'/ajax/datosExamenMedico.php';
    });

    Route::get('datosAusentismo', function()
    {
        include public_path().'/ajax/datosAusentismo.php';
    });

    Route::get('datosAccidente', function()
    {
        include public_path().'/ajax/datosAccidente.php';
    });

    Route::get('datosAccidenteSelect', function()
    {
        include public_path().'/ajax/datosAccidenteSelect.php';
    });

    Route::get('datosGrupoApoyo', function()
    {
        include public_path().'/ajax/datosGrupoApoyo.php';
    });

    Route::get('datosConformacionGrupoApoyo', function()
    {
        include public_path().'/ajax/datosConformacionGrupoApoyo.php';
    });

    Route::get('datosConformacionGrupoApoyoSelect', function()
    {
        include public_path().'/ajax/datosConformacionGrupoApoyoSelect.php';
    });

    Route::get('datosActaGrupoApoyo', function()
    {
        include public_path().'/ajax/datosActaGrupoApoyo.php';
    });

    Route::get('datosActaGrupoApoyoSelect', function()
    {
        include public_path().'/ajax/datosActaGrupoApoyoSelect.php';
    });

    Route::get('datosEntregaElementoProteccion', function()
    {
        include public_path().'/ajax/datosEntregaElementoProteccion.php';
    });

    Route::get('datosEntregaElementoProteccionSelect', function()
    {
        include public_path().'/ajax/datosEntregaElementoProteccionSelect.php';
    });

    Route::get('datosCuadroMando', function()
    {
        include public_path().'/ajax/datosCuadroMando.php';
    });

    Route::get('datosSectorEmpresa', function()
    {
        include public_path().'/ajax/datosSectorEmpresa.php';
    });
    Route::get('datosLineaNegocio', function()
    {
        include public_path().'/ajax/datosLineaNegocio.php';
    });
    Route::get('datosOrigenCRM', function()
    {
        include public_path().'/ajax/datosOrigenCRM.php';
    });
    Route::get('datosZona', function()
    {
        include public_path().'/ajax/datosZona.php';
    });
    Route::get('datosCategoriaCRM', function()
    {
        include public_path().'/ajax/datosCategoriaCRM.php';
    });
    Route::get('datosEventoCRM', function()
    {
        include public_path().'/ajax/datosEventoCRM.php';
    });
    Route::get('datosAcuerdoServicio', function()
    {
        include public_path().'/ajax/datosAcuerdoServicio.php';
    });
    Route::get('datosGrupoEstado', function()
    {
        include public_path().'/ajax/datosGrupoEstado.php';
    });
     Route::get('datosEvaluacionDesempenio', function()
    {
        include public_path().'/ajax/datosEvaluacionDesempenio.php';
    });

    Route::get('datosCategoriaAgenda', function()
    {
        include public_path().'/ajax/datosCategoriaAgenda.php';
    });

    Route::get('datosPerfilCliente', function()
    {
        include public_path().'/ajax/datosPerfilCliente.php';
    });

    Route::get('datosPerfilClienteMovimiento', function()
    {
        include public_path().'/ajax/datosPerfilClienteMovimiento.php';
    });


    Route::get('datosDocumentoCRM', function()
    {
        include public_path().'/ajax/datosDocumentoCRM.php';
    });
    Route::get('datosMovimientoCRM', function()
    {
        include public_path().'/ajax/datosMovimientoCRM.php';
    });
    Route::post('guardarAsesorMovimientoCRM', [
            'as' => 'guardarAsesorMovimientoCRM', 
            'uses' => 'MovimientoCRMController@guardarAsesorMovimientoCRM']);

    Route::post('consultarAsesorMovimientoCRM', [
            'as' => 'consultarAsesorMovimientoCRM', 
            'uses' => 'MovimientoCRMController@consultarAsesorMovimientoCRM']);

    Route::post('consultarDiasAcuerdoServicio', [
            'as' => 'consultarDiasAcuerdoServicio', 
            'uses' => 'MovimientoCRMController@consultarDiasAcuerdoServicio']);
    
    Route::get('datosCampoCRMSelect', function()
    {
        include public_path().'/ajax/datosCampoCRMSelect.php';
    });
    Route::get('datosCompaniaSelect', function()
    {
        include public_path().'/ajax/datosCompaniaSelect.php';
    });
    Route::get('datosRolSelect', function()
    {
        include public_path().'/ajax/datosRolSelect.php';
    });

    Route::get('datosPresupuesto', function()
    {
        include public_path().'/ajax/datosPresupuesto.php';
    });

    Route::get('datosCompetenciaSelect', function()
    {
    include public_path().'/ajax/datosCompetenciaSelect.php';

    });
    Route::get('datosCompetenciaRespuesta', function()
    {
        include public_path().'/ajax/datosCompetenciaRespuesta.php';
    });

    Route::get('datosHabilidadSelect', function()
    {
        include public_path().'/ajax/datosHabilidadSelect.php';
    });

    Route::get('datosFormacionSelect', function()
    {
        include public_path().'/ajax/datosFormacionSelect.php';
    });

    Route::get('datosEducacionSelect', function()
    {
        include public_path().'/ajax/datosEducacionSelect.php';
    }); 

    Route::post('llenarCampo', function()
    {
        include public_path().'/ajax/llenarCampo.php';
    });
    Route::post('llenarCompania', function()
    {
        include public_path().'/ajax/llenarCompania.php';
    });
    Route::post('llenarRol', function()
    {
        include public_path().'/ajax/llenarRol.php';
    });

    Route::post('actualizarFirmaActaGrupoApoyo', function()
    {
        include public_path().'/ajax/actualizarFirmaActaGrupoApoyo.php';
    });

    Route::post('actualizarFirmaActaCapacitacion', function()
    {
        include public_path().'/ajax/actualizarFirmaActaCapacitacion.php';
    });

    Route::post('actualizarFirmaEntregaElementoProteccion', function()
    {
        include public_path().'/ajax/actualizarFirmaEntregaElementoProteccion.php';
    });

    Route::post('actualizarFirmaAccidente', function()
    {
        include public_path().'/ajax/actualizarFirmaAccidente.php';
    });

    Route::post('actualizarFirmaInspeccion', function()
    {
        include public_path().'/ajax/actualizarFirmaInspeccion.php';
    });

    Route::post('actualizarFirmaConformacionGrupoApoyo', function()
    {
        include public_path().'/ajax/actualizarFirmaConformacionGrupoApoyo.php';
    });
    Route::get('datosMovimientocrmVacantegridselect', function()
    {
        include public_path().'/ajax/datosMovimientocrmVacantegridselect.php';
    });

    Route::get('agregarEventoAgenda', function()
    {
        include public_path().'/ajax/agregarEventoAgenda.php';
    });



    //************************************
    // Rutas de Ajax de Encuestas
    //************************************

    Route::get('datosEncuesta', function()
    {
        include public_path().'/ajax/datosEncuesta.php';
    });
    Route::get('datosEncuestaPublicacion', function()
    {
        include public_path().'/ajax/datosEncuestaPublicacion.php';
    });


    Route::get('educaciongridselect','CargoController@indexEducacionGrid');
    Route::get('formaciongridselect','CargoController@indexformacionGrid');
    Route::get('habiliadadgridselect','CargoController@indexHabilidadGrid');
    Route::get('competenciagridselect','CargoController@indexCompetenciaGrid');
    Route::get('campocrmgridselect','DocumentoCRMController@indexCampoCRMGrid');
    Route::get('companiagridselect','DocumentoCRMController@indexCompaniaGrid');
    Route::get('rolgridselect','DocumentoCRMController@indexRolGrid');
    Route::get('actagrupoapoyoselect','ActaGrupoApoyoController@indexActaGrid');
    Route::get('MovimientocrmVacantegridselect', 'MovimientoCRMController@indexMovimientocrmVacantegridselect');    


    Route::get('informeconceptogridselect','VisorInformeController@indexInformeConceptoGrid');




    //Ajax de Maestros
    Route::post('consultarSistemaInformacion', function()
    {
        include public_path().'/ajax/consultarSistemaInformacion.php';
    });

    Route::post('guardarSistemaInformacion', function()
    {
        include public_path().'/ajax/guardarSistemaInformacion.php';
    });

    Route::post('consultarEstiloInforme', function()
    {
        include public_path().'/ajax/consultarEstiloInforme.php';
    });

    Route::post('guardarEstiloInforme', function()
    {
        include public_path().'/ajax/guardarEstiloInforme.php';
    });


    Route::post('consultarCategoriaInforme', function()
    {
        include public_path().'/ajax/consultarCategoriaInforme.php';
    });
    Route::post('guardarCategoriaInforme', function()
    {
        include public_path().'/ajax/guardarCategoriaInforme.php';
    });

    Route::post('mostrarInformesCategoria', function()
    {
        include public_path().'/ajax/mostrarInformesCategoria.php';
    });



    Route::post('consultarInforme', function()
    {
        include public_path().'/ajax/consultarInforme.php';
    });
    Route::post('eliminarInforme', function()
    {
        include public_path().'/ajax/eliminarInforme.php';
    });

    Route::post('duplicarInforme', [
        'as' => 'duplicarInforme', 
        'uses' => 'InformeController@duplicate']);

    Route::post('moverInforme', [
        'as' => 'moverInforme', 
        'uses' => 'InformeController@move']);


    Route::post('consultarInformeCapa', function()
    {
        include public_path().'/ajax/consultarInformeCapa.php';
    });

    Route::post('consultarInformeConcepto', function()
    {
        include public_path().'/ajax/consultarInformeConcepto.php';
    });

    Route::post('consultarInformeGrupo', function()
    {
        include public_path().'/ajax/consultarInformeGrupo.php';
    });

    Route::post('consultarInformeObjeto', function()
    {
        include public_path().'/ajax/consultarInformeObjeto.php';
    });

    Route::post('guardarInforme', function()
    {
        include public_path().'/ajax/guardarInforme.php';
    });


    Route::post('conexionDocumento', function()
    {
        include public_path().'/ajax/conexionDocumento.php';
    });


    Route::post('conexionDocumentoCampos', function()
    {
        include public_path().'/ajax/conexionDocumentoCampos.php';
    });

    Route::get('generarInforme', function()
    {
        include public_path().'/ajax/generarInforme.php';
    });
    Route::POST('consultarinformeEntrevista', function()
    {
    include public_path().'/ajax/consultarinformeEntrevista.php';
    });
    Route::post('llenarEntrevistaCompetencia', function()
    {
    include public_path().'/ajax/llenarEntrevistaCompetencia.php';
    });

    Route::post('llenarEntrevistaCompetenciaNueva', function()
    {
        include public_path().'/ajax/llenarEntrevistaCompetenciaNueva.php';
    });
    Route::post('llenarEvaluacionDesempenioCargo', function()
    {
        include public_path().'/ajax/llenarEvaluacionDesempenioCargo.php';
    });
     Route::post('llenarResponsabilidadCargo', function()
    {
        include public_path().'/ajax/llenarResponsabilidadCargo.php';
    });

    Route::post('mostrarCamposAgenda', function()
    {
        include public_path().'/ajax/mostrarCamposAgenda.php';
    });

    Route::get('datosListaSelectTercero', function()
    {
        include public_path().'/ajax/datosListaSelectTercero.php';
    });

}

Route::get('dropzone','TerceroController@indexdropzone');
Route::post('dropzone/uploadFiles', 'TerceroController@uploadFiles'); 

Route::get('dropzone','MatrizRiesgoController@indexdropzone');
Route::post('dropzone/uploadFiles', 'MatrizRiesgoController@uploadFiles'); 

Route::get('dropzone','MatrizLegalController@indexdropzone');
Route::post('dropzone/uploadFiles', 'MatrizLegalController@uploadFiles'); 


/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| G    E     S     T    I     O     N      
| 
| D    O     C     U    M     E     N     T     A    L
|
*/

/**********************************Rutas de las Grids*********************************/

Route::get('datosDependencia', function()
{
    include public_path().'/ajax/datosDependencia.php';
});

Route::get('datosSerie', function()
{
    include public_path().'/ajax/datosSerie.php';
});

Route::get('datosSubSerie', function()
{
    include public_path().'/ajax/datosSubSerie.php';
});

Route::get('datosMetadato', function()
{
    include public_path().'/ajax/datosMetadato.php';
});

Route::get('datosSistemaInformacion', function()
{
    include public_path().'/ajax/datosSistemaInformacion.php';
});

Route::get('datosSitioWeb', function()
{
    include public_path().'/ajax/datosSitioWeb.php';
});

Route::get('datosNormograma', function()
{
    include public_path().'/ajax/datosNormograma.php';
});

Route::get('datosFuncion', function()
{
    include public_path().'/ajax/datosFuncion.php';
});

Route::get('datosDocumento', function()
{
    include public_path().'/ajax/datosDocumento.php';
});

Route::get('datosRetencion', function()
{
    include public_path().'/ajax/datosRetencion.php';
});

Route::get('datosDependenciaSelect', function()
{
    include public_path().'/ajax/datosDependenciaSelect.php';
});

Route::get('datosEtiqueta', function()
{
    include public_path().'/ajax/datosEtiqueta.php';
});

Route::get('datosRolSelect', function()
{
    include public_path().'/ajax/datosRolSelect.php';
});

Route::get('datosEtiquetaSelect', function()
{
    include public_path().'/ajax/datosEtiquetaSelect.php';
});

Route::get('datosDocumentoSelect', function()
{
    include public_path().'/ajax/datosDocumentoSelect.php';
});

Route::get('datosLista', function()
{
    include public_path().'/ajax/datosLista.php';
});

Route::get('datosListaSelect', function()
{
    include public_path().'/ajax/datosListaSelect.php';
});

Route::get('datosCompaniaSelect', function()
{
    include public_path().'/ajax/datosCompaniaSelect.php';
});

Route::get('datosMetadatoSelect', function()
{
    include public_path().'/ajax/datosMetadatoSelect.php';
});

/***************************Rutas de los controladores**************************/

    Route::resource('sistemainformacion','SistemaInformacionController');
    Route::resource('normograma','NormogramaController');
    Route::resource('sitioweb','SitioWebController');
    Route::resource('dependencia','DependenciaController');
    Route::resource('serie','SerieController');
    Route::resource('subserie','SubSerieController');
    Route::resource('metadato','MetadatoController');
    Route::resource('documento','DocumentoController');
    Route::resource('retencion','RetencionController');
    Route::resource('clasificaciondocumental','ClasificacionDocumentalController');
    Route::resource('dependenciaselect','DependenciaSelectController');
    Route::resource('etiqueta','EtiquetaController');
    Route::resource('etiquetaselect','EtiquetaSelectController');
    Route::resource('rolselect','RolSelectController');
    Route::resource('radicado','RadicadoController');
    Route::resource('lista','ListaController');
    Route::resource('consultaradicado','ConsultaRadicadoController');
    Route::resource('gridMetadatos','GridMetadatosController');
    Route::resource('formulario','FormularioController');
    Route::resource('gridFormulario','GridFormularioController');
    Route::resource('consultaradicadofiltro','ConsultaRadicadoFiltroController');



/****************************Rutas AJAX***********************************/

Route::post('armarMetadatosDocumento', function()
{
    include public_path().'/ajax/armarMetadatosDocumento.php';
});

Route::get('datosMetadatos', function()
{
    include public_path().'/ajax/datosMetadatos.php';
});

Route::get('datosFormulario', function()
{
    include public_path().'/ajax/datosFormulario.php';
});

Route::post('llamarPreview', function()
{
    include public_path().'/ajax/llamarPreview.php';
});

Route::post('armarMetadatosConsultaRadicado', function()
{
    include public_path().'/ajax/armarMetadatosConsultaRadicado.php';
});

Route::post('armarMetadatosConsultaFormulario', function()
{
    include public_path().'/ajax/armarMetadatosConsultaFormulario.php';
});

Route::get('imprimir', function()
{
    include public_path().'/ajax/imprimir.php';
});

Route::get('armarGrid', function()
{
    include public_path().'/ajax/armarGrid.php';
});

Route::post('enviarEmail', function()
{
    include public_path().'/ajax/enviarEmail.php';
});

Route::post('descargaMasiva', function()
{
    include public_path().'/ajax/descargaMasiva.php';
});

Route::post('impresionMasiva', function()
{
    include public_path().'/ajax/impresionMasiva.php';
});

Route::post('emailMasivo', function()
{
    include public_path().'/ajax/emailMasivo.php';
});

Route::post('eliminarMasivo', function()
{
    include public_path().'/ajax/eliminarMasivo.php';
});

Route::get('cargar', 'RadicadoController@cargar');

Route::get('download', 'RadicadoController@download');

Route::get('eliminarRadicado/delete/{id}', 'RadicadoController@destroy');

Route::post('conexion', function()
{
    include public_path().'/ajax/conexion.php';
});

Route::post('conexionDocumento', function()
{
    include public_path().'/ajax/conexionDocumento.php';
});

Route::post('conexionDocumentoCampos', function()
{
    include public_path().'/ajax/conexionDocumentoCampos.php';
});

Route::post('consultaMetadatos', function()
{
    include public_path().'/ajax/consultaMetadatos.php';
});

Route::post('armarMetadatosVersion', function()
{
    include public_path().'/ajax/armarMetadatosVersion.php';
});

Route::post('numeroRadicadoVersion', function()
{
    include public_path().'/ajax/numeroRadicadoVersion.php';
});

Route::post('numeroFormularioVersion', function()
{
    include public_path().'/ajax/numeroFormularioVersion.php';
});

Route::post('listarVersiones', function()
{
    include public_path().'/ajax/listarVersiones.php';
});

Route::post('armarMetadatosFormulario', function()
{
    include public_path().'/ajax/armarMetadatosFormulario.php';
});

Route::post('armarMetadatosVersionFormulario', function()
{
    include public_path().'/ajax/armarMetadatosVersionFormulario.php';
});

Route::post('duplicarDocumento', function()
{
    include public_path().'/ajax/duplicarDocumento.php';
});

Route::post('llenarDatosMultiregistro', function()
{
    include public_path().'/ajax/llenarDatosMultiregistro.php';
});

Route::post('consultarCamposMetadatoDocumento', function()
{
    include public_path().'/ajax/consultarCamposMetadatoDocumento.php';
});


//********************RUTAS DEL MISMO CONTROLADOR**********************
Route::get('dropzone','RadicadoController@indexdropzone');
Route::post('dropzone/uploadFilesRadicado', 'RadicadoController@uploadFiles'); 

Route::get('etiquetaselect}', [
    'as' => 'etiquetaselect', 'uses' => 'RadicadoController@indexEtiquetaGrid'
]);

Route::get('etiquetaselect}', [
    'as' => 'etiquetaselect', 'uses' => 'ConsultarRadicadoController@indexEtiquetaGridConsulta'
]);
Route::get('gridMetadatos}', [
    'as' => 'gridMetadatos', 'uses' => 'ConsultarRadicadoController@indexGridMetadatos'
]);

Route::get('gridFormulario}', [
    'as' => 'gridFormulario', 'uses' => 'FormularioController@indexGridFormulario'
]);

Route::get('documentoselect','DocumentoController@indexDocumentoGrid');

Route::get('companiaselect','CompaniaController@indexCompaniaGrid');

Route::get('metadatoselect','MetadatoController@indexMetadatoGrid');