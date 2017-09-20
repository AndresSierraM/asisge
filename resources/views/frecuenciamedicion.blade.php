@extends('layouts.vista')
@section('titulo')<h3 id="titulo"><center>Frecuencias de <br>Medici&oacute;n</center></h3>@stop

@section('content')
@include('alerts.request')

	@if(isset($frecuenciamedicion))
		@if(isset($_GET['accion']) and $_GET['accion'] == 'eliminar')
			{!!Form::model($frecuenciamedicion,['route'=>['frecuenciamedicion.destroy',$frecuenciamedicion->idFrecuenciaMedicion],'method'=>'DELETE'])!!}
		@else
			{!!Form::model($frecuenciamedicion,['route'=>['frecuenciamedicion.update',$frecuenciamedicion->idFrecuenciaMedicion],'method'=>'PUT'])!!}
		@endif
	@else
		{!!Form::open(['route'=>'frecuenciamedicion.store','method'=>'POST'])!!}
	@endif


<div id='form-section' >

	
	<fieldset id="frecuenciamedicion-form-fieldset">	
		<div class="form-group required" id='test'>
          {!! Form::label('codigoFrecuenciaMedicion', 'C&oacute;digo', array('class' => 'col-sm-2 control-label')) !!}
          <div class="col-sm-10">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="fa fa-barcode"></i>
              </span>
              {!!Form::text('codigoFrecuenciaMedicion',null,['class'=>'form-control','placeholder'=>'Ingresa el código de la frecuencia'])!!}
              {!! Form::hidden('idFrecuenciaMedicion', null, array('id' => 'idFrecuenciaMedicion')) !!}
            </div>
          </div>
        </div>


		
		  <div class="form-group required" id='test'>
        {!! Form::label('nombreFrecuenciaMedicion', 'Nombre', array('class' => 'col-sm-2 control-label')) !!}
        <div class="col-sm-10">
          <div class="input-group">
            <span class="input-group-addon">
              <i class="fa fa-pencil-square-o "></i>
            </span>
      			{!!Form::text('nombreFrecuenciaMedicion',null,['class'=>'form-control','placeholder'=>'Ingresa el nombre de la frecuencia'])!!}
          </div>
        </div>
      </div>

      <div class="form-group required" id='test'>
        {!! Form::label('valorFrecuenciaMedicion', 'Medir cada ', array('class' => 'col-sm-2 control-label')) !!}
        <div class="col-sm-10">
          <div class="input-group">
            <span class="input-group-addon">
              <i class="fa fa-calendar-o "></i>
            </span>
            {!!Form::text('valorFrecuenciaMedicion',null,['class'=>'form-control','placeholder'=>'Ingresa el valor de la frecuencia'])!!}
            {!!Form::select('unidadFrecuenciaMedicion', 
            [
             'Dias' => 'Dias',
             'Semanas' => 'Semanas',
             'Meses' => 'Meses',
             'Años' => 'Años',
             'Proyecto' => 'Proyecto'
             ], @(isset($frecuenciamedicion->unidadFrecuenciaMedicion) ?
                  $frecuenciamedicion->unidadFrecuenciaMedicion
                :
                  0
                ), ['class'=>'form-control']) !!}
          </div>
        </div>

    </fieldset>
	@if(isset($frecuenciamedicion))
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