@extends('layouts.grid')
@section('titulo')
	<h3 id="titulo">
		<center>Grupos de Apoyo</center>
	</h3>
@stop

@section('content')

	<?php include ("../resources/views/grupoapoyogridphp.blade.php");?>

@stop