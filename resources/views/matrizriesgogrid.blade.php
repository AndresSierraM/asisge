@extends('layouts.grid')
@section('titulo')
	<h3 id="titulo">
		<center>Matriz de Riesgos</center>
	</h3>
@stop

@section('content')

	<?php include ("../resources/views/matrizriesgogridphp.blade.php");?>

@stop