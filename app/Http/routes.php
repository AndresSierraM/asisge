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

Route::get('/', function()
{
	return view('welcome');
});

Route::get('/asisge', function()
{
	return view('layouts.menuprincipal');
});

// ---------------------------------
// Opciones del modulo de seguridad
// ---------------------------------
Route::get('/usuariogrid', function()
{
	return view('usuariogridphp');
});

Route::get('/paquetegrid', function()
{
	return view('paquetegridphp');
});

Route::get('/opciongrid', function()
{
	return view('opciongridphp');
});

Route::resource('usuario','UsuarioController');
Route::resource('paquete','PaqueteController');
Route::resource('opcion','OpcionController');


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

Route::get('/companiagrid', function()
{
	return view('companiagridphp');
});

Route::resource('pais','PaisController');
Route::resource('departamento','DepartamentoController');
Route::resource('ciudad','CiudadController');

Route::resource('tipoidentificacion','TipoIdentificacionController');
Route::resource('frecuenciamedicion','FrecuenciaMedicionController');
Route::resource('compania','CompaniaController');



// ---------------------------------
// Documentos
// ---------------------------------
