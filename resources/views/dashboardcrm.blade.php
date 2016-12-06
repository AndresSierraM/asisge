@extends('layouts.tablero')
@section('titulo')<h1 id="titulo"><center>Dashboard CRM</center></h1>@stop

@section('tablero')

{!! Html::script('chart/Chart.js'); !!}
{!! Html::script('js/dashboardcrm.js'); !!}

<?php 
    $idCompania = \Session::get("idCompania");
    $mes = date("m-Y");
    //$mesAnt = date("Y-m-d"strtotime("- 1 month", date()));
    //echo 'Mes actual '.$mes.' Mes anterior '.$mesAnt.'<br>';
?>
<!-- Token para ejecuciones de ajax -->
<input type="hidden" id="token" value="{{csrf_token()}}"/>

            <div class="row">
               <div class="col-lg-4 col-md-4">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-list fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                <?php 

                                    // -------------------------------------------
                                    //  
                                    // -------------------------------------------
                                    $total = DB::select(
                                        'SELECT count(*) as Cantidad
                                        FROM movimientocrm M 
                                        left join estadocrm E 
                                        on M.EstadoCRM_idEstadoCRM = E.idEstadoCRM
                                        where Compania_idCompania = '.$idCompania .' and DocumentoCRM_idDocumentoCRM = 6
                                        group by nombreEstadoCRM');

                                                                        
                                    // por facilidad de manejo convierto el stdclass a tipo array con un cast (array)
                                    foreach ($total as $key => $value)
                                    {
                                        $datos = (array) $value;
                                    }
                                    
                                ?>
                                    <div class="huge" title="Registros del Mes">{{$datos["Cantidad"]}}</div>
                                    <div>Programas</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->
            <div class="row">


                <?php
                    
                    $colores = array("cornflowerblue", "lightskyblue", "lightgreen", "yellowgreen", "orange", "darkorange","red", "blue", "yellow","purple","pink","gray","lime","brown", "navy","olive" ,"fuchshia");

                    $graficos = DB::select(
                        "SELECT idDocumentoCRMGrafico, DocumentoCRM_idDocumentoCRM, tituloDocumentoCRMGrafico, tipoDocumentoCRMGrafico, valorDocumentoCRMGrafico, serieDocumentoCRMGrafico, filtroDocumentoCRMGrafico 
                        FROM    documentocrmgrafico 
                        WHERE   DocumentoCRM_idDocumentoCRM = 6 ");
                    
                    for ($g=0; $g < count($graficos) ; $g++) 
                    { 
                        $graf = get_object_vars($graficos[$g]);

                        $idGrafico = $graf["idDocumentoCRMGrafico"];
                        $tabla = $graf["serieDocumentoCRMGrafico"];
                        $titulo = $graf["tituloDocumentoCRMGrafico"];
                        $tipoGrafico = $graf["tipoDocumentoCRMGrafico"];
                        $valorGrafico = $graf["valorDocumentoCRMGrafico"];

                        $consultaGrafico = DB::select(
                            "SELECT nombre".$tabla.", count(*) as Cantidad, SUM(valorMovimientoCRM) as Valor
                            FROM movimientocrm M 
                            left join ".strtolower($tabla)." T 
                            on M.".$tabla."_id".$tabla." = T.id".$tabla."
                            where   M.Compania_idCompania = ".$idCompania ." and 
                                    M.DocumentoCRM_idDocumentoCRM = 6 and 
                                    DATE_FORMAT(fechaSolicitudMovimientoCRM,'%m-%Y') = '".$mes."'
                            group by nombre".$tabla);

                        $arrayLabels = '[';
                        $arrayDatos = '[';
                        $total = 0;
                        for ($i=0; $i <count($consultaGrafico) ; $i++) 
                        { 
                            $ind = get_object_vars($consultaGrafico[$i]);

                            $total += $ind[$valorGrafico];
                        }
                        
                        foreach ($consultaGrafico as $pos => $valor) 
                        {
                            $Indicador = (array) $valor;
                           
                            $serie = "'".$Indicador['nombre'.$tabla]."'";

                            switch ($tipoGrafico) {
                                case 'Lineas':
                                    $arrayLabels .= $serie.",";
                                    $arrayDatos .= $Indicador[$valorGrafico]." ,";
                                    break;

                                case 'Barras':
                                    $arrayLabels .= $serie.",";
                                    $arrayDatos .= $Indicador[$valorGrafico]." ,";
                                    break;

                                case 'Dona':
                                    $valor = ($Indicador[$valorGrafico]/($total == 0 ? 1 : $total))*100;
                                    $arrayDatos .= "{value: ".$valor.", 
                                                    color: '".$colores[array_rand($colores)]."',
                                                    highlight: '".$colores[array_rand($colores)]."',
                                                    label: ".$serie."},
                                                    ";
                                    break;

                                case 'Area':
                                    $arrayLabels .= $serie.",";
                                    $arrayDatos .= $Indicador[$valorGrafico]." ,";
                                    break;
                                
                                default:
                                    $arrayLabels .= $serie.",";
                                    $arrayDatos .= $Indicador[$valorGrafico]." ,";
                                    break;
                            }

                            
                        }
                        $arrayLabels = substr($arrayLabels,0,strlen($arrayLabels)-1);
                        $arrayLabels .= "]";
                        $arrayDatos = substr($arrayDatos,0,strlen($arrayDatos)-1);
                        $arrayDatos .= "]";

                        echo '                                        
                                    <div class="col-lg-6 col-sm-12 col-md-6">
                                      <div class="panel panel-primary" >
                                        <div class="panel-heading">
                                         <i class="fa fa-pie-chart fa-fw"></i> '.$titulo.'
                                        </div>
                                        <div class="panel-body" style="min-height: 300px; max-height: 500px;">
                                              <canvas id="'.$idGrafico.'" ></canvas>
                                        </div>
                                      </div>
                                    </div>';
                        
                        
                        
                        switch ($tipoGrafico) 
                        {
                            case 'Lineas':

                                graficoLinea($idGrafico, $arrayLabels, $arrayDatos);

                                break;

                            case 'Barras':
                                graficoBarra($idGrafico, $arrayLabels, $arrayDatos);
                                break;

                            case 'Dona':
                                graficoDona($idGrafico, $arrayDatos);
                                break;

                            case 'Area':
                                graficoArea($idGrafico, $arrayLabels, $arrayDatos);
                                break;
                            
                            default:
                                graficoBarra($idGrafico, $arrayLabels, $arrayDatos);
                                break;
                        }
                    }
                ?>
            </div>




<?php
function graficoLinea($marco, $arrayLabels, $arrayDatos)
{
    echo '
    <script type="text/javascript">
        var ch = document.getElementById("'.$marco.'").getContext("2d");
                var data = 
                        {
                            labels: '.$arrayLabels.',
                            datasets: 
                            [
                                {
                                    fillColor: "rgba(151,187,205,0.2)",
                                    strokeColor: "rgba(151,187,205,1)",
                                    pointColor: "rgba(151,187,205,1)",
                                    highlightFill: "rgba(220,220,220,0.75)",
                                    highlightStroke: "rgba(220,220,220,1)",
                                    data: '.$arrayDatos.'
                                }
                            ]
                        };
                var myLineChart = new Chart(ch).Line(data);

    </script>';
}

function graficoArea($marco, $arrayLabels, $arrayDatos)
{
    echo '
    <script type="text/javascript">
        var ch = document.getElementById("'.$marco.'").getContext("2d");
                var data = 
                        {
                            labels: '.$arrayLabels.',
                            datasets: 
                            [
                                {
                                    fillColor: "rgba(151,187,205,0.2)",
                                    strokeColor: "rgba(151,187,205,1)",
                                    pointColor: "rgba(151,187,205,1)",
                                    highlightFill: "rgba(220,220,220,0.75)",
                                    highlightStroke: "rgba(220,220,220,1)",
                                    data: '.$arrayDatos.'
                                }
                            ]
                        };
                var myLineChart = new Chart(ch).Line(data);

    </script>';
}


function graficoBarra($marco, $arrayLabels, $arrayDatos)
{
    echo '
    <script type="text/javascript">
        
        var chrt = document.getElementById("'.$marco.'").getContext("2d");
                var data = {
                    labels: '.$arrayLabels.',
                    datasets: [
                        {
                            fillColor: "rgba(220,120,220,0.8)",
                            strokeColor: "rgba(220,120,220,0.8)",
                            highlightFill: "rgba(220,220,220,0.75)",
                            highlightStroke: "rgba(220,220,220,1)",
                            data: '.$arrayDatos.',
                        }
                    ]
                };
                var myFirstChart = new Chart(chrt).Bar(data);

        </script>';
}

function graficoDona($marco, $arrayDatos)
{
    echo '
         <script type="text/javascript">
         var ctx = $("#'.$marco.'").get(0).getContext("2d");

                var data = 
                    '.$arrayDatos.';

                //draw
                var piechart = new Chart(ctx).Doughnut(data);
            
        </script>';
}
?>


@stop