@extends('layouts.principal')

<?php $message=Session::get('message')?>

@if(Session::has('message'))
	<div>
		{{Session::get('message')}}
	</div>
@endif

@section('content')

	<table>
		<tr>
			<td>
				{!!link_to_route('tipoidentificacion.create', 'Nuevo', null, ['class'=>'btn btn-primary'])!!}
			</td>
		</tr>
		
		@foreach ($tipoidentificacion as $dato)
		<tr>
			<td>
				{!!link_to_route('tipoidentificacion.edit', 'Editar', $dato->idTipoIdentificacion, ['class'=>'btn btn-primary'])!!}
				{!!link_to_route('tipoidentificacion.edit', 'Eliminar', [$dato->idTipoIdentificacion,'accion=eliminar'], ['class'=>'btn btn-primary'])!!}
			</td>
			<td>{{$dato->idTipoIdentificacion}}</td>
			<td>{{$dato->codigoTipoIdentificacion}}</td>
			<td>{{$dato->nombreTipoIdentificacion}}</td>
		</tr>
		@endforeach
	</table>
@stop