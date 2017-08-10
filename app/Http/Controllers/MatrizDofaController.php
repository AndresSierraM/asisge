<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\MatrizDofaRequest;
use App\Http\Controllers\Controller;
use DB;
// use Input;
// use File;
// use Validator;
// use Response;
// use Excel;
include public_path().'/ajax/consultarPermisos.php';

class MatrizDofaController extends Controller
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
            return view('matrizdofagrid', compact('datos'));
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
        $Tercero = \App\Tercero::where('tipoTercero', "like", "%*01*%")->where('Compania_idCompania', "=", \Session::get('idCompania'))->lists('nombreCompletoTercero','idTercero');      
        $Proceso = \App\Proceso::where('Compania_idCompania', "=", \Session::get('idCompania'))->lists('nombreProceso','idProceso'); 
        
        return view('matrizdofa',compact('Tercero','Proceso'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(MatrizDofaRequest $request)
    {
       if($request['respuesta'] != 'falso')
        {  

              \App\MatrizDofa::create([
                  'fechaElaboracionMatrizDOFA' => $request['fechaElaboracionMatrizDOFA'],
                  'Tercero_idResponsable' => $request['Tercero_idResponsable'],
                  'Proceso_idProceso' => $request['Proceso_idProceso'],
                  'Compania_idCompania' => \Session::get('idCompania')
                  ]);


             //Primero consultar el ultimo id guardado
             $matrizdofa = \App\MatrizDofa::All()->last();


               //---------------------------------
            // guardamos las tablas de detalle
            //---------------------------------
            $this->grabarDetalle($matrizdofa->idMatrizDOFA, $request);
      }
          return redirect('/matrizdofa');
    }
    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id, Request $request)
    {
        if($_GET['accion'] == 'imprimir')
        {
          // Se llama los registros para saber  cual es  la que va a imprimir el usuario
           $matrizdofa = \App\MatrizDofa::find($id);

          $MatrizDofaEncabezado = DB::select('
              SELECT md.idMatrizDOFA,md.fechaElaboracionMatrizDOFA,t.nombreCompletoTercero,p.nombreProceso
              FROM matrizdofa md
              LEFT JOIN tercero t
              ON md.Tercero_idResponsable = t.idTercero
              LEFT JOIN proceso p
              ON md.Proceso_idProceso = p.idProceso
              WHERE md.idMatrizDOFA = '.$id);

            $MatrizDofaoportunidadS = DB::SELECT('
            SELECT mdd.idMatrizDOFADetalle as idMatrizDOFADetalle_Oportunidad ,mdd.MatrizDOFA_idMatrizDOFA,mdd.tipoMatrizDOFADetalle as tipoMatrizDOFADetalle_Oportunidad ,mdd.descripcionMatrizDOFADetalle as descripcionMatrizDOFADetalle_Oportunidad,mdd.matrizRiesgoMatrizDOFADetalle as matrizRiesgoMatrizDOFADetalle_Oportunidad
            FROM matrizdofadetalle mdd
            LEFT JOIN matrizdofa md
            ON mdd.MatrizDOFA_idMatrizDOFA = md.idMatrizDOFA
            WHERE mdd.tipoMatrizDOFADetalle = "Oportunidad" and mdd.MatrizDOFA_idMatrizDOFA = '.$id);


            $MatrizDofafortalezaS = DB::SELECT('
            SELECT mdd.idMatrizDOFADetalle as idMatrizDOFADetalle_Fortaleza ,mdd.MatrizDOFA_idMatrizDOFA,mdd.tipoMatrizDOFADetalle as tipoMatrizDOFADetalle_Fortaleza ,mdd.descripcionMatrizDOFADetalle as descripcionMatrizDOFADetalle_Fortaleza ,mdd.matrizRiesgoMatrizDOFADetalle as matrizRiesgoMatrizDOFADetalle_Fortaleza
            FROM matrizdofadetalle mdd
            LEFT JOIN matrizdofa md
            ON mdd.MatrizDOFA_idMatrizDOFA = md.idMatrizDOFA
            WHERE mdd.tipoMatrizDOFADetalle = "Fortaleza" and mdd.MatrizDOFA_idMatrizDOFA = '.$id);

             // Se hace la condicion para cuado es Amenaza
            $MatrizDofaamenazaS = DB::SELECT('
            SELECT mdd.idMatrizDOFADetalle as idMatrizDOFADetalle_Amenaza,mdd.MatrizDOFA_idMatrizDOFA,mdd.tipoMatrizDOFADetalle as tipoMatrizDOFADetalle_Amenaza,mdd.descripcionMatrizDOFADetalle as descripcionMatrizDOFADetalle_Amenaza,mdd.matrizRiesgoMatrizDOFADetalle as matrizRiesgoMatrizDOFADetalle_Amenaza
            FROM matrizdofadetalle mdd
            LEFT JOIN matrizdofa md
            ON mdd.MatrizDOFA_idMatrizDOFA = md.idMatrizDOFA
            WHERE mdd.tipoMatrizDOFADetalle = "Amenaza" and mdd.MatrizDOFA_idMatrizDOFA = '.$id);

             // Se hace la condicion para cuado es Debilidad
            $MatrizDofadebilidadS = DB::SELECT('
            SELECT mdd.idMatrizDOFADetalle as idMatrizDOFADetalle_Debilidad ,mdd.MatrizDOFA_idMatrizDOFA,mdd.tipoMatrizDOFADetalle as tipoMatrizDOFADetalle_Debilidad,mdd.descripcionMatrizDOFADetalle as descripcionMatrizDOFADetalle_Debilidad,mdd.matrizRiesgoMatrizDOFADetalle as matrizRiesgoMatrizDOFADetalle_Debilidad
            FROM matrizdofadetalle mdd
            LEFT JOIN matrizdofa md
            ON mdd.MatrizDOFA_idMatrizDOFA = md.idMatrizDOFA
            WHERE mdd.tipoMatrizDOFADetalle = "Debilidad" and mdd.MatrizDOFA_idMatrizDOFA = '.$id);


            return view('formatos.matrizdofaimpresion',compact('MatrizDofaEncabezado','MatrizDofaoportunidadS','MatrizDofafortalezaS','MatrizDofaamenazaS','MatrizDofadebilidadS'));
        // }
        
    }
  }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $matrizdofa = \App\MatrizDofa::find($id);

  
        $Tercero = \App\Tercero::where('tipoTercero', "like", "%*01*%")->where('Compania_idCompania', "=", \Session::get('idCompania'))->lists('nombreCompletoTercero','idTercero');      
        $Proceso = \App\Proceso::where('Compania_idCompania', "=", \Session::get('idCompania'))->lists('nombreProceso','idProceso');

        
        // Conculta para devolver los datos en su respectiva Multiregistro  diferenciando por el camo de tipoMatrizDOFADetalle
        // Se hace la condicion para cuado es oportunidad
        $MatrizDofaoportunidad = DB::SELECT('
        SELECT mdd.idMatrizDOFADetalle as idMatrizDOFADetalle_Oportunidad,mdd.MatrizDOFA_idMatrizDOFA,mdd.tipoMatrizDOFADetalle as tipoMatrizDOFADetalle_Oportunidad ,mdd.descripcionMatrizDOFADetalle as descripcionMatrizDOFADetalle_Oportunidad,mdd.matrizRiesgoMatrizDOFADetalle as matrizRiesgoMatrizDOFADetalle_Oportunidad
        FROM matrizdofadetalle mdd
        LEFT JOIN matrizdofa md
        ON mdd.MatrizDOFA_idMatrizDOFA = md.idMatrizDOFA
        WHERE mdd.tipoMatrizDOFADetalle = "Oportunidad" and mdd.MatrizDOFA_idMatrizDOFA = '.$id);

        // Se hace la condicion para cuado es Fortaleza
         $MatrizDofafortaleza = DB::SELECT('
        SELECT mdd.idMatrizDOFADetalle as idMatrizDOFADetalle_Fortaleza,mdd.MatrizDOFA_idMatrizDOFA,mdd.tipoMatrizDOFADetalle as tipoMatrizDOFADetalle_Fortaleza ,mdd.descripcionMatrizDOFADetalle as descripcionMatrizDOFADetalle_Fortaleza ,mdd.matrizRiesgoMatrizDOFADetalle as matrizRiesgoMatrizDOFADetalle_Fortaleza
        FROM matrizdofadetalle mdd
        LEFT JOIN matrizdofa md
        ON mdd.MatrizDOFA_idMatrizDOFA = md.idMatrizDOFA
        WHERE mdd.tipoMatrizDOFADetalle = "Fortaleza" and mdd.MatrizDOFA_idMatrizDOFA = '.$id);

         // Se hace la condicion para cuado es Amenaza
         $MatrizDofaamenaza = DB::SELECT('
        SELECT mdd.idMatrizDOFADetalle as idMatrizDOFADetalle_Amenaza,mdd.MatrizDOFA_idMatrizDOFA,mdd.tipoMatrizDOFADetalle as tipoMatrizDOFADetalle_Amenaza,mdd.descripcionMatrizDOFADetalle as descripcionMatrizDOFADetalle_Amenaza,mdd.matrizRiesgoMatrizDOFADetalle as matrizRiesgoMatrizDOFADetalle_Amenaza
        FROM matrizdofadetalle mdd
        LEFT JOIN matrizdofa md
        ON mdd.MatrizDOFA_idMatrizDOFA = md.idMatrizDOFA
        WHERE mdd.tipoMatrizDOFADetalle = "Amenaza" and mdd.MatrizDOFA_idMatrizDOFA = '.$id);

         // Se hace la condicion para cuado es Debilidad
         $MatrizDofadebilidad = DB::SELECT('
        SELECT mdd.idMatrizDOFADetalle as idMatrizDOFADetalle_Debilidad,mdd.MatrizDOFA_idMatrizDOFA,mdd.tipoMatrizDOFADetalle as tipoMatrizDOFADetalle_Debilidad,mdd.descripcionMatrizDOFADetalle as descripcionMatrizDOFADetalle_Debilidad,mdd.matrizRiesgoMatrizDOFADetalle as matrizRiesgoMatrizDOFADetalle_Debilidad
        FROM matrizdofadetalle mdd
        LEFT JOIN matrizdofa md
        ON mdd.MatrizDOFA_idMatrizDOFA = md.idMatrizDOFA
        WHERE mdd.tipoMatrizDOFADetalle = "Debilidad" and mdd.MatrizDOFA_idMatrizDOFA = '.$id);

        
    

        return view('matrizdofa',compact('Tercero','Proceso','MatrizDofaoportunidad','MatrizDofafortaleza','MatrizDofaamenaza','MatrizDofadebilidad'),['matrizdofa'=>$matrizdofa]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(MatrizDofaRequest $request, $id)
    {
       if($request['respuesta'] != 'falso')
        {
          $matrizdofa = \App\MatrizDofa::find($id);
          $matrizdofa->fill($request->all());      
          $matrizdofa->Tercero_idResponsable = (($request['Tercero_idResponsable'] == '' or $request['Tercero_idResponsable'] == 0) ? null : $request['Tercero_idResponsable'
                ]);
          $matrizdofa->Proceso_idProceso = (($request['Proceso_idProceso'] == '' or $request['Proceso_idProceso'] == 0) ? null : $request['Proceso_idProceso'
                ]);
          $matrizdofa->save();
          //---------------------------------
            // guardamos las tablas de detalle
            //---------------------------------
            $this->grabarDetalle($matrizdofa->idMatrizDOFA, $request);
    }
          
      return redirect('/matrizdofa');
    }
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        \App\MatrizDofa::destroy($id);
        return redirect('/matrizdofa');
    }


    protected function grabarDetalle($id, $request)
    {

        // Update or Create para multirgistro Oportunidad
             $idsEliminar = explode("," , $request['eliminardetalle']);
            //Eliminar registros de la multiregistro
            \App\MatrizDofaDetalle::whereIn('idMatrizDOFADetalle', $idsEliminar)->delete();
            // Guardamos el detalle de los modulos

            for($i = 0; $i < count($request['descripcionMatrizDOFADetalle_Oportunidad']); $i++)
            {
                 $indice = array(
                    'idMatrizDOFADetalle' => $request['idMatrizDOFADetalle_Oportunidad'][$i]);

                $data = array(
                  'MatrizDOFA_idMatrizDOFA' => $id,
                  'tipoMatrizDOFADetalle' => $request['tipoMatrizDOFADetalle_Oportunidad'][$i],
                  'descripcionMatrizDOFADetalle' => $request['descripcionMatrizDOFADetalle_Oportunidad'][$i],
                  'matrizRiesgoMatrizDOFADetalle' => $request['matrizRiesgoMatrizDOFADetalle_Oportunidad'][$i]                  
                  );

                $guardar = \App\MatrizDofaDetalle::updateOrCreate($indice, $data);
            } 

             $idsEliminar = explode("," , $request['eliminarFortaleza']);
            //Eliminar registros de la multiregistro
            \App\MatrizDofaDetalle::whereIn('idMatrizDOFADetalle', $idsEliminar)->delete();
            for($i = 0; $i < count($request['descripcionMatrizDOFADetalle_Fortaleza']); $i++)
            {
                 $indice = array(
                    'idMatrizDOFADetalle' => $request['idMatrizDOFADetalle_Fortaleza'][$i]);

                $data = array(
                  'MatrizDOFA_idMatrizDOFA' => $id,
                  'tipoMatrizDOFADetalle' => $request['tipoMatrizDOFADetalle_Fortaleza'][$i],
                  'descripcionMatrizDOFADetalle' => $request['descripcionMatrizDOFADetalle_Fortaleza'][$i],
                  'matrizRiesgoMatrizDOFADetalle' => $request['matrizRiesgoMatrizDOFADetalle_Fortaleza'][$i]                  
                  );

                $guardar = \App\MatrizDofaDetalle::updateOrCreate($indice, $data);
            } 

            $idsEliminar = explode("," , $request['eliminarAmenaza']);
            //Eliminar registros de la multiregistro
            \App\MatrizDofaDetalle::whereIn('idMatrizDOFADetalle', $idsEliminar)->delete();
            for($i = 0; $i < count($request['descripcionMatrizDOFADetalle_Amenaza']); $i++)
            {
                 $indice = array(
                    'idMatrizDOFADetalle' => $request['idMatrizDOFADetalle_Amenaza'][$i]);

                $data = array(
                  'MatrizDOFA_idMatrizDOFA' => $id,
                  'tipoMatrizDOFADetalle' => $request['tipoMatrizDOFADetalle_Amenaza'][$i],
                  'descripcionMatrizDOFADetalle' => $request['descripcionMatrizDOFADetalle_Amenaza'][$i],
                  'matrizRiesgoMatrizDOFADetalle' => $request['matrizRiesgoMatrizDOFADetalle_Amenaza'][$i]                  
                  );

                $guardar = \App\MatrizDofaDetalle::updateOrCreate($indice, $data);
            } 

             $idsEliminar = explode("," , $request['eliminarDebilidad']);
            //Eliminar registros de la multiregistro
            \App\MatrizDofaDetalle::whereIn('idMatrizDOFADetalle', $idsEliminar)->delete();
            for($i = 0; $i < count($request['descripcionMatrizDOFADetalle_Debilidad']); $i++) 
            {
                 $indice = array(
                    'idMatrizDOFADetalle' => $request['idMatrizDOFADetalle_Debilidad'][$i]);

                $data = array(
                  'MatrizDOFA_idMatrizDOFA' => $id,
                  'tipoMatrizDOFADetalle' => $request['tipoMatrizDOFADetalle_Debilidad'][$i],
                  'descripcionMatrizDOFADetalle' => $request['descripcionMatrizDOFADetalle_Debilidad'][$i],
                  'matrizRiesgoMatrizDOFADetalle' => $request['matrizRiesgoMatrizDOFADetalle_Debilidad'][$i]                  
                  );

                $guardar = \App\MatrizDofaDetalle::updateOrCreate($indice, $data);
            }  

    }
    

}

