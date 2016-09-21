<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\EntregaElementoProteccionRequest;
use DB;
include public_path().'/ajax/consultarPermisos.php';

class EntregaElementoProteccionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vista = basename($_SERVER["PHP_SELF"]);
        $datos = consultarPermisos($vista);

        if($datos != null)
            return view('entregaelementoprotecciongrid', compact('datos'));
        else
            return view('accesodenegado');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tercero = \App\Tercero::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('nombreCompletoTercero','idTercero');
        $idElementoProteccion = \App\ElementoProteccion::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('idElementoProteccion');
        $nombreElementoProteccion = \App\ElementoProteccion::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('nombreElementoProteccion');
        return view('entregaelementoproteccion',compact('tercero','idElementoProteccion','nombreElementoProteccion'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EntregaElementoProteccionRequest $request)
    {
       
        if($request['respuesta'] != 'falso')
        {    
            \App\EntregaElementoProteccion::create([
            'Tercero_idTercero' => $request['Tercero_idTercero'],
            'fechaEntregaElementoProteccion' => $request['fechaEntregaElementoProteccion'],
            'Compania_idCompania' => \Session::get('idCompania')
            ]);

            $entregaelementoproteccion = \App\EntregaElementoProteccion::All()->last();
            
            // armamos una ruta para el archivo de imagen y volvemos a actualizar el registro
            // esto es porque la creamos con el ID del accidente y debiamos grabar primero para obtenerlo
            $ruta = 'entregaepp/firmaentregaepp_'.$entregaelementoproteccion->idEntregaElementoProteccion.'.png';
            $entregaelementoproteccion->firmaTerceroEntregaElementoProteccion = $ruta;

            $entregaelementoproteccion->save();

            //----------------------------
            // Guardamos la imagen de la firma como un archivo en disco
            $data = $request['firmabase64'];

            list($type, $data) = explode(';', $data);
            list(, $data)      = explode(',', $data);
            $data = base64_decode($data);

            file_put_contents('imagenes/'.$ruta, $data);

            //----------------------------
            //---------------------------------
            // guardamos las tablas de detalle
            //---------------------------------
            $this->grabarDetalle($entregaelementoproteccion->idEntregaElementoProteccion, $request);

            return redirect('/entregaelementoproteccion');    
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
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
        $entregaelementoproteccion = \App\EntregaElementoProteccion::find($id);
        $tercero = \App\Tercero::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('nombreCompletoTercero','idTercero');
        $idElementoProteccion = \App\ElementoProteccion::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('idElementoProteccion');
        $nombreElementoProteccion = \App\ElementoProteccion::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('nombreElementoProteccion');
        return view('entregaelementoproteccion',compact('tercero','idElementoProteccion','nombreElementoProteccion'),['entregaelementoproteccion'=>$entregaelementoproteccion]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EntregaElementoProteccionRequest $request, $id)
    {
        if($request['respuesta'] != 'falso')
        {    
            $entregaelementoproteccion = \App\EntregaElementoProteccion::find($id);
            $entregaelementoproteccion->fill($request->all());
            
            // armamos una ruta para el archivo de imagen y volvemos a actualizar el registro
            // esto es porque la creamos con el ID del accidente y debiamos grabar primero para obtenerlo
            $ruta = 'entregaepp/firmaentregaepp_'.$entregaelementoproteccion->idEntregaElementoProteccion.'.png';
            $entregaelementoproteccion->firmaTerceroEntregaElementoProteccion = $ruta;

            $entregaelementoproteccion->save();

            //----------------------------
            // Guardamos la imagen de la firma como un archivo en disco
            $data = $request['firmabase64'];

            list($type, $data) = explode(';', $data);
            list(, $data)      = explode(',', $data);
            $data = base64_decode($data);

            file_put_contents('imagenes/'.$ruta, $data);

            //----------------------------

            //---------------------------------
            // guardamos las tablas de detalle
            //---------------------------------
            $this->grabarDetalle($entregaelementoproteccion->idEntregaElementoProteccion, $request);

            return redirect('/entregaelementoproteccion');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        \App\EntregaElementoProteccion::destroy($id);
        return redirect('/entregaelementoproteccion');
    }


    protected function grabarDetalle($id, $request)
    {
        

        // en el formulario hay un campo oculto en el que almacenamos los id que se eliminan separados por coma
        // en este proceso lo convertimos en array y eliminamos dichos id de la tabla de detalle
        $idsEliminar = explode(',', $request['eliminarElemento']);
        \App\EntregaElementoProteccionDetalle::whereIn('idEntregaElementoProteccionDetalle',$idsEliminar)->delete();


        $contadorelementoproteccion = count($request['cantidadEntregaElementoProteccionDetalle']);
        for($i = 0; $i < $contadorelementoproteccion; $i++)
        {

            $indice = array(
             'idEntregaElementoProteccionDetalle' => $request['idEntregaElementoProteccionDetalle'][$i]);

            $data = array(
             'EntregaElementoProteccion_idEntregaElementoProteccion' => $id,
            'cantidadEntregaElementoProteccionDetalle' => $request['cantidadEntregaElementoProteccionDetalle'][$i],
            'ElementoProteccion_idElementoProteccion' => $request['ElementoProteccion_idElementoProteccion'][$i] );

            $preguntas = \App\EntregaElementoProteccionDetalle::updateOrCreate($indice, $data);

        }
    }
}

