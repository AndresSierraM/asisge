@extends('layouts.principal')

@section('content')

	@if(isset($tercero))
		@if(isset($_GET['accion']) and $_GET['accion'] == 'eliminar')
			{!!Form::model($tercero,['route'=>['tercero.destroy',$tercero->idTercero],'method'=>'DELETE'])!!}
		@else
			{!!Form::model($tercero,['route'=>['tercero.update',$tercero->idTercero],'method'=>'PUT'])!!}
		@endif	
	@else
		{!!Form::open(['route'=>'tercero.store','method'=>'POST'])!!}			
	@endif
		
		<div id="form_section">
			<div class="container">
				<div class="navbar-header pull-left">
					<a class="navbar-brand">Terceros</a>
				</div>
			</div>
			<div class="form-container">
				
			</div>
		</div>

	{!!Form::close()!!}	

@stop