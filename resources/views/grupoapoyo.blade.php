@extends('layouts.vista')

@section('titulo')
	<h3 id="titulo">
		<center>Grupos de Apoyo</center>
	</h3>
@stop

@section('content')

	@include('alerts.request')
	
	@if(isset($grupoApoyo))
		@if(isset($_GET['accion']) and $_GET['accion'] == 'eliminar')
			{!!Form::model($grupoApoyo,['route'=>['grupoapoyo.destroy',$grupoApoyo->idGrupoApoyo],'method'=>'DELETE'])!!}
		@else
			{!!Form::model($grupoApoyo,['route'=>['grupoapoyo.update',$grupoApoyo->idGrupoApoyo],'method'=>'PUT'])!!}
		@endif
	@else
		{!!Form::open(['route'=>'grupoapoyo.store','method'=>'POST'])!!}
	@endif

		<div id="form_section">
			<fieldset id="grupoapoyo-form-fieldset">
				<div class="form-group" id='test'>
					{!!Form::label('codigoGrupoApoyo', 'C&oacute;digo', array('class' => 'col-sm-2 control-label'))!!}
					<div class="col-sm-10">
						<div class="input-group">
							<span class="input-group-addon">
								<i class="fa fa-pencil-square-o" style="width: 14px;"></i>
							</span>
							<input type="hidden" id="token" value="{{csrf_token()}}"/>
							{!!Form::text('codigoGrupoApoyo', null, ['class'=>'form-control','placeholder'=>'Ingresa el c&oacute;digo','id' => 'codigoGrupoApoyo'])!!}
							{!!Form::hidden('idGrupoApoyo', null, array('id' => 'idGrupoApoyo'))!!}
						</div>
					</div>
				</div>
				<div class="form-group" id='test'>
					{!!Form::label('nombreGrupoApoyo', 'Nombre', array('class' => 'col-sm-2 control-label'))!!}
					<div class="col-sm-10">
						<div class="input-group">
							<span class="input-group-addon">
								<i class="fa fa-pencil-square-o" style="width: 14px;"></i>
							</span>
							{!!Form::text('nombreGrupoApoyo',null,['class'=>'form-control','placeholder'=>'Ingresa el nombre'])!!}
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="col-lg-12">
						<div class="panel panel-default">
							<div class="panel-heading">Detalles</div>
							<div class="panel-body">
								<div class="panel-group" id="accordion">
									<div class="panel panel-default">
										<div class="panel-heading">
											<h4 class="panel-title">
												<a data-toggle="collapse" data-parent="#accordion" href="#convocatoria">Convocatoria Votaci&oacute;n</a>
											</h4>
										</div>
										<div id="convocatoria" class="panel-collapse collapse in">
											<div class="panel-body">
												<div class="form-group" id='test'>
													<div class="col-sm-10" style="width: 100%;">
														<div class="input-group">
															{!!Form::textarea('convocatoriaVotacionGrupoApoyo',null,['class'=>'ckeditor','placeholder'=>'Ingresa la convocatoria'])!!}
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="panel panel-default">
										<div class="panel-heading">
											<h4 class="panel-title">
												<a data-toggle="collapse" data-parent="#acta" href="#acta">Acta de Escrutinio y Votaci&oacute;n</a>
											</h4>
										</div>
										<div id="acta" class="panel-collapse collapse">
											<div class="panel-body">
												<div class="form-group" id='test'>
													<div class="col-sm-10" style="width: 100%;">
														<div class="input-group">
															{!!Form::textarea('actaEscrutinioGrupoApoyo',null,['class'=>'ckeditor','placeholder'=>'Ingresa el acta'])!!}
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="panel panel-default">
										<div class="panel-heading">
											<h4 class="panel-title">
												<a data-toggle="collapse" data-parent="#accordion" href="#constitucion">Acta de Constituci&oacute;n</a>
											</h4>
										</div>
										<div id="constitucion" class="panel-collapse collapse">
											<div class="panel-body">
												<div class="form-group" id='test'>
													<div class="col-sm-10" style="width: 100%;">
														<div class="input-group">
															{!!Form::textarea('actaConstitucionGrupoApoyo',null,['class'=>'ckeditor','placeholder'=>'Ingresa el acta'])!!}
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-12">
						@if(isset($grupoApoyo))
							{!!Form::submit(((isset($_GET['accion']) and $_GET['accion'] == 'eliminar') ? 'Eliminar' : 'Modificar'),["class"=>"btn btn-primary","onclick"=>'validarFormulario(event);'])!!}
						@else
							{!!Form::submit('Adicionar',["class"=>"btn btn-primary","onclick"=>'validarFormulario(event);'])!!}
						@endif
						</br></br></br></br>
					</div>
				</div>
			</fieldset>
		</div>	
	{!!Form::close()!!}
@stop