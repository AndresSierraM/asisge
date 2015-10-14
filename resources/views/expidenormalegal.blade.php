@extends('layouts.vista')
@section('titulo')<h3 id="titulo"><center>Emisor Norma Legal</center></h3>@stop

@section('content')
@include('alerts.request')
	@if(isset($expidenormalegal))
		@if(isset($_GET['accion']) and $_GET['accion'] == 'eliminar')
			{!!Form::model($expidenormalegal,['route'=>['expidenormalegal.destroy',$expidenormalegal->idExpideNormaLegal],'method'=>'DELETE'])!!}
		@else
			{!!Form::model($expidenormalegal,['route'=>['expidenormalegal.update',$expidenormalegal->idExpideNormaLegal],'method'=>'PUT'])!!}
		@endif
	@else
		{!!Form::open(['route'=>'expidenormalegal.store','method'=>'POST'])!!}
	@endif


<div id='form-section' >

	<fieldset id="expidenormalegal-form-fieldset">	
		<div class="form-group" id='test'>
          {!!Form::label('codigoExpideNormaLegal', 'C&oacute;digo', array('class' => 'col-sm-2 control-label')) !!}
          <div class="col-sm-10">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="fa fa-barcode"></i>
              </span>
              {!!Form::text('codigoExpideNormaLegal',null,['class'=>'form-control','placeholder'=>'Ingresa el código de la entidad que expide la norma'])!!}
              {!!Form::hidden('idExpideNormaLegal', null, array('id' => 'idExpideNormaLegal')) !!}
            </div>
          </div>
        </div>


		
		<div class="form-group" id='test'>
          {!!Form::label('nombreExpideNormaLegal', 'Nombre', array('class' => 'col-sm-2 control-label')) !!}
          <div class="col-sm-10">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="fa fa-pencil-square-o "></i>
              </span>
				{!!Form::text('nombreExpideNormaLegal',null,['class'=>'form-control','placeholder'=>'Ingresa el nombre de la entidad que expide la norma'])!!}
            </div>
          </div>
    </fieldset>
	@if(isset($expidenormalegal))
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