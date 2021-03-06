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

    // Primero se busca el modelo del Modulo  para enviar por parametros.
    public function find(Route $route){
        $this->tercero = \App\Tercero::find($route->getParameter('tercero'));
        return $this->tercero;
    }
    public function index()
    {
        // Se recibe el parametro que se crea en el modulo "OPCION"
        $vista = basename($_SERVER["PHP_SELF"].'?tipoTercero='.$_GET['tipoTercero']);
        $datos = consultarPermisos($vista);

        if($datos != null)
        {
            // Se hace la condicion para las 3 rutas del parametro de tipo de tercero con el fin de que muestre la grid correspondiente
            if ($vista ==  basename($_SERVER["PHP_SELF"].'?tipoTercero='.'*01*')) 
                {
                     return view('terceroempleadogrid', compact('datos'));
                }
            else 
            if ($vista ==  basename($_SERVER["PHP_SELF"].'?tipoTercero='.'*02*')) 
                {
                     return view('terceroproveedorgrid', compact('datos'));
                }
            else
            if ($vista == basename($_SERVER["PHP_SELF"].'?tipoTercero='.'*03*')) 
                {
                     return view('terceroclientegrid', compact('datos'));
                }

           
        }
        else
        {
            return view('accesodenegado');
        }
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

   
         $centrocosto = \App\CentroCosto::where('Compania_idCompania', "=", \Session::get('idCompania'))->lists('nombreCentroCosto','idCentroCosto'); 
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

        $tipoproveedor = \App\TipoProveedor::where('Compania_idCompania', '=', \Session::get('idCompania'))->lists('nombreTipoProveedor', 'idTipoProveedor');
        
      
        return view('tercero',compact('centrocosto','ciudad','tipoIdentificacion','cargo','idTipoExamen','nombreTipoExamen','idFrecuenciaMedicion','nombreFrecuenciaMedicion','frecuenciaAlcohol', 'zona', 'sectorempresa','empleadorcontratista', 'tipoproveedor'));
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
                'TipoProveedor_idTipoProveedor' => (($request['TipoProveedor_idTipoProveedor'] == '' or $request['TipoProveedor_idTipoProveedor'] == 0) ? null : $request['TipoProveedor_idTipoProveedor']),
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
                'CentroCosto_idCentroCosto' => (($request['CentroCosto_idCentroCosto'] == '' or $request['CentroCosto_idCentroCosto'] == 0) ? null : $request['CentroCosto_idCentroCosto']),
                'observacionTercero' => $request["observacionTercero"],            
                'contratistaTercero' => isset($request['contratistaTercero']) ? 1 : 0,
                'Compania_idCompania' => \Session::get('idCompania')
                ]);
            
            $tercero = \App\Tercero::All()->last();

            \App\TerceroInformacion::create([
                    'Tercero_idTercero' => $tercero->idTercero,
                    'fechaNacimientoTerceroInformacion' => $request['fechaNacimientoTerceroInformacion'],
                    'fechaIngresoTerceroInformacion' => $request['fechaIngresoTerceroInformacion'],
                    'fechaRetiroTerceroInformacion' => $request['fechaRetiroTerceroInformacion'],
                    'fechaInicioExamenMedicoTerceroInformacion' => $request['fechaInicioExamenMedicoTerceroInformacion'],
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
            
           
            $contadorTipoProveedorSeleccion = count($request['cumpleTerceroTipoProveedorSeleccion']);
            for($i = 0; $i < $contadorTipoProveedorSeleccion; $i++)
            {
                \App\TerceroTipoProveedorSeleccion::create([
                'cumpleTerceroTipoProveedorSeleccion' => $request['cumpleTerceroTipoProveedorSeleccion'][$i],
                'Tercero_idTercero' => $tercero->idTercero,
                'TipoProveedorSeleccion_idTipoProveedorSeleccion' => $request['TipoProveedorSeleccion_idTipoProveedorSeleccion'][$i]
               ]);
            }

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
                'FichaTecnica_idFichaTecnica' => $request['FichaTecnica_idFichaTecnica'][$i]
               ]);
            }
            // Se quita Esta mltiregistro ya que es un campo que ya están en cargos / perfiles

            // $contadorExamen = count($request['TipoExamenMedico_idTipoExamenMedico']);
            // for($i = 0; $i < $contadorExamen; $i++)
            // {
            //     \App\TerceroExamenMedico::create([
            //     'Tercero_idTercero' => $tercero->idTercero,
            //     'TipoExamenMedico_idTipoExamenMedico' => $request['TipoExamenMedico_idTipoExamenMedico'][$i], 
            //     'ingresoTerceroExamenMedico' => $request['ingresoTerceroExamenMedico'][$i], 
            //     'retiroTerceroExamenMedico' => $request['retiroTerceroExamenMedico'][$i], 
            //     'periodicoTerceroExamenMedico' => $request['periodicoTerceroExamenMedico'][$i], 
            //     'FrecuenciaMedicion_idFrecuenciaMedicion' => $request['FrecuenciaMedicion_idFrecuenciaMedicion'][$i]   
            //    ]);
            // }

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
            
            return redirect('/tercero?tipoTercero='.$request['tipoTercero']);
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

        $centrocosto = \App\CentroCosto::where('Compania_idCompania', "=", \Session::get('idCompania'))->lists('nombreCentroCosto','idCentroCosto');
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

        $tipoproveedor = \App\TipoProveedor::where('Compania_idCompania', '=', \Session::get('idCompania'))->lists('nombreTipoProveedor', 'idTipoProveedor');

        $proveedorseleccion = DB::Select('
            SELECT idTerceroTipoProveedorSeleccion, cumpleTerceroTipoProveedorSeleccion, TipoProveedorSeleccion_idTipoProveedorSeleccion, Tercero_idTercero, descripcionTipoProveedorSeleccion as descripcionTerceroTipoProveedorSeleccion
            FROM tercerotipoproveedorseleccion ttps
            LEFT JOIN tipoproveedorseleccion tps ON ttps.TipoProveedorSeleccion_idTipoProveedorSeleccion = tps.idTipoProveedorSeleccion
            WHERE Tercero_idTercero = '.$id);

        $terceroproducto = DB::Select('
            SELECT idTerceroProducto, FichaTecnica_idFichaTecnica, referenciaFichaTecnica as referenciaTerceroProducto, nombreFichaTecnica as descripcionProducto
            FROM terceroproducto tp
            LEFT JOIN fichatecnica ft ON tp.FichaTecnica_idFichaTecnica = ft.idFichaTecnica
            WHERE tp.Tercero_idTercero = '.$id);

        $tercero = \App\Tercero::find($id);

        return view('tercero',compact('centrocosto','ciudad','tipoIdentificacion','cargo','idTipoExamen','nombreTipoExamen','idFrecuenciaMedicion','nombreFrecuenciaMedicion','frecuenciaAlcohol', 'zona', 'sectorempresa', 'empleadorcontratista', 'tipoproveedor', 'proveedorseleccion', 'terceroproducto'),['tercero'=>$tercero]);
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
            $tercero->CentroCosto_idCentroCosto = (($request['CentroCosto_idCentroCosto'] == '' or $request['CentroCosto_idCentroCosto'] == 0) ? null : $request['CentroCosto_idCentroCosto'
                ]);

            $tercero->TipoProveedor_idTipoProveedor = (($request['TipoProveedor_idTipoProveedor'] == '' or $request['TipoProveedor_idTipoProveedor'] == 0) ? null : $request['TipoProveedor_idTipoProveedor'
                ]);
            // Checlbbox de contratista
             $tercero->contratistaTercero = isset($request['contratistaTercero']) ? 1 : 0;
       

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
                'fechaInicioExamenMedicoTerceroInformacion' => $request['fechaInicioExamenMedicoTerceroInformacion'],
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

            for ($i=0; $i < count($request['cumpleTerceroTipoProveedorSeleccion']); $i++) 
            { 
                $indice = array(
                  'idTerceroTipoProveedorSeleccion' => $request['idTerceroTipoProveedorSeleccion'][$i]);

                $data = array(
                'cumpleTerceroTipoProveedorSeleccion' => $request['cumpleTerceroTipoProveedorSeleccion'][$i],
                'Tercero_idTercero' => $id,
                'TipoProveedorSeleccion_idTipoProveedorSeleccion' => $request['TipoProveedorSeleccion_idTipoProveedorSeleccion'][$i]);

                $datos = \App\TerceroTipoProveedorSeleccion::updateOrCreate($indice, $data);
            }

            

            \App\TerceroContacto::where('Tercero_idTercero',$id)->delete();
            \App\TerceroProducto::where('Tercero_idTercero',$id)->delete();
            // \App\TerceroExamenMedico::where('Tercero_idTercero',$id)->delete();
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

            $contadorProducto = count($request['FichaTecnica_idFichaTecnica']);
            for($i = 0; $i < $contadorProducto; $i++)
            {
                \App\TerceroProducto::create([
                'Tercero_idTercero' => $id,
                'FichaTecnica_idFichaTecnica' => $request['FichaTecnica_idFichaTecnica'][$i]
               ]);
            }
            // Se quita Esta mltiregistro ya que es un campo que ya están en cargos / perfiles
            // $contadorExamen = count($request['TipoExamenMedico_idTipoExamenMedico']);
            // for($i = 0; $i < $contadorExamen; $i++)
            // {
            //     \App\TerceroExamenMedico::create([
            //     'Tercero_idTercero' => $id,
            //     'TipoExamenMedico_idTipoExamenMedico' => $request['TipoExamenMedico_idTipoExamenMedico'][$i], 
            //     'ingresoTerceroExamenMedico' => $request['ingresoTerceroExamenMedico'][$i], 
            //     'retiroTerceroExamenMedico' => $request['retiroTerceroExamenMedico'][$i], 
            //     'periodicoTerceroExamenMedico' => $request['periodicoTerceroExamenMedico'][$i], 
            //     'FrecuenciaMedicion_idFrecuenciaMedicion' => $request['FrecuenciaMedicion_idFrecuenciaMedicion'][$i]   
            //    ]);
            // }

            
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
            return redirect('/tercero?tipoTercero='.$request['tipoTercero']);
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
                                                                              //Se pone Tercero_id para que solo consulte los que empiezan por esa palabra y se pone la condicion (and...not like)de que no busque tercero en miniscula para las tablas hijas de tercero
         $consulta = DB::Select("SELECT TABLE_NAME, COLUMN_NAME FROM information_schema.`COLUMNS` WHERE COLUMN_NAME like 'Tercero_id%' and TABLE_SCHEMA = 'sisoft' and TABLE_NAME NOT LIKE 'tercero%'");
           //se crea una variable para concatenar 
        $tablas = ''; 
        // Variable para almancenar el tipo
        $tipo= '';
        if ($request['tipoTercero'] == '*01*') 
        {
            $tipo='Empleado';   
        }
        else if($request['tipoTercero'] == '*02*')
        {
            $tipo = 'Proveedor/Contratistas';
        }
        else if ($request['tipoTercero'] == '*03*')
        {
            $tipo= 'Cliente';
        }

        // se crea una variable para el nombre del modulo
        $nombremodulo = 'tercero Tipo '.$tipo;

        // esta variable es la que devuelve al formulario
        $nombremoduloformulario = 'tercero?tipoTercero='.$request['tipoTercero'];

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

            \App\Tercero::destroy($id);
             return redirect('/tercero?tipoTercero='.$request['tipoTercero']);
 
        }          
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
            $fila = 11;
            $posTer = 0;
            $posErr = 0;
            
            while ($datos->getCellByColumnAndRow(0, $fila)->getValue() != '' and
                    $datos->getCellByColumnAndRow(0, $fila)->getValue() != NULL) {
                

                // para cada registro de terceros recorremos las columnas desde la 0 hasta la 22
                $terceros[$posTer]["idTercero"] = 0;
                $terceros[$posTer]["Compania_idCompania"] = 0;
                for ($columna = 0; $columna <= 24; $columna++) {
                    // en la fila 4 del archivo de excel (oculta) estan los nombres de los campos de la tabla
                    $campo = $datos->getCellByColumnAndRow($columna, 10)->getValue();

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
                // Tipo de Tercero
                //*****************************
                // si la celda esta en blanco o no tiene una de las palabras válida, mostramos error
                if($terceros[$posTer]["tipoTercero"] == '' or 
                    $terceros[$posTer]["tipoTercero"] == null or 
                    ($terceros[$posTer]["tipoTercero"] != 'CLIENTE' and 
                    $terceros[$posTer]["tipoTercero"] != 'PROVEEDOR'))
                {
                    $errores[$posErr]["linea"] = $fila;
                    $errores[$posErr]["nombre"] = $terceros[ $posTer]["nombreCompletoTercero"];
                    $errores[$posErr]["mensaje"] = 'Debe seleccionar el Tipo de Tercero (CLIENTE o PROVEEDOR)';
                    
                    $posErr++;
                }
                else
                {
                    $terceros[$posTer]["tipoTercero"] = ($terceros[$posTer]["tipoTercero"] == 'PROVEEDOR' ? '*02*' : '*01*');
                }


                //*****************************
                // Es Contratista
                //*****************************
                // si la celda esta en blanco o no tiene una de las palabras válida, mostramos error
                if($terceros[$posTer]["contratistaTercero"] == '' or 
                    $terceros[$posTer]["contratistaTercero"] == null or 
                    ($terceros[$posTer]["contratistaTercero"] != 'SI' and 
                    $terceros[$posTer]["contratistaTercero"] != 'NO'))
                {
                    $errores[$posErr]["linea"] = $fila;
                    $errores[$posErr]["nombre"] = $terceros[ $posTer]["nombreCompletoTercero"];
                    $errores[$posErr]["mensaje"] = 'Debe seleccionar si es Contratista o no';
                    
                    $posErr++;
                }
                else
                {
                    $terceros[$posTer]["contratistaTercero"] = ($terceros[$posTer]["contratistaTercero"] == 'SI' ? 1 : 0);
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
                    ($terceros[$posTer]["estadoTercero"] != 'ACTIVO' and 
                    $terceros[$posTer]["estadoTercero"] != 'INACTIVO'))
                {
                    $terceros[$posTer]["estadoTercero"] = 'ACTIVO';
                }
            
                //*****************************
                // Dirección
                //*****************************
                // si la celda esta en blanco, reportamos error de obligatoriedad
                if($terceros[ $posTer]["direccionTercero"] == '' or 
                    $terceros[ $posTer]["direccionTercero"] == null)
                {
                    $errores[$posErr]["linea"] = $fila;
                    $errores[$posErr]["nombre"] = $terceros[ $posTer]["nombreCompletoTercero"];
                    $errores[$posErr]["mensaje"] = 'Debe diligenciar la Dirección';
                    
                    $posErr++;
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
                // Teléfono
                //*****************************
                // si la celda esta en blanco, reportamos error de obligatoriedad
                if($terceros[ $posTer]["telefonoTercero"] == '' or 
                    $terceros[ $posTer]["telefonoTercero"] == null)
                {
                    $errores[$posErr]["linea"] = $fila;
                    $errores[$posErr]["nombre"] = $terceros[ $posTer]["nombreCompletoTercero"];
                    $errores[$posErr]["mensaje"] = 'Debe diligenciar el Teléfono';
                    
                    $posErr++;
                }


                //*****************************
                // Zona
                //*****************************
                // si la celda esta en blanco, reportamos error de obligatoriedad
                if($terceros[ $posTer]["Zona_idZona"] == '' or 
                    $terceros[ $posTer]["Zona_idZona"] == null)
                {
                    $terceros[$posTer]["Zona_idZona"] = null;
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
                        $errores[$posErr]["linea"] = $fila;
                        $errores[$posErr]["nombre"] = $terceros[ $posTer]["nombreCompletoTercero"];
                        $errores[$posErr]["mensaje"] = 'Código de Zona '. $terceros[ $posTer]["Zona_idZona"]. ' no existe';
                        $posErr++;
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
                        $errores[$posErr]["linea"] = $fila;
                        $errores[$posErr]["nombre"] = $terceros[ $posTer]["nombreCompletoTercero"];
                        $errores[$posErr]["mensaje"] = 'Código de Sector Empresarial '. $terceros[ $posTer]["SectorEmpresa_idSectorEmpresa"]. ' no existe';
                        
                        $posErr++;
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
                for($posTer = 0; $posTer < count($terceros); $posTer++) 
                {

                    $fechaCreacion = ($terceros[$posTer]['fechaCreacionTercero'] + 2 - 25569.833299) * 86400; 
                    $fechaCreacion = date("Y-m-d",$fechaCreacion);
                    
                    $indice = array(
                          'idTercero' => $terceros[$posTer]["idTercero"]);

                    $data = array(
                        'TipoIdentificacion_idTipoIdentificacion' => $terceros[$posTer]['TipoIdentificacion_idTipoIdentificacion'],
                        'documentoTercero' => $terceros[$posTer]['documentoTercero'],
                        'nombreCompletoTercero' => $terceros[$posTer]['nombreCompletoTercero'],
                        'fechaCreacionTercero' => $fechaCreacion,
                        'estadoTercero' => $terceros[$posTer]['estadoTercero'],
                        'imagenTercero' => $terceros[$posTer]['imagenTercero'],
                        'tipoTercero' => $terceros[$posTer]['tipoTercero'],
                        'contratistaTercero' => $terceros[$posTer]['contratistaTercero'],
                        'direccionTercero' => $terceros[$posTer]['direccionTercero'],
                        'Ciudad_idCiudad' => $terceros[$posTer]['Ciudad_idCiudad'],
                        'telefonoTercero' => $terceros[$posTer]['telefonoTercero'],
                        'faxTercero' => $terceros[$posTer]['faxTercero'],
                        'movil1Tercero' => $terceros[$posTer]['movil1Tercero'],
                        'movil2Tercero' => $terceros[$posTer]['movil2Tercero'],
                        'correoElectronicoTercero' => $terceros[$posTer]['correoElectronicoTercero'],
                        'paginaWebTercero' => $terceros[$posTer]['paginaWebTercero'],
                        'Zona_idZona' => $terceros[$posTer]['Zona_idZona'],
                        'SectorEmpresa_idSectorEmpresa' => $terceros[$posTer]['SectorEmpresa_idSectorEmpresa'],
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
            $fila = 11;
            $posTer = 0;
            $posErr = 0;
            
            while ($datos->getCellByColumnAndRow(0, $fila)->getValue() != '' and
                    $datos->getCellByColumnAndRow(0, $fila)->getValue() != NULL) {

                

                // para cada registro de empleados recorremos las columnas desde la 0 hasta la 40
                $terceros[$posTer]["idTercero"] = 0;
                $terceros[$posTer]["Compania_idCompania"] = 0;
                for ($columna = 0; $columna <= 41; $columna++) {
                    // en la fila 4 del archivo de excel (oculta) estan los nombres de los campos de la tabla
                    $campo = $datos->getCellByColumnAndRow($columna, 10)->getValue();

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
                    $errores[$posErr]["mensaje"] = 'Debe diligenciar el Tipo de identificación';
                    
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
                    $consulta = \App\Tercero::where('Compania_idCompania', "=", \Session::get('idCompania'))
                                            ->where('documentoTercero','=', $terceros[ $posTer]["documentoTercero"])->lists('idTercero');
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
                else
                {
                    // convertimosla fecha de excel a formato Y-m-d
                    if(is_numeric($terceros[$posTer]["fechaCreacionTercero"]))
                    {
                        $terceros[$posTer]["fechaCreacionTercero"] = date("Y-m-d",$terceros[$posTer]["fechaCreacionTercero"]);

                        if( !$this->validarFormatoFecha($terceros[$posTer]["fechaCreacionTercero"]))
                        {
                            $errores[$posErr]["linea"] = $fila;
                            $errores[$posErr]["nombre"] = $terceros[ $posTer]["nombreCompletoTercero"];
                            $errores[$posErr]["mensaje"] = 'La fecha de creación no es válida ('.gettype($terceros[$posTer]["fechaCreacionTercero"]).$terceros[$posTer]["fechaCreacionTercero"].'), debe ser en formato AAAA-MM-DD';
                            
                            $posErr++;
                        }
                    }
                    else
                    {
                        $errores[$posErr]["linea"] = $fila;
                        $errores[$posErr]["nombre"] = $terceros[ $posTer]["nombreCompletoTercero"];
                        $errores[$posErr]["mensaje"] = 'La fecha de creación no es un formato adecuado ('.$terceros[$posTer]["fechaCreacionTercero"].'), debe ser en formato AAAA-MM-DD';
                        
                        $posErr++;
                    }
                    
                    
                }


                //*****************************
                // Estado
                //*****************************
                // si la celda esta en blanco o no tiene una de las palabras válida, la llenamos con activo
                if($terceros[$posTer]["estadoTercero"] == '' or 
                    $terceros[$posTer]["estadoTercero"] == null or 
                    ($terceros[$posTer]["estadoTercero"] != 'ACTIVO' and 
                    $terceros[$posTer]["estadoTercero"] != 'INACTIVO'))
                {
                    $terceros[$posTer]["estadoTercero"] = 'ACTIVO';
                }

                //*****************************
                // Tipo de Tercero
                //*****************************
                // se llena fijo como empleado (01)
                $terceros[$posTer]["tipoTercero"] = '*01*';
            

                //*****************************
                // Direccion
                //*****************************
                // si la celda esta en blanco, reportamos error de obligatoriedad
                if($terceros[ $posTer]["direccionTercero"] == '' or 
                    $terceros[ $posTer]["direccionTercero"] == null)
                {
                    $errores[$posErr]["linea"] = $fila;
                    $errores[$posErr]["nombre"] = $terceros[ $posTer]["nombreCompletoTercero"];
                    $errores[$posErr]["mensaje"] = 'Debe diligenciar la Dirección';
                    
                    $posErr++;
                }

                 //*****************************
                // Teléfono
                //*****************************
                // si la celda esta en blanco, reportamos error de obligatoriedad
                if($terceros[ $posTer]["telefonoTercero"] == '' or 
                    $terceros[ $posTer]["telefonoTercero"] == null)
                {
                    $errores[$posErr]["linea"] = $fila;
                    $errores[$posErr]["nombre"] = $terceros[ $posTer]["nombreCompletoTercero"];
                    $errores[$posErr]["mensaje"] = 'Debe diligenciar el Teléfono';
                    
                    $posErr++;
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
                // Sexo
                //*****************************
                // Validamos el campo de lista enviando, el nombre del campo, los valores posibles y el mensaje de error
                $resp = $this->validarListaSeleccion($terceros[$posTer], $fila, "sexoTercero", ",null,M,F", "el Sexo (M o F)");
                $posErr += count($resp);
                $errores = array_merge($errores, $resp);

                

                //*****************************
                // Cargo
                //*****************************
                // si la celda NO esta en blanco, validamos que el codigo exista en la BD
                if($terceros[ $posTer]["Cargo_idCargo"] != '' and 
                    $terceros[ $posTer]["Cargo_idCargo"] != null)
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
                // Centro de Costos
                //*****************************
                // si la celda NO esta en blanco, validamos que el codigo exista en la BD
                if($terceros[ $posTer]["CentroCosto_idCentroCosto"] != '' and 
                    $terceros[ $posTer]["CentroCosto_idCentroCosto"] != null)
                {
                
                    $consulta = \App\CentroCosto::where('Compania_idCompania', "=", \Session::get('idCompania'))
                                                ->where('codigoCentroCosto','=', $terceros[ $posTer]["CentroCosto_idCentroCosto"])->lists('idCentroCosto');

                    // si se encuentra el id lo guardamos en el array
                    if(isset($consulta[0]))
                        $terceros[$posTer]["CentroCosto_idCentroCosto"] = $consulta[0];
                    else
                    {
                        
                        $errores[$posErr]["linea"] = $fila;
                        $errores[$posErr]["nombre"] = $terceros[ $posTer]["nombreCompletoTercero"];
                        $errores[$posErr]["mensaje"] = 'Código de Centro de Costos '. $terceros[ $posTer]["CentroCosto_idCentroCosto"]. ' no existe';
                        
                        $posErr++;
                    }
                }

                
                //*****************************
                // Tipo de Contrato
                //*****************************
                // Validamos el campo de lista enviando, el nombre del campo, los valores posibles y el mensaje de error
                $resp = $this->validarListaSeleccion($terceros[$posTer], $fila, "tipoContratoTerceroInformacion", ",null,C,TF,I,S", "el Tipo de Contrato");
                $posErr += count($resp);
                $errores = array_merge($errores, $resp);


                //*****************************
                // Estado Civil
                //*****************************
                // Validamos el campo de lista enviando, el nombre del campo, los valores posibles y el mensaje de error
                $resp = $this->validarListaSeleccion($terceros[$posTer], $fila, "estadoCivilTerceroInformacion", ",null,CASADO,SOLTERO", "el Estado Civil");
                $posErr += count($resp);
                $errores = array_merge($errores, $resp);

                //*****************************
                // Composición Familiar
                //*****************************
                // Validamos el campo de lista enviando, el nombre del campo, los valores posibles y el mensaje de error
                $resp = $this->validarListaSeleccion($terceros[$posTer], $fila, "composicionFamiliarTerceroInformacion", ",null,VS,SH,EH,FO,A", "la Composición Familiar");
                $posErr += count($resp);
                $errores = array_merge($errores, $resp);

                //*****************************
                // Tipo de Vivienda
                //*****************************
                // Validamos el campo de lista enviando, el nombre del campo, los valores posibles y el mensaje de error
                $resp = $this->validarListaSeleccion($terceros[$posTer], $fila, "tipoViviendaTerceroInformacion", ",null,PROPIA,ARRENDADA,FAMILIAR", "el Tipo de Vivienda");
                $posErr += count($resp);
                $errores = array_merge($errores, $resp);

                //*****************************
                // Tipo de Transporte
                //*****************************
                // Validamos el campo de lista enviando, el nombre del campo, los valores posibles y el mensaje de error
                $resp = $this->validarListaSeleccion($terceros[$posTer], $fila, "tipoTransporteTerceroInformacion", ",null,PIE,BICICLETA,PUBLICO,MOTO,CARRO", "el Tipo de Transporte");
                $posErr += count($resp);
                $errores = array_merge($errores, $resp);
               
                //*****************************
                // Actividad Física
                //*****************************
                // Validamos el campo de lista enviando, el nombre del campo, los valores posibles y el mensaje de error
                $resp = $this->validarListaSeleccion($terceros[$posTer], $fila, "actividadFisicaTerceroInformacion", ",null,SI,NO", "si hace o no actividad física");
                $posErr += count($resp);
                $errores = array_merge($errores, $resp);
                
                //*****************************
                // Consume Licor
                //*****************************
                // Validamos el campo de lista enviando, el nombre del campo, los valores posibles y el mensaje de error
                $resp = $this->validarListaSeleccion($terceros[$posTer], $fila, "consumeLicorTerceroInformacion", ",null,SI,NO", "si consume o no licor");
                $posErr += count($resp);
                $errores = array_merge($errores, $resp);

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
                        $consulta = \App\FrecuenciaMedicion::where('codigoFrecuenciaMedicion','=', $terceros[ $posTer]["FrecuenciaMedicion_idConsumeLicor"])->lists('idFrecuenciaMedicion');

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
                else
                {
                    $terceros[$posTer]["FrecuenciaMedicion_idConsumeLicor"] = 0;
                }

                //*****************************
                // Consume Cigarrillo
                //*****************************
                // Validamos el campo de lista enviando, el nombre del campo, los valores posibles y el mensaje de error
                $resp = $this->validarListaSeleccion($terceros[$posTer], $fila, "consumeCigarrilloTerceroInformacion", ",null,SI,NO", "si consume o no cigarrillo");
                $posErr += count($resp);
                $errores = array_merge($errores, $resp);

                
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
                    

                    $fechaNacimiento = ($terceros[$reg]['fechaNacimientoTercero'] + 2 - 25569.833299) * 86400; 
                    $fechaNacimiento = date("Y-m-d",$fechaNacimiento);


                    $fechaIngreso = ($terceros[$reg]['fechaIngresoTerceroInformacion'] + 2 - 25569.833299) * 86400; 
                    $fechaIngreso = date("Y-m-d",$fechaIngreso);

                    $fechaRetiro = ($terceros[$reg]['fechaRetiroTerceroInformacion'] + 2 - 25569.833299) * 86400; 
                    $fechaRetiro = date("Y-m-d",$fechaRetiro);

                    $fechaCreacion = ($terceros[$reg]['fechaCreacionTercero'] + 2 - 25569.833299) * 86400; 
                    $fechaCreacion = date("Y-m-d",$fechaCreacion);

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
                        'fechaCreacionTercero' => $fechaCreacion,
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
                        'correoElectronicoTercero' => $terceros[$reg]['correoElectronicoTercero'],
                        'paginaWebTercero' => $terceros[$reg]['paginaWebTercero'],
                        'Cargo_idCargo' => $terceros[$reg]['Cargo_idCargo'],
                         'CentroCosto_idCentroCosto' => ($terceros[$reg]['CentroCosto_idCentroCosto'] == '' or $terceros[$reg]['CentroCosto_idCentroCosto'] == 0 ? null : $terceros[$reg]['CentroCosto_idCentroCosto']),
                        'Compania_idCompania' => \Session::get("idCompania")
                    );


                    $tercero = \App\Tercero::updateOrCreate($indice, $data);

                    

                    if($terceros[$reg]["idTercero"] == 0)
                    {
                        $tercero = \App\Tercero::All()->last();
                        $idtercero = $tercero->idTercero;
                        $idTerceroInformacion = array(0 =>'');
                    }
                    else
                    {
                        $idtercero = $terceros[$reg]["idTercero"];
                        $idTerceroInformacion = \App\TerceroInformacion::where('Tercero_idTercero','=',$idtercero)->lists('idTerceroInformacion');
                    }

                    $indice = array(
                          'idTerceroInformacion' => isset($idTerceroInformacion[0]) ? $idTerceroInformacion[0] : 0 ); 

                    $data = array(
                        'Tercero_idTercero' => $idtercero,
                        'fechaNacimientoTerceroInformacion' => $fechaNacimiento,
                        'fechaIngresoTerceroInformacion' => $fechaIngreso,
                        'fechaRetiroTerceroInformacion' => $fechaRetiro,
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
                        'actividadFisicaTerceroInformacion' => ($terceros[$reg]['actividadFisicaTerceroInformacion'] == 'SI' ? 1 : 0),
                        'consumeLicorTerceroInformacion' => ($terceros[$reg]['consumeLicorTerceroInformacion'] == 'SI' ? 1 : 0),
                        'FrecuenciaMedicion_idConsumeLicor' => ($terceros[$reg]['FrecuenciaMedicion_idConsumeLicor'] == '' or $terceros[$reg]['FrecuenciaMedicion_idConsumeLicor'] == 0 ? null : $terceros[$reg]['FrecuenciaMedicion_idConsumeLicor']),
                        'consumeCigarrilloTerceroInformacion' =>($terceros[$reg]['consumeCigarrilloTerceroInformacion'] == 'SI' ? 1 : 0)
                        );

                    $tercero = \App\TerceroInformacion::updateOrCreate($indice, $data);
                }
                echo json_encode(array(true, 'Importacion Exitosa, por favor verifique'));
            }


        });
        unlink ( $destinationPath.'/Plantilla Empleados.xlsx');
        
    }

    function validarListaSeleccion($terceros, $fila, $campo, $opciones, $error)
    {
        $valores = explode(",", $opciones);
        $aError = array();
        if( !in_array($terceros[$campo], $valores) )
        {
            $aError[0]["linea"] = $fila;
            $aError[0]["nombre"] = $terceros["nombreCompletoTercero"];
            $aError[0]["mensaje"] = 'Debe seleccionar '.$error;
            
           
        }
        return $aError;
    }

    function validarFormatoFecha($fecha)
    {
        $valores = explode('-', $fecha);
        if(count($valores) == 3 && checkdate($valores[1], $valores[2], $valores[0])){
            return true;
        }
        return false;
    }

}