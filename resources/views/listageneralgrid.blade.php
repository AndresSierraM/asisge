@extends('layouts.grid')

@section('titulo')
	<h3 id="titulo">
		<center>Listas Generales</center>
	</h3>
@stop

@section('content')

	<?php include ("../resources/views/listageneralgridphp.blade.php");?>

@stop