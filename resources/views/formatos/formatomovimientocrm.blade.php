<?php 

$id = isset($_GET["idDocumentoCRM"]) ? $_GET["idDocumentoCRM"] : 0; 

$campos = DB::select(
    'SELECT codigoDocumentoCRM, nombreDocumentoCRM, nombreCampoCRM,descripcionCampoCRM, 
            mostrarGridDocumentoCRMCampo, relacionTablaCampoCRM, relacionNombreCampoCRM, relacionAliasCampoCRM
    FROM documentocrm
    left join documentocrmcampo
    on documentocrm.idDocumentoCRM = documentocrmcampo.DocumentoCRM_idDocumentoCRM
    left join campocrm
    on documentocrmcampo.CampoCRM_idCampoCRM = campocrm.idCampoCRM
    where documentocrm.idDocumentoCRM = '.$id.' and mostrarVistaDocumentoCRMCampo = 1');


$datos = array();
$camposVista = '';
for($i = 0; $i < count($campos); $i++)
{
    $datos = get_object_vars($campos[$i]); 
    
    $camposVista .= $datos["nombreCampoCRM"].',';
}

	$idMovimientoCRMA = (isset($movimientocrm->idMovimientoCRM) ? $movimientocrm->idMovimientoCRM : 0);

?>
@extends('layouts.formato')
<h3 id="titulo"><center><?php echo '('.$datos["codigoDocumentoCRM"].') '.$datos["nombreDocumentoCRM"];?></center></h3>

@section('contenido')

	@if(isset($movimientocrm))
		{!!Form::model($movimientocrm)!!}
	@endif
		<div id='form-section' >
				<fieldset id="movimientocrm-form-fieldset">	
					<div class="form-group" id='test'>
						<div class="col-sm-6">
							<div class="col-sm-4">
								{!!Form::label('numeroMovimientoCRM', 'Número', array())!!}
							</div>
							<div class="col-sm-8">
					            <div class="input-group">
					              	<?php echo $movimientocrm->numeroMovimientoCRM;?>
								</div>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="col-sm-4">
								{!!Form::label('asuntoMovimientoCRM', 'Asunto', array())!!}
							</div>
							<div class="col-sm-8">
					            <div class="input-group">
					              	<?php echo $movimientocrm->asuntoMovimientoCRM;?>
					    		</div>
					    	</div>
					    </div>
					    <?php
						
							if(strpos($camposVista, 'OrigenCRM_idOrigenCRM') !== false)
							{ 
						?>
						<div class="col-sm-6">
							<div class="col-sm-4">
								{!!Form::label('nombreOrigenCRM', 'Origen', array())!!}
							</div>
							<div class="col-sm-8">
					            <div class="input-group">
					              	<?php echo $movimientocrm->OrigenCRM->nombreOrigenCRM;?>
								</div>
							</div>
						</div>
						<?php
							}
						?>
					    <div class="col-sm-6">
							<div class="col-sm-4">
								{!!Form::label('fechaSolicitudMovimientoCRM', 'F. Elaboración', array())!!}
							</div>
							<div class="col-sm-8">
					            <div class="input-group">
					              	<?php echo $movimientocrm->fechaSolicitudMovimientoCRM;?>
								</div>
							</div>
						</div>
						
						<?php 
							if(strpos($camposVista, 'fechaEstimadaSolucionMovimientoCRM') !== false)
							{ 
						?>
						<div class="col-sm-6">
							<div class="col-sm-4">
								{!!Form::label('fechaEstimadaSolucionMovimientoCRM', 'Estimada', array())!!}
							</div>
							<div class="col-sm-8">
					            <div class="input-group">
					              	<?php echo $movimientocrm->fechaEstimadaSolucionMovimientoCRM;?>
								</div>
							</div>
						</div>
						
						<?php
							}

							if(strpos($camposVista, 'fechaVencimientoMovimientoCRM') !== false)
							{ 
						?>
						<div class="col-sm-6">
							<div class="col-sm-4">
								{!!Form::label('fechaVencimientoMovimientoCRM', 'F. Vencimiento', array())!!}
							</div>
							<div class="col-sm-8">
					            <div class="input-group">
					              	<?php echo $movimientocrm->fechaVencimientoMovimientoCRM;?>
								</div>
							</div>
						</div>
						
						<?php
							}

							if(strpos($camposVista, 'fechaRealSolucionMovimientoCRM') !== false)
							{ 
						?>
						<div class="col-sm-6">
							<div class="col-sm-4">
								{!!Form::label('fechaRealSolucionMovimientoCRM', 'F. Real Solución', array())!!}
							</div>
							<div class="col-sm-8">
					            <div class="input-group">
					              	<?php echo $movimientocrm->fechaRealSolucionMovimientoCRM;?>
								</div>
							</div>
						</div>
						<?php
							}

							if(strpos($camposVista, 'AcuerdoServicio_idAcuerdoServicio') !== false)
							{ 
						?>
						<div class="col-sm-6">
							<div class="col-sm-4">
								{!!Form::label('AcuerdoServicio_idAcuerdoServicio', 'Acuerdo de Servicio', array())!!}
							</div>
							<div class="col-sm-8">
					            <div class="input-group">
					              	<?php echo $movimientocrm->AcuerdoServicio->nombreAcuerdoServicio;?>

								</div>
							</div>
						</div>
						<?php
							}

							if(strpos($camposVista, 'diasEstimadosSolucionMovimientoCRM') !== false)
							{ 
						?>
						<div class="col-sm-6">
							<div class="col-sm-4">
								{!!Form::label('diasEstimadosSolucionMovimientoCRM', 'Días Est. Solución', array())!!}
							</div>
							<div class="col-sm-8">
					            <div class="input-group">
					              	<?php echo $movimientocrm->diasEstimadosSolucionMovimientoCRM;?>
								</div>
							</div>
						</div>
						<?php
							}

							if(strpos($camposVista, 'diasRealesSolucionMovimientoCRM') !== false)
							{ 
						?>
						<div class="col-sm-6">
							<div class="col-sm-4">
								{!!Form::label('diasRealesSolucionMovimientoCRM', 'Días Reales Solución', array())!!}
							</div>
							<div class="col-sm-8">
					            <div class="input-group">
					              	<?php echo $movimientocrm->diasRealesSolucionMovimientoCRM;?>
								</div>
							</div>
						</div>
						<?php
							}

							if(strpos($camposVista, 'prioridadMovimientoCRM') !== false)
							{ 
						?>
						<div class="col-sm-6">
							<div class="col-sm-4">
								{!!Form::label('prioridadMovimientoCRM', 'Prioridad', array())!!}
							</div>
							<div class="col-sm-8">
					            <div class="input-group">
					              	<?php echo $movimientocrm->prioridadMovimientoCRM;?>
								</div>
							</div>
						</div>
						<?php
							}

							if(strpos($camposVista, 'Tercero_idSolicitante') !== false)
							{ 
						?>
						<div class="col-sm-6">
							<div class="col-sm-4">
								{!!Form::label('Tercero_idSolicitante', 'Solicitante', array())!!}
							</div>
							<div class="col-sm-8">
					            <div class="input-group">
					              	<?php echo $movimientocrm->TerceroSolicitante->nombreCompletoTercero;?>
								</div>
							</div>
						</div>
						<?php
							}

							if(strpos($camposVista, 'Tercero_idSupervisor') !== false)
							{ 
						?>
						<div class="col-sm-6">
							<div class="col-sm-4">
								{!!Form::label('Tercero_idSupervisor', 'Supervisor', array())!!}
							</div>
							<div class="col-sm-8">
					            <div class="input-group">
					              	<?php echo $movimientocrm->TerceroSupervisor->nombreCompletoTercero;?>
								</div>
							</div>
						</div>
						<?php
							}

							if(strpos($camposVista, 'Tercero_idAsesor') !== false)
							{ 
						?>
						<div class="col-sm-6">
							<div class="col-sm-4">
								{!!Form::label('Tercero_idAsesor', 'Asesor', array())!!}
							</div>
							<div class="col-sm-8">
					            <div class="input-group">
					              	<?php echo $movimientocrm->TerceroAsesor->nombreCompletoTercero;?>
								</div>
							</div>
						</div>
						<?php
							}

							if(strpos($camposVista, 'CategoriaCRM_idCategoriaCRM') !== false)
							{ 
						?>
						<div class="col-sm-6">
							<div class="col-sm-4">
								{!!Form::label('CategoriaCRM_idCategoriaCRM', 'Categoría', array())!!}
							</div>
							<div class="col-sm-8">
					            <div class="input-group">
					              	<?php echo $movimientocrm->CategoriaCRM->nombreCategoriaCRM;?>

								</div>
							</div>
						</div>
						<?php
							}

							if(strpos($camposVista, 'EventoCRM_idEventoCRM') !== false)
							{ 
						?>
						<div class="col-sm-6">
							<div class="col-sm-4">
								{!!Form::label('EventoCRM_idEventoCRM', 'Evento / Campaña', array())!!}
							</div>
							<div class="col-sm-8">
					            <div class="input-group">
					              	<?php echo $movimientocrm->EventoCRM->nombreEventoCRM;?>
								</div>
							</div>
						</div>
						<?php
							}

							if(strpos($camposVista, 'LineaNegocio_idLineaNegocio') !== false)
							{ 
						?>
						<div class="col-sm-6">
							<div class="col-sm-4">
								{!!Form::label('LineaNegocio_idLineaNegocio', 'Línea de Negocio', array())!!}
							</div>
							<div class="col-sm-8">
					            <div class="input-group">
					              	<?php echo $movimientocrm->LineaNegocio->nombreLineaNegocio;?>
								</div>
							</div>
						</div>
						<?php
							}

							if(strpos($camposVista, 'valorMovimientoCRM') !== false)
							{ 
						?>
						<div class="col-sm-6">
							<div class="col-sm-4">
								{!!Form::label('valorMovimientoCRM', 'Valor', array())!!}
							</div>
							<div class="col-sm-8">
					            <div class="input-group">
					              	<?php echo $movimientocrm->valorMovimientoCRM;?>

								</div>
							</div>
						</div>
						
						<?php
							}

							if(strpos($camposVista, 'EstadoCRM_idEstadoCRM') !== false)
							{ 
						?>
						<div class="col-sm-6">
							<div class="col-sm-4">
								{!!Form::label('EstadoCRM_idEstadoCRM', 'Estado', array())!!}
							</div>
							<div class="col-sm-8">
					            <div class="input-group">
					              	<?php echo $movimientocrm->EstadoCRM;?>

								</div>
							</div>
						</div>
						
						<?php
							}
						?>

						

					<?php
						if(strpos($camposVista, 'detallesMovimientoCRM') !== false)
						{ 
					?>
					  <div id="detalles" class="panel panel-primary">
					    <div class="col-sm-12">
							<div class="panel panel-primary">
					            <div class="panel-heading">
					                <i class="fa fa-pencil-square-o"></i> {!!Form::label('detallesMovimientoCRM', 'Detalles', array())!!}
					            </div>
					            <div class="panel-body">
					                
									<div class="col-sm-12">
							              <?php echo $movimientocrm->detallesMovimientoCRM;?>
									</div>

					            </div>
					        </div>
						</div>
					  </div>
					<?php
						}
					
						if(strpos($camposVista, 'solucionMovimientoCRM') !== false)
						{ 
					?>
					  <div id="solucion" class="panel panel-primary">
					  	<div class="col-sm-12">
							<div class="panel panel-primary">
                                <div class="panel-heading">
                                    <i class="fa fa-pencil-square-o"></i> {!!Form::label('solucionMovimientoCRM', 'Solución', array())!!}
                                </div>
                                <div class="panel-body">
                                    
									<div class="col-sm-12">
							              <?php echo $movimientocrm->solucionMovimientoCRM;?>
									</div>

                                </div>
                            </div>
						</div>
					</div>
					<?php
						}
					if(strpos($camposVista, 'asistentesMovimientoCRM') !== false)
						{ 
					?>
					  <div id="solucion" class="panel panel-primary">
					  	<div class="col-sm-12">
							<div class="panel panel-primary">
                                <div class="panel-heading">
                                    <i class="fa fa-pencil-square-o"></i> {!!Form::label('', 'Asistentes', array())!!}
                                </div>
                                <div class="panel-body">
                                    
									<div class="col-sm-12">
							            <table >
											<tr>
												<td style="width: 330px;">Nombre</td>
												<td style="width: 270px;">Cargo</td>
												<td style="width: 150px;">Tel&eacute;fono</td>
												<td style="width: 230px;">Correo</td>
											</tr>
											
												<?php $asistentes =  (isset($movimientocrm) ? ($movimientocrm->movimientoCRMAsistentes) : array());

												foreach ($asistentes as $key => $value) {
													echo '<tr><td>'.$value['nombreMovimientoCRMAsistente'].'</td>';
													echo '<td>'.$value['cargoMovimientoCRMAsistente'].'</td>';
													echo '<td>'.$value['telefonoMovimientoCRMAsistente'].'</td>';
													echo '<td>'.$value['correoElectronicoMovimientoCRMAsistente'].'</td>';
													echo '</tr>';
												}
												?>
											
										</table>
									</div>

                                </div>
                            </div>
						</div>
					</div>
										
									
					 <?php
						}
					?>
					
					</div>
				</fieldset>	
		    </div>	

{!!Form::close()!!}	
@stop