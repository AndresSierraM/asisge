<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\PlanEmergenciaRequest;
use App\Http\Controllers\Controller;
use DB;

include public_path().'/ajax/consultarPermisos.php';

class PlanEmergenciaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */



      // Esta funcion es para que cuando suba el archvio vaya al repositorio/temporal y guarde una copia mientras le dan guardar al registro 
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


    public function index()
    {



         $vista = basename($_SERVER["PHP_SELF"]);
         $datos = consultarPermisos($vista);

         if($datos != null)
          return view('planemergenciagrid', compact('datos'));
         else
            return view('accesodenegado');
        
        // return view('perfilcargogrid');

     }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       
        $centrocosto = \App\CentroCosto::where('Compania_idCompania', "=", \Session::get('idCompania'))->lists('nombreCentroCosto','idCentroCosto');
        $tercero = \App\Tercero::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('nombreCompletoTercero','idTercero');


  // Se crea una array mandando las 3 posiciones para que salgan al crear un registro
        $Nivel =  array();

        $Nivel[0] = ['','','Estratégico','','','']; 
        $Nivel[1] = ['','','Táctico','','',''];
        $Nivel[2] = ['','','Ejecución','','',''];


         
        return view ('planemergencia', compact('Nivel','centrocosto','tercero'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PlanEmergenciaRequest $request)
    {
     if($request['respuesta'] != 'falso')
        {  
         \App\PlanEmergencia::create([
         'fechaElaboracionPlanEmergencia' => $request['fechaElaboracionPlanEmergencia'],
         'nombrePlanEmergencia' => $request['nombrePlanEmergencia'],
         'CentroCosto_idCentroCosto'=> $request['CentroCosto_idCentroCosto'], 
         'justificacionPlanEmergencia'=> $request['justificacionPlanEmergencia'],
         'marcoLegalPlanEmergencia'=> $request['marcoLegalPlanEmergencia'],
         'definicionesPlanEmergencia'=> $request['definicionesPlanEmergencia'],
         'generalidadesPlanEmergencia'=> $request['generalidadesPlanEmergencia'],
         'objetivosPlanEmergencia'=> $request['objetivosPlanEmergencia'],
         'alcancePlanEmergencia'=> $request['alcancePlanEmergencia'],
         'nitPlanEmergencia'=> $request['nitPlanEmergencia'],
         'direccionPlanEmergencia'=> $request['direccionPlanEmergencia'],
         'telefonoPlanEmergencia'=> $request['telefonoPlanEmergencia'],
         'ubicacionPlanEmergencia'=> $request['ubicacionPlanEmergencia'],
         'personalOperativoPlanEmergencia'=> $request['personalOperativoPlanEmergencia'],
         'personalAdministrativoPlanEmergencia'=> $request['personalAdministrativoPlanEmergencia'],
         'turnoOperativoPlanEmergencia'=> $request['turnoOperativoPlanEmergencia'],
         'turnoAdministrativoPlanEmergencia'=> $request['turnoAdministrativoPlanEmergencia'],
         'visitasDiaPlanEmergencia'=> $request['visitasDiaPlanEmergencia'],
         'Tercero_idRepresentanteLegal'=> $request['Tercero_idRepresentanteLegal'],
         'Compania_idCompania' => \Session::get('idCompania')
        ]);

            // en esta parte es el guardado de la multiregistro descripcion
           //Primero consultar el ultimo id guardado
       $planemergencia = \App\PlanEmergencia::All()->last();
           //for para guardar cada registro de la multiregistro


       // GUargado de la tabla definicion 1
       \App\PlanEmergenciaDefinicion1::create([
         'PlanEmergencia_idPlanEmergencia' => $planemergencia->idPlanEmergencia,
         'procedimientoEmergenciaPlanEmergenciaDefinicion1' => $request['procedimientoEmergenciaPlanEmergenciaDefinicion1'],
         'sistemaAlertaPlanEmergenciaDefinicion1'  => $request['sistemaAlertaPlanEmergenciaDefinicion1'],
         'notificacionInternaPlanEmergenciaDefinicion1'  => $request['notificacionInternaPlanEmergenciaDefinicion1'],
         'rutasEvacuacionPlanEmergenciaDefinicion1'  => $request['rutasEvacuacionPlanEmergenciaDefinicion1']
       ]);

           // GUargado de la tabla definicion 2
       \App\PlanEmergenciaDefinicion2::create([
         'PlanEmergencia_idPlanEmergencia' => $planemergencia->idPlanEmergencia,
         'sistemaComunicacionPlanEmergenciaDefinicion2' => $request['sistemaComunicacionPlanEmergenciaDefinicion2'],
         'coordinacionSocorroPlanEmergenciaDefinicion2' => $request['coordinacionSocorroPlanEmergenciaDefinicion2'],
         'cesePeligroPlanEmergenciaDefinicion2' => $request['cesePeligroPlanEmergenciaDefinicion2']
       ]);


             // GUargado de la tabla definicion 3
       \App\PlanEmergenciaDefinicion3::create([
         'PlanEmergencia_idPlanEmergencia' => $planemergencia->idPlanEmergencia,
         'capacitacionSimulacroPlanEmergenciaDefinicion3' => $request['capacitacionSimulacroPlanEmergenciaDefinicion3'],
         'analisisVulnerabilidadPlanEmergenciaDefinicion3' => $request['analisisVulnerabilidadPlanEmergenciaDefinicion3'],
         'listaAnexosPlanEmergenciaDefinicion3' => $request['listaAnexosPlanEmergenciaDefinicion3']
       ]);







       // Multiregistro limite Guardado
        for ($i=0; $i < count($request['sedePlanEmergenciaLimite']); $i++) 
           { 
            \App\PlanEmergenciaLimite::create([
            'PlanEmergencia_idPlanEmergencia' => $planemergencia->idPlanEmergencia,
            'sedePlanEmergenciaLimite' => $request['sedePlanEmergenciaLimite'][$i],
            'nortePlanEmergenciaLimite' => $request['nortePlanEmergenciaLimite'][$i], 
            'surPlanEmergenciaLimite' => $request['surPlanEmergenciaLimite'][$i],
            'orientePlanEmergenciaLimite' => $request['orientePlanEmergenciaLimite'][$i],
            'occidentePlanEmergenciaLimite' => $request['occidentePlanEmergenciaLimite'][$i]
              ]);
           }

           // Multiregistro inventario Guardado
           for ($i=0; $i < count($request['sedePlanEmergenciaInventario']); $i++) 
           { 
            \App\PlanEmergenciaInventario::create([
            'PlanEmergencia_idPlanEmergencia' => $planemergencia->idPlanEmergencia,
            'sedePlanEmergenciaInventario' => $request['sedePlanEmergenciaInventario'][$i],
            'recursoPlanEmergenciaInventario' => $request['recursoPlanEmergenciaInventario'][$i], 
            'cantidadPlanEmergenciaInventario' => $request['cantidadPlanEmergenciaInventario'][$i],
            'ubicacionPlanEmergenciaInventario' => $request['ubicacionPlanEmergenciaInventario'][$i],
            'observacionPlanEmergenciaInventario' => $request['observacionPlanEmergenciaInventario'][$i]
              ]);
           }

               // Multiregistro Comite Guardado
           for ($i=0; $i < count($request['comitePlanEmergenciaComite']); $i++) 
           { 
            \App\PlanEmergenciaComite::create([
             'PlanEmergencia_idPlanEmergencia' => $planemergencia->idPlanEmergencia,
            'comitePlanEmergenciaComite' => $request['comitePlanEmergenciaComite'][$i],
            'integrantesPlanEmergenciaComite'  => $request['integrantesPlanEmergenciaComite'][$i], 
            'funcionesPlanEmergenciaComite' => $request['funcionesPlanEmergenciaComite'][$i],
            'antesPlanEmergenciaComite' => $request['antesPlanEmergenciaComite'][$i],
            'durantePlanEmergenciaComite' => $request['durantePlanEmergenciaComite'][$i],
            'despuesPlanEmergenciaComite' => $request['despuesPlanEmergenciaComite'][$i]
              ]);
           }

               // Multiregistro Nivel Guardado
           for ($i=0; $i < count($request['cargoPlanEmergenciaNivel']); $i++) 
           { 
            \App\PlanEmergenciaNivel::create([
            'PlanEmergencia_idPlanEmergencia' => $planemergencia->idPlanEmergencia,
            'nivelPlanEmergenciaNivel' => $request['nivelPlanEmergenciaNivel'][$i],
            'cargoPlanEmergenciaNivel' => $request['cargoPlanEmergenciaNivel'][$i], 
            'funcionPlanEmergenciaNivel' => $request['funcionPlanEmergenciaNivel'][$i],
            'papelPlanEmergenciaNivel' => $request['papelPlanEmergenciaNivel'][$i]
              ]);        
           }




           // Guardado del dropzone
                $arrayImage = $request['archivoPlanEmergenciaArray'];
                $arrayImage = substr($arrayImage, 0, strlen($arrayImage)-1);
                $arrayImage = explode(",", $arrayImage);
                $ruta = '';
                for ($i=0; $i < count($arrayImage) ; $i++) 
                { 
                    if ($arrayImage[$i] != '' || $arrayImage[$i] != 0) 
                    {
                        $origen = public_path() . '/imagenes/repositorio/temporal/'.$arrayImage[$i];
                        $destinationPath = public_path() . '/imagenes/planemergencia/'.$arrayImage[$i];
                        $ruta = '/planemergencia/'.$arrayImage[$i];
                       
                        if (file_exists($origen))
                        {
                            copy($origen, $destinationPath);
                            unlink($origen);
                        }   
                        else
                        {
                            echo "No existe el archivo";
                        }
                        \App\PlanEmergenciaArchivo::create([
                        'PlanEmergencia_idPlanEmergencia' => $planemergencia->idPlanEmergencia,
                        'rutaPlanEmergenciaArchivo' => $ruta
                       ]);
                    }

                }

                   // armamos una ruta para el archivo de imagen y volvemos a actualizar el registro
            // esto es porque la creamos con el ID del accidente y debiamos grabar primero para obtenerlo
            $ruta = 'planemergencia/firmaplanemergencia_'.$planemergencia->idPlanEmergencia.'.png';
            $planemergencia->firmaRepresentantePlanEmergencia = $ruta;

            $planemergencia->save();

            //----------------------------
            // Guardamos la imagen de la firma como un archivo en disco
            if (isset($request['firmabase64']) and $request['firmabase64'] != '') 
            {
                $data = $request['firmabase64'];

                list($type, $data) = explode(';', $data);
                list(, $data)      = explode(',', $data);
                $data = base64_decode($data);

                file_put_contents('imagenes/'.$ruta, $data);
            }


           
     }
            

         return redirect('/planemergencia');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
           if($_GET['accion'] == 'imprimir')
        {
          // Se llama los registros para saber  cual es  la que va a imprimir el usuario
           $planemergencia = \App\PlanEmergencia::find($id);


           $PlanEmergenciaDefinicion3 = DB::SELECT('
            SELECT ped3.capacitacionSimulacroPlanEmergenciaDefinicion3,ped3.analisisVulnerabilidadPlanEmergenciaDefinicion3,ped3.listaAnexosPlanEmergenciaDefinicion3
            FROM planemergenciadefinicion3 ped3
            LEFT JOIN planemergencia pe
            ON ped3.PlanEmergencia_idPlanEmergencia = pe.idPlanEmergencia
            WHERE ped3.PlanEmergencia_idPlanEmergencia = '.$id);

           $PlanEmergenciaDefinicion2 = DB::SELECT('
            SELECT ped2.sistemaComunicacionPlanEmergenciaDefinicion2,ped2.coordinacionSocorroPlanEmergenciaDefinicion2,ped2.cesePeligroPlanEmergenciaDefinicion2
            FROM planemergenciadefinicion2 ped2
            LEFT JOIN planemergencia pe
            ON ped2.PlanEmergencia_idPlanEmergencia = pe.idPlanEmergencia
            WHERE ped2.PlanEmergencia_idPlanEmergencia = '.$id);

           $PlanEmergenciaDefinicion1 = DB::SELECT('
            SELECT ped1.procedimientoEmergenciaPlanEmergenciaDefinicion1,ped1.sistemaAlertaPlanEmergenciaDefinicion1,ped1.notificacionInternaPlanEmergenciaDefinicion1,ped1.rutasEvacuacionPlanEmergenciaDefinicion1
            FROM planemergenciadefinicion1 ped1
            LEFT JOIN planemergencia pe
            ON ped1.PlanEmergencia_idPlanEmergencia = pe.idPlanEmergencia
             WHERE ped1.PlanEmergencia_idPlanEmergencia = '.$id);
          

            $PlanEmergenciaEncabezado = DB::select('
            SELECT pe.idPlanEmergencia,pe.fechaElaboracionPlanEmergencia,pe.nombrePlanEmergencia,cc.nombreCentroCosto,pe.justificacionPlanEmergencia,pe.marcoLegalPlanEmergencia,pe.definicionesPlanEmergencia,pe.generalidadesPlanEmergencia,pe.objetivosPlanEmergencia,pe.alcancePlanEmergencia,pe.nitPlanEmergencia,pe.direccionPlanEmergencia,pe.telefonoPlanEmergencia,pe.ubicacionPlanEmergencia,pe.personalOperativoPlanEmergencia,pe.personalAdministrativoPlanEmergencia,pe.turnoOperativoPlanEmergencia,pe.turnoAdministrativoPlanEmergencia,pe.visitasDiaPlanEmergencia,t.nombreCompletoTercero,pe.firmaRepresentantePlanEmergencia
            FROM planemergencia pe
            LEFT JOIN centrocosto cc
            ON pe.CentroCosto_idCentroCosto = cc.idCentroCosto
            LEFT JOIN tercero t
            ON pe.Tercero_idRepresentanteLegal = t.idTercero
            WHERE pe.idPlanEmergencia = '.$id);


            $PlanEmergenciaLimie = DB::select('
            SELECT pel.PlanEmergencia_idPlanEmergencia,pel.sedePlanEmergenciaLimite,pel.nortePlanEmergenciaLimite,pel.surPlanEmergenciaLimite,pel.orientePlanEmergenciaLimite,pel.occidentePlanEmergenciaLimite,pel.idPlanEmergenciaLimite
            FROM planemergencialimite pel
            LEFT JOIN planemergencia  pe
            ON pel.PlanEmergencia_idPlanEmergencia = pe.idPlanEmergencia
            WHERE pel.PlanEmergencia_idPlanEmergencia ='.$id);

            $PlanEmergenciaIventario = DB::select('
            SELECT pei.idPlanEmergenciaInventario,pei.PlanEmergencia_idPlanEmergencia,pei.sedePlanEmergenciaInventario,pei.recursoPlanEmergenciaInventario,pei.cantidadPlanEmergenciaInventario,pei.ubicacionPlanEmergenciaInventario,pei.observacionPlanEmergenciaInventario
            FROM planemergenciainventario pei
            LEFT JOIN planemergencia pe ON pei.PlanEmergencia_idPlanEmergencia = pe.idPlanEmergencia
            WHERE pei.PlanEmergencia_idPlanEmergencia = '.$id);

           $PlanEmergenciaNivel = DB::SELECT('
            SELECT pen.idPlanEmergenciaNivel,pen.PlanEmergencia_idPlanEmergencia,pen.nivelPlanEmergenciaNivel,pen.cargoPlanEmergenciaNivel,pen.funcionPlanEmergenciaNivel, pen.papelPlanEmergenciaNivel
            FROM planemergencianivel pen
            LEFT JOIN planemergencia pe
            ON pen.PlanEmergencia_idPlanEmergencia = pe.idPlanEmergencia
            WHERE pen.PlanEmergencia_idPlanEmergencia ='.$id);


            $PlanEmergenciaArchivo = DB::SELECT('
            SELECT pea.idPlanEmergenciaArchivo,pea.PlanEmergencia_idPlanEmergencia,pea.rutaPlanEmergenciaArchivo
            FROM planemergenciaarchivo pea
            LEFT JOIN planemergencia pe
            ON pea.PlanEmergencia_idPlanEmergencia = pe.idPlanEmergencia
            WHERE pea.PlanEmergencia_idPlanEmergencia = '.$id); 


            return view('formatos.planemergenciaimpresion',compact('PlanEmergenciaDefinicion3','PlanEmergenciaDefinicion2','PlanEmergenciaDefinicion1','PlanEmergenciaEncabezado','PlanEmergenciaLimie','PlanEmergenciaIventario','PlanEmergenciaNivel','PlanEmergenciaArchivo'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    public function edit($id)
    {
        $planemergencia = \App\PlanEmergencia::find($id);
        $centrocosto = \App\CentroCosto::where('Compania_idCompania', "=", \Session::get('idCompania'))->lists('nombreCentroCosto','idCentroCosto');
        $tercero = \App\Tercero::where('Compania_idCompania','=', \Session::get('idCompania'))->lists('nombreCompletoTercero','idTercero');



        // orm, query builder, consulta modelo
        // Se envia la informacion con este tipo de consulta para que me reciba los datos sin problemas 
        // Se hace la consulta al modelo para enviar los campos al momento de editar, de sus respetivas tablas 
        // Se agrega e los leftjoin la tabla como tal planemergencia, ya que si se pone el modelo en linux no aparece la relacion
        $PLanEmergenciaDefiniciones = \App\PlanEmergencia::selectRaw(
        'planemergenciadefinicion1.idPlanEmergenciaDefinicion1,
        planemergenciadefinicion1.procedimientoEmergenciaPlanEmergenciaDefinicion1,
        planemergenciadefinicion1.sistemaAlertaPlanEmergenciaDefinicion1,
        planemergenciadefinicion1.notificacionInternaPlanEmergenciaDefinicion1,
        planemergenciadefinicion1.rutasEvacuacionPlanEmergenciaDefinicion1,
        planemergenciadefinicion2.idPlanEmergenciaDefinicion2,
        planemergenciadefinicion2.sistemaComunicacionPlanEmergenciaDefinicion2,
        planemergenciadefinicion2.coordinacionSocorroPlanEmergenciaDefinicion2,
        planemergenciadefinicion2.cesePeligroPlanEmergenciaDefinicion2, 
        planemergenciadefinicion3.idPlanEmergenciaDefinicion3,
        planemergenciadefinicion3.capacitacionSimulacroPlanEmergenciaDefinicion3,
        planemergenciadefinicion3.analisisVulnerabilidadPlanEmergenciaDefinicion3,
        listaAnexosPlanEmergenciaDefinicion3')
        ->leftjoin('planemergenciadefinicion1','planemergencia.idPlanEmergencia','=','planemergenciadefinicion1.PlanEmergencia_idPlanEmergencia')
        ->leftjoin('planemergenciadefinicion2','planemergencia.idPlanEmergencia','=','planemergenciadefinicion2.PlanEmergencia_idPlanEmergencia')
        ->leftjoin('planemergenciadefinicion3','planemergencia.idPlanEmergencia','=','planemergenciadefinicion3.PlanEmergencia_idPlanEmergencia')
        ->where('planemergencia.idPlanEmergencia','=', $id)
        ->firstOrFail(); /*Para que solo muestre el primer registro */
        //  se ejecuta este echo$PLanEmergenciaDefiniciones->toSql(); para verificar en php myadmin que todo este correcto


      
      $PlanEmergenciaLimite = DB::SELECT('
        SELECT pel.idPlanEmergenciaLimite,pel.PlanEmergencia_idPlanEmergencia,pel.sedePlanEmergenciaLimite,pel.nortePlanEmergenciaLimite,pel.surPlanEmergenciaLimite,pel.orientePlanEmergenciaLimite,pel.occidentePlanEmergenciaLimite
        FROM planemergencialimite pel
        LEFT JOIN planemergencia pe
        ON pel.PlanEmergencia_idPlanEmergencia = pe.idPlanEmergencia
        WHERE pel.PlanEmergencia_idPlanEmergencia ='.$id);


      $PlanEmergenciaInventario = DB::SELECT('
        SELECT pei.idPlanEmergenciaInventario, pei.PlanEmergencia_idPlanEmergencia,pei.sedePlanEmergenciaInventario,pei.recursoPlanEmergenciaInventario,pei.cantidadPlanEmergenciaInventario,pei.ubicacionPlanEmergenciaInventario,pei.observacionPlanEmergenciaInventario
        FROM planemergenciainventario pei
        LEFT JOIN planemergencia pe
        ON pei.PlanEmergencia_idPlanEmergencia = pe.idPlanEmergencia
        WHERE pei.PlanEmergencia_idPlanEmergencia ='.$id);

      $PlanEmergenciaComite = DB::SELECT('
        SELECT pec.idPlanEmergenciaComite, pec.PlanEmergencia_idPlanEmergencia,pec.comitePlanEmergenciaComite,pec.integrantesPlanEmergenciaComite,pec.funcionesPlanEmergenciaComite,pec.antesPlanEmergenciaComite,pec.durantePlanEmergenciaComite,pec.despuesPlanEmergenciaComite
        FROM planemergenciacomite pec
        LEFT JOIN planemergencia pe
        ON pec.PlanEmergencia_idPlanEmergencia = pe.idPlanEmergencia
        WHERE pec.PlanEmergencia_idPlanEmergencia ='.$id);


       $PlanEmergenciaNivel = DB::SELECT('
        SELECT pen.idPlanEmergenciaNivel,pen.PlanEmergencia_idPlanEmergencia,pen.nivelPlanEmergenciaNivel,pen.cargoPlanEmergenciaNivel,pen.funcionPlanEmergenciaNivel, pen.papelPlanEmergenciaNivel
        FROM planemergencianivel pen
        LEFT JOIN planemergencia pe
        ON pen.PlanEmergencia_idPlanEmergencia = pe.idPlanEmergencia
        WHERE pen.PlanEmergencia_idPlanEmergencia ='.$id);


        return view('planemergencia',compact('PLanEmergenciaDefiniciones','PlanEmergenciaNivel','PlanEmergenciaComite','PlanEmergenciaInventario','PlanEmergenciaLimite','centrocosto','tercero'),['planemergencia'=>$planemergencia]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PlanEmergenciaRequest $request, $id)
    {
        if($request['respuesta'] != 'falso')
        {
            $planemergencia = \App\PlanEmergencia::find($id);
            $planemergencia->fill($request->all());
            $planemergencia->CentroCosto_idCentroCosto = (($request['CentroCosto_idCentroCosto'] == '' or $request['CentroCosto_idCentroCosto'] == 0) ? null : $request['CentroCosto_idCentroCosto'
                    ]);

            $planemergencia->Tercero_idRepresentanteLegal = (($request['Tercero_idRepresentanteLegal'] == '' or $request['Tercero_idRepresentanteLegal'] == 0) ? null : $request['Tercero_idRepresentanteLegal'
                    ]);

            $planemergencia->save();



            //Se guarda los registros de la tabla PlanEmergenciaDefinicion1 
                //se pregunta si el ID ya existe para que reemplace todos los campos Actuales
            $indice = array(
                'PlanEmergencia_idPlanEmergencia' => $id);

            $data = array(
                'procedimientoEmergenciaPlanEmergenciaDefinicion1' => $request['procedimientoEmergenciaPlanEmergenciaDefinicion1'],
                'sistemaAlertaPlanEmergenciaDefinicion1'  => $request['sistemaAlertaPlanEmergenciaDefinicion1'],
                'notificacionInternaPlanEmergenciaDefinicion1'  => $request['notificacionInternaPlanEmergenciaDefinicion1'],
                'rutasEvacuacionPlanEmergenciaDefinicion1'  => $request['rutasEvacuacionPlanEmergenciaDefinicion1']); 

                 $planemergenciadefinicion1 = \App\PlanEmergenciaDefinicion1::updateOrCreate($indice, $data);



                      //Se guarda los registros de la tabla PlanEmergenciaDefinicion2
                //se pregunta si el ID ya existe para que reemplace todos los campos Actuales
            $indice = array(
                'PlanEmergencia_idPlanEmergencia' => $id);

            $data = array(
                 'sistemaComunicacionPlanEmergenciaDefinicion2' => $request['sistemaComunicacionPlanEmergenciaDefinicion2'],
                 'coordinacionSocorroPlanEmergenciaDefinicion2' => $request['coordinacionSocorroPlanEmergenciaDefinicion2'],
                 'cesePeligroPlanEmergenciaDefinicion2' => $request['cesePeligroPlanEmergenciaDefinicion2']); 

                 $planemergenciadefinicion2 = \App\PlanEmergenciaDefinicion2::updateOrCreate($indice, $data);



                      //Se guarda los registros de la tabla PlanEmergenciaDefinicion3
                //se pregunta si el ID ya existe para que reemplace todos los campos Actuales
            $indice = array(
                'PlanEmergencia_idPlanEmergencia' => $id);

            $data = array(                 
                    'capacitacionSimulacroPlanEmergenciaDefinicion3' => $request['capacitacionSimulacroPlanEmergenciaDefinicion3'],
                    'analisisVulnerabilidadPlanEmergenciaDefinicion3' => $request['analisisVulnerabilidadPlanEmergenciaDefinicion3'],
                    'listaAnexosPlanEmergenciaDefinicion3' => $request['listaAnexosPlanEmergenciaDefinicion3']);

                 $planemergenciadefinicion3 = \App\PlanEmergenciaDefinicion3::updateOrCreate($indice, $data);








                  // Update para el detalle de  limite
                 $idsEliminar = explode("," , $request['eliminarlimite']);
                //Eliminar registros de la multiregistro
                \App\PlanEmergenciaLimite::whereIn('idPlanEmergenciaLimite', $idsEliminar)->delete();
                // Guardamos el detalle de los modulos
                for($i = 0; $i < count($request['idPlanEmergenciaLimite']); $i++)
                {
                     $indice = array(
                        'idPlanEmergenciaLimite' => $request['idPlanEmergenciaLimite'][$i]);

                    $data = array(
                    'PlanEmergencia_idPlanEmergencia' => $planemergencia->idPlanEmergencia,
                    'sedePlanEmergenciaLimite' => $request['sedePlanEmergenciaLimite'][$i],
                    'nortePlanEmergenciaLimite' => $request['nortePlanEmergenciaLimite'][$i], 
                    'surPlanEmergenciaLimite' => $request['surPlanEmergenciaLimite'][$i],
                    'orientePlanEmergenciaLimite' => $request['orientePlanEmergenciaLimite'][$i],
                    'occidentePlanEmergenciaLimite' => $request['occidentePlanEmergenciaLimite'][$i]
                      );

                    $guardar = \App\PlanEmergenciaLimite::updateOrCreate($indice, $data);
                } 


                       // Update para el detalle de  limite
                 $idsEliminar = explode("," , $request['eliminarInventario']);
                //Eliminar registros de la multiregistro
                \App\PlanEmergenciaInventario::whereIn('idPlanEmergenciaInventario', $idsEliminar)->delete();
                // Guardamos el detalle de los modulos
                for($i = 0; $i < count($request['idPlanEmergenciaInventario']); $i++)
                {
                     $indice = array(
                        'idPlanEmergenciaInventario' => $request['idPlanEmergenciaInventario'][$i]);

                    $data = array(
                    'PlanEmergencia_idPlanEmergencia' => $planemergencia->idPlanEmergencia,
                    'sedePlanEmergenciaInventario' => $request['sedePlanEmergenciaInventario'][$i],
                    'recursoPlanEmergenciaInventario' => $request['recursoPlanEmergenciaInventario'][$i], 
                    'cantidadPlanEmergenciaInventario' => $request['cantidadPlanEmergenciaInventario'][$i],
                    'ubicacionPlanEmergenciaInventario' => $request['ubicacionPlanEmergenciaInventario'][$i],
                    'observacionPlanEmergenciaInventario' => $request['observacionPlanEmergenciaInventario'][$i]
                      );

                    $guardar = \App\PlanEmergenciaInventario::updateOrCreate($indice, $data);
                } 


                    // Update para el detalle de  Comite
                 $idsEliminar = explode("," , $request['eliminarComite']);
                //Eliminar registros de la multiregistro
                \App\PlanEmergenciaComite::whereIn('idPlanEmergenciaComite', $idsEliminar)->delete();
                // Guardamos el detalle de los modulos
                for($i = 0; $i < count($request['idPlanEmergenciaComite']); $i++)
                {
                     $indice = array(
                        'idPlanEmergenciaComite' => $request['idPlanEmergenciaComite'][$i]);

                    $data = array(        
                    'PlanEmergencia_idPlanEmergencia' => $planemergencia->idPlanEmergencia,
                    'comitePlanEmergenciaComite' => $request['comitePlanEmergenciaComite'][$i],
                    'integrantesPlanEmergenciaComite'  => $request['integrantesPlanEmergenciaComite'][$i], 
                    'funcionesPlanEmergenciaComite' => $request['funcionesPlanEmergenciaComite'][$i],
                    'antesPlanEmergenciaComite' => $request['antesPlanEmergenciaComite'][$i],
                    'durantePlanEmergenciaComite' => $request['durantePlanEmergenciaComite'][$i],
                    'despuesPlanEmergenciaComite' => $request['despuesPlanEmergenciaComite'][$i]
                      );

                    $guardar = \App\PlanEmergenciaComite::updateOrCreate($indice, $data);
                } 


                       // Update para el detalle de  Nivel
                 $idsEliminar = explode("," , $request['eliminarNivel']);
                //Eliminar registros de la multiregistro
                \App\PlanEmergenciaNivel::whereIn('idPlanEmergenciaNivel', $idsEliminar)->delete();
                // Guardamos el detalle de los modulos
                for($i = 0; $i < count($request['idPlanEmergenciaNivel']); $i++)
                {
                     $indice = array(
                        'idPlanEmergenciaNivel' => $request['idPlanEmergenciaNivel'][$i]);

                    $data = array(                       
                    'PlanEmergencia_idPlanEmergencia' => $planemergencia->idPlanEmergencia,
                    'nivelPlanEmergenciaNivel' => $request['nivelPlanEmergenciaNivel'][$i],
                    'cargoPlanEmergenciaNivel' => $request['cargoPlanEmergenciaNivel'][$i], 
                    'funcionPlanEmergenciaNivel' => $request['funcionPlanEmergenciaNivel'][$i],
                    'papelPlanEmergenciaNivel' => $request['papelPlanEmergenciaNivel'][$i]
                      );

                    $guardar = \App\PlanEmergenciaNivel::updateOrCreate($indice, $data);
                } 


                 //Para sobreescribir  el archivo 
            // HAGO UN INSERT A LOS NUEVOS ARCHIVOS SUBIDOS EN EL DROPZONE
            if ($request['archivoPlanEmergenciaArray'] != '') 
            {
                $arrayImage = $request['archivoPlanEmergenciaArray'];
                $arrayImage = substr($arrayImage, 0, strlen($arrayImage)-1);
                $arrayImage = explode(",", $arrayImage);
                $ruta = '';

                for($i = 0; $i < count($arrayImage); $i++)
                {
                    if ($arrayImage[$i] != '' || $arrayImage[$i] != 0) 
                    {
                        $origen = public_path() . '/imagenes/repositorio/temporal/'.$arrayImage[$i];
                        $destinationPath = public_path() . '/imagenes/planemergencia/'.$arrayImage[$i];
                        
                        if (file_exists($origen))
                        {
                            copy($origen, $destinationPath);
                            unlink($origen);
                            $ruta = '/planemergencia/'.$arrayImage[$i];

                            DB::table('planemergenciaarchivo')->insert(['idPlanEmergenciaArchivo' => '0', 'PlanEmergencia_idPlanEmergencia' =>$id,'rutaPlanEmergenciaArchivo' => $ruta]);
                        }   
                        else
                        {
                            echo "No existe el archivo";
                        }
                    }
                }
            }
               // Para eliminar los archivos que se muestran en el preview del archivo cargado.Se hace una funcion en el JS para eliminar el div 
            // ELIMINO LOS ARCHIVOS
            $idsEliminar = $request['eliminarArchivo'];
            $idsEliminar = substr($idsEliminar, 0, strlen($idsEliminar)-1);
            if($idsEliminar != '')
            {
                $idsEliminar = explode(',',$idsEliminar);
                \App\PlanEmergenciaArchivo::whereIn('idPlanEmergenciaArchivo',$idsEliminar)->delete();
            }




             // armamos una ruta para el archivo de imagen y volvemos a actualizar el registro
            // esto es porque la creamos con el ID del accidente y debiamos grabar primero para obtenerlo
            $ruta = 'planemergencia/firmaplanemergencia_'.$planemergencia->idPlanEmergencia.'.png';
            $planemergencia->firmaRepresentantePlanEmergencia = $ruta;

            $planemergencia->save();

            //----------------------------
            // Guardamos la imagen de la firma como un archivo en disco
            $data = $request['firmabase64'];

            if($data != '')
            {
                list($type, $data) = explode(';', $data);
                list(, $data)      = explode(',', $data);
                $data = base64_decode($data);

                file_put_contents('imagenes/'.$ruta, $data);
            }


        }

        return redirect('planemergencia');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        \App\PlanEmergencia::destroy($id);
        return redirect('/planemergencia');
    }
}
