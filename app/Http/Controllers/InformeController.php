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

    public function indexInformeGenerador()
    {
        $informe = \App\Informe::leftjoin('informecompania AS IC', 'informe.idInforme', '=', 'IC.Informe_idInforme')
        ->leftjoin('informerol AS IR', 'informe.idInforme', '=', 'IC.Informe_idInforme')
        ->leftjoin('users AS U' , 'IR.Rol_idRol', '=', 'U.Rol_idRol')
        ->where('U.id', '=', \Session::get('idUsuario'))
        ->where('IC.Compania_idCompania', '=', \Session::get('idCompania'))
        ->lists('nombreInforme','idInforme');

        return view('informegenerador',compact('informe'));
        
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
            ->select('idInformeColumna', 'secuenciaInformeColumna', 'campoInformeColumna', 'ordenInformeColumna', 'grupoInformeColumna', 'ocultoInformeColumna', 'tituloInformeColumna', 'alineacionHInformeColumna', 'alineacionVInformeColumna', 'caracterRellenoInformeColumna', 'alineacionRellenoInformeColumna', 'calculoInformeColumna', 'formatoInformeColumna', 'longitudInformeColumna', 'decimalesInformeColumna' )
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

        $informerol = DB::table('informerol')
            ->leftjoin('rol','Rol_idRol','=','idRol')
            ->select('idInformeRol', 'Rol_idRol', 'nombreRol' )
            ->where('Informe_idInforme', '=', $id)
            ->get();

        $informecompania = DB::table('informecompania')
            ->leftjoin('compania','Compania_idCompania','=','idCompania')
            ->select('idInformeCompania', 'Compania_idCompania', 'nombreCompania' )
            ->where('Informe_idInforme', '=', $id)
            ->get();

        return view('informe', ['informe' => $informe], compact('categoriainforme','sistemainformacion','tablas','informecolumna', 
                            'informegrupo','informefiltro','informerol','informecompania'));
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
                'secuenciaInformeColumna' => $request['secuenciaInformeColumna'][$i],
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

        
        //*******************
        //
        //  R O L E S
        //
        //*******************
        $idsEliminar = explode(',', $request['eliminarRol']);
        \App\InformeRol::whereIn('idInformeRol',$idsEliminar)->delete();
        $contadorInformeRol = count($request['idInformeRol']);
        for($i = 0; $i < $contadorInformeRol; $i++)
        {
            $indice = array(
                'idInformeRol' => $request['idInformeRol'][$i]);

            $datos= array(
                'Informe_idInforme' => $idInforme,
                'Rol_idRol' => $request['Rol_idRol'][$i]);

            $guardar = \App\InformeRol::updateOrCreate($indice, $datos);
        }

        
        //*******************
        //
        //  C O M P A N I A S
        //
        //*******************
        $idsEliminar = explode(',', $request['eliminarCompania']);
        \App\InformeCompania::whereIn('idInformeCompania',$idsEliminar)->delete();
        $contadorInformeCompania = count($request['idInformeCompania']);
        for($i = 0; $i < $contadorInformeCompania; $i++)
        {
            $index = array(
                'idInformeCompania' => $request['idInformeCompania'][$i]);

            $data= array(
                'Informe_idInforme' => $idInforme,
                'Compania_idCompania' => $request['Compania_idCompania'][$i]);

            $save = \App\InformeCompania::updateOrCreate($index, $data);
        }


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
        ->where('COLUMN_NAME','!=','Compania_idCompania')
        ->get();
        
        // devolvemos al ajax los registros de campos, con estos se creara una lista de seleccion
        echo json_encode($camposBD);
    }

    public function llamarFiltros()
    {
        $idInforme = $_GET["idInforme"];

        $filtros = DB::table('informe AS I')
            ->leftjoin('informefiltro AS IF','I.idInforme','=','IF.Informe_idInforme')
            ->select(DB::raw('vistaInforme, idInformeFiltro, agrupadorInicialInformeFiltro, campoInformeFiltro, 
                            operadorInformeFiltro, valorInformeFiltro, agrupadorFinalInformeFiltro, 
                            conectorInformeFiltro'))
            ->where('idInforme','=',$idInforme)
            ->get();
       
        // devolvemos al ajax los registros de campos, con estos se creara una lista de seleccion
        echo json_encode($filtros);
    }
    


    public function GenerarInforme($idInforme, $condicion)
    {
       
        // COnsultamos el DISEÑO del informe, con el fin de tener todos los datos necesarios para la consulta
        $columnas = DB::table('informe AS I')
            ->leftjoin('informecolumna AS IC','I.idInforme','=','IC.Informe_idInforme')
            ->leftjoin('sistemainformacion','SistemaInformacion_idSistemaInformacion','=','idSistemaInformacion')
            ->select(DB::raw('nombreInforme, descripcionInforme, encabezadoInforme, bdSistemaInformacion, vistaInforme, 
                            campoInformeColumna, ordenInformeColumna, grupoInformeColumna, ocultoInformeColumna, 
                            tituloInformeColumna, alineacionHInformeColumna, alineacionVInformeColumna, caracterRellenoInformeColumna, 
                            alineacionRellenoInformeColumna, calculoInformeColumna, formatoInformeColumna, 
                            longitudInformeColumna, decimalesInformeColumna'))
            ->where('idInforme','=',$idInforme)
            ->orderby('secuenciaInformeColumna')
            ->get();

        $col = get_object_vars($columnas[0]);

        // Inicializamos variables apra armar la consulta de datos
        $select = '';
        $from = $col["bdSistemaInformacion"].".".$col["vistaInforme"];
        $where = $condicion;
        $order = '';

        // inicializamos variables auxiliares  para calculos
        $totalColumnas = 0;
        $calculos = array();

        // recorremos los registros de la consulta
        for($i = 0; $i < count($columnas); $i++)
        {
            $col = get_object_vars($columnas[$i]);
            // con los datos de cada registro vamos armando las partes de una consulta

            // la sentencia  select lleva el nombre del campo y su alias, pero antes debemos confirmar si lleva caracter de relleno,
            // cual es la longitud y decimales, cual es el formato, para aplicarle esos cambios
            $campo = $col["campoInformeColumna"];
            
            //$campo = $this->asignarFormatoCampo($col["campoInformeColumna"], $col["formatoInformeColumna"], $col["longitudInformeColumna"], $col["decimalesInformeColumna"]);
            //$campo = $this->asignarEstiloCampo($campo, $col["ocultoInformeColumna"], $col["alineacionHInformeColumna"], $col["alineacionVInformeColumna"]);

            
            //$select .= $campo.' AS `'.$col["tituloInformeColumna"].'`, ';
            $select .= $campo.' AS `'.$col["campoInformeColumna"].'`, ';
            
            // los campos que eestén marcados como Grupo, los utilizamos 
            if($col["grupoInformeColumna"] == 1 or $col["ordenInformeColumna"] == 1)
                $order .= $col["campoInformeColumna"].', ';

            if($col["ocultoInformeColumna"] != 1)
                $totalColumnas++;


        }
        
        // quitamos las (,) comas finales de la lista de campos del select y el order
        $select = substr($select, 0, -2);
        $order = substr($order, 0, -2);

        // ejecutamos la consulta de datos 
        $datos = DB::select(
                'SELECT ' . $select.' ' .
                'FROM ' . $from. ' '. 
                ($where != '' ? 'WHERE '.$where : '').' '.
                ($order != '' ? 'ORDER BY '.$order : ''));

      
        // pasamos la consulta de StdClass a un Array para facilidad de manejo 
        $reg = 0;
        while($reg < count($datos))
        {
            $dato[] = get_object_vars($datos[$reg]);
            $reg++;
        }

        // Recorremos los datos consultados en forma de Rompimiento de control, éste lo indica el campo "grupoInformeColumna"
        // para esto consultamos la tabla de informegrupo

        $grupo = DB::table('informegrupo AS IG')
            ->leftjoin('informecolumna AS IC',function($join)
                {
                    $join->on('IG.Informe_idInforme', '=', 'IC.Informe_idInforme');
                    $join->on('IG.campoInformeGrupo', '=', 'IC.campoInformeColumna');

                })
            ->select(DB::raw('campoInformeGrupo, tituloEncabezadoInformeGrupo, tituloPieInformeGrupo, espaciadoInformeGrupo'))
            ->where('IG.Informe_idInforme','=',$idInforme)
            ->get();

        // Recorremos Cada columna verificando si tiene calculo spara inicializarle una variable, adicionalmente
        // hay que ponerle totales en cada grupo y al final de informe, entonces internamente recorremos los grupos
        // para usarlos como segunda posicion del array de calculos
        for($c = 0; $c < count($columnas); $c++)
        {
            $col = get_object_vars($columnas[$c]);

            // si el campo tiene calculos, lo adicionamos al array de calculos inicializado en cero
            if($col["calculoInformeColumna"] != '')
            {
                // por cada uno de los grupos del informe
                for($g = 0; $g < count($grupo); $g++)
                {
                    $romp = get_object_vars($grupo[$g]);

                    // la primara posicion del array indica el nombre del campo y la segun el nombre del grupo
                    $calculos[$col["campoInformeColumna"]][$romp["campoInformeGrupo"]] = 0;
                }
                // finalmente creamos tambien para cada campo de calculo, los totales de fin de informe
                $calculos[$col["campoInformeColumna"]]["Totales"] = 0;
            }

        }

        $condCiclo = '$reg < count($dato)';
        $totalReg = count($grupo);

        $rompimiento[0] = 
                        '
                        // Imprimir los títulos de las columnas (solo Cuando no existen grupos)
                        if('.(($totalReg == 0 ) ? 'true' : 'false').')
                            $this->imprimirTitulosInforme($columnas);
                        
                        $reg = 0;
                        while('.$condCiclo.')
                        {
                            '.  ($totalReg == 0 
                                ? ' // Imprimir los valores de las columnas y hace los calculos (contadores y acumuladores)
                                    $calculos = $this->imprimirValoresInforme($dato[$reg], $columnas, $calculos, $grupo);
                                    
                                    // Hacer 
                                    
                                    // Incrementa de registro
                                    $reg++;
                                  '
                                : '**CONTENIDO**'
                            ).'
                        }
                        // Imprime totales de fin de informe
                        echo  "<tr><td colspan=\"'.$totalColumnas.'\" class=\"tituloTotal\">Totales del Informe</td></tr>";
                        $this->imprimirTotalesInforme($columnas, $calculos);
                        ';

        
        for($i = 0; $i < $totalReg; $i++)
        {
            $romp = get_object_vars($grupo[$i]);

            $condCiclo .= ' AND $'.$romp["campoInformeGrupo"].'Ant == $dato[$reg]["'.$romp["campoInformeGrupo"].'"]';

            // creamos la variable de control del rompimiento
            $rompimiento[$i+1] = 
                    '$'.$romp["campoInformeGrupo"].'Ant = $dato[$reg]["'.$romp["campoInformeGrupo"].'"];
                    
                    // Imprime titulo de encabezado de grupo
                    echo  "<tr><td colspan=\"'.$totalColumnas.'\" class=\"tituloGrupo\"><br><br>'.$romp["tituloEncabezadoInformeGrupo"].'".  $'.$romp["campoInformeGrupo"].'Ant."<br><br><br></td></tr>";
                    
                    
                    // Imprimir los títulos de las columnas (solo para el ultimo grupo)
                    if('.(($i+1 == $totalReg) ? 'true' : 'false').')
                        $this->imprimirTitulosInforme($columnas);

                    // Inicializar los calculos del grupo actual en cero
                    $calculos = $this->inicializarCalculosGrupo($columnas, "'.$romp["campoInformeGrupo"].'", $calculos);


                    while('.$condCiclo.')
                    {
                        '.  (($i+1) >= $totalReg 
                                ? ' // Imprimir los valores de las columnas y hace los calculos (contadores y acumuladores)
                                    $calculos = $this->imprimirValoresInforme($dato[$reg], $columnas, $calculos, $grupo);
                                    
                                    // Hacer 
                                    
                                    // Incrementa de registro
                                    $reg++;
                                  '
                                : '**CONTENIDO**'
                            ).'
                    }
                    
                    
                    // Imprimir Totales del Grupo
                    echo  "<tr><td colspan=\"'.$totalColumnas.'\" class=\"tituloGrupo\">'.$romp["tituloPieInformeGrupo"].'".  $'.$romp["campoInformeGrupo"].'Ant."</td></tr>";
                    $this->imprimirTotalesGrupo($columnas, $calculos, "'.$romp["campoInformeGrupo"].'");
                    ';
  
        }

        

        $codigo = $rompimiento[0];
        // recorremos el arrai de rompimiento para insertar cada ciclo dentro del padre y devolver una sola variable con todo el codigo
        for($i = 0; $i < count($rompimiento); $i++)
        {
            if(isset($rompimiento[$i+1]))
                $codigo = str_replace('**CONTENIDO**',$rompimiento[$i+1],$codigo);
        }
        
        echo 
        '<!DOCTYPE html>
            <html lang="en">
                <head>
                    
                    <meta charset="utf-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1">
                    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
                    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
                    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
                    <style>
                        .tituloInforme
                        {
                            font-size: 16px;
                            font-weight: bold;
                            text-align: center;
                        }
                        .tituloGrupo
                        {
                            font-size: 14px;
                            font-weight: bold;
                        }
                        .tituloTotal
                        {
                            font-size: 16px;
                            font-weight: bold;
                        }
                    </style>
                </head>
            <body>
                <div>
                    <table class="table table-striped table-hover">
                        <caption class="tituloInforme">'.$col["nombreInforme"].'</caption>
                        <tbody>';
                            echo eval($codigo);
                            echo 
                        '</tbody>
                    </table>
                </div>
            </body>
        </html>';
    }


    private function inicializarCalculosGrupo($columnas, $grupo, $calculos)
    {
        for($c = 0; $c < count($columnas); $c++)
        {
            $col = get_object_vars($columnas[$c]);

            // si el campo tiene calculos, lo adicionamos al array de calculos inicializado en cero
            if($col["calculoInformeColumna"] != '')
            {
                // la primara posicion del array indica el nombre del campo y la segun el nombre del grupo
                $calculos[$col["campoInformeColumna"]][$grupo] = 0;
            }
        }
        return $calculos;
    }

    private function  imprimirTitulosInforme($columnas)
    {
        // iniciamos un registro
        echo '<tr class="thead-light">';

        // recorremos el array $columnas que es el que contiene los campos a imprimir en columnas
        for($i = 0; $i < count($columnas); $i++)
        {
            $col = get_object_vars($columnas[$i]);
            $estilo = ($col["ocultoInformeColumna"] == 1 ? 'style="display:none;"' : '').'';
            echo  '<th scope="col" '.$estilo.'>'.$col["tituloInformeColumna"].'</th>';
        }

        // terminamos el registro
        echo '</tr>';
    }

    private function  imprimirValoresInforme($dato, $columnas, $calculos, $grupo)
    {
        // iniciamos un registro
        echo '<tr>';
        // recorremos el array $columnas que es el que contiene los campos a imprimir en columnas
        for($i = 0; $i < count($columnas); $i++)
        {
            $col = get_object_vars($columnas[$i]);
            $valor = $this->asignarFormatoCampo($dato[$col["campoInformeColumna"]], 
                                        $col["formatoInformeColumna"], 
                                        $col["longitudInformeColumna"], 
                                        $col["decimalesInformeColumna"]);

            $valor = $this->asignarEstiloCampo($valor, 
                                        $col["ocultoInformeColumna"], 
                                        $col["alineacionHInformeColumna"], 
                                        $col["alineacionVInformeColumna"]);
            echo  $valor;

            // si el campo tiene calculos, lo adicionamos al array de calculos inicializado en cero
            if($col["calculoInformeColumna"] != '')
            {

                switch($col["calculoInformeColumna"] )
                {
                    case 'Suma':
                        // por cada uno de los grupos del informe
                        for($g = 0; $g < count($grupo); $g++)
                        {
                            $romp = get_object_vars($grupo[$g]);

                            // la primara posicion del array indica el nombre del campo y la segun el nombre del grupo
                            $calculos[$col["campoInformeColumna"]][$romp["campoInformeGrupo"]] += (float)$dato[$col["campoInformeColumna"]];
                        }
                        // finalmente creamos tambien para cada campo de calculo, los totales de fin de informe
                        $calculos[$col["campoInformeColumna"]]["Totales"] += (float)$dato[$col["campoInformeColumna"]];
                        
                        break;

                    case 'Conteo':
                        // por cada uno de los grupos del informe
                        for($g = 0; $g < count($grupo); $g++)
                        {
                            $romp = get_object_vars($grupo[$g]);

                            // la primara posicion del array indica el nombre del campo y la segun el nombre del grupo
                            $calculos[$col["campoInformeColumna"]][$romp["campoInformeGrupo"]]++;
                        }
                        // finalmente creamos tambien para cada campo de calculo, los totales de fin de informe
                        $calculos[$col["campoInformeColumna"]]["Totales"]++;
                        
                        break;

                    case 'Promedio':
                        // por cada uno de los grupos del informe
                        for($g = 0; $g < count($grupo); $g++)
                        {
                            $romp = get_object_vars($grupo[$g]);

                            // la primara posicion del array indica el nombre del campo y la segun el nombre del grupo
                            $calculos[$col["campoInformeColumna"]][$romp["campoInformeGrupo"]]++;
                        }
                        // finalmente creamos tambien para cada campo de calculo, los totales de fin de informe
                        $calculos[$col["campoInformeColumna"]]["Totales"]++;
                        break;

                }
                
            }
            
        }


        // terminamos el registro
        echo '</tr>';

        // devolvemos el array de calculos
        return $calculos;
    }


    private function  imprimirTotalesGrupo($columnas, $calculos, $grupo)
    {
        // iniciamos un registro
        echo '<tr>';
        // recorremos el array $columnas que es el que contiene los campos a imprimir en columnas
        for($i = 0; $i < count($columnas); $i++)
        {
            $col = get_object_vars($columnas[$i]);

            // si el campo tiene caclulos, imprimimos el resultado, de lo contrario ponemos un espacio vacio
            //echo  '<td  class="tituloGrupo">'.($col["calculoInformeColumna"] != '' ? $calculos[$col["campoInformeColumna"]][$grupo] : '&nbsp;').'</td>';
            $valor = ($col["calculoInformeColumna"] != '' ? $calculos[$col["campoInformeColumna"]][$grupo] : '');

            $valor = $this->asignarFormatoCampo($valor, 
                                        $col["formatoInformeColumna"], 
                                        $col["longitudInformeColumna"], 
                                        $col["decimalesInformeColumna"]);

            $valor = $this->asignarEstiloCampo($valor, 
                                        $col["ocultoInformeColumna"], 
                                        $col["alineacionHInformeColumna"], 
                                        $col["alineacionVInformeColumna"]);
            echo  $valor;
        }

        // terminamos el registro
        echo '</tr>';
    }

    private function  imprimirTotalesInforme($columnas, $calculos)
    {
        // iniciamos un registro
        echo '<tr>';
        // recorremos el array $columnas que es el que contiene los campos a imprimir en columnas
        for($i = 0; $i < count($columnas); $i++)
        {
            $col = get_object_vars($columnas[$i]);

            // si el campo tiene caclulos, imprimimos el resultado, de lo contrario ponemos un espacio vacio
            echo  '<td  class="tituloGrupo">'.($col["calculoInformeColumna"] != '' ? $calculos[$col["campoInformeColumna"]]['Totales'] : '&nbsp;').'</td>';
        }

        // terminamos el registro
        echo '</tr>';
    }

    private function asignarFormatoCampo($campo, $formato, $long, $dec)
    {
        if(trim($campo) == '' or $campo == null)
            return $campo;

        #  los formatos posibles son: 'Texto','NumeroSeparador','Numero','MonedaSeparador','Moneda','DMA','AMD','MDA','Hora','Porcentaje'
        switch($formato)
        {
            // Numero con Separador
            case 'Texto':
                $campo = substr($campo, 0, $long);
                break;

            case 'NumeroSeparador':
                $campo = number_format($campo, $dec, ".", ",");
                break;

            case 'Numero':
                $campo = number_format($campo, $dec, ".", "");
                break;

            // Moneda con Separador
            case 'MonedaSeparador':
                $campo = '$ ' . number_format($campo, $dec, ".", ",");
                break;

            case 'Moneda':
                $campo = '$ ' . number_format($campo, $dec, ".", "");
                break;

            // Formato de Fecha Día-Mes-Año
            case 'DMA':
                $campo = date("d-m-Y", strtotime($campo));
                break;

            // Formato de Fecha Año-Mes-Día
            case 'AMD':
                $campo = date("Y-m-d", strtotime($campo));
                break;

            // Formato de Fecha Mes-Día-Año
            case 'MDA':
                $campo = date("m-d-Y", strtotime($campo));
                break;

            case 'Hora':
                $campo = substr($campo, 0, $long);
                break;

            // Porcentaje
            case 'Porcentaje':
                $campo = number_format($campo, $dec, ".", "").'%';
                break;
        }
        return $campo;


    }


    private function asignarEstiloCampo($campo, $oculto, $alineaH, $alineaV)
    {
        // inicializamos la variable para los estilos 
        $estilo = 'style="';

        $estilo .= ($oculto == 1 ? 'display:none;' : '');

        // Alineacion Horizontal
        $estilo .= 'text-align: '.($alineaH == 'I' ? 'left' : ($alineaH == 'C' ? 'center' : ($alineaH == 'D' ? 'right' :''))).';';

        // Alineacion Vertical
        $estilo .= 'vertical-align: '.($alineaV == 'S' ? 'top' : ($alineaV == 'C' ? 'middle' : ($alineaV == 'I' ? 'bottom' : ''))).';';

        $estilo .= '"';

        // Campo Oculto
        // if($oculto == 1)
        //     $campos = '';
        // else
            $campo = '<td '.$estilo.'>'.$campo.'</td>';

        return $campo;
    }
}
