
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/data.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
@extends('layouts.formato')


@section('contenido')

{!!Form::model($diagnostico2)!!}

		<div class="col-lg-12">
            <div class="panel panel-default" >
				<div class="panel-body" >
					<table class="table table-striped table-bordered" width="100%">
					@foreach($diagnosticoEncabezado as $dato2)
						<thead>						
							<tr>
								<td colspan="4" style="font-weight: bold; text-align: center;">
									DIAGNOSTICO EN SEGURIDAD Y SALUD EN EL TRABAJO SST
								</td>
							</tr>
							<tr>
								<td colspan="4">
									Fecha Elaboraci&oacute;n: {{$dato2->fechaElaboracionDiagnostico2}}
								</td>
							</tr>
							<tr>
								<td colspan="4">
									Descripción del Diagnostico: {{$dato2->nombreDiagnostico2}}
								</td>
							</tr>
							<tr>
								<td colspan="4" >
									Evaluación inicial que se realiza con el fin de identificar las prioridades en Seguridad y Salud en el Trabajo propias de la empresa como punto de partida para el establecimiento del Sistema de Gestión de Seguridad y Salud en el Trabajo SG-SST o para la actualización existen. La evaluación inicial debe ser revisada (mínimo una vez al año) y actualizada cuando sea necesario, con el objetivo de mantener vigente las prioridades en seguridad y salud en el trabajo acorde con los cambios en las condiciones y procesos de trabajo. 
								</td>
							</tr>	
        				</table>			        
				        <table class="table table-striped table-bordered" width="100%">
							<tr>
								<td colspan="4">
									Equipos Cr&iacute;ticos: {{$dato2->equiposCriticosDiagnostico2}}
								</td>
							</tr>
							<tr>
								<td colspan="4">
									Herramientas Cr&iacute;ticas: {{$dato2->herramientasCriticasDiagnostico2}}
								</td>
							</tr>
							<tr>
								<td colspan="4">
									Observaciones: {{$dato2->observacionesDiagnostico2}}
								</td>
							</tr>
						</thead>
						@endforeach
						<tbody>
				       
				         
              <?php 
                if (isset($diagnostico2)) 
                {
                            

               $datos = array();
               // por facilidad de manejo convierto el stdclass a tipo array con un cast (array)
                   for ($i = 0, $c = count($diagnostico2); $i < $c; ++$i) 
                   {
                      $datos[$i] = (array) $diagnostico2[$i];
                      
                   }


                echo '<table  class="table table-striped table-bordered table-hover">';
                $i = 0;
                // Se crea una variable que a llevar el total de los registros contados
                $total = count($diagnostico2);


                // Ciclo principal que recorre toda la consulta, Que hace el primer rompimiento, "Nivel 1 de tabla diagnostico"

                // El primer while va hacer el primer Rompimiento que se va a encargar en devolver los titulos.
                while ($i < $total)   
                {

                   $niveles = $datos[$i]['tituloDiagnosticoNivel1'];
                   $idniveles = $datos[$i]['idDiagnosticoNivel1'];
                    // Se crea la variable papa que es la que va acomular cada nivel mediano
                   $totalAcumulador= 0;

                   
                     echo '
                    <thead class="thead-inverse">  
                        <tr class="table-info">
                       <th colspan="20" style=" background-color:#255986; color:white;">'.$datos[$i]['numeroDiagnosticoNivel1'].'. '.$datos[$i]['tituloDiagnosticoNivel1'].'</th>                
                      </tr>                                    
                    </thead>';


                  
                  // se hace rompimiento de aca en adelante para los demas niveles  
                  while ($i < $total and $niveles == $datos[$i]["tituloDiagnosticoNivel1"])
                    {     
                    // Se crea una variable para el acumulador
                    	$totalRegistros= 0;               	
                        // dentro de acada while se va crear una variable que contenga almenos el titulo para comprarlo con el sigueinte
                        $nivel2 = $datos[$i]['tituloDiagnosticoNivel2'];
                         // Se crea una variable que contenta el valor maximo del nivel 1 porcnivel1
                        $porcnivel1 = $datos[$i]['valorDiagnosticoNivel1'];
                        $porcnivel2 = $datos[$i]['valorDiagnosticoNivel2'];
                        $idnivel2 = $datos[$i]['idDiagnosticoNivel2'];                     	
                        echo '
                          <thead class="thead-inverse">  
                            <tr class="table-info">
                            <th colspan="20" style=" background-color:#1B43AB; color:white;">'.$datos[$i]['tituloDiagnosticoNivel2'].'('.$datos[$i]['valorDiagnosticoNivel2'].'%)'.'</th>                
                            </tr>                            
                          </thead>';    

                          
                           while ($i < $total and $nivel2 == $datos[$i]["tituloDiagnosticoNivel2"])
                            {


                                $nivel3 = $datos[$i]['tituloDiagnosticoNivel3'];
                                echo '
                              <thead class="thead-inverse">  
                                <tr class="table-info">
                                <th colspan="20" style=" background-color:#041F64; color:white;">'.$datos[$i]['tituloDiagnosticoNivel3'].'('.$datos[$i]['valorDiagnosticoNivel3'].'%)'.'</th>                
                                </tr>                          
                              </thead>';
                            
                              while ($i < $total and $nivel3 == $datos[$i]["tituloDiagnosticoNivel3"])
                                {
                            
                                  $nivel4 = $datos[$i]['tituloDiagnosticoNivel4'];
   
                                  $totalRegistros += $datos[$i]['resultadoDiagnostico2Detalle'];

                                  echo '
                                  <tbody>

                                        <tr>
                                          <td style=" background-color:#CACACA;">'.$datos[$i]['numeroDiagnosticoNivel4'].' '.$datos[$i]['tituloDiagnosticoNivel4'].'</td>
                                          <td>'.$datos[$i]['valorDiagnosticoNivel4'].'</td>
                                          <td>'.$datos[$i]["respuestaDiagnostico2Detalle"].'</td>
                                          <td>'.$datos[$i]['resultadoDiagnostico2Detalle'].'</td>
                                          <td>'.$datos[$i]['mejoraDiagnostico2Detalle'].'</td>                              
                                        </tr> 

                                      </tbody
                                  </thead>';

                               
                                  $i++;
                                  //al final del ultimo while tiene que haber una virable incremental í++
                                }      
                              
                            } 
                            // RESULTADO DE NIVEL 2  recursos
                            echo '
                          <thead class="thead-inverse">  
                            <tr class="table-info">
                            <th colspan="3" style=" background-color:#1B43AB; color:white;">RESULTADO  '.$nivel2.'('.$porcnivel2.'%)'.'</th>
                            <th><input type="text" id="resultadonivel2_'.$idnivel2.'" name="resultadonivel2[]" value='.$totalRegistros.' readonly="readonly"></th>                
                            </tr>                            
                          </thead>';
                          $totalAcumulador += $totalRegistros;
                      }
                      // aca termina eel nivel 1 se podria poner un espacio en blanco Resultado de planificacion
                       echo '
                    <thead class="thead-inverse">  
                        <tr class="table-info">
                       <th colspan="3" style=" background-color:#255986; color:white;">RESULTADO '.$niveles.' (PUNTAJE MÁXIMO '.$porcnivel1.'%)</th>
                       <th><input type="text" id="resultadonivel1_'.$idniveles.'" name="resultadonivel1[]" value='.$totalAcumulador.' readonly="readonly"></th>              
                      </tr>
                      <tr class="table-info">
                       <th colspan="20" >&nbsp;</th>                
                      </tr>                                    
                    </thead>'; 
                } 
       
                        
                echo '</table>';
                }	

               ?>            
						</tbody>
					</table>
									<!-- SE HACE DENTRO DE ESTA TABLA el debido rompimiento para armar la tabla  que hace el calculo para la grafica -->
					<table id="TablaGrafico" class="table table-striped table-bordered" width="100%">
						<thead>					
						<tr>
							<td style="background-color:#DCDCDC">ASPECTO A EVALUAR</td>
							<td style="background-color:#DCDCDC">PUNTAJE M&#193;XIMO</td>
							<td style="background-color:#DCDCDC">PUNTAJE OBTENIDO</td>
							<td style="background-color:#DCDCDC">CUMPLIMIENTO (%)</td>	
						<tbody>
						<?php
						 if (isset($diagnosticoEncabezado)) 
                			{	
                				// Se trae el total que ya esta convertido mas arriba 
                				$total = count($diagnostico2);					
			                   	$j=0; 
                				// Se crea una variable que a llevar el total de los registros contados
                				$total = count($diagnostico2);
								$suma = 0;
								$conteo = 0;
								$arrayGrafico = '';
								// Variable en 0 para acumular los valores de la columna PUNTAJE OBTENIDO
								$totalObtenido = 0;
								$cumplimiento = 0;
								// Para el Valor diagnostico 1 
								$ValorNivel1 = 0;
								// Se hace un rompimiento para los titulos, luego otro para los valores
								while($j < $total)
						        {			

					        	 $niveles = $datos[$j]['tituloDiagnosticoNivel1'];
					        	 $idniveles = $datos[$j]['idDiagnosticoNivel1'];
					        	 // Se crea la variable par aalmacenar el valor de puntaje maximo
						         $totalMaximo = 0;
						         
						         $resultadoTotalRegistrosObtenidos = 0;
						         

									echo '<tr>
											<td>'.$datos[$j]["tituloDiagnosticoNivel1"].'</td>
											<th>'.$datos[$j]["valorDiagnosticoNivel1"].'</th>
											';					
									$ValorNivel1 += $datos[$j]["valorDiagnosticoNivel1"];
									// Se crea una variable para mandar el valor que ya fue incrementado COn la J
									$ValorNivel1Incrementado = $datos[$j]["valorDiagnosticoNivel1"]; 


									 while ($j < $total and $niveles == $datos[$j]["tituloDiagnosticoNivel1"])
								        {		

								        	
								          // Se crea una variable para el acumulador
                    					$totalRegistrosObtenido= 0;   	                            						 								       							                            			
								        $nivel2 = $datos[$j]['tituloDiagnosticoNivel2'];		        							
											
										while ($j < $total and $nivel2 == $datos[$j]["tituloDiagnosticoNivel2"])
                            				{		

                        					    $nivel3 = $datos[$j]['tituloDiagnosticoNivel3'];
                        						 	

                            					    while ($j < $total and $nivel3 == $datos[$j]["tituloDiagnosticoNivel3"])
                            					    {     
                            					    	$totalRegistrosObtenido += $datos[$j]['resultadoDiagnostico2Detalle'];
                            					    
                            					    	$conteo++;
														$j++;



                            					    }    
                            					    

                        					}   
                        					$resultadoTotalRegistrosObtenidos += $totalRegistrosObtenido;

										}

										// se imprime el th despues de los rompimientos para tener el acumulado al final OBTENIDO
										echo '
										<th>'.$resultadoTotalRegistrosObtenidos.'</th>
										<th>'.(($resultadoTotalRegistrosObtenidos / $ValorNivel1Incrementado) *100).'</th>
										</tr>';

										$totalMaximo += $ValorNivel1;
										$totalObtenido += $resultadoTotalRegistrosObtenidos;
										// $cumplimiento += (($resultadoTotalRegistrosObtenidos / $ValorNivel1Incrementado) *100);
								}
								
								
								
								 // Aca se imprimen los imput para los resultados Maximo,Obtendo y Total
                       echo '                       
	                    <thead class="thead-inverse">  
	                        <tr class="table-info">
	                       <th><b>TOTAL</b></th>
	                       <th><input  id="resultadonivel1_'.$idniveles.'" name="resultadonivel1PuntajeMaximo[]" value= '.$totalMaximo.'  readonly="readonly"></th>              
	                       <th><input  id="resultadonivel1_'.$idniveles.'" name="resultadonivel1[]" value='.$totalObtenido.' readonly="readonly"></th>	                     
	                      </tr>    
	                      </tr>

	                    </thead>'; 
							}								
						?>

            <!--    <th><input  id="resultadonivel1_'.$idniveles.'" name="resultadonivel1[]" value='.$cumplimiento.' readonly="readonly"></th>   -->
						</tbody>
					</table>

					<div id="graficaChart" style="height: 250px; width: 800px;">
						
					</div>

				</div>
			</div>
		</div>


<script>
	Highcharts.chart('graficaChart', {
    data: {
        table: 'TablaGrafico'
    },
    chart: {
        type: 'column'
    },
    title: {
        text: 'RESULTADO DIAGNÓSTICO'
    },
    yAxis: {
        allowDecimals: false,
        title: {
            text: ''
        }
    },
    tooltip: {
        formatter: function () {
            return '<b>' + this.series.name + '</b><br/>' +
                this.point.y + ' ' + this.point.name.toLowerCase();
        }
    }
});
</script>


	{!!Form::close()!!}
	
@stop