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
 

 
Route::group(['middleware' => 'auth'], function () 
{

	Route::get('datos', function()
	{
		return view('layouts.principal');
	});

	Route::get('dashboard', function()
	{
		return view('layouts.tablero');
	});

	Route::get('firma', function()
	{
		return view('signaturepad');
	});

	Route::get('calcularCuadroMando', function()
	{
		include public_path().'/ajax/calcularCuadroMando.php';
	});

	// Route::get('importarTerceroProveedor', function()
	// {
	// 	include public_path().'/ajax/importarTerceroProveedor.php';
	// });

	Route::post('importarTerceroProveedor', [
		'as' => 'importarTerceroProveedor', 
		'uses' => 'TerceroController@importarTerceroProveedor']);

	// Creamos un Controlador para gestionar la autenticación en HomeController.
	//Route::controller('/','HomeController');

	//Route::get('datosasisge', 'HomeController@index');
	/*Route::controllers([
			"auth" 		=> "Auth\AuthController",
			"password" 	=> "Auth\PasswordController"
		]);	*/


	

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

	Route::resource('users','UsersController');
	Route::resource('paquete','PaqueteController');
	Route::resource('opcion','OpcionController');
	Route::resource('opcionselect','OpcionController@select');
	Route::resource('rol','RolController');

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

	Route::get('datosDocumento', function()
	{
		include public_path().'/ajax/datosDocumento.php';
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

	Route::post('consultarPermisos', function()
	{
	    include public_path().'/ajax/consultarPermisos.php';
	});

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
	Route::resource('documento','DocumentoController');
	Route::resource('tipoinspeccion','TipoInspeccionController');
	Route::resource('tipoexamenmedico','TipoExamenMedicoController');
	Route::resource('tipoelementoproteccion','TipoElementoProteccionController');
	Route::resource('elementoproteccion','ElementoProteccionController');


	//Ajax de Maestros
	Route::post('llenarCargo', function()
	{
	    include public_path().'/ajax/llenarCargo.php';
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


	Route::get('datosGrupoApoyo', function()
	{
		include public_path().'/ajax/datosGrupoApoyo.php';
	});

	Route::get('datosConformacionGrupoApoyo', function()
	{
		include public_path().'/ajax/datosConformacionGrupoApoyo.php';
	});

	Route::get('datosActaGrupoApoyo', function()
	{
		include public_path().'/ajax/datosActaGrupoApoyo.php';
	});

	Route::get('datosEntregaElementoProteccion', function()
	{
	    include public_path().'/ajax/datosEntregaElementoProteccion.php';
	});

	Route::get('datosCuadroMando', function()
	{
	    include public_path().'/ajax/datosCuadroMando.php';
	});

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


	Route::get('datosDocumentoCRM', function()
	{
	    include public_path().'/ajax/datosDocumentoCRM.php';
	});
	Route::get('datosMovimientoCRM', function()
	{
	    include public_path().'/ajax/datosMovimientoCRM.php';
	});

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

	Route::get('campocrmgridselect','DocumentoCRMController@indexCampoCRMGrid');
	Route::get('companiagridselect','DocumentoCRMController@indexCompaniaGrid');
	Route::get('rolgridselect','DocumentoCRMController@indexRolGrid');
});

Route::get('dropzone','TerceroController@indexdropzone');
Route::post('dropzone/uploadFiles', 'TerceroController@uploadFiles'); 