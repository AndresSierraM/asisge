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

        return view('ausentismogrid', compact('datos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $tercero = \App\Tercero::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('nombreCompletoTercero','idTercero');
        return view('ausentismo',compact('tercero'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(AusentismoRequest $request)
    {

        if(null !== Input::file('archivoAusentismo') )
        {
            $image = Input::file('archivoAusentismo');
            $imageName = 'ausentismo/'. $request->file('archivoAusentismo')->getClientOriginalName();
        
            $manager = new ImageManager();
            $manager->make($image->getRealPath())->heighten(1280)->save('images/'. $imageName);
        }
        else
        {
            $imageName = "";
        }

        \App\Ausentismo::create([
            'Tercero_idTercero' => $request['Tercero_idTercero'],
            'nombreAusentismo' => $request['nombreAusentismo'],
            'fechaElaboracionAusentismo' => $request['fechaElaboracionAusentismo'],
            'tipoAusentismo' => $request['tipoAusentismo'],
            'fechaInicioAusentismo' => $request['fechaInicioAusentismo'],
            'fechaFinAusentismo' => $request['fechaFinAusentismo'],
            'diasAusentismo' => $request['diasAusentismo'],
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
    public function show($id)
    {
        //
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
        $tercero = \App\Tercero::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('nombreCompletoTercero','idTercero');
        return view('ausentismo',compact('tercero'),['ausentismo'=>$ausentismo]);
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
        
        $imageName = "";
        if(null !== Input::file('archivoAusentismo') )
        {
            $image = Input::file('archivoAusentismo');
            $imageName = 'ausentismo/'. $request->file('archivoAusentismo')->getClientOriginalName();
        
            $manager = new ImageManager();
            $manager->make($image->getRealPath())->save('images/'. $imageName);
            
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
