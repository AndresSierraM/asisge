@extends('layouts.grid')
@section('titulo')
	<h3 id="titulo">
		<center>Cargo</center>
	</h3>
@stop

@section('content')

	<?php include("../resources/views/cargogridphp.blade.php");?>

@stop