@extends('layouts.grid')

@section('titulo')<h3 id="titulo"><center>Orden de Trabajo</center></h3>@stop

@section('content')
@include('alerts.request')


{!!Html::script('js/ordentrabajo.js')!!}


	@if(isset($ordentrabajo))
		@if(isset($_GET['accion']) and $_GET['accion'] == 'eliminar')
			{!!Form::model($ordentrabajo,['route'=>['ordentrabajo.destroy',$ordentrabajo->idOrdenTrabajo],'method'=>'DELETE'])!!}
		@else
			{!!Form::model($ordentrabajo,['route'=>['ordentrabajo.update',$ordentrabajo->idOrdenTrabajo],'method'=>'PUT'])!!}
		@endif
	@else
		{!!Form::open(['route'=>'ordentrabajo.store','method'=>'POST'])!!}
	@endif

<?php 
  $fechahora = Carbon\Carbon::now();
?>



<div id='form-section' >
	<fieldset id="ordentrabajo-form-fieldset">	
    

    <div class="col-sm-6">
      <div class="col-sm-4">
        {!!Form::label('numeroOrdenTrabajo', 'Número O.T.', array())!!}
      </div>
      <div class="col-sm-8">
          <div class="input-group">
            <span class="input-group-addon">
              <i class="fa fa-pencil-square-o"></i>
            </span>
            {!!Form::text('numeroOrdenTrabajo',(isset($ordentrabajo) ? null : 'Automático'),['class'=>'form-control', "placeholder" => "Número Orden Trabajo", "readOnly"=>"readOnly"])!!}
            {!!Form::hidden('idOrdenTrabajo',null,['id'=>'idOrdenTrabajo'])!!}
            <input type="hidden" id="token" value="{{csrf_token()}}"/>
          </div>
      </div>
    </div>  

    <div class="col-sm-6">
      <div class="col-sm-4">
        {!!Form::label('fechaElaboracionOrdenTrabajo', 'Fecha Elaboración', array())!!}
      </div>
      <div class="col-sm-8">
          <div class="input-group">
            <span class="input-group-addon">
              <i class="fa fa-pencil-square-o"></i>
            </span>
            {!!Form::text('fechaElaboracionOrdenTrabajo',(isset($ordentrabajo) ? $ordentrabajo->fechaElaboracionOrdenTrabajo : $fechahora),['readonly'=>'readonly', 'class'=>'form-control'])!!}
          </div>
      </div>
    </div>  

     <div class="col-sm-6">
      <div class="col-sm-4">
        {!!Form::label('OrdenProduccion_idOrdenProduccion', 'Número O.P.', array())!!}
      </div>
      <div class="col-sm-8">
        <div class="input-group">
          <span class="input-group-addon">
            <i class="fa fa-pencil-square-o"></i>
          </span>
          {!!Form::select('OrdenProduccion_idOrdenProduccion',$ordenproduccion, @$ordentrabajo->OrdenProduccion_idOrdenProduccion,["onchange" => "cargarOrdenProduccionPendiente();", "class" => "chosen-select form-control", "placeholder" => "Seleccione la Orden de Producción"])!!}
        </div>
      </div>
    </div> 


    <div class="col-sm-6">
      <div class="col-sm-4">
        {!!Form::label('nombreCompletoTercero', 'Cliente', array())!!}
      </div>
      <div class="col-sm-8">
        <div class="input-group">
          <span class="input-group-addon">
            <i class="fa fa-pencil-square-o"></i>
          </span>
            {!!Form::text('nombreCompletoTercero',(isset($ordentrabajo) ? $ordentrabajo->nombreCompletoTercero : ''),['readonly'=>'readonly', 'class'=>'form-control'])!!}
        </div>
      </div>
    </div>  

    <div class="col-sm-6">
      <div class="col-sm-4">
        {!!Form::label('numeroPedidoOrdenTrabajo', 'Orden Compra No.', array())!!}
      </div>
      <div class="col-sm-8">
          <div class="input-group">
            <span class="input-group-addon">
              <i class="fa fa-pencil-square-o"></i>
            </span>
            {!!Form::text('numeroPedidoOrdenTrabajo',null,['readonly'=>'readonly', 'class'=>'form-control'])!!}
          </div>
      </div>
    </div>  

    <div class="col-sm-6">
      <div class="col-sm-4">
        {!!Form::label('referenciaFichaTecnica', 'Referencia', array())!!}
      </div>
      <div class="col-sm-8">
          <div class="input-group">
            <span class="input-group-addon">
              <i class="fa fa-pencil-square-o"></i>
            </span>
            {!!Form::text('referenciaFichaTecnica',null,['readonly'=>'readonly', 'class'=>'form-control'])!!}
          </div>
      </div>
    </div>  

    <div class="col-sm-6">
      <div class="col-sm-4">
        {!!Form::label('nombreFichaTecnica', 'Descripción', array())!!}
      </div>
      <div class="col-sm-8">
          <div class="input-group">
            <span class="input-group-addon">
              <i class="fa fa-pencil-square-o"></i>
            </span>
            {!!Form::text('nombreFichaTecnica',null,['readonly'=>'readonly', 'class'=>'form-control'])!!}
          </div>
      </div>
    </div>  
    
    <div class="col-sm-6">
      <div class="col-sm-4">
        {!!Form::label('especificacionOrdenTrabajo', 'Especificación', array())!!}
      </div>
      <div class="col-sm-8">
          <div class="input-group">
            <span class="input-group-addon">
              <i class="fa fa-pencil-square-o"></i>
            </span>
            {!!Form::text('especificacionOrdenTrabajo',null,['readonly'=>'readonly', 'class'=>'form-control'])!!}
          </div>
      </div>
    </div>  

    <div class="col-sm-6">
      <div class="col-sm-4">
        {!!Form::label('estadoOrdenTrabajo', 'Estado', array())!!}
      </div>
      <div class="col-sm-8">
          <div class="input-group">
            <span class="input-group-addon">
              <i class="fa fa-pencil-square-o"></i>
            </span>
            {!!Form::text('especificacionOrdenTrabajo', @$ordentrabajo->estadoOrdenTrabajo,['readonly'=>'readonly', 'class'=>'form-control'])!!}
          </div>
      </div>
    </div> 

     <div class="col-sm-6">
      <div class="col-sm-4">
        {!!Form::label('cantidadOrdenTrabajo', 'Cantidad', array())!!}
      </div>
      <div class="col-sm-8">
          <div class="input-group">
            <span class="input-group-addon">
              <i class="fa fa-pencil-square-o"></i>
            </span>
            {!!Form::hidden('cantidadPendiente',null,['id'=>'cantidadPendiente'])!!}
            {!!Form::text('cantidadOrdenTrabajo',null,['class'=>'form-control', "placeholder" => "Cantidad a producir"])!!}
          </div>
      </div>
    </div> 
  </fieldset>

    <br>
	@if(isset($ordentrabajo))
 		@if(isset($_GET['accion']) and $_GET['accion'] == 'eliminar')
   			{!!Form::submit('Eliminar',["class"=>"btn btn-primary"])!!}
  		@else
   			{!!Form::submit('Modificar',["class"=>"btn btn-primary", "onclick"=>'validarFormulario(event);'])!!}
  		@endif
 	@else
  		{!!Form::submit('Adicionar',["class"=>"btn btn-primary", "onclick"=>'validarFormulario(event);'])!!}
 	@endif
	{!! Form::close() !!}
</div>

@stop