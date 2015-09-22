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

/*Route::get('/', function()
{
	return view('welcome');
});*/

// Creamos un Controlador para gestionar la autenticación en HomeController.
//Route::controller('/','HomeController');

//Route::get('/asisge', 'HomeController@index');
/*Route::controllers([
		"auth" 		=> "Auth\AuthController",
		"password" 	=> "Auth\PasswordController"
	]);	*/


// ---------------------------------
// Opciones del modulo de seguridad
// ---------------------------------




Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', ['as' =>'auth/login', 'uses' => 'Auth\AuthController@postLogin']);
Route::get('auth/logout', ['as' => 'auth/logout', 'uses' => 'Auth\AuthController@getLogout']);
 
Route::get('/usersgrid', function()
{
	return view('usersgridphp');
});

Route::get('/paquetegrid', function()
{
	return view('paquetegridphp');
});

Route::get('/opciongrid', function()
{
	return view('opciongridphp');
});

Route::get('/opciongridselect', function()
{
	return view('opciongridphpselect');
});

Route::get('/rolgrid', function()
{
	return view('rolgridphp');
});

Route::resource('users','UsersController');
Route::resource('paquete','PaqueteController');
Route::resource('opcion','OpcionController');
Route::resource('opcionselect','OpcionController@select');
Route::resource('rol','RolController');

// ---------------------------------
// Archivos Maestros
// ---------------------------------
Route::get('/paisgrid', function()
{
	return view('paisgridphp');
});

Route::get('/departamentogrid', function(){
	return view('departamentogridphp');
});


Route::get('/ciudadgrid', function(){
	return view('ciudadgridphp');
});

Route::get('/tipoidentificaciongrid', function()
{
	return view('tipoidentificaciongridphp');
});

Route::get('/frecuenciamediciongrid', function()
{
	return view('frecuenciamediciongridphp');
});

Route::get('/procesogrid', function()
{
	return view('procesogridphp');
});

Route::get('/companiagrid', function()
{
	return view('companiagridphp');
});

Route::get('/tercerogrid', function()
{
	return view('tercerogridphp');
});

Route::get('/clasificacionriesgogrid', function()
{
	return view('clasificacionriesgogridphp');
});

Route::get('/tiporiesgogrid', function()
{
	return view('tiporiesgogridphp');
});

Route::get('/listageneralgrid', function()
{
	return view('listageneralgridphp');
});

Route::resource('listageneral','ListaGeneralController');
Route::resource('pais','PaisController');
Route::resource('departamento','DepartamentoController');
Route::resource('ciudad','CiudadController');
Route::resource('tipoidentificacion','TipoIdentificacionController');
Route::resource('frecuenciamedicion','FrecuenciaMedicionController');
Route::resource('proceso','ProcesoController');
Route::resource('compania','CompaniaController');
Route::resource('tercero','TerceroController');
Route::resource('clasificacionriesgo','ClasificacionRiesgoController');
Route::resource('tiporiesgo','TipoRiesgoController');


// ---------------------------------
// Documentos
// ---------------------------------


Route::get('/diagnosticogrid', function()
{
	return view('diagnosticogridphp');
});

Route::get('/matrizriesgogrid', function()
{
	return view('matrizriesgogridphp');
});

Route::resource('diagnostico','DiagnosticoController');
Route::resource('cuadromando','CuadroMandoController');
Route::resource('matrizriesgo','MatrizRiesgoController');
Route::get('buscar', 'MatrizRiesgoController@buscar');