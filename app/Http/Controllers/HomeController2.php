<?php namespace App\Http\Controllers;
use Auth;
use Redirect;
use Request;
 // Hash de contraseñas.
use Hash;

class HomeController extends Controller {
 
	/*
	|--------------------------------------------------------------------------
	| Home Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders your application's "dashboard" for users that
	| are authenticated. Of course, you are free to change or remove the
	| controller as you wish. It is just here to get your app started!
	|
	*/
 
	public function getIndex()
	{
		return Redirect::to('login');
	}
 
	// Al acceder a login mostramos un formulario de Login.
	public function getLogin()
	{
		return view('login');
	}
 

 	// Al recibir los datos del formulario de Login.
	public function postLogin()
	{
		$credenciales=array(
			'email'=>Request::input('email'),
			'password'=>Request::input('password')
			);

		if (Auth::attempt($credenciales))
		{
			// En  lugar de redireccionarlo a una página en cuestión lo redireccionamos
			// a la página a la cuál el usuario quería ir antes de estar autenticado en la aplicación.
			// Esa página debería estar identificada en una variable de sesión.
 
			// En el caso de que no ésté en la sesión especificada la URL a la que quería ir
			// se le puede indicar por defecto la URL por defecto a la que ir: ('users') en este caso.
			return view('layouts.bienvenida');
		}
		else
			return Redirect::to('login')->withInput(); //"NO esta bien ".Request::input('email').Request::input('password');
	}
 
 
	// Página de logout.
	public function getLogout()
	{
		Auth::logout();
		return Redirect::to('login');
	}
 
}