<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\FichaTecnicaRequest;

//use Intervention\Image\ImageManagerStatic as Image;
use Input;
use File;
// include composer autoload
require '../vendor/autoload.php';
// import the Intervention Image Manager Class
use Intervention\Image\ImageManager ;


use Illuminate\Routing\Route;
use DB;
include public_path().'/ajax/consultarPermisos.php';
use Carbon;

class FichaTecnicaController extends Controller
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
        $this->fichatecnica = \App\FichaTecnica::find($route->getParameter('fichatecnica'));
        return $this->fichatecnica;
    }

    public function index()
    {
        $vista = basename($_SERVER["PHP_SELF"].'?tipo='.$_GET['tipo']);
        $datos = consultarPermisos($vista);

        if($datos != null)
            return view('fichatecnicagrid', compact('datos'));
        else
            return view('accesodenegado');


    }

    public function indexSelect()
    {
            return view('fichatecnicagridselect');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $linea = \App\LineaProducto::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('nombreLineaProducto','idLineaProducto');
      

        if($_GET['tipo'] == 'p')
        {
            $tercero = \App\Tercero::where('Compania_idCompania','=', \Session::get('idCompania'))
                        ->where('tipoTercero','like','%03%')
                        ->lists('nombreCompletoTercero','idTercero');
        }
        else
        {
            $tercero = \App\Tercero::where('Compania_idCompania','=', \Session::get('idCompania'))
                        ->where('tipoTercero','like','%02%')
                        ->lists('nombreCompletoTercero','idTercero');
        }
        
        return view('fichatecnica', compact('linea','sublinea','tercero'));
    }

    
    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(FichaTecnicaRequest $request)
    {
       if($request['respuesta'] != 'falso')
        {  
            \App\FichaTecnica::create([
                'tipoFichaTecnica' => $request['tipoFichaTecnica'],
                'referenciaFichaTecnica' => $request['referenciaFichaTecnica'],
                'nombreFichaTecnica' => $request['nombreFichaTecnica'],
                'fechaCreacionFichaTecnica' => $request['fechaCreacionFichaTecnica'],
                'estadoFichaTecnica' => $request['estadoFichaTecnica'],
                'LineaProducto_idLineaProducto' => $request['LineaProducto_idLineaProducto'],
                'SublineaProducto_idSublineaProducto' => ($request['SublineaProducto_idSublineaProducto'] == '' ? null : $request['SublineaProducto_idSublineaProducto']),
                'Tercero_idTercero' => ($request['Tercero_idTercero'] == '' ? null : $request['Tercero_idTercero']),
                'observacionFichaTecnica' => $request['observacionFichaTecnica'],
                'Compania_idCompania' => \Session::get('idCompania')
                ]);

            $fichatecnica = \App\FichaTecnica::All()->last();

            $this->grabarDetalle($fichatecnica->idFichaTecnica, $request);


            $arrayImage = $request['imagenFichaTecnicaArray'];
            $arrayImage = substr($arrayImage, 0, strlen($arrayImage)-1);
            $arrayImage = explode(",", $arrayImage);
            $ruta = '';
            for ($i=0; $i < count($arrayImage) ; $i++) 
            { 
                if ($arrayImage[$i] != '' || $arrayImage[$i] != 0) 
                {
                    $origen = public_path() . '/imagenes/repositorio/temporal/'.$arrayImage[$i];
                    $destinationPath = public_path() . '/imagenes/fichatecnica/'.$arrayImage[$i];
                    $ruta = '/fichatecnica/'.$arrayImage[$i];
                   
                    if (file_exists($origen))
                    {
                        copy($origen, $destinationPath);
                        unlink($origen);
                    }   
                    else
                    {
                        echo "No existe la imagen";
                    }
                    \App\FichaTecnicaImagen::create([
                    'FichaTecnica_idFichaTecnica' => $fichatecnica->idFichaTecnica,
                    'tituloFichaTecnicaImagen' => "", 
                    'rutaFichaTecnicaImagen' => $ruta
                   ]);
                }

            }
            


            $arrayImage = $request['archivoFichaTecnicaArray'];
            $arrayImage = substr($arrayImage, 0, strlen($arrayImage)-1);
            $arrayImage = explode(",", $arrayImage);
            $ruta = '';
            for ($i=0; $i < count($arrayImage) ; $i++) 
            { 
                if ($arrayImage[$i] != '' || $arrayImage[$i] != 0) 
                {
                    $origen = public_path() . '/imagenes/repositorio/temporal/'.$arrayImage[$i];
                    $destinationPath = public_path() . '/imagenes/fichatecnica/'.$arrayImage[$i];
                    $ruta = '/fichatecnica/'.$arrayImage[$i];
                   
                    if (file_exists($origen))
                    {
                        copy($origen, $destinationPath);
                        unlink($origen);
                    }   
                    else
                    {
                        echo "No existe el archivo";
                    }
                    \App\FichaTecnicaArchivo::create([
                    'FichaTecnica_idFichaTecnica' => $fichatecnica->idFichaTecnica,
                    'rutaFichaTecnicaArchivo' => $ruta
                   ]);
                }

            }
            return redirect('/fichatecnica?tipo='.$request['tipoFichaTecnica']);

        }
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
        $fichatecnica = \App\FichaTecnica::find($id);

        $proceso = DB::select(
            'SELECT idFichaTecnicaProceso, 
                    ordenFichaTecnicaProceso,
                    Proceso_idProceso,
                    nombreProceso,
                    observacionFichaTecnicaProceso
            FROM fichatecnicaproceso FTP
            LEFT JOIN proceso P 
            ON FTP.Proceso_idProceso = P.idProceso
            WHERE FichaTecnica_idFichaTecnica = '.$id.' 
            Order by ordenFichaTecnicaProceso');

        $proceso = $this->convertirArray($proceso);

        $material = DB::select(
            'SELECT idFichaTecnicaMaterial, 
                    FichaTecnica_idMaterial,
                    referenciaFichaTecnica as referenciaFichaTecnicaMaterial, 
                    nombreFichaTecnica as nombreFichaTecnicaMaterial, 
                    Proceso_idProceso as Proceso_idMaterial, 
                    consumoFichaTecnicaMaterial, 
                    observacionFichaTecnicaMaterial
            FROM fichatecnicamaterial FTM
            LEFT JOIN fichatecnica FT 
            ON FTM.FichaTecnica_idMaterial = FT.idFichaTecnica
            WHERE FichaTecnica_idFichaTecnica = '.$id);

        $material = $this->convertirArray($material);

        $operacion = DB::select(
            'SELECT idFichaTecnicaOperacion, 
                    Proceso_idProceso as Proceso_idOperacion,
                    ordenFichaTecnicaOperacion, 
                    nombreFichaTecnicaOperacion, 
                    samFichaTecnicaOperacion, 
                    observacionFichaTecnicaOperacion
            FROM fichatecnicaoperacion FTO
            WHERE FichaTecnica_idFichaTecnica = '.$id);

        $operacion = $this->convertirArray($operacion);

        $nota = DB::select(
            'SELECT idFichaTecnicaNota, 
                    Users_idUsuario,
                    name as nombreUsuario,
                    fechaFichaTecnicaNota,
                    observacionFichaTecnicaNota
            FROM fichatecnicanota FTN 
            LEFT JOIN users U 
            ON FTN.Users_idUsuario = U.id 
            WHERE FichaTecnica_idFichaTecnica = '.$id);

        $nota = $this->convertirArray($nota);

        $linea = \App\LineaProducto::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('nombreLineaProducto','idLineaProducto');
  

        if($_GET['tipo'] == 'p')
        {
            $tercero = \App\Tercero::where('Compania_idCompania','=', \Session::get('idCompania'))
                        ->where('tipoTercero','like','%03%')
                        ->lists('nombreCompletoTercero','idTercero');
        }
        else
        {
            $tercero = \App\Tercero::where('Compania_idCompania','=', \Session::get('idCompania'))
                        ->where('tipoTercero','like','%02%')
                        ->lists('nombreCompletoTercero','idTercero');
        }
        
        return view('fichatecnica', ['fichatecnica'=>$fichatecnica], compact('linea','sublinea','tercero', 'proceso', 'material', 'operacion','nota'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(FichaTecnicaRequest $request, $id)
    {
       if($request['respuesta'] != 'falso')
        { 
            $fichatecnica = \App\FichaTecnica::find($id);
            $fichatecnica->fill($request->all());
            $fichatecnica->SublineaProducto_idSublineaProducto = ($request['SublineaProducto_idSublineaProducto'] == '' ? null : $request['SublineaProducto_idSublineaProducto']);
            $fichatecnica->Tercero_idTercero = ($request['Tercero_idTercero'] == '' ? null : $request['Tercero_idTercero']);
            $fichatecnica->save();

            $this->grabarDetalle($id, $request);

            // HAGO UN INSERT A LOS NUEVOS ARCHIVOS SUBIDOS EN EL DROPZONE
            if ($request['archivoFichaTecnicaArray'] != '') 
            {
                $arrayImage = $request['archivoFichaTecnicaArray'];
                $arrayImage = substr($arrayImage, 0, strlen($arrayImage)-1);
                $arrayImage = explode(",", $arrayImage);
                $ruta = '';

                for($i = 0; $i < count($arrayImage); $i++)
                {
                    if ($arrayImage[$i] != '' || $arrayImage[$i] != 0) 
                    {
                        $origen = public_path() . '/imagenes/repositorio/temporal/'.$arrayImage[$i];
                        $destinationPath = public_path() . '/imagenes/fichatecnica/'.$arrayImage[$i];
                        
                        if (file_exists($origen))
                        {
                            copy($origen, $destinationPath);
                            unlink($origen);
                            $ruta = '/fichatecnica/'.$arrayImage[$i];

                            DB::table('fichatecnicaarchivo')->insert([
                                'idFichaTecnicaArchivo' => '0', 
                                'FichaTecnica_idFichaTecnica' =>$id,
                                'rutaFichaTecnicaArchivo' => $ruta]);
                        }   
                        else
                        {
                            echo "No existe el archivo";
                        }
                    }
                }
            }
            // ELIMINO LOS ARCHIVOS
            $idsEliminar = $request['eliminarArchivo'];
            $idsEliminar = substr($idsEliminar, 0, strlen($idsEliminar)-1);
            if($idsEliminar != '')
            {
                $idsEliminar = explode(',',$idsEliminar);
                \App\FichaTecnicaArchivo::whereIn('idFichaTecnicaArchivo',$idsEliminar)->delete();
            }


            // HAGO UN INSERT A LOS NUEVOS ARCHIVOS SUBIDOS EN EL DROPZONE
            if ($request['imagenFichaTecnicaArray'] != '') 
            {
                $arrayImage = $request['imagenFichaTecnicaArray'];
                $arrayImage = substr($arrayImage, 0, strlen($arrayImage)-1);
                $arrayImage = explode(",", $arrayImage);
                $ruta = '';
                for ($i=0; $i < count($arrayImage) ; $i++) 
                { 
                    if ($arrayImage[$i] != '' || $arrayImage[$i] != 0) 
                    {
                        $origen = public_path() . '/imagenes/repositorio/temporal/'.$arrayImage[$i];
                        $destinationPath = public_path() . '/imagenes/fichatecnica/'.$arrayImage[$i];
        
                        if (file_exists($origen))
                        {
                            copy($origen, $destinationPath);
                            unlink($origen);
                            $ruta = '/fichatecnica/'.$arrayImage[$i];


                        DB::table('fichatecnicaimagen')->insert([
                                'idFichaTecnicaImagen' => '0',
                                'observacionFichaTecnicaImagen' => '',
                                'FichaTecnica_idFichaTecnica' =>$id,
                                'rutaFichaTecnicaImagen' => $ruta]);
                        }   
                        else
                        {
                            echo "No existe la imagen";
                        }
                      
                    }

                }
            }
            // ELIMINO LOS ARCHIVOS
            $idsEliminar = $request['eliminarImagen'];
            $idsEliminar = substr($idsEliminar, 0, strlen($idsEliminar)-1);
            if($idsEliminar != '')
            {
                $idsEliminar = explode(',',$idsEliminar);
                \App\FichaTecnicaImagen::whereIn('idFichaTecnicaImagen',$idsEliminar)->delete();
            }
           return redirect('/fichatecnica?tipo='.$request['tipoFichaTecnica']);

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy(Request $request,$id)
    {
                                                                                                //Se pone FichaTecnica_id para que solo consulte los que empiezan por esa palabra y se pone la condicion (and...not like)de que no busque ficha en miniscula para las tablas hijas de ficha
         $consulta = DB::Select("SELECT TABLE_NAME, COLUMN_NAME FROM information_schema.`COLUMNS` WHERE COLUMN_NAME like 'FichaTecnica_id%' and TABLE_SCHEMA = 'sisoft' and TABLE_NAME NOT LIKE 'ficha%'");
         //se crea una variable para concatenar 
        $tablas = ''; 
        // Variable para almancenar el tipo
        $tipo= '';
        if ($request['tipoFichaTecnica'] == 'p') 
        {
            $tipo='Producto';   
        }
        else if($request['tipoFichaTecnica'] == 'm')
        {
            $tipo = 'Materias Primas';
        }
        else
        {
            $tipo= 'Servicio';
        }
        // se crea una variable para el nombre del modulo y en que tipo está
        $nombremodulo = 'Ficha Tecnica Tipo  '.$tipo;
        // esta variable es la que devuelve al formulario
        $nombremoduloformulario = 'fichatecnica?tipo='.$request['tipoFichaTecnica'];


        for ($i=0; $i < count($consulta); $i++)
        {
            $datosconsulta = get_object_vars($consulta[$i]);

            $consultacondicion = DB::Select('SELECT '.$datosconsulta['COLUMN_NAME'].' FROM '.$datosconsulta['TABLE_NAME'].' WHERE '.$datosconsulta['COLUMN_NAME'].' = '. $id);


           if (count($consultacondicion)>0) 
                {   
                    // se concatena el nombre de cada una de las tablas que recorre el ciclo y simplemente se separan por comas
                    $tablas .= $datosconsulta['TABLE_NAME'].', ';

                }   
        }
        if ($tablas != '') 
            {
                 //Se envia la variable tablas a la vista Resources/View/alerta.blade
                return view('alerts.alerta',compact('tablas','nombremodulo','nombremoduloformulario'));
            }
        else
            {
                \App\FichaTecnica::destroy($id);
                return redirect('/fichatecnica?tipo='.$request['tipoFichaTecnica']);
            }
    }


     public function grabarDetalle($id, $request)
    {
        // -----------------------------------
        // PROCESOS
        // en el formulario hay un campo oculto en el que almacenamos los id que se eliminan separados por coma
        // en este proceso lo convertimos en array y eliminamos dichos id de la tabla de detalle
        // -----------------------------------
        $idsEliminar = explode(',', $request['eliminarProceso']);
        \App\FichaTecnicaProceso::whereIn('idFichaTecnicaProceso',$idsEliminar)->delete();

        $contador = count($request['idFichaTecnicaProceso']);
        for($i = 0; $i < $contador; $i++)
        {
            $indice = array(
             'idFichaTecnicaProceso' => $request['idFichaTecnicaProceso'][$i]);

            $data = array(
            'FichaTecnica_idFichaTecnica' => $id,
            'ordenFichaTecnicaProceso' => $request['ordenFichaTecnicaProceso'][$i],
            'Proceso_idProceso' => $request['Proceso_idProceso'][$i],
            'observacionFichaTecnicaProceso' => $request['observacionFichaTecnicaProceso'][$i] );

            $guardar = \App\FichaTecnicaProceso::updateOrCreate($indice, $data);

        }


        // -----------------------------------
        // MATERIALES
        // en el formulario hay un campo oculto en el que almacenamos los id que se eliminan separados por coma
        // en este proceso lo convertimos en array y eliminamos dichos id de la tabla de detalle
        // -----------------------------------
        $idsEliminar = explode(',', $request['eliminarMaterial']);
        \App\FichaTecnicaMaterial::whereIn('idFichaTecnicaMaterial',$idsEliminar)->delete();

        $contador = count($request['idFichaTecnicaMaterial']);
        for($i = 0; $i < $contador; $i++)
        {
            $indice = array(
             'idFichaTecnicaMaterial' => $request['idFichaTecnicaMaterial'][$i]);

            $data = array(
            'FichaTecnica_idFichaTecnica' => $id,
            'FichaTecnica_idMaterial' => $request['FichaTecnica_idMaterial'][$i],
            'Proceso_idProceso' => $request['Proceso_idMaterial'][$i],
            'consumoFichaTecnicaMaterial' => $request['consumoFichaTecnicaMaterial'][$i],
            'observacionFichaTecnicaMaterial' => $request['observacionFichaTecnicaMaterial'][$i] );

            $guardar = \App\FichaTecnicaMaterial::updateOrCreate($indice, $data);

        }


        // -----------------------------------
        // OPERACIONES
        // en el formulario hay un campo oculto en el que almacenamos los id que se eliminan separados por coma
        // en este proceso lo convertimos en array y eliminamos dichos id de la tabla de detalle
        // -----------------------------------
        $idsEliminar = explode(',', $request['eliminarOperacion']);
        \App\FichaTecnicaOperacion::whereIn('idFichaTecnicaOperacion',$idsEliminar)->delete();

        $contador = count($request['idFichaTecnicaOperacion']);
        for($i = 0; $i < $contador; $i++)
        {
            $indice = array(
             'idFichaTecnicaOperacion' => $request['idFichaTecnicaOperacion'][$i]);

            $data = array(
            'FichaTecnica_idFichaTecnica' => $id,
            'ordenFichaTecnicaOperacion' => $request['ordenFichaTecnicaOperacion'][$i],
            'nombreFichaTecnicaOperacion' => $request['nombreFichaTecnicaOperacion'][$i],
            'Proceso_idProceso' => $request['Proceso_idOperacion'][$i],
            'samFichaTecnicaOperacion' => $request['samFichaTecnicaOperacion'][$i],
            'observacionFichaTecnicaOperacion' => $request['observacionFichaTecnicaOperacion'][$i] );

            $guardar = \App\FichaTecnicaOperacion::updateOrCreate($indice, $data);

        }

        // -----------------------------------
        // NOTAS
        // en el formulario hay un campo oculto en el que almacenamos los id que se eliminan separados por coma
        // en este proceso lo convertimos en array y eliminamos dichos id de la tabla de detalle
        // -----------------------------------
        $idsEliminar = explode(',', $request['eliminarNota']);
        \App\FichaTecnicaNota::whereIn('idFichaTecnicaNota',$idsEliminar)->delete();

        $contador = count($request['idFichaTecnicaNota']);
        for($i = 0; $i < $contador; $i++)
        {
            $indice = array(
             'idFichaTecnicaNota' => $request['idFichaTecnicaNota'][$i]);

            $data = array(
            'FichaTecnica_idFichaTecnica' => $id,
            'Users_idUsuario' => $request['Users_idUsuario'][$i],
            'fechaFichaTecnicaNota' => $request['fechaFichaTecnicaNota'][$i],
            'observacionFichaTecnicaNota' => $request['observacionFichaTecnicaNota'][$i] );

            $guardar = \App\FichaTecnicaNota::updateOrCreate($indice, $data);

        }

        // -----------------------------------
        // CRITERIOS
        // en el formulario hay un campo oculto en el que almacenamos los id que se eliminan separados por coma
        // en este proceso lo convertimos en array y eliminamos dichos id de la tabla de detalle
        // -----------------------------------
        $idsEliminar = explode(',', $request['eliminarCriterio']);
        \App\FichaTecnicaCriterio::whereIn('idFichaTecnicaCriterio',$idsEliminar)->delete();
        $contador = count($request['idFichaTecnicaCriterio']);
        for($i = 0; $i < $contador; $i++)
        {
            $indice = array(
             'idFichaTecnicaCriterio' => $request['idFichaTecnicaCriterio'][$i]);
            $data = array(
            'FichaTecnica_idFichaTecnica' => $id,
            'descripcionFichaTecnicaCriterio' => $request['descripcionFichaTecnicaCriterio'][$i]);
            $guardar = \App\FichaTecnicaCriterio::updateOrCreate($indice, $data);
        }

    }

    function convertirArray($dato)
    {
        $nuevo = array();

        for($i = 0; $i < count($dato); $i++) 
        {
          $nuevo[] = get_object_vars($dato[$i]) ;
        }
        return $nuevo;
    }

}
