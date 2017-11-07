<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\AusentismoRequest;
use Input;
use File;
use Intervention\Image\ImageManager ;

use Illuminate\Routing\Route;
use DB;
include public_path().'/ajax/consultarPermisos.php';

class AusentismoController extends Controller
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
        $this->ausentismo = \App\Ausentismo::find($route->getParameter('ausentismo'));
        return $this->ausentismo;
    }

    public function index()
    {
        $vista = basename($_SERVER["PHP_SELF"]);
        $datos = consultarPermisos($vista);

        if($datos != null)
            return view('ausentismogrid', compact('datos'));
        else
            return view('accesodenegado');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $centrocosto = \App\CentroCosto::where('Compania_idCompania', "=", \Session::get('idCompania'))->lists('nombreCentroCosto','idCentroCosto');    
        $tercero = \App\Tercero::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('nombreCompletoTercero','idTercero');
        return view('ausentismo',compact('tercero','centrocosto'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(AusentismoRequest $request)
    {


        //-------------------------------------------------------------------------------------------------------------
            // --------------------------------------------------Para  Guardar archivos ---------------------------------
            
           
            $files = Input::file('archivoAusentismo');  // Se recibe el archivo desde el formulario
            $file = $files;
            $rutaImagen = '';   //Se iniciliaza la variable vacia que es que va a contener la ruta 
            $destinationPath = '/ausentismo/';  //Nombre de la carpeta en el disco,public/imagenes una carpeta que se llame ausentismo

        
            if(isset($file))   //Se pregunta si subieron algun archivo (Adjuntaron algo)
            {
 
                $filename = $destinationPath . $file->getClientOriginalName(); // se obtiene el nombre del archivo (la que se subio).
                \Storage::disk('local')->put($filename, \File::get($file)); //Ruta que va a tener en el servidor.
                $rutaImagen = 'ausentismo/'.$file->getClientOriginalName(); //Ruta que va a quedar grabada en la bd por ejemplo ausentimos/imagensubida.jpg

                
                $imageName =  $rutaImagen;   // El campo ['nombre'] le lleve a la ruta $rutaImagen
            }
            else
            {
                $imageName = ""; //si no hay imagen subida se guarda vacia la ruta
            }

        // if(null !== Input::file('archivoAusentismo') )
        // {
        //     $image = Input::file('archivoAusentismo');
        //     $imageName = 'ausentismo/'. $request->file('archivoAusentismo')->getClientOriginalName();
        
        //     $manager = new ImageManager();
        //     $manager->make($image->getRealPath())->heighten(1280)->save('images/'. $imageName);
        // }
        // else
        // {
        //     $imageName = "";
        // }

        \App\Ausentismo::create([
            'Tercero_idTercero' => $request['Tercero_idTercero'],
            'nombreAusentismo' => $request['nombreAusentismo'],
            'fechaElaboracionAusentismo' => $request['fechaElaboracionAusentismo'],
            'tipoAusentismo' => $request['tipoAusentismo'],
            'fechaInicioAusentismo' => $request['fechaInicioAusentismo'],
            'fechaFinAusentismo' => $request['fechaFinAusentismo'],
            'diasAusentismo' => $request['diasAusentismo'],
            'horasAusentismo' => $request['horasAusentismo'],
            'CentroCosto_idCentroCosto' => $request['CentroCosto_idCentroCosto'],
            'Compania_idCompania' => \Session::get('idCompania'),
            'archivoAusentismo' => $imageName

            ]);

            

        return redirect('/ausentismo');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id, Request $request)
    {
        $ausentismoS = DB::SELECT(" 
        SELECT t.nombreCompletoTercero,aus.nombreAusentismo,aus.tipoAusentismo,aus.fechaElaboracionAusentismo,aus.fechaInicioAusentismo,aus.fechaFinAusentismo,aus.diasAusentismo,aus.archivoAusentismo,aus.horasAusentismo,cc.nombreCentroCosto
        FROM ausentismo aus
        LEFT JOIN tercero t 
        ON aus.Tercero_idTercero = t.idTercero
        LEFT JOIN centrocosto cc
        on aus.CentroCosto_idCentroCosto = cc.idCentroCosto
        WHERE aus.idAusentismo = ".$id);

        return view('formatos.ausentismoimpresion',compact('ausentismoS'));
       
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $ausentismo = \App\Ausentismo::find($id);
        $centrocosto = \App\CentroCosto::where('Compania_idCompania', "=", \Session::get('idCompania'))->lists('nombreCentroCosto','idCentroCosto');    
        $tercero = \App\Tercero::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('nombreCompletoTercero','idTercero');

    
        return view('ausentismo',compact('tercero','centrocosto'),['ausentismo'=>$ausentismo]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(AusentismoRequest $request, $id)
    {
        $ausentismo = \App\Ausentismo::find($id);
        $ausentismo->fill($request->all());
        // 
        $imageName = ""; 
        $files = Input::file('archivoAusentismo');  // Se recibe el archivo desde el formulario
        $file = $files;
        $rutaImagen = '';   //Se iniciliaza la variable vacia que es que va a contener la ruta 
        $destinationPath = '/ausentismo/';  //Nombre de la carpeta en el disco,public/imagenes una carpeta que se llame ausentismo

    
        if(isset($file))   //Se pregunta si subieron algun archivo (Adjuntaron algo)
        {

            $filename = $destinationPath . $file->getClientOriginalName(); // se obtiene el nombre del archivo (la que se subio).
            \Storage::disk('local')->put($filename, \File::get($file)); //Ruta que va a tener en el servidor.
            $rutaImagen = 'ausentismo/'.$file->getClientOriginalName(); //Ruta que va a quedar grabada en la bd por ejemplo ausentimos/imagensubida.jpg   
            $imageName =  $rutaImagen;   // El campo ['nombre'] le lleve a la ruta $rutaImagen
            $ausentismo->archivoAusentismo = $imageName;
        }


        
        $ausentismo->save();

        
       return redirect('/ausentismo');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        \App\Ausentismo::destroy($id);
        return redirect('/ausentismo');
    }
}
