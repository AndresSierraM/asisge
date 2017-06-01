@extends('layouts.grid')
@section('titulo')<h3 id="titulo"><center>Orden de Compra</center></h3>@stop

@section('content')
@include('alerts.request')
{!!Html::script('js/ordencompra.js'); !!}
	@if(isset($ordencompra))
		@if(isset($_GET['accion']) and $_GET['accion'] == 'eliminar')
			{!!Form::model($ordencompra,['route'=>['ordencompra.destroy',$ordencompra->idOrdenCompra],'method'=>'DELETE'])!!}
		@else
			{!!Form::model($ordencompra,['route'=>['ordencompra.update',$ordencompra->idOrdenCompra],'method'=>'PUT'])!!}
		@endif
	@else
		{!!Form::open(['route'=>'ordencompra.store','method'=>'POST'])!!}
	@endif


<script type="text/javascript">
  var ordenCompraProductoServicio = '<?php echo (isset($ordenCompraProducto) ? json_encode($ordenCompraProducto) : "");?>';
  ordenCompraProductoServicio = (ordenCompraProductoServicio != '' ? JSON.parse(ordenCompraProductoServicio) : '');

  calcultarValorCantidad = ['onchange','calcularValorTotal(this.id, "cantidad")'];
  calcultarValorUnitario = ['onchange','calcularValorTotal(this.id, "unitario")'];

  valorOrdenCompra = ['','','',1,1,1,''];

  $(document).ready(function(){

      producto = new Atributos('producto','contenedor_permisos','permisos_');

      producto.altura = '35px';
      producto.campoid = 'idOrdenCompraProducto';
      producto.campoEliminacion = 'eliminarOrdenCompraProducto';

      producto.campos   = ['FichaTecnica_idFichaTecnica','referenciaOrdenCompraProducto','descripcionOrdenCompraProducto','cantidadOrdenCompraProducto','valorUnitarioOrdenCompraProducto','valorTotalOrdenCompraProducto', 'MovimientoCRM_idMovimientoCRM', 'idOrdenCompraProducto'];
      producto.etiqueta = ['input','input','input','input','input','input', 'input', 'input'];
      producto.tipo     = ['hidden','text','text','text','text','text', 'hidden', 'hidden'];
      producto.estilo   = ['','width: 200px;height:35px;','width: 400px; height:35px;','width: 100px; height:35px;','width: 150px; height:35px;','width: 150px; height:35px;', '', ''];
      producto.clase = ['','','','','','','','']; 
      producto.sololectura = [false,true,true,false,false,true, false, false]; 
      producto.completar = ['off','off','off','off','off','off', 'off', 'off']; 
      producto.opciones = ['','','','','','','', '']; 
      producto.funciones  = ['','','',calcultarValorCantidad,calcultarValorUnitario,'','', ''];

    for(var j=0, k = ordenCompraProductoServicio.length; j < k; j++)
    {
      producto.agregarCampos(JSON.stringify(ordenCompraProductoServicio[j]),'L');
      calcularValorTotal(j, ''); 
    }
  });
</script>


