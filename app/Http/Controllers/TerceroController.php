<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\TerceroRequest;
use App\Http\Controllers\Controller;

//use Intervention\Image\ImageManagerStatic as Image;
use Input;
use File;
// include composer autoload
//require '../vendor/autoload.php';
// import the Intervention Image Manager Class
use Intervention\Image\ImageManager ;

class TerceroController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('tercerogrid');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $ciudad = \App\Ciudad::All()->lists('nombreCiudad','idCiudad');
        $tipoIdentificacion = \App\TipoIdentificacion::All()->lists('nombreTipoIdentificacion','idTipoIdentificacion');
        return view('tercero',compact('ciudad','tipoIdentificacion'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(TerceroRequest $request)
    {
        $image = Input::file('imagenTercero');
        $imageName = $request->file('imagenTercero')->getClientOriginalName();
        $manager = new ImageManager();
        $manager->make($image->getRealPath())->heighten(56)->save('images/terceros/'. $imageName);

        \App\Tercero::create([
            'TipoIdentificacion_idTipoIdentificacion'  => (isset($request['TipoIdentificacion_idTipoIdentificacion']) ? $request['TipoIdentificacion_idTipoIdentificacion'] : 0),
            'documentoTercero' => $request['documentoTercero'],
            'nombre1Tercero' => $request['nombre1Tercero'],
            'nombre2Tercero' => $request['nombre2Tercero'],
            'apellido1Tercero' => $request['apellido1Tercero'],
            'apellido2Tercero' => $request['apellido2Tercero'],
            'nombreCompletoTercero' => $request['nombreCompletoTercero'],
            'fechaCreacionTercero' => $request['fechaCreacionTercero'],
            'estadoTercero' => $request['estadoTercero'],
            'imagenTercero' => 'terceros\\'. $imageName,
            'tipoTercero' => $request['tipoTercero'],
            'direccionTercero' => $request['direccionTercero'],
            'Ciudad_idCiudad' => $request['Ciudad_idCiudad'],
            'telefonoTercero' => $request['telefonoTercero'],
            'faxTercero' => $request['faxTercero'],
            'movil1Tercero' => $request['movil1Tercero'],
            'movil2Tercero' => $request["movil2Tercero"],
            'sexoTercero' => $request['sexoTercero'],
            'fechaNacimientoTercero' => $request['fechaNacimientoTercero'],
            'correoElectronicoTercero' => $request['correoElectronicoTercero'],
            'paginaWebTercero' => $request['paginaWebTercero'],
            'Cargo_idCargo' => 1,
            'Compania_idCompania' => 1
            ]);
        
        $tercero = \App\Tercero::All()->last();
        $contadorContacto = count($request['nombreTerceroContacto']);
        for($i = 0; $i < $contadorContacto; $i++)
        {
            \App\TerceroContacto::create([
            'Tercero_idTercero' => $tercero->idTercero,
            'nombreTerceroContacto' => $request['nombreTerceroContacto'][$i],
            'cargoTerceroContacto' => $request['cargoTerceroContacto'][$i],
            'telefonoTerceroContacto' => $request['telefonoTerceroContacto'][$i],
            'movilTerceroContacto' => $request['movilTerceroContacto'][$i],
            'correoElectronicoTerceroContacto' => $request['correoElectronicoTerceroContacto'][$i]
           ]);
        }
        
        $contadorProducto = count($request['codigoTerceroProducto']);
        for($i = 0; $i < $contadorProducto; $i++)
        {
            \App\TerceroProducto::create([
            'Tercero_idTercero' => $tercero->idTercero,
            'codigoTerceroProducto' => $request['codigoTerceroProducto'][$i],
            'nombreTerceroProducto' => $request['nombreTerceroProducto'][$i]
           ]);
        }
        return redirect('/tercero');
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
        $ciudad = \App\Ciudad::All()->lists('nombreCiudad','idCiudad');
        $tipoIdentificacion = \App\TipoIdentificacion::All()->lists('nombreTipoIdentificacion','idTipoIdentificacion');
        $tercero = \App\Tercero::find($id);
        return view('tercero',compact('ciudad','tipoIdentificacion'),['tercero'=>$tercero]);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(TerceroRequest $request, $id)
    {

        $tercero = \App\Tercero::find($id);
        $tercero->fill($request->all());

        if(null !== Input::file('imagenTercero') )
        {
            $image = Input::file('imagenTercero');
            $imageName = $request->file('imagenTercero')->getClientOriginalName();
            $manager = new ImageManager();
            $manager->make($image->getRealPath())->heighten(56)->save('images/terceros/'. $imageName);

            $tercero->imagenTercero = 'terceros\\'. $imageName;
        }   

        $tercero->save();

        \App\TerceroContacto::where('Tercero_idTercero',$id)->delete();
        \App\TerceroProducto::where('Tercero_idTercero',$id)->delete();
        $contadorContacto = count($request['nombreTerceroContacto']);
        for($i = 0; $i < $contadorContacto; $i++)
        {
            \App\TerceroContacto::create([
            'Tercero_idTercero' => $id,
            'nombreTerceroContacto' => $request['nombreTerceroContacto'][$i],
            'cargoTerceroContacto' => $request['cargoTerceroContacto'][$i],
            'telefonoTerceroContacto' => $request['telefonoTerceroContacto'][$i],
            'movilTerceroContacto' => $request['movilTerceroContacto'][$i],
            'correoElectronicoTerceroContacto' => $request['correoElectronicoTerceroContacto'][$i]
           ]);
        }
        $contadorProducto = count($request['codigoTerceroProducto']);
        for($i = 0; $i < $contadorProducto; $i++)
        {
            \App\TerceroProducto::create([
            'Tercero_idTercero' => $id,
            'codigoTerceroProducto' => $request['codigoTerceroProducto'][$i],
            'nombreTerceroProducto' => $request['nombreTerceroProducto'][$i]
           ]);
        }
        return redirect('/tercero');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        \App\Tercero::destroy($id);
        return redirect('/tercero');
    }
}