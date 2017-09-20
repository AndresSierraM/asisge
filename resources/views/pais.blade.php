  @extends('layouts.vista')
@section('titulo')<h3 id="titulo"><center>Paises</center></h3>@stop



@section('content')
@include('alerts.request')
	@if(isset($pais))
		@if(isset($_GET['accion']) and $_GET['accion'] == 'eliminar')
			{!!Form::model($pais,['route'=>['pais.destroy',$pais->idPais],'method'=>'DELETE'])!!}
		@else
			{!!Form::model($pais,['route'=>['pais.update',$pais->idPais],'method'=>'PUT'])!!}
		@endif
	@else
		{!!Form::open(['route'=>'pais.store','method'=>'POST'])!!}
	@endif


<div id='form-section' >

	<fieldset id="pais-form-fieldset">	
		<div class="form-group required" id='test'>
          {!!Form::label('codigoPais', 'C&oacute;digo', array('class' => 'col-sm-2 control-label')) !!}
          <div class="col-sm-10">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="fa fa-barcode"></i>
              </span>
              {!!Form::text('codigoPais',null,['class'=>'form-control','placeholder'=>'Ingresa el código del país'])!!}
              {!!Form::hidden('idPais', null, array('id' => 'idPais')) !!}
            </div>
          </div>
        </div>


		
		<div class="form-group required" id='test'>
          {!!Form::label('nombrePais', 'Nombre', array('class' => 'col-sm-2 control-label')) !!}
          <div class="col-sm-10">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="fa fa-pencil-square-o "></i>
              </span>
				{!!Form::text('nombrePais',null,['class'=>'form-control','placeholder'=>'Ingresa el nombre del país'])!!}
            </div>
          </div>
    </fieldset>
	@if(isset($pais))
 		@if(isset($_GET['accion']) and $_GET['accion'] == 'eliminar')
   			{!!Form::submit('Eliminar',["class"=>"btn btn-primary"])!!}
  		@else
   			{!!Form::submit('Modificar',["class"=>"btn btn-primary"])!!}
  		@endif
 	@else
  		{!!Form::submit('Adicionar',["class"=>"btn btn-primary"])!!}
 	@endif

	{!! Form::close() !!}
	</div>
</div>
@stop