<div id='form-section' >

	<fieldset id="ordencompra-form-fieldset">	
    <input type="hidden" id="token" value="{{csrf_token()}}"/>
		<div class="form-group col-md-6" id='test'>
      {!!Form::label('numeroOrdenCompra', 'Número', array('class' => 'col-sm-3 control-label')) !!}
      <div class="col-sm-10">
        <div class="input-group">
          <span class="input-group-addon">
            <i class="fa fa-barcode"></i>
          </span>
          {!!Form::text('numeroOrdenCompra',(isset($ordencompra) ? $ordencompra->numeroOrdenCompra : $numeroOrden),['class'=>'form-control', 'readonly'])!!}
          {!!Form::hidden('idOrdenCompra', null, array('id' => 'idOrdenCompra')) !!}
          {!!Form::hidden('fechaAprobacionOrdenCompra', null, array('id' => 'fechaAprobacionOrdenCompra')) !!}
          {!!Form::hidden('observacionAprobacionOrdenCompra', null, array('id' => 'observacionAprobacionOrdenCompra')) !!}
          {!!Form::hidden('DocumentoCRM_idDocumentoCRM', $_GET['idDocumentoCRM'], array('id' => 'DocumentoCRM_idDocumentoCRM')) !!}
        </div>
      </div>
    </div>

    <div class="form-group col-md-6" id='test'>
      {!!Form::label('requerimientoOrdenCompra', 'Requerimientos', array('class' => 'col-sm-3 control-label')) !!}
      <div class="col-sm-10">
        <div class="input-group">
          <span class="input-group-addon">
            <i class="fa fa-tasks"></i>
          </span>
          {!!Form::text('requerimientoOrdenCompra',null,['class'=>'form-control', 'readonly'])!!}
          <span class="input-group-addon" title="Adicionar requerimientos" style="cursor:pointer;" onclick="abrirModalCRM()">
            <i class="fa fa-file"></i>
          </span>
        </div>
      </div>
    </div>

    <div class="form-group col-md-6" id='test'>
      {!!Form::label('sitioEntregaOrdenCompra', 'Sitio Entrega', array('class' => 'col-sm-3 control-label')) !!}
      <div class="col-sm-10">
        <div class="input-group">
          <span class="input-group-addon">
            <i class="fa fa-bank"></i>
          </span>
          {!!Form::text('sitioEntregaOrdenCompra',null,['class'=>'form-control'])!!}
        </div>
      </div>
    </div>

    <div class="form-group col-md-6" id='test'>
      {!!Form::label('fechaElaboracionOrdenCompra', 'Elaboración', array('class' => 'col-sm-3 control-label')) !!}
      <div class="col-sm-10">
        <div class="input-group">
          <span class="input-group-addon">
            <i class="fa fa-calendar"></i>
          </span>
          {!!Form::text('fechaElaboracionOrdenCompra',null,['class'=>'form-control'])!!}
        </div>
      </div>
    </div>

    <div class="form-group col-md-6" id='test'>
      {!!Form::label('fechaEstimadaOrdenCompra', 'Est. Entrega', array('class' => 'col-sm-3 control-label')) !!}
      <div class="col-sm-10">
        <div class="input-group">
          <span class="input-group-addon">
            <i class="fa fa-calendar"></i>
          </span>
          {!!Form::text('fechaEstimadaOrdenCompra',null,['class'=>'form-control'])!!}
        </div>
      </div>
    </div>

    <div class="form-group col-md-6" id='test'>
      {!!Form::label('fechaVencimientoOrdenCompra', 'Vencimiento', array('class' => 'col-sm-3 control-label')) !!}
      <div class="col-sm-10">
        <div class="input-group">
          <span class="input-group-addon">
            <i class="fa fa-calendar"></i>
          </span>
          {!!Form::text('fechaVencimientoOrdenCompra',null,['class'=>'form-control'])!!}
        </div>
      </div>
    </div>

    <div class="form-group col-md-6" id='test'>
      {!!Form::label('Tercero_idProveedor', 'Proveedor', array('class' => 'col-sm-3 control-label')) !!}
      <div class="col-sm-10">
        <div class="input-group">
          <span class="input-group-addon">
            <i class="fa fa-user"></i>
          </span>
          {!!Form::select('Tercero_idProveedor',$proveedor, @$ordencompra->Tercero_idProveedor,["class" => "chosen-select form-control", "placeholder" => "Seleccione"])!!}
        </div>
      </div>
    </div>

    <div class="form-group col-md-6" id='test'>
      {!!Form::label('Tercero_idSolicitante', 'Solicitante', array('class' => 'col-sm-3 control-label')) !!}
      <div class="col-sm-10">
        <div class="input-group">
          <span class="input-group-addon">
            <i class="fa fa-user"></i>
          </span>
          {!!Form::text('nombreSolicitanteOrdenCompra',(isset($solicitante) ? $solicitante['nombreSolicitante'] : \Session::get('nombreUsuario')),['class'=>'form-control', 'readonly'])!!}
          {!!Form::hidden('Tercero_idSolicitante', (isset($solicitante) ? $solicitante['idTercero'] : \Session::get('idTercero')), array('id' => 'Tercero_idSolicitante')) !!}
        </div>
      </div>
    </div>

    <div class="form-group col-md-6" id='test'>
      {!!Form::label('Tercero_idAutorizador', 'Autorizador', array('class' => 'col-sm-3 control-label')) !!}
      <div class="col-sm-10">
        <div class="input-group">
          <span class="input-group-addon">
            <i class="fa fa-user"></i>
          </span>
          {!!Form::text('Tercero_idAutorizador',null,['class'=>'form-control', 'readonly'])!!}
        </div>
      </div>
    </div>

    <div class="form-group col-md-6" id='test'>
      {!!Form::label('estadoOrdenCompra', 'Estado', array('class' => 'col-sm-3 control-label')) !!}
      <div class="col-sm-10">
        <div class="input-group">
          <span class="input-group-addon">
            <i class="fa fa-user"></i>
          </span>
          {!!Form::text('estadoOrdenCompra',(isset($ordencompra) ? $ordencompra->estadoOrdenCompra : 'En Proceso'),['class'=>'form-control', 'readonly'])!!}
        </div>
      </div>
    </div>

    <br><br><br><br><br>

        <div class="form-group">
          <div class="col-lg-12">
            <div class="panel panel-primary">
              <div class="panel-heading">Ordenes</div>
              <div class="panel-body">
                <div class="form-group" id='test'>
                  <div class="col-sm-12">
                    <div class="row show-grid">
                      <div class="col-md-1" style="width: 40px;height: 35px; cursor: pointer;" onclick="abrirModalFichaTecnica();">
                        <span class="glyphicon glyphicon-plus"></span>
                      </div>
                      <div class="col-md-1" style="width: 200px;display:inline-block;height:35px;">Referencia</div>
                      <div class="col-md-1" style="width: 400px;display:inline-block;height:35px;">Descripción</div>
                      <div class="col-md-1" style="width: 100px;display:inline-block;height:35px;">Cantidad</div>
                      <div class="col-md-1" style="width: 150px;display:inline-block;height:35px;">Valor Unitario</div>
                      <div class="col-md-1" style="width: 150px;display:inline-block;height:35px;">Valor Total</div>
                        
                      <div id="contenedor_permisos">
                      </div>
                    </div>
                  </div>
                </div>  

                <div class="form-group col-md-12" id='test' style="display:inline-block">
                  {!!Form::label('totalProducto', 'Valor Total Productos: ', array('class' => 'col-sm-2 control-label')) !!}
                  <div class="col-md-8">
                    <div class="input-group">
                      <span class="input-group-addon">
                        <i class="fa fa-dollar"></i>
                      </span>
                      {!!Form::text('totalProducto',null,['class'=>'form-control','readonly', 'placeholder'=>''])!!}
                    </div>
                  </div>
                </div>
                {!!Form::hidden('eliminarOrdenCompraProducto', null, array('id' => 'eliminarOrdenCompraProducto'))!!}
              </div>
            </div>
          </div>
        </div>

        <div class="form-group col-md-12" id='test'>
          {!!Form::label('observacionOrdenCompra', 'Observaciones', array('class' => 'col-sm-3 control-label')) !!}
          <div class="col-sm-12">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="fa fa-pencil-square-o "></i>
              </span>
              {!!Form::textarea('observacionOrdenCompra',null,['class'=>'form-control ckeditor','style'=>'height:100px'])!!}
            </div>
          </div>
        </div>

    </fieldset>
	@if(isset($ordencompra))
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
<script>
  CKEDITOR.replace(('observacionOrdenCompra'), {
      fullPage: true,
      allowedContent: true
    });  

  $(document).ready( function () {

    $("#fechaElaboracionOrdenCompra, #fechaEstimadaOrdenCompra, #fechaVencimientoOrdenCompra").datetimepicker(
      ({
        format: "YYYY-MM-DD"
      })
    );
});
</script>
@stop
<div id="modalFichaTecnica" class="modal fade" role="dialog">
  <div class="modal-dialog" style="width:80%;">
    <div style="" class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Ficha técnica</h4>
      </div>
      <div class="modal-body">
        <div class="container">
            <div class="row" style="width:90%;">
                <div class="container" style="width:100%;">
                    <table id="tfichatecnica" name="tfichatecnica" class="display table-bordered" width="100%">
                        <thead>
                            <tr class="btn-default active">
                                <th><b>Referencia</b></th>
                                <th><b>Descripción</b></th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr class="btn-default active">
                                <th>Referencia</th>
                                <th>Descripción</th>
                            </tr>
                        </tfoot>
                    </table>
                    <div class="modal-footer">
                        <button id="botonFichaTecnica" name="botonFichaTecnica" type="button" class="btn btn-primary" >Seleccionar</button>
                    </div>
                </div>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div id="modalMovimientoCRM" class="modal fade" role="dialog">
  <div class="modal-dialog" style="width:80%;">
    <div style="" class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Ficha técnica</h4>
      </div>
      <div class="modal-body">
        <div class="container">
            <div class="row" style="width:90%;">
                <div class="container" style="width:100%;">
                    <table id="tmovimientocrm" name="tmovimientocrm" class="display table-bordered" width="100%">
                        <thead>
                            <tr class="btn-default active">
                                <th><b>ID</b></th>
                                <th><b>Descripción</b></th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr class="btn-default active">
                                <th>ID</th>
                                <th>Descripción</th>
                            </tr>
                        </tfoot>
                    </table>
                    <div class="modal-footer">
                        <button id="botonMovimientoCRM" name="botonMovimientoCRM" type="button" class="btn btn-primary" >Seleccionar</button>
                    </div>
                </div>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>