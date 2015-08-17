@extends('layouts.vista')

@section('content')
@include('alerts.request')

	@if(isset($opcion))
		@if(isset($_GET['accion']) and $_GET['accion'] == 'eliminar')
			{!!Form::model($opcion,['route'=>['opcion.destroy',$opcion->idOpcion],'method'=>'DELETE', 'files' => true])!!}
		@else
			{!!Form::model($opcion,['route'=>['opcion.update',$opcion->idOpcion],'method'=>'PUT', 'files' => true])!!}
		@endif
	@else
		{!!Form::open(['route'=>'opcion.store','method'=>'POST', 'files' => true])!!}
	@endif


<div id='form-section' >

	<div class="container">
		<div class="navbar-header pull-left">
	  	<a class="navbar-brand"  >Opcions del Men&uacute;</a>
	</div>
	</div>

  <div class="form-container">
	<fieldset id="opcion-form-fieldset">	
		<div class="form-group" id='test'>
          {!! Form::label('ordenOpcion', 'Orden', array('class' => 'col-sm-2 control-label')) !!}
          <div class="col-sm-10">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="fa fa-barcode"></i>
              </span>
              {!!Form::text('ordenOpcion',null,['class'=>'form-control','placeholder'=>'Ingresa el orden del opcion en el menu'])!!}
              {!! Form::hidden('id', null, array('id' => 'id')) !!}
            </div>
          </div>
        </div>


		
		    <div class="form-group" id='test'>
          {!! Form::label('nombreOpcion', 'Nombre', array('class' => 'col-sm-2 control-label')) !!}
          <div class="col-sm-10">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="fa fa-pencil-square-o "></i>
              </span>
      				{!!Form::text('nombreOpcion',null,['class'=>'form-control','placeholder'=>'Ingresa el nombre del opcion'])!!}
            </div>
          </div>
        </div>


        <div class="form-group" id='test'>
          {!! Form::label('rutaOpcion', 'Ruta', array('class' => 'col-sm-2 control-label')) !!}
          <div class="col-sm-10">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="fa fa-code"></i>
              </span>
              {!!Form::text('rutaOpcion',null,['class'=>'form-control','placeholder'=>'Ingresa la ruta de acceso'])!!}
            </div>
          </div>
        </div>

        <div class="form-group" id='test'>
            {!!Form::label('Paquete_idPaquete', 'Paquete', array('class' => 'col-sm-2 control-label'))!!}
            <div class="col-sm-10">
                    <div class="input-group">
                        <span class="input-group-addon">
                          <i class="fa fa-bars"></i>
                        </span>
                {!!Form::select('Paquete_idPaquete',$paquete, (isset($opcion) ? $opcion->Paquete_idPaquete : 0),["class" => "chosen-select form-control", "placeholder" =>"Seleccione el Paquete"])!!}
              </div>
            </div>
          </div>

        <div class="form-group" id='test'>
          {!! Form::label('iconoOpcion', 'Icono', array('class' => 'col-sm-2 control-label')) !!}
          <div class="col-sm-10">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="fa fa-file-image-o "></i>
              </span>
              {!!Form::file('iconoOpcion')!!}

              @if(isset($opcion->iconoOpcion))
                {!!Html::image('images/'. $opcion->iconoOpcion) !!}
              @endif
            </div>
          </div>
        </div>


    </fieldset>
	@if(isset($opcion))
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