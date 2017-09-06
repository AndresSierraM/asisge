@extends('layouts.vista')

@section('titulo')
	<h3 id="titulo">
		Verificaci&#243;n de Equipos de seguimiento y medici&#243;n
	</h3>
@stop
@section('content')

	@include('alerts.request')
	{!!Html::script('js/equiposeguimientoverificacion.js')!!}
<script>
$(document).ready(function(){ 

  codigo = "<?php echo @$equiposeguimientoverificacion->EquipoSeguimientoDetalle_idEquipoSeguimientoDetalle;?>";
  if ($("#EquipoSeguimiento_idEquipoSeguimiento").length > 0  && $("#EquipoSeguimiento_idEquipoSeguimiento").val() !== '') 
  {
      llenarCodigoResponsable($("#EquipoSeguimiento_idEquipoSeguimiento").val(),codigo);
      $("#EquipoSeguimientoDetalle_idEquipoSeguimientoDetalle").trigger("chosen:updated").prop('selected','selected');
      $("#EquipoSeguimiento_idEquipoSeguimiento").trigger("chosen:updated").prop('selected','selected');
  }
  });              

</script>
	@if(isset($equiposeguimientoverificacion))
		@if(isset($_GET['accion']) and $_GET['accion'] == 'eliminar')
			{!!Form::model($equiposeguimientoverificacion,['route'=>['equiposeguimientoverificacion.destroy',$equiposeguimientoverificacion->idEquipoSeguimientoVerificacion],'method'=>'DELETE', 'files' => true])!!}
		@else
			{!!Form::model($equiposeguimientoverificacion,['route'=>['equiposeguimientoverificacion.update',$equiposeguimientoverificacion->idEquipoSeguimientoVerificacion],'method'=>'PUT', 'files' => true])!!}
		@endif
	@else
		{!!Form::open(['route'=>'equiposeguimientoverificacion.store','method'=>'POST', 'files' => true])!!}
	@endif
		
		<div id="form_section">
			<fieldset id="equiposeguimientoverificacion-form-fieldset">
				<div class="form-group" id='test'>
					{!!Form::label('fechaEquipoSeguimientoVerificacion', 'Fecha', array('class' => 'col-sm-2 control-label'))!!}
					<div class="col-sm-10">
			            <div class="input-group">
			              	<span class="input-group-addon">
			                	<i class="fa fa-calendar" style="width: 14px;"></i>
			              	</span>
			              	<input type="hidden" id="token" value="{{csrf_token()}}"/>
			              	{!!Form::text('fechaEquipoSeguimientoVerificacion',null,['class'=>'form-control','placeholder'=>'Seleccione la fecha'])!!}
					      	{!!Form::hidden('idEquipoSeguimientoVerificacion', 0, array('id' => 'idEquipoSeguimientoVerificacion'))!!}
					      	<!-- Se oculta el ID de detalle de Seguimiento Detalle -->					
						</div>
					</div>
				</div>
				<div class="form-group" id='test'>
					{!! Form::label('EquipoSeguimiento_idEquipoSeguimiento', 'Equipo', array('class' => 'col-sm-2 control-label')) !!}
					<div class="col-sm-10">
			            <div class="input-group">
			              	<span class="input-group-addon">
			                	<i class="fa fa-pencil-square-o" style="width: 14px;"></i>
			              	</span>
			              								<!-- Se ejecuta un onchange para llenar la lista de Codigo y Responsable -->
							{!!Form::select('EquipoSeguimiento_idEquipoSeguimiento',$EquipoSeguimientoE, (isset($equiposeguimientoverificacion) ? $equiposeguimientoverificacion->EquipoSeguimiento_idEquipoSeguimiento : 0),["class" => "chosen-select form-control", "placeholder" =>"Seleccione el Equipo",'onchange'=>"llenarCodigoResponsable(this.value,codigo);"])!!}  
					    </div>
					</div>
				</div>
				<div class="form-group" id='test'>
					{!!Form::label('Tercero_idResponsable', 'Responsable', array('class' => 'col-sm-2 control-label'))!!}
					<div class="col-sm-10">
			            <div class="input-group">
			              	<span class="input-group-addon">
			                	<i class="fa fa-caret-square-o-down" style="width: 14px;"></i>
			              	</span>							
						    {!!Form::text('Tercero_idResponsable',null,['class'=>'form-control','readonly','placeholder'=>'Debe seleccionar el Equipo', 'autocomplete' => 'off'])!!}      
					    </div>
					</div>
				</div>
				<div class="form-group" id='test'>
					{!!Form::label('EquipoSeguimientoDetalle_idEquipoSeguimientoDetalle', 'C&#243;digo', array('class' => 'col-sm-2 control-label'))!!}
					<div class="col-sm-10">
			            <div class="input-group">
			              	<span class="input-group-addon">
			                	<i class="fa fa-caret-square-o-down" style="width: 14px;"></i>
			              	</span>
			              	{!!Form::select('EquipoSeguimientoDetalle_idEquipoSeguimientoDetalle',[],null,['id'=>'EquipoSeguimientoDetalle_idEquipoSeguimientoDetalle','class' => 'form-control','style'=>'padding-left:2px;','placeholder'=>'Seleccione el C&#243;digo','onchange'=>"CompararErrorEquipo(this.value)"])!!}
					    </div>
					</div>
				</div>
				<div class="form-group" id='test'>
					{!!Form::label('errorEncontradoEquipoSeguimientoVerificacion', 'Error Encontrado', array('class' => 'col-sm-2 control-label'))!!}
					<div class="col-sm-10">
			            <div class="input-group">
			              	<span class="input-group-addon">
			                	<i class="fa fa-pencil-square-o" style="width: 14px;"></i>
			              	</span>							
							{!!Form::text('errorEncontradoEquipoSeguimientoVerificacion',null,['class'=>'form-control','placeholder'=>'Ingresa el Error Encontrado','onchange'=>"CompararErrorEquipo($('#EquipoSeguimientoDetalle_idEquipoSeguimientoDetalle').val())"])!!}
					    </div>
					</div>
				</div>
				<br><br><br><br><br><br><br><br><br>
				<div class="form-group" id='test'>
					{!!Form::label('resultadoEquipoSeguimientoVerificacion', 'Resultado', array('class' => 'col-sm-2 control-label'))!!}
					<div class="col-sm-10">
			            <div class="input-group">
			              	<span class="input-group-addon">
			                	<i class="fa fa-spinner" style="width: 14px;"></i>
			              	</span>							
							{!!Form::text('resultadoEquipoSeguimientoVerificacion',null,['class'=>'form-control','readonly','placeholder'=>'Debe seleccionar el Equipo'])!!}
					    </div>
					</div>
				</div>
				<div class="form-group" id='test'>
					{!!Form::label('accionEquipoSeguimientoVerificacion', 'Acci&#243;n a tomar', array('class' => 'col-sm-2 control-label'))!!}
					<div class="col-sm-10">
			            <div class="input-group">
			              	<span class="input-group-addon">
			                	<i class="fa fa-pencil-square-o" style="width: 14px;"></i>
			              	</span>							
							{!!Form::text('accionEquipoSeguimientoVerificacion',null,['class'=>'form-control','placeholder'=>'Ingresa la Acci&#243;n a tomar'])!!}
					    </div>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-12">
						@if(isset($equiposeguimientoverificacion))
							{!!Form::submit(((isset($_GET['accion']) and $_GET['accion'] == 'eliminar') ? 'Eliminar' : 'Modificar'),["class"=>"btn btn-primary","onclick"=>'validarFormulario(event);'])!!}
						@else
							{!!Form::submit('Adicionar',["class"=>"btn btn-primary","onclick"=>'validarFormulario(event);'])!!}
						@endif
					</div>
				</div>
			</fieldset>
		</div>	

	{!!Form::close()!!}
	<script type="text/javascript">

		$('#fechaEquipoSeguimientoVerificacion').datetimepicker(({
			format: "YYYY-MM-DD"
		}));

    </script>
@stop