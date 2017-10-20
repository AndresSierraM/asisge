<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\InformeRequest;
use DB;
include public_path().'/ajax/consultarPermisos.php';

class InformeController extends Controller
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
            return view('informegrid', compact('datos'));
        else
            return view('accesodenegado');
    }


    public function indexCampoGridSelect()
    {
        return view('informecampogridselect');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categoriainforme = \App\CategoriaInforme::All()->lists('nombreCategoriaInforme','idCategoriaInforme');
        $sistemainformacion = \App\SistemaInformacion::All()->lists('nombreSistemaInformacion','idSistemaInformacion');
        $tablas = DB::select('select TABLE_NAME from information_schema.TABLES where TABLE_SCHEMA = "sisoft"');
        
        return view('informe', compact('categoriainforme','sistemainformacion','tablas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(InformeRequest $request)
    {
        if($request['respuesta'] != 'falso')
        {
            \App\Informe::create(
                [
                'nombreInforme' => $request["nombreInforme"],
                'descripcionInforme' => $request["descripcionInforme"],
                'CategoriaInforme_idCategoriaInforme' => $request["CategoriaInforme_idCategoriaInforme"],
                'tipoInforme' => 'G',
                'SistemaInformacion_idSistemaInformacion' => $request["SistemaInformacion_idSistemaInformacion"],
                'vistaInforme' => $request["vistaInforme"]
                ]
            );


            $informe = \App\Informe::All()->last();

            $this->grabarDetalle($informe->idInforme, $request);

            return redirect('/informe');
        }
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
        $informe = \App\Informe::find($id);

        $categoriainforme = \App\CategoriaInforme::All()->lists('nombreCategoriaInforme','idCategoriaInforme');
        $sistemainformacion = \App\SistemaInformacion::All()->lists('nombreSistemaInformacion','idSistemaInformacion');
        $tablas = DB::select('select TABLE_NAME from information_schema.TABLES where TABLE_SCHEMA = "sisoft"');
        
        $informecolumna = DB::table('informecolumna')
            ->select('idInformeColumna', 'campoInformeColumna', 'ordenInformeColumna', 'grupoInformeColumna', 'ocultoInformeColumna', 'tituloInformeColumna', 'alineacionHInformeColumna', 'alineacionVInformeColumna', 'caracterRellenoInformeColumna', 'alineacionRellenoInformeColumna', 'calculoInformeColumna', 'formatoInformeColumna', 'longitudInformeColumna', 'decimalesInformeColumna' )
            ->where('Informe_idInforme', '=', $id)
            ->get();

        $informegrupo = DB::table('informegrupo')
            ->select('idInformeGrupo', 'campoInformeGrupo', 'tituloEncabezadoInformeGrupo', 'tituloPieInformeGrupo', 'espaciadoInformeGrupo' )
            ->where('Informe_idInforme', '=', $id)
            ->get();

        $informefiltro = DB::table('informefiltro')
            ->select('idInformeFiltro', 'agrupadorInicialInformeFiltro', 'campoInformeFiltro', 'operadorInformeFiltro', 'valorInformeFiltro', 'agrupadorFinalInformeFiltro', 'conectorInformeFiltro' )
            ->where('Informe_idInforme', '=', $id)
            ->get();

        return view('informe', ['informe' => $informe], compact('categoriainforme','sistemainformacion','tablas','informecolumna', 'informegrupo','informefiltro'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(InformeRequest $request, $id)
    {
        if($request['respuesta'] != 'falso')
        {
            $informe = \App\Informe::find($id);
            $informe->fill($request->all());
            $informe->save();
            
            $this->grabarDetalle($id, $request);

            return redirect('/informe');
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
        \App\Informe::destroy($id);
        
        return redirect('/informe');
    }

    public function llamarVistas()
    {
        $id = $_GET["idSistemaInformacion"];
        $tablas = DB::select('select TABLE_NAME, 
                                    IF(TABLE_TYPE = "VIEW", TABLE_NAME, 
                                        IF(TABLE_COMMENT = "" ,TABLE_NAME, TABLE_COMMENT)
                                    ) as TABLE_COMMENT from information_schema.TABLES where TABLE_SCHEMA = 
                            (SELECT bdSistemaInformacion FROM sistemainformacion Where idSistemaInformacion = '.$id.')');


        $informe= array();
        for($i = 0; $i < count($tablas); $i++) 
        {
          $informe[] = get_object_vars($tablas[$i]);
        }

        echo json_encode($informe);
    }

    public function llamarCampos()
    {
        $nombretabla = $_GET["tabla"];

        $camposBD = DB::table('information_schema.COLUMNS')
        ->select(DB::raw('TABLE_NAME, COLUMN_NAME, ORDINAL_POSITION, COLUMN_TYPE, COLUMN_COMMENT'))
        ->where('TABLE_NAME', "=", $nombretabla)
        ->where('TABLE_SCHEMA', "=", env('DB_DATABASE', 'sisoft'))
        ->get();
        
        // devolvemos al ajax los registros de campos, con estos se creara una lista de seleccion
        echo json_encode($camposBD);
    }

    private function grabarDetalle($idInforme, $request)
    {
        //*******************
        //
        //  C O L U M N A S 
        //
        //*******************

        $idsEliminar = explode(',', $request['eliminarInformeColumna']);
        \App\InformeColumna::whereIn('idInformeColumna',$idsEliminar)->delete();

        for($i = 0; $i < count($request['idInformeColumna']); $i++)
        {
            $indice = array(
                'idInformeColumna' => $request['idInformeColumna'][$i]);

            $datos= array(
                'Informe_idInforme' => $idInforme,
                'campoInformeColumna' => $request['campoInformeColumna'][$i],
                'ordenInformeColumna' => $request['ordenInformeColumna'][$i],
                'grupoInformeColumna' => $request['grupoInformeColumna'][$i],
                'ocultoInformeColumna' => $request['ocultoInformeColumna'][$i],
                'tituloInformeColumna' => $request['tituloInformeColumna'][$i],
                'alineacionHInformeColumna' => $request['alineacionHInformeColumna'][$i],
                'alineacionVInformeColumna' => $request['alineacionVInformeColumna'][$i],
                'caracterRellenoInformeColumna' => $request['caracterRellenoInformeColumna'][$i],
                'alineacionRellenoInformeColumna' => $request['alineacionRellenoInformeColumna'][$i],
                'calculoInformeColumna' => $request['calculoInformeColumna'][$i],
                'formatoInformeColumna' => $request['formatoInformeColumna'][$i],
                'longitudInformeColumna' => $request['longitudInformeColumna'][$i],
                'decimalesInformeColumna' => $request['decimalesInformeColumna'][$i]
                );

            $guardar = \App\InformeColumna::updateOrCreate($indice, $datos);
        }


        //*******************
        //
        //  G R U P O S
        //
        //*******************
        $idsEliminar = explode(',', $request['eliminarInformeGrupo']);
        \App\InformeGrupo::whereIn('idInformeGrupo',$idsEliminar)->delete();

        for($i = 0; $i < count($request['idInformeGrupo']); $i++)
        {
            $indice = array(
                'idInformeGrupo' => $request['idInformeGrupo'][$i]);

            $datos= array(
                'Informe_idInforme' => $idInforme,
                'campoInformeGrupo' => $request['campoInformeGrupo'][$i],
                'tituloEncabezadoInformeGrupo' => $request['tituloEncabezadoInformeGrupo'][$i],
                'tituloPieInformeGrupo' => $request['tituloPieInformeGrupo'][$i],
                'espaciadoInformeGrupo' => $request['espaciadoInformeGrupo'][$i]
                );

            $guardar = \App\InformeGrupo::updateOrCreate($indice, $datos);
        }


        //*******************
        //
        //  F I L T R O S
        //
        //*******************
        $idsEliminar = explode(',', $request['eliminarInformeFiltro']);
        \App\InformeFiltro::whereIn('idInformeFiltro',$idsEliminar)->delete();

        for($i = 0; $i < count($request['idInformeFiltro']); $i++)
        {
            $indice = array(
                'idInformeFiltro' => $request['idInformeFiltro'][$i]);

            $datos= array(
                'Informe_idInforme' => $idInforme,
                'agrupadorInicialInformeFiltro' => $request['agrupadorInicialInformeFiltro'][$i],
                'campoInformeFiltro' => $request['campoInformeFiltro'][$i],
                'operadorInformeFiltro' => $request['operadorInformeFiltro'][$i],
                'valorInformeFiltro' => $request['valorInformeFiltro'][$i],
                'agrupadorFinalInformeFiltro' => $request['agrupadorFinalInformeFiltro'][$i],
                'conectorInformeFiltro' => $request['conectorInformeFiltro'][$i]
                );

            $guardar = \App\InformeFiltro::updateOrCreate($indice, $datos);
        }

    }
}
