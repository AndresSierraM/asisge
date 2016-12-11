@extends('layouts.vista')
@section('titulo')<h3 id="titulo"><center>Configuraci&oacute;n de la Alerta- Plan de Trabajo</center></h3>@stop

@section('content')
@include('alerts.request')

	@if(isset($tipoexamenmedico))
		@if(isset($_GET['accion']) and $_GET['accion'] == 'eliminar')
			{!!Form::model($tipoexamenmedico,['route'=>['tipoexamenmedico.destroy',$tipoexamenmedico->idTipoExamenMedico],'method'=>'DELETE'])!!}
		@else
			{!!Form::model($tipoexamenmedico,['route'=>['tipoexamenmedico.update',$tipoexamenmedico->idTipoExamenMedico],'method'=>'PUT'])!!}
		@endif
	@else
		{!!Form::open(['route'=>'tipoexamenmedico.store','method'=>'POST'])!!}
	@endif
