@extends('layouts.vista')

@section('content')
@include('alerts.request')

	@if(isset($paquete))
		@if(isset($_GET['accion']) and $_GET['accion'] == 'eliminar')
			{!!Form::model($paquete,['route'=>['paquete.destroy',$paquete->idPaquete],'method'=>'DELETE', 'files' => true])!!}
		@else
			{!!Form::model($paquete,['route'=>['paquete.update',$paquete->idPaquete],'method'=>'PUT', 'files' => true])!!}
		@endif
	@else
		{!!Form::open(['route'=>'paquete.store','method'=>'POST', 'files' => true])!!}
	@endif


<div id='form-section' >

	<div class="container">
		<div class="navbar-header pull-left">
	  	<a class="navbar-brand"  >Paquetes del Men&uacute;</a>
	</div>
	</div>

  <div class="form-container">
	<fieldset id="paquete-form-fieldset">	
		<div class="form-group" id='test'>
          {!! Form::label('ordenPaquete', 'Orden', array('class' => 'col-sm-2 control-label')) !!}
          <div class="col-sm-10">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="fa fa-barcode"></i>
              </span>
              {!!Form::text('ordenPaquete',null,['class'=>'form-control','placeholder'=>'Ingresa el orden del paquete en el menu'])!!}
              {!! Form::hidden('id', null, array('id' => 'id')) !!}
            </div>
          </div>
        </div>


		
		    <div class="form-group" id='test'>
          {!! Form::label('nombrePaquete', 'Nombre', array('class' => 'col-sm-2 control-label')) !!}
          <div class="col-sm-10">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="fa fa-pencil-square-o "></i>
              </span>
      				{!!Form::text('nombrePaquete',null,['class'=>'form-control','placeholder'=>'Ingresa el nombre del paquete'])!!}
            </div>
          </div>
        </div>

        <div class="form-group" id='test'>
          {!! Form::label('iconoPaquete', 'Icono', array('class' => 'col-sm-2 control-label')) !!}
          <div class="col-sm-10">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="fa fa-file-image-o "></i>
              </span>
              {!!Form::file('iconoPaquete')!!}

              @if(isset($paquete->iconoPaquete))
                {!!Html::image('images/'. $paquete->iconoPaquete) !!}
              @endif
            </div>
          </div>
        </div>

    </fieldset>
	@if(isset($paquete))
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