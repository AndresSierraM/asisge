@extends('layouts.vista')
@section('titulo')<h1 id="titulo"><center>Dashboard</center></h1>@stop

@section('content')

<?php 
    $idCompania = \Session::get("idCompania");
?>

            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-list fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                <?php 
                                    $dato = DB::select("Select count(idPrograma) as total From programa Where MONTH(fechaElaboracionPrograma) = ".date("m")." and Compania_idCompania = ".$idCompania);
                                    
                                    // por facilidad de manejo convierto el stdclass a tipo array con un cast (array)
                                    foreach ($dato as $key => $value) 
                                    {
                                        $datos = (array) $value;
                                    }
                                ?>
                                    <div class="huge">{{$datos["total"]}}</div>
                                    <div>Programas</div>
                                </div>
                            </div>
                        </div>
                        <a href="#">
                            <div class="panel-footer">
                                <span class="pull-left">Ver Detalles</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-book fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                <?php 
                                    $dato = DB::select("Select count(idActaCapacitacion) as total From actacapacitacion Where MONTH(fechaElaboracionActaCapacitacion) = ".date("m")." and Compania_idCompania = ".$idCompania);
                                    
                                    // por facilidad de manejo convierto el stdclass a tipo array con un cast (array)
                                    foreach ($dato as $key => $value) 
                                    {
                                        $datos = (array) $value;
                                    }
                                ?>
                                    <div class="huge">{{$datos["total"]}}</div>
                                    <div>Capacitaciones</div>
                                </div>
                            </div>
                        </div>
                        <a href="#">
                            <div class="panel-footer">
                                <span class="pull-left">Ver Detalles</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-yellow">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-search-plus fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <?php 
                                        $dato = DB::select("Select count(idInspeccion) as total From inspeccion Where MONTH(fechaElaboracionInspeccion) = ".date("m")." and Compania_idCompania = ".$idCompania);
                                        
                                        // por facilidad de manejo convierto el stdclass a tipo array con un cast (array)
                                        foreach ($dato as $key => $value) 
                                        {
                                            $datos = (array) $value;
                                        }
                                    ?>
                                    <div class="huge">{{$datos["total"]}}</div>                                    
                                    <div>Inspecciones</div>
                                </div>
                            </div>
                        </div>
                        <a href="#">
                            <div class="panel-footer">
                                <span class="pull-left">Ver Detalles</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-user-md fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <?php 
                                        $dato = DB::select("Select count(idExamenMedico) as total From examenmedico Where MONTH(fechaExamenMedico) = ".date("m")." and Compania_idCompania = ".$idCompania);
                                        
                                        // por facilidad de manejo convierto el stdclass a tipo array con un cast (array)
                                        foreach ($dato as $key => $value) 
                                        {
                                            $datos = (array) $value;
                                        }
                                    ?>
                                    <div class="huge">{{$datos["total"]}}</div>                                    
                                    <div>Exámenes Médicos</div>
                                </div>
                            </div>
                        </div>
                        <a href="#">
                            <div class="panel-footer">
                                <span class="pull-left">Ver Detalles</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-danger">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-user fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <?php 
                                        $dato = DB::select("Select count(idAusentismo) as total From ausentismo Where MONTH(fechaElaboracionAusentismo) = ".date("m")." and Compania_idCompania = ".$idCompania);
                                        
                                        // por facilidad de manejo convierto el stdclass a tipo array con un cast (array)
                                        foreach ($dato as $key => $value) 
                                        {
                                            $datos = (array) $value;
                                        }
                                    ?>
                                    <div class="huge">{{$datos["total"]}}</div>                                    
                                    <div>Ausencias</div>
                                </div>
                            </div>
                        </div>
                        <a href="#">
                            <div class="panel-footer">
                                <span class="pull-left">Ver Detalles</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-warning">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-ambulance fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <?php 
                                        $dato = DB::select(
                                           "Select count(idAusentismo) as total, 
                                                    SUM(IF(idAccidente IS NULL, 0, 1)) as total2 
                                            From ausentismo 
                                            left join accidente 
                                            on idAusentismo = Ausentismo_idAusentismo 
                                            Where (tipoAusentismo like '%Accidente%' or tipoAusentismo like '%Incidente%') and MONTH(fechaElaboracionAusentismo) = ".date("m")." and ausentismo.Compania_idCompania = ".$idCompania);
                                        
                                        // por facilidad de manejo convierto el stdclass a tipo array con un cast (array)
                                        foreach ($dato as $key => $value) 
                                        {
                                            $datos = (array) $value;
                                        }
                                    ?>
                                    <div class="huge">{{$datos["total"]}} / {{$datos["total2"]}}</div>                                    
                                    <div>Accidentes</div>
                                </div>
                            </div>
                        </div>
                        <a href="#">
                            <div class="panel-footer">
                                <span class="pull-left">Ver Detalles</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-users fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <?php 
                                        $dato = DB::select("Select count(idConformacionGrupoApoyo) as total From conformaciongrupoapoyo Where MONTH(fechaConformacionGrupoApoyo) = ".date("m")." and Compania_idCompania = ".$idCompania);
                                        
                                        // por facilidad de manejo convierto el stdclass a tipo array con un cast (array)
                                        foreach ($dato as $key => $value) 
                                        {
                                            $datos = (array) $value;
                                        }
                                    ?>
                                    <div class="huge">{{$datos["total"]}}</div>                                    
                                    <div>Grupos Apoyo</div>
                                </div>
                            </div>
                        </div>
                        <a href="#">
                            <div class="panel-footer">
                                <span class="pull-left">Ver Detalles</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-headphones fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <?php 
                                        $dato = DB::select("Select count(idEntregaElementoProteccion) as total From entregaelementoproteccion Where MONTH(fechaEntregaElementoProteccion) = ".date("m")." and Compania_idCompania = ".$idCompania);
                                        
                                        // por facilidad de manejo convierto el stdclass a tipo array con un cast (array)
                                        foreach ($dato as $key => $value) 
                                        {
                                            $datos = (array) $value;
                                        }
                                    ?>
                                    <div class="huge">{{$datos["total"]}}</div>                                    
                                    <div>Entregas EPP</div>
                                </div>
                            </div>
                        </div>
                        <a href="#">
                            <div class="panel-footer">
                                <span class="pull-left">Ver Detalles</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <!-- /.row -->
            <div class="row">


                <?php
                // Consultamos todos los indicadores creados en la compañia actual
                    $cuadroMandoObjeto = DB::table('cuadromando as CM')
                        ->select(DB::raw('idCuadroMando, indicadorCuadroMando, formulaCuadroMando, visualizacionCuadroMando'))
                        ->where("Compania_idCompania", $idCompania)
                        ->get();    


                    // por facilidad de manejo convierto el stdclass a tipo array con un cast (array)
                    foreach ($cuadroMandoObjeto as $key => $value) 
                    {
                        $CuadroMando = (array) $value;
                        // para cada indicador, consultamos los resultados de calculos en la tabla de indicadores
                        $indicadores = DB::table('indicador as I')
                                ->leftJoin('cuadromando as CM', 'I.CuadroMando_idCuadroMando', '=', 'CM.idCuadroMando')
                                ->leftJoin('frecuenciamedicion as FM', 'CM.FrecuenciaMedicion_idFrecuenciaMedicion', '=', 'FM.idFrecuenciaMedicion')
                                ->select(DB::raw('idCuadroMando, indicadorCuadroMando, formulaCuadroMando, fechaCalculoIndicador, fechaCorteIndicador, valorIndicador, nombreFrecuenciaMedicion, tipoMetaCuadroMando'))
                                ->where('CuadroMando_idCuadroMando','=',$CuadroMando['idCuadroMando'])
                                ->get();
                                                
                        $arrayGrafico = '[';
                        foreach ($indicadores as $pos => $valor) 
                        {
                            $Indicador = (array) $valor;
                            $dt = strtotime($Indicador['fechaCorteIndicador']);
                            $month = array("","Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic");
                            
                            $fecha_reg = $month[date('n', $dt)]."/".date("Y", $dt);

                            switch ($CuadroMando['visualizacionCuadroMando']) {
                                case 'Lineas':
                                    $arrayGrafico .= "[".date('n', $dt).", ".$Indicador["valorIndicador"]." ],";
                                    break;

                                case 'Barras':
                                    $arrayGrafico .= "['".$fecha_reg."', ".$Indicador["valorIndicador"]." ],";
                                    break;

                                case 'Dona':
                                    $arrayGrafico .= "{label: '".$fecha_reg."', data: ".$Indicador["valorIndicador"]." },";
                                    break;

                                case 'Area':
                                    $arrayGrafico .= "[".date('n', $dt).", ".$Indicador["valorIndicador"]." ],";
                                    break;
                                
                                default:
                                    $arrayGrafico .= "['".$fecha_reg."', ".$Indicador["valorIndicador"]." ],";
                                    break;
                            }
                             
                            
                        }
                        $arrayGrafico = substr($arrayGrafico,0,strlen($arrayGrafico)-1);
                        $arrayGrafico .= "]";
                        
                        
                        echo '
                        <div class="col-lg-6">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <i class="fa fa-pie-chart fa-fw"></i> '.$CuadroMando['indicadorCuadroMando'].'<br>
                                    <i class="fa fa-superscript fa-fw"></i> '.$CuadroMando['formulaCuadroMando'].'
                                </div>
                                <!-- /.panel-heading -->
                                <div class="panel-body">
                                    <div id="indicador'.$CuadroMando['idCuadroMando'].'" style="height: 300px;"></div>
                                </div>
                                <!-- /.panel-body -->
                            </div>
                        </div>';

                        switch ($CuadroMando['visualizacionCuadroMando']) {
                                case 'Lineas':

                                    graficoLinea("indicador".$CuadroMando['idCuadroMando'], $arrayGrafico);
                                    break;

                                case 'Barras':
                                    graficoBarra("indicador".$CuadroMando['idCuadroMando'], $arrayGrafico);
                                    break;

                                case 'Dona':
                                    graficoDona("indicador".$CuadroMando['idCuadroMando'], $arrayGrafico);
                                    break;

                                case 'Area':
                                    graficoArea("indicador".$CuadroMando['idCuadroMando'], $arrayGrafico);
                                    break;
                                
                                default:
                                    graficoBarra("indicador".$CuadroMando['idCuadroMando'], $arrayGrafico);
                                    break;
                            }

                    }
                ?>
                
                
             
               
                <!-- /.col-lg-8 -->
                <div class="col-lg-12">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <i class="fa fa-pie-chart fa-fw"></i> Indicadores de Gestión
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                        <?php 

                            $indicadores = DB::table('indicador as I')
                                ->leftJoin('cuadromando as CM', 'I.CuadroMando_idCuadroMando', '=', 'CM.idCuadroMando')
                                ->leftJoin('frecuenciamedicion as FM', 'CM.FrecuenciaMedicion_idFrecuenciaMedicion', '=', 'FM.idFrecuenciaMedicion')
                                ->select(DB::raw('idCuadroMando, indicadorCuadroMando, formulaCuadroMando, fechaCalculoIndicador, fechaCorteIndicador, valorIndicador, nombreFrecuenciaMedicion, tipoMetaCuadroMando'))
                                ->where("Compania_idCompania", $idCompania)
                                ->get();
                            // por facilidad de manejo convierto el stdclass a tipo array con un cast (array)
                            $Indicador = array();
                            foreach ($indicadores as $key => $value) 
                            {
                                $Indicador[] = (array) $value;
                            }

                            // recorremos cada indicador para calcularlo y almacenar su resultado en la tabla de indicadores
                            for ($i=0; $i < count($Indicador); $i++) 
                            { 
                                echo '<div class="list-group">
                                        <div style="width:300px; display:inline-block;">'.$Indicador[$i]["indicadorCuadroMando"].'</div>
                                        <div style="width:300px; display:inline-block;">'.$Indicador[$i]["formulaCuadroMando"].'</div>
                                        <div style="width:300px; display:inline-block;">'.$Indicador[$i]["nombreFrecuenciaMedicion"].'  ('.$Indicador[$i]["fechaCorteIndicador"].')'.'</div>
                                        <div style="width:300px; display:inline-block;">'.$Indicador[$i]["fechaCalculoIndicador"].'</div>
                                        <span class="pull-right text-muted small"><em>'.number_format($Indicador[$i]["valorIndicador"],2,'.',',').' '.($Indicador[$i]["tipoMetaCuadroMando"] == 'C' ? 'Und' : $Indicador[$i]["tipoMetaCuadroMando"]).'</em></span>
                                    </div>';
                            }
                        ?>
                        </div>
                        <!-- /.panel-body -->
                    </div>

                </div>
                <!-- /.col-lg-4 -->
            </div>
            <!-- /.row -->

<?php
function graficoLinea($marco, $arrayGrafico)
{
    echo '
    <script type="text/javascript">
            
            var line_data1 = {
                data: '.$arrayGrafico.'
            };
            
            $.plot("#'.$marco.'", [line_data1], {
                grid: {
                    hoverable: true,
                    borderColor: "#f3f3f3",
                    borderWidth: 1,
                    tickColor: "#f3f3f3"
                },
                series: {
                    shadowSize: 0,
                    lines: {
                        show: true
                    },
                    points: {
                        show: true
                    }
                },
                lines: {
                    fill: false
                },
                yaxis: {
                    show: true,
                },
                xaxis: {
                    show: true
                }
            });
            //Initialize tooltip on hover
            $("<div class=\'tooltip-inner\' id=\''.$marco.'-tooltip\'></div>").css(
            {
                position: "absolute",
                display: "none",
                opacity: 0.8
            }).appendTo("body");
            
            $("#'.$marco.'").bind("plothover", function(event, pos, item) {
                if (item) {
                    var x = item.datapoint[0].toFixed(2),
                            y = item.datapoint[1].toFixed(2);
                    $("#'.$marco.'-tooltip").html("Periodo " + x + " / Valor " + y)
                            .css({top: item.pageY + 5, left: item.pageX + 5})
                            .fadeIn(200);
                } else {
                    $("#'.$marco.'-tooltip").hide();
                }
            });

        </script>';
}

function graficoArea($marco, $arrayGrafico)
{
    echo '
    <script type="text/javascript">
                var areaData = '.$arrayGrafico.';
                $.plot("#'.$marco.'", [areaData], {
                    grid: {
                        borderWidth: 0
                    },
                    series: {
                        shadowSize: 0, // Drawing is faster without shadows
                        color: "#00c0ef"
                    },
                    lines: {
                        fill: true //Converts the line chart to area chart                        
                    },
                    yaxis: {
                        show: false
                    },
                    xaxis: {
                        show: false
                    }
                });

        </script>';
}


function graficoBarra($marco, $arrayGrafico)
{
    echo '
    <script type="text/javascript">

                var bar_data = {
                    data: '.$arrayGrafico.',
                    color: "#3c8dbc"
                };
                $.plot("#'.$marco.'", [bar_data], {
                    grid: {
                        borderWidth: 1,
                        borderColor: "#f3f3f3",
                        tickColor: "#f3f3f3"
                    },
                    series: {
                        bars: {
                            show: true,
                            barWidth: 0.5,
                            align: "center"
                        }
                    },
                    xaxis: {
                        mode: "categories",
                        tickLength: 0
                    }
                });

        </script>';
}

function graficoDona($marco, $arrayGrafico)
{
    echo '
         <script type="text/javascript">
                var donutData = '.$arrayGrafico.';
                $.plot("#'.$marco.'", donutData, {
                    series: {
                        pie: {
                            show: true,
                            radius: 1,
                            innerRadius: 0.5,
                            label: {
                                show: true,
                                radius: 2 / 3,
                                formatter: labelFormatter,
                                threshold: 0.1
                            }
                        }
                    },
                    legend: {
                        show: true
                    }
                });
        
            function labelFormatter(label, series) {
                    return "<div style=\'font-size:13px; text-align:center; padding:2px; color: #fff; font-weight: 600;\'>"
                    + label
                    + "<br/>"
                    + Math.round(series.percent) + "%</div>";
            }
        </script>';
}
?>


@stop