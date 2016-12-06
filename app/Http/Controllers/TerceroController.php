<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\TerceroRequest;
use App\Http\Controllers\Controller;

//use Intervention\Image\ImageManagerStatic as Image;
use Input;
use File;
use Validator;
use Response;
use DB;
use Excel;
include public_path().'/ajax/consultarPermisos.php';
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
        $vista = basename($_SERVER["PHP_SELF"]);
        $datos = consultarPermisos($vista);

        if($datos != null)
            return view('tercerogrid', compact('datos'));
        else
            return view('accesodenegado');
    }

    public function indexdropzone() 
    {
        return view('dropzone');
    }

    //Funcion para subir archivos con dropzone
    public function uploadFiles(Request $request) 
    {
 
        $input = Input::all();
 
        $rules = array(
        );
 
        $validation = Validator::make($input, $rules);
 
        if ($validation->fails()) {
            return Response::make($validation->errors->first(), 400);
        }
        
        $destinationPath = public_path() . '/imagenes/repositorio/temporal'; //Guardo en la carpeta  temporal

        $extension = Input::file('file')->getClientOriginalExtension(); 
        $fileName = Input::file('file')->getClientOriginalName(); // nombre de archivo
        $upload_success = Input::file('file')->move($destinationPath, $fileName);
 
        if ($upload_success) {
            return Response::json('success', 200);
        } 
        else {
            return Response::json('error', 400);
        }
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {   
        $idTipoExamen = \App\TipoExamenMedico::All()->lists('idTipoExamenMedico');
        $nombreTipoExamen = \App\TipoExamenMedico::All()->lists('nombreTipoExamenMedico');
        $idFrecuenciaMedicion = \App\FrecuenciaMedicion::All()->lists('idFrecuenciaMedicion');
        $nombreFrecuenciaMedicion = \App\FrecuenciaMedicion::All()->lists('nombreFrecuenciaMedicion');
        $frecuenciaAlcohol = \App\FrecuenciaMedicion::All()->lists('nombreFrecuenciaMedicion','idFrecuenciaMedicion');
        $ciudad = \App\Ciudad::All()->lists('nombreCiudad','idCiudad');
        $tipoIdentificacion = \App\TipoIdentificacion::All()->lists('nombreTipoIdentificacion','idTipoIdentificacion');
        $cargo = \App\Cargo::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('nombreCargo','idCargo');

        $zona = \App\Zona::All()->lists('nombreZona', 'idZona');
        
        $sectorempresa = \App\SectorEmpresa::All()->lists('nombreSectorEmpresa', 'idSectorEmpresa');

        $empleadorcontratista = \App\Tercero::where('tipoTercero', 'like','%*01*%')->where('Compania_idCompania', '=', \Session::get('idCompania'))->lists('nombreCompletoTercero','idTercero');

      
        return view('tercero',compact('ciudad','tipoIdentificacion','cargo','idTipoExamen','nombreTipoExamen','idFrecuenciaMedicion','nombreFrecuenciaMedicion','frecuenciaAlcohol', 'zona', 'sectorempresa','empleadorcontratista'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */


    public function store(TerceroRequest $request)
    {
        if($request['respuesta'] != 'falso')
        { 
            if(null !== Input::file('imagenTercero') )
            {
                $image = Input::file('imagenTercero');
                $imageName = 'tercero/'.$request->file('imagenTercero')->getClientOriginalName();
                $manager = new ImageManager();
                $manager->make($image->getRealPath())->heighten(500)->save('imagenes/'. $imageName);
            }
            else
            {
                $imageName = "";
            }
            \App\Tercero::create([
                'documentoTercero' => $request['documentoTercero'],
                'TipoIdentificacion_idTipoIdentificacion'  => 
                 ( 
                    ($request['TipoIdentificacion_idTipoIdentificacion'] == '' or 
                    $request['TipoIdentificacion_idTipoIdentificacion'] == 0) 
                    ? null 
                    : $request['TipoIdentificacion_idTipoIdentificacion'] 
                 ),
                'nombre1Tercero' => $request['nombre1Tercero'],
                'nombre2Tercero' => $request['nombre2Tercero'],
                'apellido1Tercero' => $request['apellido1Tercero'],
                'apellido2Tercero' => $request['apellido2Tercero'],
                'nombreCompletoTercero' => $request['nombreCompletoTercero'],
                'fechaCreacionTercero' => $request['fechaCreacionTercero'],
                'estadoTercero' => $request['estadoTercero'],
                'imagenTercero' => 'tercero/'. $imageName,
                'tipoTercero' => $request['tipoTercero'],
                'direccionTercero' => $request['direccionTercero'],
                'Ciudad_idCiudad' => $request['Ciudad_idCiudad'],
                'telefonoTercero' => $request['telefonoTercero'],
                'faxTercero' => $request['faxTercero'],
                'movil1Tercero' => $request['movil1Tercero'],
                'movil2Tercero' => $request["movil2Tercero"],
                'sexoTercero' => $request['sexoTercero'],
                'correoElectronicoTercero' => $request['correoElectronicoTercero'],
                'paginaWebTercero' => $request['paginaWebTercero'],
                'Cargo_idCargo' => (($request['Cargo_idCargo'] == '' or $request['Cargo_idCargo'] == 0) ? null : $request['Cargo_idCargo']),
                'Zona_idZona' => (($request['Zona_idZona'] == '' or $request['Zona_idZona'] == 0) ? null : $request['Zona_idZona']),
                'SectorEmpresa_idSectorEmpresa' => (($request['SectorEmpresa_idSectorEmpresa'] == '' or $request['SectorEmpresa_idSectorEmpresa'] == 0) ? null : $request['SectorEmpresa_idSectorEmpresa']),
                'Tercero_idEmpladorContratista' => (($request['Tercero_idEmpladorContratista'] == '' or $request['Tercero_idEmpladorContratista'] == 0) ? null : $request['Tercero_idEmpladorContratista']),
                'Compania_idCompania' => \Session::get('idCompania')
                ]);
            
            $tercero = \App\Tercero::All()->last();

            \App\TerceroInformacion::create([
                    'Tercero_idTercero' => $tercero->idTercero,
                    'fechaNacimientoTerceroInformacion' => $request['fechaNacimientoTerceroInformacion'],
                    'fechaIngresoTerceroInformacion' => $request['fechaIngresoTerceroInformacion'],
                    'fechaRetiroTerceroInformacion' => $request['fechaRetiroTerceroInformacion'],
                    'tipoContratoTerceroInformacion' => $request['tipoContratoTerceroInformacion'],
                    'aniosExperienciaTerceroInformacion' => $request['aniosExperienciaTerceroInformacion'],
                    'educacionTerceroInformacion' => $request['educacionTerceroInformacion'],
                    'experienciaTerceroInformacion' => $request['experienciaTerceroInformacion'],
                    'formacionTerceroInformacion' => $request['formacionTerceroInformacion'],
                    'estadoCivilTerceroInformacion' => $request['estadoCivilTerceroInformacion'],
                    'numeroHijosTerceroInformacion' => $request['numeroHijosTerceroInformacion'],
                    'composicionFamiliarTerceroInformacion' => $request['composicionFamiliarTerceroInformacion'],
                    'personasACargoTerceroInformacion' => $request['personasACargoTerceroInformacion'],
                    'estratoSocialTerceroInformacion' => $request['estratoSocialTerceroInformacion'],
                    'tipoViviendaTerceroInformacion' => $request['tipoViviendaTerceroInformacion'],
                    'tipoTransporteTerceroInformacion' => $request['tipoTransporteTerceroInformacion'],
                    'HobbyTerceroInformacion' => $request['HobbyTerceroInformacion'],
                    'actividadFisicaTerceroInformacion' => $request['actividadFisicaTerceroInformacion'],
                    'consumeLicorTerceroInformacion' => $request['consumeLicorTerceroInformacion'],
                    'FrecuenciaMedicion_idConsumeLicor' => 
                        (
                            ($request['FrecuenciaMedicion_idConsumeLicor'] == '' or 
                            $request['FrecuenciaMedicion_idConsumeLicor'] == 0) 
                            ? null 
                            : $request['FrecuenciaMedicion_idConsumeLicor']),
                    'consumeCigarrilloTerceroInformacion' => $request['consumeCigarrilloTerceroInformacion']
                ]);
            
           
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

            $contadorExamen = count($request['TipoExamenMedico_idTipoExamenMedico']);
            for($i = 0; $i < $contadorExamen; $i++)
            {
                \App\TerceroExamenMedico::create([
                'Tercero_idTercero' => $tercero->idTercero,
                'TipoExamenMedico_idTipoExamenMedico' => $request['TipoExamenMedico_idTipoExamenMedico'][$i], 
                'ingresoTerceroExamenMedico' => $request['ingresoTerceroExamenMedico'][$i], 
                'retiroTerceroExamenMedico' => $request['retiroTerceroExamenMedico'][$i], 
                'periodicoTerceroExamenMedico' => $request['periodicoTerceroExamenMedico'][$i], 
                'FrecuenciaMedicion_idFrecuenciaMedicion' => $request['FrecuenciaMedicion_idFrecuenciaMedicion'][$i]   
               ]);
            }

            $arrayImage = $request['archivoTerceroArray'];
            $arrayImage = substr($arrayImage, 0, strlen($arrayImage)-1);
            $arrayImage = explode(",", $arrayImage);
            $ruta = '';
            for ($i=0; $i <count($arrayImage) ; $i++) 
            { 
                if ($arrayImage[$i] != '' || $arrayImage[$i] != 0) 
                {
                    $origen = public_path() . '/imagenes/repositorio/temporal/'.$arrayImage[$i];
                    $destinationPath = public_path() . '/imagenes/tercero/'.$arrayImage[$i];
                    $ruta = '/tercero/'.$arrayImage[$i];
                   
                    if (file_exists($origen))
                    {
                        copy($origen, $destinationPath);
                        unlink($origen);
                    }   
                    else
                    {
                        echo "No existe el archivo";
                    }
                }

                \App\TerceroArchivo::create([
                'Tercero_idTercero' => $tercero->idTercero,
                'tituloTerceroArchivo' => $request['tituloTerceroArchivo'],
                'fechaTerceroArchivo' => $request['fechaTerceroArchivo'],
                'rutaTerceroArchivo' => $ruta
               ]);
            }
            
            return redirect('/tercero');
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
        $idTipoExamen = \App\TipoExamenMedico::All()->lists('idTipoExamenMedico');
        $nombreTipoExamen = \App\TipoExamenMedico::All()->lists('nombreTipoExamenMedico');
        $idFrecuenciaMedicion = \App\FrecuenciaMedicion::All()->lists('idFrecuenciaMedicion');
        $nombreFrecuenciaMedicion = \App\FrecuenciaMedicion::All()->lists('nombreFrecuenciaMedicion');
        $frecuenciaAlcohol = \App\FrecuenciaMedicion::All()->lists('nombreFrecuenciaMedicion','idFrecuenciaMedicion');
        $ciudad = \App\Ciudad::All()->lists('nombreCiudad','idCiudad');
        $tipoIdentificacion = \App\TipoIdentificacion::All()->lists('nombreTipoIdentificacion','idTipoIdentificacion');
        $cargo = \App\Cargo::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('nombreCargo','idCargo');

        $zona = \App\Zona::All()->lists('nombreZona', 'idZona');
        
        $sectorempresa = \App\SectorEmpresa::All()->lists('nombreSectorEmpresa', 'idSectorEmpresa');

        $empleadorcontratista = \App\Tercero::where('tipoTercero', 'like','%*01*%')->where('Compania_idCompania', '=', \Session::get('idCompania'))->lists('nombreCompletoTercero','idTercero');

        $tercero = \App\Tercero::find($id);

        return view('tercero',compact('ciudad','tipoIdentificacion','cargo','idTipoExamen','nombreTipoExamen','idFrecuenciaMedicion','nombreFrecuenciaMedicion','frecuenciaAlcohol', 'zona', 'sectorempresa', 'empleadorcontratista'),['tercero'=>$tercero]);
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
        if($request['respuesta'] != 'falso')
        { 
            $tercero = \App\Tercero::find($id);
            $tercero->fill($request->all());
            $tercero->Cargo_idCargo = (($request['Cargo_idCargo'] == '' or $request['Cargo_idCargo'] == 0) ? null : $request['Cargo_idCargo']);
            $tercero->Zona_idZona = (($request['Zona_idZona'] == '' or $request['Zona_idZona'] == 0) ? null : $request['Zona_idZona']);
            $tercero->SectorEmpresa_idSectorEmpresa = (($request['SectorEmpresa_idSectorEmpresa'] == '' or $request['SectorEmpresa_idSectorEmpresa'] == 0) ? null : $request['SectorEmpresa_idSectorEmpresa'
                ]);
            $tercero->Tercero_idEmpleadorContratista = (($request['Tercero_idEmpleadorContratista'] == '' or $request['Tercero_idEmpleadorContratista'] == 0) ? null : $request['Tercero_idEmpleadorContratista'
                ]);

            if(null !== Input::file('imagenTercero') )
            {
                $image = Input::file('imagenTercero');
                $imageName = $request->file('imagenTercero')->getClientOriginalName();
                $manager = new ImageManager();
                $manager->make($image->getRealPath())->heighten(500)->save('imagenes/tercero/'. $imageName);

                $tercero->imagenTercero = 'tercero/'. $imageName;
            }   

            $tercero->save();

            $indice = array(
                  'Tercero_idTercero' => $id);

            $data = array(
                'fechaNacimientoTerceroInformacion' => $request['fechaNacimientoTerceroInformacion'],
                'fechaIngresoTerceroInformacion' => $request['fechaIngresoTerceroInformacion'],
                'fechaRetiroTerceroInformacion' => $request['fechaRetiroTerceroInformacion'],
                'tipoContratoTerceroInformacion' => $request['tipoContratoTerceroInformacion'],
                'aniosExperienciaTerceroInformacion' => $request['aniosExperienciaTerceroInformacion'],
                'educacionTerceroInformacion' => $request['educacionTerceroInformacion'],
                'experienciaTerceroInformacion' => $request['experienciaTerceroInformacion'],
                'formacionTerceroInformacion' => $request['formacionTerceroInformacion'],
                'estadoCivilTerceroInformacion' => $request['estadoCivilTerceroInformacion'],
                'numeroHijosTerceroInformacion' => $request['numeroHijosTerceroInformacion'],
                'composicionFamiliarTerceroInformacion' => $request['composicionFamiliarTerceroInformacion'],
                'personasACargoTerceroInformacion' => $request['personasACargoTerceroInformacion'],
                'estratoSocialTerceroInformacion' => $request['estratoSocialTerceroInformacion'],
                'tipoViviendaTerceroInformacion' => $request['tipoViviendaTerceroInformacion'],
                'tipoTransporteTerceroInformacion' => $request['tipoTransporteTerceroInformacion'],
                'HobbyTerceroInformacion' => $request['HobbyTerceroInformacion'],
                'actividadFisicaTerceroInformacion' => $request['actividadFisicaTerceroInformacion'],
                'consumeLicorTerceroInformacion' => $request['consumeLicorTerceroInformacion'],
                'FrecuenciaMedicion_idConsumeLicor' => 
                        (
                            ($request['FrecuenciaMedicion_idConsumeLicor'] == '' or 
                            $request['FrecuenciaMedicion_idConsumeLicor'] == 0) 
                            ? null 
                            : $request['FrecuenciaMedicion_idConsumeLicor']),
                'consumeCigarrilloTerceroInformacion' => $request['consumeCigarrilloTerceroInformacion']);

            $terceroinformacion = \App\TerceroInformacion::updateOrCreate($indice, $data);

            \App\TerceroContacto::where('Tercero_idTercero',$id)->delete();
            \App\TerceroProducto::where('Tercero_idTercero',$id)->delete();
            \App\TerceroExamenMedico::where('Tercero_idTercero',$id)->delete();
            // \App\TerceroArchivo::where('Tercero_idTercero',$id)->delete();
            
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

            $contadorExamen = count($request['TipoExamenMedico_idTipoExamenMedico']);
            for($i = 0; $i < $contadorExamen; $i++)
            {
                \App\TerceroExamenMedico::create([
                'Tercero_idTercero' => $id,
                'TipoExamenMedico_idTipoExamenMedico' => $request['TipoExamenMedico_idTipoExamenMedico'][$i], 
                'ingresoTerceroExamenMedico' => $request['ingresoTerceroExamenMedico'][$i], 
                'retiroTerceroExamenMedico' => $request['retiroTerceroExamenMedico'][$i], 
                'periodicoTerceroExamenMedico' => $request['periodicoTerceroExamenMedico'][$i], 
                'FrecuenciaMedicion_idFrecuenciaMedicion' => $request['FrecuenciaMedicion_idFrecuenciaMedicion'][$i]   
               ]);
            }

            
            // HAGO UN INSERT A LOS NUEVOS ARCHIVOS SUBIDOS EN EL DROPZONE
            if ($request['archivoTerceroArray'] != '') 
            {
                $arrayImage = $request['archivoTerceroArray'];
                $arrayImage = substr($arrayImage, 0, strlen($arrayImage)-1);
                $arrayImage = explode(",", $arrayImage);
                $ruta = '';

                for($i = 0; $i < count($arrayImage); $i++)
                {
                    if ($arrayImage[$i] != '' || $arrayImage[$i] != 0) 
                    {
                        $origen = public_path() . '/imagenes/repositorio/temporal/'.$arrayImage[$i];
                        $destinationPath = public_path() . '/imagenes/tercero/'.$arrayImage[$i];
                        
                        if (file_exists($origen))
                        {
                            copy($origen, $destinationPath);
                            unlink($origen);
                            $ruta = '/tercero/'.$arrayImage[$i];

                            DB::table('terceroarchivo')->insert(['idTerceroArchivo' => '0', 'Tercero_idTercero' =>$tercero->idTercero,'fechaTerceroArchivo' => $request['fechaTerceroArchivo'],'rutaTerceroArchivo' => $ruta]);
                        }   
                        else
                        {
                            echo "No existe el archivo";
                        }
                    }
                }
            }
            

            // HAGO UN UPDATE DE LOS DATOS
                // $index = array(
                //     'idTerceroArchivo' => $request['idTerceroArchivo'][$i]);

                // $data= array(
                //     'Tercero_idTercero' => $tercero->idTercero,
                //     'tituloTerceroArchivo' => '',
                //     'fechaTerceroArchivo' => $request['fechaTerceroArchivo'][$i],
                //     'descripcionTerceroArchivo' => '',
                //     'rutaTerceroArchivo' => '');
                
                // $save = \App\TerceroArchivo::updateOrCreate($index, $data);
            // for ($i=0; $i < ; $i++) 
            // { 
            //     DB::table('terceroarchivo')->update(['idTerceroArchivo' => '', 'Tercero_idTercero' =>$tercero->idTercero,'fechaTerceroArchivo' => '', 'descripcionTerceroArchivo' => '','rutaTerceroArchivo' => '']);
            // }

            // ELIMINO LOS ARCHIVOS
            $idsEliminar = $request['eliminarArchivo'];
            $idsEliminar = substr($idsEliminar, 0, strlen($idsEliminar)-1);
            if($idsEliminar != '')
            {
                $idsEliminar = explode(',',$idsEliminar);
                \App\TerceroArchivo::whereIn('idTerceroArchivo',$idsEliminar)->delete();
            }
            return redirect('/tercero');
        }
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

    public function importarTerceroProveedor()
    {
        $destinationPath = public_path() . '/imagenes/repositorio/temporal'; 
        Excel::load($destinationPath.'/Plantilla Terceros.xlsx', function($reader) {

            

            // // llemos todo el archivo
            // $datos = $reader->get();

            // // Tiulo de la Hoja
            // $workbookTitle = $datos->getTitle();
            // echo 'A'.$workbookTitle;

            $datos = $reader->getActiveSheet();
            
             // echo $datos->getCell('C5')->getValue();

            $terceros = array();
            $errores = array();
            $fila = 5;
            $posTer = 0;
            $posErr = 0;
            
            while ($datos->getCellByColumnAndRow(0, $fila)->getValue() != '' and
                    $datos->getCellByColumnAndRow(0, $fila)->getValue() != NULL) {
                

                // para cada registro de terceros recorremos las columnas desde la 0 hasta la 22
                $terceros[$posTer]["idTercero"] = 0;
                $terceros[$posTer]["Compania_idCompania"] = 0;
                for ($columna = 0; $columna <= 22; $columna++) {
                    // en la fila 4 del archivo de excel (oculta) estan los nombres de los campos de la tabla
                    $campo = $datos->getCellByColumnAndRow($columna, 4)->getValue();

                    // si es una celda calculada, la ejeutamos, sino tomamos su valor
                    if ($datos->getCellByColumnAndRow($columna, $fila)->getDataType() == 'f')
                        $terceros[$posTer][$campo] = $datos->getCellByColumnAndRow($columna, $fila)->getCalculatedValue();
                    else
                    {
                        $terceros[$posTer][$campo] = 
                            ($datos->getCellByColumnAndRow($columna, $fila)->getValue() == null 
                                ? ''
                                : $datos->getCellByColumnAndRow($columna, $fila)->getValue());
                    }

                }

                // tomamos el tipo de identificacion que el usuario llena como codigo para convertirlo en id buscandolo en el modelo
                
                //*****************************
                // Tipo de identificacion
                //*****************************
                // si la celda esta en blanco, reportamos error de obligatoriedad
                if($terceros[ $posTer]["TipoIdentificacion_idTipoIdentificacion"] == '' or 
                    $terceros[ $posTer]["TipoIdentificacion_idTipoIdentificacion"] == null)
                {
                    $errores[$posErr]["linea"] = $fila;
                    $errores[$posErr]["nombre"] = $terceros[ $posTer]["nombreCompletoTercero"];
                    $errores[$posErr]["mensaje"] = 'Debe diligenciar el Tipo de identificacion';
                    
                    $posErr++;
                }
                else
                {
                    $consulta = \App\TipoIdentificacion::where('codigoTipoIdentificacion','=', $terceros[ $posTer]["TipoIdentificacion_idTipoIdentificacion"])->lists('idTipoIdentificacion');

                    // si se encuentra el id lo guardamos en el array
                    if(isset($consulta[0]))
                    {
                        $terceros[$posTer]["TipoIdentificacion_idTipoIdentificacion"] = $consulta[0];
                    }
                    else
                    {
                        $errores[$posErr]["linea"] = $fila;
                        $errores[$posErr]["nombre"] = $terceros[ $posTer]["nombreCompletoTercero"];
                        $errores[$posErr]["mensaje"] = 'Tipo de identificacion '. $terceros[ $posTer]["TipoIdentificacion_idTipoIdentificacion"]. ' no existe';
                        
                        $posErr++;
                    }
                }

                //*****************************
                // Tipo de Tercero
                //*****************************
                // con los campos de tipo cliente y tipo proveedor, armamos el tipo de tercero
                $terceros[$posTer]["tipoTercero"] = 
                        ($terceros[$posTer]["tipoProveedor"] != '' ? '*02*': '').
                        ($terceros[$posTer]["tipoCliente"] != '' ? '*03*': '');
                // si le tipo de tercero queda vacio, por defecto lo ponemos como proveedor
                $terceros[$posTer]["tipoTercero"] == ($terceros[$posTer]["tipoTercero"] == '' ? '*02*' : $terceros[$posTer]["tipoTercero"]);


                //*****************************
                // Número de documento
                //*****************************
                // si la celda esta en blanco, reportamos error de obligatoriedad
                if($terceros[ $posTer]["documentoTercero"] == '' or 
                    $terceros[ $posTer]["documentoTercero"] == null)
                {
                    $errores[$posErr]["linea"] = $fila;
                    $errores[$posErr]["nombre"] = $terceros[ $posTer]["nombreCompletoTercero"];
                    $errores[$posErr]["mensaje"] = 'Debe diligenciar el Número de Documento';
                    
                    $posErr++;
                }
                else
                {
                    //buscamos el id en el modelo correspondiente
                    $consulta = \App\Tercero::where('Compania_idCompania', "=", \Session::get('idCompania'))->where('documentoTercero','=', $terceros[ $posTer]["documentoTercero"])->lists('idTercero');
                    // si se encuentra el id lo guardamos en el array

                    if(isset($consulta[0]))
                        $terceros[$posTer]["idTercero"] = $consulta[0];
                }

                //*****************************
                // Primer Nombre 
                //*****************************
                // si la celda esta en blanco, reportamos error de obligatoriedad
                if($terceros[ $posTer]["nombre1Tercero"] == '' or 
                    $terceros[ $posTer]["nombre1Tercero"] == null)
                {
                    $errores[$posErr]["linea"] = $fila;
                    $errores[$posErr]["nombre"] = $terceros[ $posTer]["nombreCompletoTercero"];
                    $errores[$posErr]["mensaje"] = 'Debe diligenciar el Primer Nombre';
                    
                    $posErr++;
                }

                //*****************************
                // Primer Apellido
                //*****************************
                // si la celda esta en blanco, reportamos error de obligatoriedad
                if($terceros[ $posTer]["apellido1Tercero"] == '' or 
                    $terceros[ $posTer]["apellido1Tercero"] == null)
                {
                    $errores[$posErr]["linea"] = $fila;
                    $errores[$posErr]["nombre"] = $terceros[ $posTer]["nombreCompletoTercero"];
                    $errores[$posErr]["mensaje"] = 'Debe diligenciar el Primer Apellido';
                    
                    $posErr++;
                }


                //*****************************
                // Nombre Completo
                //*****************************
                // si la celda esta en blanco, reportamos error de obligatoriedad
                if($terceros[ $posTer]["nombreCompletoTercero"] == '' or 
                    $terceros[ $posTer]["nombreCompletoTercero"] == null)
                {
                    $errores[$posErr]["linea"] = $fila;
                    $errores[$posErr]["nombre"] = $terceros[ $posTer]["nombreCompletoTercero"];
                    $errores[$posErr]["mensaje"] = 'Debe diligenciar el Nombre completo o Razon Social';
                    
                    $posErr++;
                }

                //*****************************
                // Fecha de Creación 
                //*****************************
                // si la celda esta en blanco, la llenamos con la fecha actual
                if($terceros[ $posTer]["fechaCreacionTercero"] == '' or 
                    $terceros[ $posTer]["fechaCreacionTercero"] == null)
                {
                    $terceros[$posTer]["fechaCreacionTercero"] = date("Y-m-d");
                }


                //*****************************
                // Estado
                //*****************************
                // si la celda esta en blanco o no tiene una de las palabras válida, la llenamos con activo
                if($terceros[$posTer]["estadoTercero"] == '' or 
                    $terceros[$posTer]["estadoTercero"] == null or 
                    $terceros[$posTer]["estadoTercero"] != 'ACTIVO' or 
                    $terceros[$posTer]["estadoTercero"] != 'INACTIVO')
                {
                    $terceros[$posTer]["estadoTercero"] = 'ACTIVO';
                }
            
                //*****************************
                // Ciudad
                //*****************************
                // si la celda esta en blanco, reportamos error de obligatoriedad
                if($terceros[ $posTer]["Ciudad_idCiudad"] == '' or 
                    $terceros[ $posTer]["Ciudad_idCiudad"] == null)
                {
                    $errores[$posErr]["linea"] = $fila;
                    $errores[$posErr]["nombre"] = $terceros[ $posTer]["nombreCompletoTercero"];
                    $errores[$posErr]["mensaje"] = 'Debe diligenciar el código de la ciudad';
                    
                    $posErr++;
                }
                else
                {
                    $consulta = \App\Ciudad::where('codigoCiudad','=', $terceros[ $posTer]["Ciudad_idCiudad"])->lists('idCiudad');

                    // si se encuentra el id lo guardamos en el array
                    if(isset($consulta[0]))
                        $terceros[$posTer]["Ciudad_idCiudad"] = $consulta[0];
                    else
                    {
                        $errores[$posErr]["linea"] = $fila;
                        $errores[$posErr]["nombre"] = $terceros[ $posTer]["nombreCompletoTercero"];
                        $errores[$posErr]["mensaje"] = 'Código de Ciudad '. $terceros[ $posTer]["Ciudad_idCiudad"]. ' no existe';
                        
                        $posErr++;
                    }
                }


                //*****************************
                // Cargo
                //*****************************
                // si la celda esta en blanco, reportamos error de obligatoriedad
                if($terceros[ $posTer]["Cargo_idCargo"] == '' or 
                    $terceros[ $posTer]["Cargo_idCargo"] == null)
                {
                    $terceros[$posTer]["Cargo_idCargo"] = null;
                    // $errores[$posErr]["linea"] = $fila;
                    // $errores[$posErr]["nombre"] = $terceros[ $posTer]["nombreCompletoTercero"];
                    // $errores[$posErr]["mensaje"] = 'Debe diligenciar el código del Cargo';
                    
                    // $posErr++;
                }
                else
                {
                    $consulta = \App\Cargo::where('Compania_idCompania', "=", \Session::get('idCompania'))->where('codigoCargo','=', $terceros[ $posTer]["Cargo_idCargo"])->lists('idCargo');

                    // si se encuentra el id lo guardamos en el array
                    if(isset($consulta[0]))
                        $terceros[$posTer]["Cargo_idCargo"] = $consulta[0];
                    else
                    {
                        $terceros[$posTer]["Cargo_idCargo"] = null;
                        // $errores[$posErr]["linea"] = $fila;
                        // $errores[$posErr]["nombre"] = $terceros[ $posTer]["nombreCompletoTercero"];
                        // $errores[$posErr]["mensaje"] = 'Código de Cargo '. $terceros[ $posTer]["Cargo_idCargo"]. ' no existe';
                        
                        // $posErr++;
                    }
                }


                //*****************************
                // Zona
                //*****************************
                // si la celda esta en blanco, reportamos error de obligatoriedad
                if($terceros[ $posTer]["Zona_idZona"] == '' or 
                    $terceros[ $posTer]["Zona_idZona"] == null)
                {
                    $terceros[$posTer]["Zona_idZona"] = null;
                    // $errores[$posErr]["linea"] = $fila;
                    // $errores[$posErr]["nombre"] = $terceros[ $posTer]["nombreCompletoTercero"];
                    // $errores[$posErr]["mensaje"] = 'Debe diligenciar el código del Cargo';
                    
                    // $posErr++;
                }
                else
                {
                    $consulta = \App\Zona::where('codigoZona','=', $terceros[ $posTer]["Zona_idZona"])->lists('idZona');

                    // si se encuentra el id lo guardamos en el array
                    if(isset($consulta[0]))
                        $terceros[$posTer]["Zona_idZona"] = $consulta[0];
                    else
                    {
                        $terceros[$posTer]["Zona_idZona"] = null;
                        // $errores[$posErr]["linea"] = $fila;
                        // $errores[$posErr]["nombre"] = $terceros[ $posTer]["nombreCompletoTercero"];
                        // $errores[$posErr]["mensaje"] = 'Código de Cargo '. $terceros[ $posTer]["Cargo_idCargo"]. ' no existe';
                        
                        // $posErr++;
                    }
                }
                

                //*****************************
                // Sector Empresarial
                //*****************************
                // si la celda esta en blanco, reportamos error de obligatoriedad
                if($terceros[ $posTer]["SectorEmpresa_idSectorEmpresa"] == '' or 
                    $terceros[ $posTer]["SectorEmpresa_idSectorEmpresa"] == null)
                {
                    $terceros[$posTer]["SectorEmpresa_idSectorEmpresa"] = null;
                    // $errores[$posErr]["linea"] = $fila;
                    // $errores[$posErr]["nombre"] = $terceros[ $posTer]["nombreCompletoTercero"];
                    // $errores[$posErr]["mensaje"] = 'Debe diligenciar el código del Cargo';
                    
                    // $posErr++;
                }
                else
                {
                    $consulta = \App\SectorEmpresa::where('codigoSectorEmpresa','=', $terceros[ $posTer]["SectorEmpresa_idSectorEmpresa"])->lists('idSectorEmpresa');

                    // si se encuentra el id lo guardamos en el array
                    if(isset($consulta[0]))
                        $terceros[$posTer]["SectorEmpresa_idSectorEmpresa"] = $consulta[0];
                    else
                    {
                        $terceros[$posTer]["SectorEmpresa_idSectorEmpresa"] = null;
                        // $errores[$posErr]["linea"] = $fila;
                        // $errores[$posErr]["nombre"] = $terceros[ $posTer]["nombreCompletoTercero"];
                        // $errores[$posErr]["mensaje"] = 'Código de Cargo '. $terceros[ $posTer]["Cargo_idCargo"]. ' no existe';
                        
                        // $posErr++;
                    }
                }


                $posTer++;
                $fila++;
                
            }

            $totalErrores = count($errores);

            if($totalErrores > 0)
            {
                $mensaje = '<table cellspacing="0" cellpadding="1" style="width:100%;">'.
                        '<tr>'.
                            '<td colspan="3">'.
                                '<h3>Informe de inconsistencias en Importacion de Terceros</h3>'.
                            '</td>'.
                        '</tr>'.
                        '<tr>'.
                            '<td >No. Línea</td>'.
                            '<td >Nombre</td>'.
                            '<td >Mensaje</td>'.
                        '</tr>';

                for($regErr = 0; $regErr < $totalErrores; $regErr++)
                {
                     $mensaje .= '<tr>'.
                                '<td >'.$errores[$regErr]["linea"].'</td>'.
                                '<td >'.$errores[$regErr]["nombre"].'</td>'.
                                '<td >'.$errores[$regErr]["mensaje"].'</td>'.
                            '</tr>';
                }
                $mensaje .= '</table>';
                echo json_encode(array(false, $mensaje));
            }
            else
            {
                // recorremos el array recibido para insertar o actualizar cada registro
                for($reg = 0; $reg < count($terceros); $reg++)
                {
                    
                    $indice = array(
                          'idTercero' => $terceros[$reg]["idTercero"]);

                    $data = array(
                        'TipoIdentificacion_idTipoIdentificacion' => $terceros[$reg]['TipoIdentificacion_idTipoIdentificacion'],
                        'documentoTercero' => $terceros[$reg]['documentoTercero'],
                        'nombre1Tercero' => $terceros[$reg]['nombre1Tercero'],
                        'nombre2Tercero' => $terceros[$reg]['nombre2Tercero'],
                        'apellido1Tercero' => $terceros[$reg]['apellido1Tercero'],
                        'apellido2Tercero' => $terceros[$reg]['apellido2Tercero'],
                        'nombreCompletoTercero' => $terceros[$reg]['nombreCompletoTercero'],
                        'fechaCreacionTercero' => $terceros[$reg]['fechaCreacionTercero'],
                        'estadoTercero' => $terceros[$reg]['estadoTercero'],
                        'imagenTercero' => $terceros[$reg]['imagenTercero'],
                        'tipoTercero' => $terceros[$reg]['tipoTercero'],
                        'direccionTercero' => $terceros[$reg]['direccionTercero'],
                        'Ciudad_idCiudad' => $terceros[$reg]['Ciudad_idCiudad'],
                        'telefonoTercero' => $terceros[$reg]['telefonoTercero'],
                        'faxTercero' => $terceros[$reg]['faxTercero'],
                        'movil1Tercero' => $terceros[$reg]['movil1Tercero'],
                        'movil2Tercero' => $terceros[$reg]['movil2Tercero'],
                        'sexoTercero' => $terceros[$reg]['sexoTercero'],
                        'fechaNacimientoTercero' => $terceros[$reg]['fechaNacimientoTercero'],
                        'correoElectronicoTercero' => $terceros[$reg]['correoElectronicoTercero'],
                        'paginaWebTercero' => $terceros[$reg]['paginaWebTercero'],
                        'Cargo_idCargo' => $terceros[$reg]['Cargo_idCargo'],
                        'Compania_idCompania' => \Session::get("idCompania")
                    );

                    $tercero = \App\Tercero::updateOrCreate($indice, $data);
                }
                echo json_encode(array(true, 'Importacion Exitosa, por favor verifique'));
            }


        });
        unlink ( $destinationPath.'/Plantilla Terceros.xlsx');
        
    }


    public function importarTerceroEmpleado()
    {
        $destinationPath = public_path() . '/imagenes/repositorio/temporal'; 
        Excel::load($destinationPath.'/Plantilla Empleados.xlsx', function($reader) {

            $datos = $reader->getActiveSheet();
            
            $terceros = array();
            $errores = array();
            $fila = 5;
            $posTer = 0;
            $posErr = 0;
            
            while ($datos->getCellByColumnAndRow(0, $fila)->getValue() != '' and
                    $datos->getCellByColumnAndRow(0, $fila)->getValue() != NULL) {
                

                // para cada registro de empleados recorremos las columnas desde la 0 hasta la 40
                $terceros[$posTer]["idTercero"] = 0;
                $terceros[$posTer]["Compania_idCompania"] = 0;
                for ($columna = 0; $columna <= 40; $columna++) {
                    // en la fila 4 del archivo de excel (oculta) estan los nombres de los campos de la tabla
                    $campo = $datos->getCellByColumnAndRow($columna, 4)->getValue();

                    // si es una celda calculada, la ejecutamos, sino tomamos su valor
                    if ($datos->getCellByColumnAndRow($columna, $fila)->getDataType() == 'f')
                        $terceros[$posTer][$campo] = $datos->getCellByColumnAndRow($columna, $fila)->getCalculatedValue();
                    else
                    {
                        $terceros[$posTer][$campo] = 
                            ($datos->getCellByColumnAndRow($columna, $fila)->getValue() == null 
                                ? ''
                                : $datos->getCellByColumnAndRow($columna, $fila)->getValue());
                    }

                }

                // tomamos el tipo de identificacion que el usuario llena como codigo para convertirlo en id buscandolo en el modelo
                
                //*****************************
                // Tipo de identificacion
                //*****************************
                // si la celda esta en blanco, reportamos error de obligatoriedad
                if($terceros[ $posTer]["TipoIdentificacion_idTipoIdentificacion"] == '' or 
                    $terceros[ $posTer]["TipoIdentificacion_idTipoIdentificacion"] == null)
                {
                    $errores[$posErr]["linea"] = $fila;
                    $errores[$posErr]["nombre"] = $terceros[ $posTer]["nombreCompletoTercero"];
                    $errores[$posErr]["mensaje"] = 'Debe diligenciar el Tipo de identificacion';
                    
                    $posErr++;
                }
                else
                {
                    $consulta = \App\TipoIdentificacion::where('codigoTipoIdentificacion','=', $terceros[ $posTer]["TipoIdentificacion_idTipoIdentificacion"])->lists('idTipoIdentificacion');

                    // si se encuentra el id lo guardamos en el array
                    if(isset($consulta[0]))
                    {
                        $terceros[$posTer]["TipoIdentificacion_idTipoIdentificacion"] = $consulta[0];
                    }
                    else
                    {
                        $errores[$posErr]["linea"] = $fila;
                        $errores[$posErr]["nombre"] = $terceros[ $posTer]["nombreCompletoTercero"];
                        $errores[$posErr]["mensaje"] = 'Tipo de identificacion '. $terceros[ $posTer]["TipoIdentificacion_idTipoIdentificacion"]. ' no existe';
                        
                        $posErr++;
                    }
                }

                //*****************************
                // Número de documento
                //*****************************
                // si la celda esta en blanco, reportamos error de obligatoriedad
                if($terceros[ $posTer]["documentoTercero"] == '' or 
                    $terceros[ $posTer]["documentoTercero"] == null)
                {
                    $errores[$posErr]["linea"] = $fila;
                    $errores[$posErr]["nombre"] = $terceros[ $posTer]["nombreCompletoTercero"];
                    $errores[$posErr]["mensaje"] = 'Debe diligenciar el Número de Documento';
                    
                    $posErr++;
                }
                else
                {
                    //buscamos el id en el modelo correspondiente
                    $consulta = \App\Tercero::where('Compania_idCompania', "=", \Session::get('idCompania'))->where('documentoTercero','=', $terceros[ $posTer]["documentoTercero"])->lists('idTercero');
                    // si se encuentra el id lo guardamos en el array

                    if(isset($consulta[0]))
                        $terceros[$posTer]["idTercero"] = $consulta[0];
                }

                //*****************************
                // Primer Nombre 
                //*****************************
                // si la celda esta en blanco, reportamos error de obligatoriedad
                if($terceros[ $posTer]["nombre1Tercero"] == '' or 
                    $terceros[ $posTer]["nombre1Tercero"] == null)
                {
                    $errores[$posErr]["linea"] = $fila;
                    $errores[$posErr]["nombre"] = $terceros[ $posTer]["nombreCompletoTercero"];
                    $errores[$posErr]["mensaje"] = 'Debe diligenciar el Primer Nombre';
                    
                    $posErr++;
                }

                //*****************************
                // Primer Apellido
                //*****************************
                // si la celda esta en blanco, reportamos error de obligatoriedad
                if($terceros[ $posTer]["apellido1Tercero"] == '' or 
                    $terceros[ $posTer]["apellido1Tercero"] == null)
                {
                    $errores[$posErr]["linea"] = $fila;
                    $errores[$posErr]["nombre"] = $terceros[ $posTer]["nombreCompletoTercero"];
                    $errores[$posErr]["mensaje"] = 'Debe diligenciar el Primer Apellido';
                    
                    $posErr++;
                }


                //*****************************
                // Nombre Completo
                //*****************************
                // si la celda esta en blanco, reportamos error de obligatoriedad
                if($terceros[ $posTer]["nombreCompletoTercero"] == '' or 
                    $terceros[ $posTer]["nombreCompletoTercero"] == null)
                {
                    $errores[$posErr]["linea"] = $fila;
                    $errores[$posErr]["nombre"] = $terceros[ $posTer]["nombreCompletoTercero"];
                    $errores[$posErr]["mensaje"] = 'Debe diligenciar el Nombre completo o Razon Social';
                    
                    $posErr++;
                }

                //*****************************
                // Fecha de Creación 
                //*****************************
                // si la celda esta en blanco, la llenamos con la fecha actual
                if($terceros[ $posTer]["fechaCreacionTercero"] == '' or 
                    $terceros[ $posTer]["fechaCreacionTercero"] == null)
                {
                    $terceros[$posTer]["fechaCreacionTercero"] = date("Y-m-d");
                }


                //*****************************
                // Estado
                //*****************************
                // si la celda esta en blanco o no tiene una de las palabras válida, la llenamos con activo
                if($terceros[$posTer]["estadoTercero"] == '' or 
                    $terceros[$posTer]["estadoTercero"] == null or 
                    $terceros[$posTer]["estadoTercero"] != 'ACTIVO' or 
                    $terceros[$posTer]["estadoTercero"] != 'INACTIVO')
                {
                    $terceros[$posTer]["estadoTercero"] = 'ACTIVO';
                }
            
                //*****************************
                // Ciudad
                //*****************************
                // si la celda esta en blanco, reportamos error de obligatoriedad
                if($terceros[ $posTer]["Ciudad_idCiudad"] == '' or 
                    $terceros[ $posTer]["Ciudad_idCiudad"] == null)
                {
                    $errores[$posErr]["linea"] = $fila;
                    $errores[$posErr]["nombre"] = $terceros[ $posTer]["nombreCompletoTercero"];
                    $errores[$posErr]["mensaje"] = 'Debe diligenciar el código de la ciudad';
                    
                    $posErr++;
                }
                else
                {
                    $consulta = \App\Ciudad::where('codigoCiudad','=', $terceros[ $posTer]["Ciudad_idCiudad"])->lists('idCiudad');

                    // si se encuentra el id lo guardamos en el array
                    if(isset($consulta[0]))
                        $terceros[$posTer]["Ciudad_idCiudad"] = $consulta[0];
                    else
                    {
                        $errores[$posErr]["linea"] = $fila;
                        $errores[$posErr]["nombre"] = $terceros[ $posTer]["nombreCompletoTercero"];
                        $errores[$posErr]["mensaje"] = 'Código de Ciudad '. $terceros[ $posTer]["Ciudad_idCiudad"]. ' no existe';
                        
                        $posErr++;
                    }
                }

                //*****************************
                // Cargo
                //*****************************
                // si la celda esta en blanco, reportamos error de obligatoriedad
                if($terceros[ $posTer]["Cargo_idCargo"] == '' or 
                    $terceros[ $posTer]["Cargo_idCargo"] == null)
                {
                    $errores[$posErr]["linea"] = $fila;
                    $errores[$posErr]["nombre"] = $terceros[ $posTer]["nombreCompletoTercero"];
                    $errores[$posErr]["mensaje"] = 'Debe diligenciar el código del Cargo';
                    
                    $posErr++;
                }
                else
                {
                    $consulta = \App\Cargo::where('Compania_idCompania', "=", \Session::get('idCompania'))->where('codigoCargo','=', $terceros[ $posTer]["Cargo_idCargo"])->lists('idCargo');

                    // si se encuentra el id lo guardamos en el array
                    if(isset($consulta[0]))
                        $terceros[$posTer]["Cargo_idCargo"] = $consulta[0];
                    else
                    {
                        
                        $errores[$posErr]["linea"] = $fila;
                        $errores[$posErr]["nombre"] = $terceros[ $posTer]["nombreCompletoTercero"];
                        $errores[$posErr]["mensaje"] = 'Código de Cargo '. $terceros[ $posTer]["Cargo_idCargo"]. ' no existe';
                        
                        $posErr++;
                    }
                }

                
                //*****************************
                // Frecuencia de Medicion Licor
                //*****************************
                // si la celda esta en blanco, reportamos error de obligatoriedad
                if($terceros[ $posTer]["consumeLicorTerceroInformacion"] == 'SI')
                {

                    if($terceros[ $posTer]["FrecuenciaMedicion_idConsumeLicor"] == '' or 
                        $terceros[ $posTer]["FrecuenciaMedicion_idConsumeLicor"] == null)
                    {
                        $errores[$posErr]["linea"] = $fila;
                        $errores[$posErr]["nombre"] = $terceros[ $posTer]["nombreCompletoTercero"];
                        $errores[$posErr]["mensaje"] = 'Debe diligenciar el código de Frecuencia de Consumo de Licor';
                        
                        $posErr++;
                    }
                    else
                    {
                        $consulta = \App\Cargo::where('codigoCargo','=', $terceros[ $posTer]["FrecuenciaMedicion_idConsumeLicor"])->lists('idCargo');

                        // si se encuentra el id lo guardamos en el array
                        if(isset($consulta[0]))
                            $terceros[$posTer]["FrecuenciaMedicion_idConsumeLicor"] = $consulta[0];
                        else
                        {
                            
                            $errores[$posErr]["linea"] = $fila;
                            $errores[$posErr]["nombre"] = $terceros[ $posTer]["nombreCompletoTercero"];
                            $errores[$posErr]["mensaje"] = 'Código de Frecuencia de Consumo de Licor '. $terceros[ $posTer]["FrecuenciaMedicion_idConsumeLicor"]. ' no existe';
                            
                            $posErr++;
                        }
                    }
                }

                $posTer++;
                $fila++;
                
            }

            $totalErrores = count($errores);

            if($totalErrores > 0)
            {
                $mensaje = '<table cellspacing="0" cellpadding="1" style="width:100%;">'.
                        '<tr>'.
                            '<td colspan="3">'.
                                '<h3>Informe de inconsistencias en Importacion de Empleados</h3>'.
                            '</td>'.
                        '</tr>'.
                        '<tr>'.
                            '<td >No. Línea</td>'.
                            '<td >Nombre</td>'.
                            '<td >Mensaje</td>'.
                        '</tr>';

                for($regErr = 0; $regErr < $totalErrores; $regErr++)
                {
                     $mensaje .= '<tr>'.
                                '<td >'.$errores[$regErr]["linea"].'</td>'.
                                '<td >'.$errores[$regErr]["nombre"].'</td>'.
                                '<td >'.$errores[$regErr]["mensaje"].'</td>'.
                            '</tr>';
                }
                $mensaje .= '</table>';
                echo json_encode(array(false, $mensaje));
            }
            else
            {
                // recorremos el array recibido para insertar o actualizar cada registro
                for($reg = 0; $reg < count($terceros); $reg++)
                {
                    
                    $indice = array(
                          'idTercero' => $terceros[$reg]["idTercero"]);

                    $data = array(
                        'TipoIdentificacion_idTipoIdentificacion' => $terceros[$reg]['TipoIdentificacion_idTipoIdentificacion'],
                        'documentoTercero' => $terceros[$reg]['documentoTercero'],
                        'nombre1Tercero' => $terceros[$reg]['nombre1Tercero'],
                        'nombre2Tercero' => $terceros[$reg]['nombre2Tercero'],
                        'apellido1Tercero' => $terceros[$reg]['apellido1Tercero'],
                        'apellido2Tercero' => $terceros[$reg]['apellido2Tercero'],
                        'nombreCompletoTercero' => $terceros[$reg]['nombreCompletoTercero'],
                        'fechaCreacionTercero' => $terceros[$reg]['fechaCreacionTercero'],
                        'estadoTercero' => $terceros[$reg]['estadoTercero'],
                        'imagenTercero' => $terceros[$reg]['imagenTercero'],
                        'tipoTercero' => $terceros[$reg]['tipoTercero'],
                        'direccionTercero' => $terceros[$reg]['direccionTercero'],
                        'Ciudad_idCiudad' => $terceros[$reg]['Ciudad_idCiudad'],
                        'telefonoTercero' => $terceros[$reg]['telefonoTercero'],
                        'faxTercero' => $terceros[$reg]['faxTercero'],
                        'movil1Tercero' => $terceros[$reg]['movil1Tercero'],
                        'movil2Tercero' => $terceros[$reg]['movil2Tercero'],
                        'sexoTercero' => $terceros[$reg]['sexoTercero'],
                        'fechaNacimientoTercero' => $terceros[$reg]['fechaNacimientoTercero'],
                        'correoElectronicoTercero' => $terceros[$reg]['correoElectronicoTercero'],
                        'paginaWebTercero' => $terceros[$reg]['paginaWebTercero'],
                        'Cargo_idCargo' => $terceros[$reg]['Cargo_idCargo'],
                        'Compania_idCompania' => \Session::get("idCompania")
                    );


                    $tercero = \App\Tercero::updateOrCreate($indice, $data);

                    if($terceros[$reg]["idTercero"] == 0)
                    {
                        $tercero = \App\Tercero::All()->last();
                        $idtercero = $tercero->idTercero;
                    }
                    else
                        $idtercero = $terceros[$reg]["idTercero"]

                    $indice = array(
                          'idTerceroInformacion' => $terceros[$reg]['idTerceroInformacion']);

                    $data = array(
                        'Tercero_idTercero' => $idtercero,
                        'fechaIngresoTerceroInformacion' => $terceros[$reg]['fechaIngresoTerceroInformacion'],
                        'fechaRetiroTerceroInformacion' => $terceros[$reg]['fechaRetiroTerceroInformacion'],
                        'tipoContratoTerceroInformacion' => $terceros[$reg]['tipoContratoTerceroInformacion'],
                        'aniosExperienciaTerceroInformacion' => $terceros[$reg]['aniosExperienciaTerceroInformacion'],
                        'educacionTerceroInformacion' => $terceros[$reg]['educacionTerceroInformacion'],
                        'experienciaTerceroInformacion' => $terceros[$reg]['experienciaTerceroInformacion'],
                        'formacionTerceroInformacion' => $terceros[$reg]['formacionTerceroInformacion'],
                        'estadoCivilTerceroInformacion' => $terceros[$reg]['estadoCivilTerceroInformacion'],
                        'numeroHijosTerceroInformacion' => $terceros[$reg]['numeroHijosTerceroInformacion'],
                        'composicionFamiliarTerceroInformacion' => $terceros[$reg]['composicionFamiliarTerceroInformacion'],
                        'estratoSocialTerceroInformacion' => $terceros[$reg]['estratoSocialTerceroInformacion'],
                        'tipoViviendaTerceroInformacion' => $terceros[$reg]['tipoViviendaTerceroInformacion'],
                        'tipoTransporteTerceroInformacion' => $terceros[$reg]['tipoTransporteTerceroInformacion'],
                        'HobbyTerceroInformacion' => $terceros[$reg]['HobbyTerceroInformacion'],
                        'actividadFisicaTerceroInformacion' => $terceros[$reg]['actividadFisicaTerceroInformacion'],
                        'consumeLicorTerceroInformacion' => $terceros[$reg]['consumeLicorTerceroInformacion'],
                        'FrecuenciaMedicion_idConsumeLicor' => $terceros[$reg]['FrecuenciaMedicion_idConsumeLicor'],
                        'consumeCigarrilloTerceroInformacion' => $terceros[$reg]['consumeCigarrilloTerceroInformacion']
                        );

                    $tercero = \App\TerceroInformacion::updateOrCreate($indice, $data);
                }
                echo json_encode(array(true, 'Importacion Exitosa, por favor verifique'));
            }


        });
        unlink ( $destinationPath.'/Plantilla Empleados.xlsx');
        
    }


}