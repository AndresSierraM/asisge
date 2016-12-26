@extends('layouts.tablero')
@section('titulo')<h1 id="titulo"><center>Resultados de la Encuesta</center></h1>@stop

@section('tablero')

{!! Html::script('chart/Chart.js'); !!}

<?php 
    $idCompania = \Session::get("idCompania");
?>
<!-- Token para ejecuciones de ajax -->
<input type="hidden" id="token" value="{{csrf_token()}}"/>
            <!-- /.row -->
<div class="row">


    <?php
        
        $colores = array("cornflowerblue", "lightskyblue", "lightgreen", "yellowgreen", "orange", "darkorange","red", "blue", "yellow","purple","pink","gray","lime","brown", "navy","olive" ,"fuchshia");

        // Consultamos la tabulacion de la encuesta (conteo de respuestas de cada pregunta)
        // teniendo en cuenta solo las de selecciones, ya que las descriptivas no es 
        // posible tabularlas
        $graficos = DB::select(
            "SELECT idEncuestaPregunta, preguntaEncuestaPregunta, nombreEncuestaOpcion, count(idEncuestaPregunta) as total 
            FROM encuestapregunta PR
            left join encuestaopcion OP
            on PR.idEncuestaPregunta = OP.EncuestaPregunta_idEncuestaPregunta
            left join encuestapublicacion PU
            on PR.Encuesta_idEncuesta = PU.Encuesta_idEncuesta
            where PU.idEncuestaPublicacion =  ".$idEncuestaPublicacion." and 
                PR.tipoRespuestaEncuestaPregunta IN ('Selección Múltiple','Casillas de Verificación','Lista de Opciones')
            group by PR.idEncuestaPregunta, OP.valorEncuestaOpcion
            order by PR.idEncuestaPregunta, OP.valorEncuestaOpcion;");
        
        // convertimos el stdClass en un array para facilidad de manejo 
        $graf = array();
        for ($g=0; $g < count($graficos) ; $g++) 
        { 
            $graf[] = get_object_vars($graficos[$g]);
        }

        // hacemos rompimiento de control por cada Pregunta
        $reg = 0;
        while ($reg < count($graf)) 
        {
            // totamos el valor del rompimiento por id de pregunta
            $preguntaAnt = $graf[$reg]["idEncuestaPregunta"];

            // Creamos un DIV para el grafico con el id y titulo
            echo '                                        
                <div class="col-lg-6 col-sm-12 col-md-6">
                  <div class="panel panel-primary" >
                    <div class="panel-heading">
                     <i class="fa fa-pie-chart fa-fw"></i> '.$graf[$reg]["preguntaEncuestaPregunta"].'
                    </div>
                    <div class="panel-body" style="min-height: 300px; max-height: 500px;">
                          <canvas id="'.$preguntaAnt.'" ></canvas>
                    </div>
                  </div>
                </div>';

            // concatenamos los nombres de las series y los valores para enviarlos
            // como parameto al grafico en forma de array
            $arrayLabels = '[';
            $arrayDatos = '[';
            while ($reg < count($graf) and $preguntaAnt == $graf[$reg]["idEncuestaPregunta"]) 
            {
                //concatenamos series y valores
                $arrayLabels .= "'".$graf[$reg]["nombreEncuestaOpcion"]."',";
                $arrayDatos .= $graf[$reg]["total"]." ,";
                $reg++;
            }
            // quitamos la ultima coma y cerramos los array 
            $arrayLabels = substr($arrayLabels,0,strlen($arrayLabels)-1);
            $arrayLabels .= "]";
            $arrayDatos = substr($arrayDatos,0,strlen($arrayDatos)-1);
            $arrayDatos .= "]";


            // ejecutamos la funcion de grafico en barras
            graficoBarra($preguntaAnt, $arrayLabels, $arrayDatos);
        }

    ?>
</div>




<?php

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
?>

@stop