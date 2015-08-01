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
				{!!link_to_route('pais.create', 'Nuevo', null, ['class'=>'btn btn-primary'])!!}
			</td>
		</tr>
		<tr>
			<td>Acci&oacute;n</td>
			<td>Id</td>
			<td>C&oacute;digo</td>
			<td>Nombre</td>
		</tr>
		@foreach ($pais as $dato)
		<tr>
			<td>
				{!!link_to_route('pais.edit', 'Editar', $dato->idPais, ['class'=>'btn btn-primary'])!!}
				{!!link_to_route('pais.edit', 'Eliminar', [$dato->idPais,'accion=eliminar'], ['class'=>'btn btn-primary'])!!}
			</td>
			<td>{{$dato->idPais}}</td>
			<td>{{$dato->codigoPais}}</td>
			<td>{{$dato->nombrePais}}</td>
		</tr>
		@endforeach
	</table>
@stop