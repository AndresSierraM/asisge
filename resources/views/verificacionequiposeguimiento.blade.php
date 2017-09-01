@extends('layouts.vista')

@section('titulo')
	<h3 id="titulo">
		Verificaci&#243;n de Equipos de seguimiento y medici&#243;n
	</h3>
@stop
@section('content')

	@include('alerts.request')
<!-- 	{!!Html::script('js/equiposeguimiento.js')!!} -->
<script>
// 
</script>
	@if(isset($equiposeguimiento))
		@if(isset($_GET['accion']) and $_GET['accion'] == 'eliminar')
			{!!Form::model($equiposeguimiento,['route'=>['equiposeguimiento.destroy',$equiposeguimiento->idEquipoSeguimiento],'method'=>'DELETE', 'files' => true])!!}
		@else
			{!!Form::model($equiposeguimiento,['route'=>['equiposeguimiento.update',$equiposeguimiento->idEquipoSeguimiento],'method'=>'PUT', 'files' => true])!!}
		@endif
	@else
		{!!Form::open(['route'=>'equiposeguimiento.store','method'=>'POST', 'files' => true])!!}
	@endif
		
		<div id="form_section">
			<fieldset id="equiposeguimiento-form-fieldset">
				<div class="form-group" id='test'>
					{!!Form::label('fechaEquipoSeguimiento', 'Fecha', array('class' => 'col-sm-2 control-label'))!!}
					<div class="col-sm-10">
			            <div class="input-group">
			              	<span class="input-group-addon">
			                	<i class="fa fa-calendar" style="width: 14px;"></i>
			              	</span>
			              	<input type="hidden" id="token" value="{{csrf_token()}}"/>
			              	{!!Form::text('fechaEquipoSeguimiento',null,['class'=>'form-control','placeholder'=>'Seleccione la fecha'])!!}
					      	{!!Form::hidden('idEquipoSeguimiento', 0, array('id' => 'idEquipoSeguimiento'))!!}
					      	 {!!Form::hidden('eliminarseguimiento',null, array('id' => 'eliminarseguimiento'))!!}
						</div>
					</div>
				</div>
				<div class="form-group" id='test'>
					{!! Form::label('nombreEquipoSeguimiento', 'Equipo', array('class' => 'col-sm-2 control-label')) !!}
					<div class="col-sm-10">
			            <div class="input-group">
			              	<span class="input-group-addon">
			                	<i class="fa fa-pencil-square-o" style="width: 14px;"></i>
			              	</span>							
							{!!Form::select('Tercero_idResponsable',$EquipoSeguimientoE, (isset($equiposeguimiento) ? $equiposeguimiento->Tercero_idResponsable : 0),["class" => "chosen-select form-control", "placeholder" =>"Seleccione el Equipo"])!!}  



					    </div>
					</div>
				</div>
				<div class="form-group" id='test'>
					{!!Form::label('Tercero_idResponsable', 'C&#243;digo', array('class' => 'col-sm-2 control-label'))!!}
					<div class="col-sm-10">
			            <div class="input-group">
			              	<span class="input-group-addon">
			                	<i class="fa fa-caret-square-o-down" style="width: 14px;"></i>
			              	</span>
			              	{!!Form::select('SublineaProducto_idSublineaProducto',[],null,['id'=>'SublineaProducto_idSublineaProducto','class' => 'form-control','style'=>'padding-left:2px;','placeholder'=>'Seleccione el C&#243;digo'])!!}
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
						   {!!Form::select('SublineaProducto_idSublineaProducto',[],null,['id'=>'SublineaProducto_idSublineaProducto','class' => 'form-control','style'=>'padding-left:2px;','placeholder'=>'Seleccione el Responsable'])!!}
					    </div>
					</div>
				</div>
				<div class="form-group" id='test'>
					{!!Form::label('Tercero_idResponsable', 'Error Encontrado', array('class' => 'col-sm-2 control-label'))!!}
					<div class="col-sm-10">
			            <div class="input-group">
			              	<span class="input-group-addon">
			                	<i class="fa fa-pencil-square-o" style="width: 14px;"></i>
			              	</span>							
							{!!Form::text('nombreEquipoSeguimiento',null,['class'=>'form-control','placeholder'=>'Ingresa el Error Encontrado'])!!}
					    </div>
					</div>
				</div>
				<br><br><br><br><br><br><br><br><br>
				<div class="form-group" id='test'>
					{!!Form::label('Tercero_idResponsable', 'Resultado', array('class' => 'col-sm-2 control-label'))!!}
					<div class="col-sm-10">
			            <div class="input-group">
			              	<span class="input-group-addon">
			                	<i class="fa fa-spinner" style="width: 14px;"></i>
			              	</span>							
							{!!Form::text('nombreEquipoSeguimiento',null,['class'=>'form-control','readonly','placeholder'=>'Debe seleccionar el Equipo'])!!}
					    </div>
					</div>
				</div>
				<div class="form-group" id='test'>
					{!!Form::label('Tercero_idResponsable', 'Acci&#243;n a tomar', array('class' => 'col-sm-2 control-label'))!!}
					<div class="col-sm-10">
			            <div class="input-group">
			              	<span class="input-group-addon">
			                	<i class="fa fa-pencil-square-o" style="width: 14px;"></i>
			              	</span>							
							{!!Form::text('nombreEquipoSeguimiento',null,['class'=>'form-control','placeholder'=>'Ingresa la Acci&#243;n a tomar'])!!}
					    </div>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-12">
						@if(isset($equiposeguimiento))
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

		$('#fechaEquipoSeguimiento').datetimepicker(({
			format: "YYYY-MM-DD"
		}));

    </script>
@stop