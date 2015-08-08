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

Route::get('/paisgrid', function()
{
	return view('paisgridphp');
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
Route::resource('tipoidentificacion','TipoIdentificacionController');
Route::resource('frecuenciamedicion','FrecuenciaMedicionController');
Route::resource('compania','CompaniaController');