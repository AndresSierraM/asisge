<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
 use App\Http\Requests\OrdenProduccionRequest;

//use Intervention\Image\ImageManagerStatic as Image;
use Input;
use File;
// include composer autoload
require '../vendor/autoload.php';



use Illuminate\Routing\Route;
use DB;
include public_path().'/ajax/consultarPermisos.php';


class ConsultaOrdenProduccionController extends Controller
{
        public function index()
    {
        $vista = basename($_SERVER["PHP_SELF"]);
        $datos = consultarPermisos($vista);

        if($datos != null)
            return view('consultaordenproducciongrid', compact('datos'));
        else
            return view('accesodenegado');


    }
}
