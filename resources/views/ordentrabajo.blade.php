@extends('layouts.grid')

@section('titulo')<h3 id="titulo"><center>Orden de Trabajo</center></h3>@stop

@section('content')
@include('alerts.request')


<script type="">
  var idTipoCalidad = '<?php echo isset($idTipoCalidad) ? $idTipoCalidad : "";?>';
  var nombreTipoCalidad = '<?php echo isset($nombreTipoCalidad) ? $nombreTipoCalidad : "";?>';
  var tipocalidad = [JSON.parse(idTipoCalidad),JSON.parse(nombreTipoCalidad)];

  var detalles = '<?php echo (isset($detalle) ? json_encode($detalle) : "");?>';
  detalles = (detalles != '' ? JSON.parse(detalles) : '');

  var operaciones = '<?php echo (isset($operacion) ? json_encode($operacion) : "");?>';
  operaciones = (operaciones != '' ? JSON.parse(operaciones) : '');

  var idProceso = "<?php echo (isset($ordentrabajo->Proceso_idProceso) ? $ordentrabajo->Proceso_idProceso : 0);?>";
  valorDetalle = Array(0, 0, '', 0);
</script>

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
            {!!Form::hidden('eliminarDetalle',null,['id'=>'eliminarDetalle'])!!}
            
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
          {!!Form::select('OrdenProduccion_idOrdenProduccion',$ordenproduccion, @$ordentrabajo->OrdenProduccion_idOrdenProduccion,["onchange" => "cargarDatosOrdenProduccion('".@$ordentrabajo->Proceso_idProceso."');", "class" => "chosen-select form-control", "placeholder" => "Seleccione la Orden de Producción"])!!}
        </div>
      </div>
    </div> 

    <div class="col-sm-6">
      <div class="col-sm-4">
        {!!Form::label('Proceso_idProceso', 'Proceso', array())!!}
      </div>
      <div class="col-sm-8">
        <div class="input-group">
          <span class="input-group-addon">
            <i class="fa fa-pencil-square-o"></i>
          </span>
          {!!Form::select('Proceso_idProceso',$proceso, @$ordentrabajo->Proceso_idProceso,["onchange" => "cargarOrdenTrabajoPendiente(); cargarOrdenTrabajoOperaciones();", "class" => "form-control", "placeholder" => "Seleccione el Proceso"])!!}
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
            {!!Form::text('estadoOrdenTrabajo', @$ordentrabajo->estadoOrdenTrabajo,['readonly'=>'readonly', 'class'=>'form-control'])!!}
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

  <ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#detalle">Cantidades</a></li>
    <li><a data-toggle="tab" href="#operacion">Operaciones</a></li>
  </ul>

  <div class="tab-content">

    <div id="detalle" class="tab-pane fade in active">
      <div class="form-group" id='test'>
          <div class="col-sm-12">
              <div class="row show-grid" style=" border: 1px solid #C0C0C0;">
                  <div style="overflow:auto; height:350px;">
                      <div style="width: 100%; display: inline-block;">
                          <div class="col-md-1" style="width: 40px;height: 42px; cursor:pointer;" onclick="detalle.agregarCampos(valorDetalle,'A');">
                            <span class="glyphicon glyphicon-plus"></span>
                          </div>
                          <div class="col-md-1" style="width: 400px;" >Tipo de Calidad</div>
                          <div class="col-md-1" style="width: 150px;" >Cantidad</div>
                          <div id="contenedor_detalle">
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
    </div>

    <div id="operacion" class="tab-pane fade">
      <div class="form-group" id='test'>
          <div class="col-sm-12">
              <div class="row show-grid" style=" border: 1px solid #C0C0C0;">
                  <div style="overflow:auto; height:350px;">
                      <div style="width: 100%; display: inline-block;">
                          <div class="col-md-1" style="width: 150px;" >Referencia</div>
                          <div class="col-md-1" style="width: 350px;" >Material</div>
                          <div class="col-md-1" style="width: 200px;" >Consumo Unitario</div>
                          <div class="col-md-1" style="width: 200px;" >Consumo Total</div>
                          <div id="contenedor_material">
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
    </div>

    
  </div>

    <br>
	@if(isset($ordentrabajo))
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

@stop