@extends('layouts.grid')
@section('titulo')
	<h3 id="titulo">
		<center>Tipo de Riesgos</center>
	</h3>
@stop

@section('content')

  <?php include ("../resources/views/tiporiesgogridphp.blade.php");?>
@stop