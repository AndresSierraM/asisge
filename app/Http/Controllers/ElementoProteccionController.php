<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\ElementoProteccionRequest;
use Illuminate\Routing\Route;

use Input;
use File;
// // include composer autoload
require '../vendor/autoload.php';
// // import the Intervention Image Manager Class
use Intervention\Image\ImageManager;

class ElementoProteccionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('elementoprotecciongrid');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tipoelementoproteccion = \App\TipoElementoProteccion::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('nombreTipoElementoProteccion','idTipoElementoProteccion');
        return view('elementoproteccion',compact('tipoelementoproteccion'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ElementoProteccionRequest $request)
    {
        if(null !== Input::file('imagenElementoProteccion') )
        {
            $image = Input::file('imagenElementoProteccion');
            $imageName = 'proteccion/'. $request->file('imagenElementoProteccion')->getClientOriginalName();
        
            $manager = new ImageManager();
            $manager->make($image->getRealPath())->heighten(200)->save('imagenes/'. $imageName);
            //$manager->make($image->getRealPath())->widen(48)->save('imagenes/'. $imageName);
            //$manager->make($image->getRealPath())->resize(48,48)->save('imagenes/'. $imageName);
        }
        else
        {
            $imageName = "";
        }
        
        \App\ElementoProteccion::create([
            'codigoElementoProteccion' => $request['codigoElementoProteccion'],
            'nombreElementoProteccion' => $request['nombreElementoProteccion'],
            'TipoElementoProteccion_idTipoElementoProteccion'=> $request['TipoElementoProteccion_idTipoElementoProteccion'],
            'normaElementoProteccion' => $request['normaElementoProteccion'],
            'descripcionElementoProteccion' => $request['descripcionElementoProteccion'],
            'procesosElementoProteccion' => $request['procesosElementoProteccion'],
            'imagenElementoProteccion' =>  $imageName,
            'Compania_idCompania' => \Session::get('idCompania')
            ]);
          return redirect('/elementoproteccion');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {   
        $elementoproteccion = \App\ElementoProteccion::find($id);
        $tipoelementoproteccion = \App\TipoElementoProteccion::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('nombreTipoElementoProteccion','idTipoElementoProteccion');
        return view('elementoproteccion',compact('tipoelementoproteccion'),['elementoproteccion'=>$elementoproteccion]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ElementoProteccionRequest $request, $id)
    {
        $elementoproteccion = \App\ElementoProteccion::find($id);
        $elementoproteccion->fill($request->all());

        if(null !== Input::file('imagenElementoProteccion') ){
            $image = Input::file('imagenElementoProteccion');
            $imageName = $request->file('imagenElementoProteccion')->getClientOriginalName();
            $manager = new ImageManager();
            $manager->make($image->getRealPath())->heighten(200)->save('imagenes/proteccion/'. $imageName);

            $elementoproteccion->imagenElementoProteccion = 'proteccion/'. $imageName;
        }

        $elementoproteccion->save();
        

       return redirect('/elementoproteccion');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        \App\ElementoProteccion::destroy($id);
        return redirect('/elementoproteccion');
    }
}
