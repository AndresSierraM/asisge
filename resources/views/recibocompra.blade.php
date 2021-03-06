@extends('layouts.grid')
@section('titulo')<h3 id="titulo"><center>Recibo de Compra</center></h3>@stop

@section('content')
 <style>
          /*Se quema la clase, ya que se esta utilizando el layout grid para que salga el mensaje los campos que tienen * ----*/
  .requiredAlert
          {
            display: block;
          }
  </style>
@include('alerts.request')
{!!Html::script('js/recibocompra.js'); !!}
	@if(isset($recibocompra))
		@if(isset($_GET['accion']) and $_GET['accion'] == 'eliminar')
			{!!Form::model($recibocompra,['route'=>['recibocompra.destroy',$recibocompra->idReciboCompra],'method'=>'DELETE'])!!}
		@else
			{!!Form::model($recibocompra,['route'=>['recibocompra.update',$recibocompra->idReciboCompra],'method'=>'PUT'])!!}
		@endif
	@else
		{!!Form::open(['route'=>'recibocompra.store','method'=>'POST'])!!}
	@endif


<script type="text/javascript">

  var idTipoCalidad = '<?php echo isset($idTipoCalidad) ? $idTipoCalidad : "";?>';
  var nombreTipoCalidad = '<?php echo isset($nombreTipoCalidad) ? $nombreTipoCalidad : "";?>';
  var tipocalidad = [JSON.parse(idTipoCalidad), JSON.parse(nombreTipoCalidad)];

  var recibocompra = '<?php echo (isset($reciboCompraProducto) ? json_encode($reciboCompraProducto) : "");?>';
  recibocompra = (recibocompra != '' ? JSON.parse(recibocompra) : '');

  var resultadocompra = '<?php echo (isset($resultadoCompra) ? json_encode($resultadoCompra) : "");?>';
  resultadocompra = (resultadocompra != '' ? JSON.parse(resultadocompra) : '');

  calcultarValorCantidad = ['onchange','calcularValorTotal(this.id, "cantidad"); calcularTotalRecibo();'];
  calcultarValorUnitario = ['onchange','calcularValorTotal(this.id, "unitario"); calcularTotalRecibo();'];
  consultarNoConforme = ['onchange','consultarNoConformeTipoCalidad(this.id, this.value);'];

  valorReciboCompra = ['','','',1,1,1,''];

  $(document).ready(function(){

      producto = new Atributos('producto','contenedor_recibo','recibos_');

      producto.altura = '35px';
      producto.campoid = 'idReciboCompraProducto';
      producto.campoEliminacion = 'eliminarReciboCompraProducto';

      producto.campos   = [
      'FichaTecnica_idFichaTecnica',
      'referenciaReciboCompraProducto',
      'descripcionReciboCompraProducto',
      'cantidadOrdenCompraProducto',
      'cantidadReciboCompraProducto',
      'TipoCalidad_idTipoCalidad',
      'productoConformeTipoCalidad',
      'valorUnitarioOrdenCompraProducto',
      'valorUnitarioReciboCompraProducto',
      'valorTotalReciboCompraProducto',
      'idReciboCompraProducto'];

      producto.etiqueta = [
      'input',
      'input',
      'input',
      'input',
      'input',
      'select',
      'input',
      'input',
      'input',
      'input',
      'input'];

      producto.tipo     = [
      'hidden',
      'text',
      'text',
      'text',
      'text',
      '',
      'hidden',
      'text',
      'text',
      'text',
      'hidden'];
      
      producto.estilo   = [
      '',
      'width: 100px;height:35px;',
      'width: 300px; height:35px;',
      'width: 100px;height:35px;',
      'width: 100px;height:35px;',
      'width: 100px;height:35px;',
      '',
      'width: 100px;height:35px;',
      'width: 100px;height:35px;',
      'width: 100px;height:35px;',
      ''];

      producto.clase = ['','','','','','','','','','','']; 
      producto.sololectura = [true,true,true,true,false,false,true,true,false,true,true]; 
      producto.completar = ['off','off','off','off','off','off', 'off', 'off', 'off', 'off', 'off']; 
      producto.opciones = ['','','','','',tipocalidad,'','', '', '', '']; 
      producto.funciones  = ['','','','',calcultarValorCantidad,consultarNoConforme,'','', calcultarValorUnitario, '', ''];

    for(var j=0, k = recibocompra.length; j < k; j++)
    {
      producto.agregarCampos(JSON.stringify(recibocompra[j]),'L');
      calcularValorTotal(j, ''); 
      consultarNoConformeTipoCalidad('TipoCalidad_idTipoCalidad'+j,recibocompra[j]['TipoCalidad_idTipoCalidad']);
    }

    ////////////////////////////
    //R E S U L T A D O
    ///////////////////////////

      resultado = new Atributos('resultado','contenedor_resultado','resultados_');

      resultado.altura = '35px';
      resultado.campoid = 'idReciboCompraResultado';
      resultado.campoEliminacion = 'eliminarReciboCompraResultado';
      resultado.botonEliminacion = false;

      resultado.campos   = [
      'descripcionReciboCompraResultado',
      'valorCompraReciboCompraResultado',
      'valorReciboReciboCompraResultado',
      'diferenciaReciboCompraResultado',
      'porcentajeReciboCompraResultado',
      'pesoReciboCompraResultado',
      'resultadoReciboCompraResultado',
      'idReciboCompraResultado',
      'ReciboCompra_idReciboCompra'];

      resultado.etiqueta = [
      'input',
      'input',
      'input',
      'input',
      'input',
      'input',
      'input',
      'input',
      'input'];

      resultado.tipo     = [
      'text',
      'text',
      'text',
      'text',
      'text',
      'text',
      'text',
      'hidden',
      'hidden'];
      
      resultado.estilo   = [
      'width: 200px;height:35px;',
      'width: 200px;height:35px;',
      'width: 200px; height:35px;',
      'width: 100px;height:35px;',
      'width: 100px;height:35px;',
      'width: 100px;height:35px;',
      'width: 100px;height:35px;',
      '',
      ''
      ];

      resultado.clase = ['','','','','','','','','']; 
      resultado.sololectura = [true,true,true,true,false,false,true,false,true]; 
      resultado.completar = ['off','off','off','off','off','off', 'off', 'off', 'off']; 
      resultado.opciones = ['','','','','',tipocalidad,'', '', '']; 
      resultado.funciones  = ['','','','',calcultarValorCantidad,'','', calcultarValorUnitario, ''];

    for(var j=0, k = resultadocompra.length; j < k; j++)
    {
      resultado.agregarCampos(JSON.stringify(resultadocompra[j]),'L');
      calcularValorTotal(j, ''); 
      calcularTotales();

    }
  });
</script>


<div id='form-section' >

	<fieldset id="recibocompra-form-fieldset">	
    <input type="hidden" id="token" value="{{csrf_token()}}"/>
		<div class="form-group col-md-6" id='test'>
      {!!Form::label('numeroReciboCompra', 'Número', array('class' => 'col-sm-3 control-label')) !!}
      <div class="col-sm-10">
        <div class="input-group">
          <span class="input-group-addon">
            <i class="fa fa-barcode"></i>
          </span>
          {!!Form::text('numeroReciboCompra',(isset($recibocompra) ? $recibocompra->numeroReciboCompra : $numeroRecibo),['class'=>'form-control', 'readonly'])!!}
          {!!Form::hidden('idReciboCompra', null, array('id' => 'idReciboCompra')) !!}
        </div>
      </div>
    </div>

    <div class="form-group col-md-6" id='test'>
      {!!Form::label('OrdenCompra_idOrdenCompra', 'Orden de compra', array('class' => 'col-sm-4 control-label')) !!}
      <div class="col-sm-10">
        <div class="input-group">
          <span class="input-group-addon">
            <i class="fa fa-tasks"></i>
          </span>
          {!!Form::text('numeroOrdenCompra',(isset($ordencompra) ? $ordencompra['numeroOrdenCompra'] : null),['class'=>'form-control', 'readonly', 'id' => 'numeroOrdenCompra'])!!}
          {!!Form::hidden('OrdenCompra_idOrdenCompra', null, array('id' => 'OrdenCompra_idOrdenCompra')) !!}
          <span class="input-group-addon" title="Adicionar orden de compra" style="cursor:pointer;" onclick="abrirModalOrdenCompra()">
            <i class="fa fa-file"></i>
          </span>
        </div>
      </div>
    </div>

    <div class="form-group col-md-6" id='test'>
      {!!Form::label('fechaElaboracionReciboCompra', 'Elaboración', array('class' => 'col-sm-3 control-label')) !!}
      <div class="col-sm-10">
        <div class="input-group">
          <span class="input-group-addon">
            <i class="fa fa-calendar"></i>
          </span>
          {!!Form::text('fechaElaboracionReciboCompra',(isset($recibocompra) ? $recibocompra->fechaElaboracionReciboCompra : date('Y-m-d')),['class'=>'form-control', 'readonly'])!!}
        </div>
      </div>
    </div>

    <div class="form-group col-md-6 " id='test'>
      {!!Form::label('fechaEstimadaReciboCompra', 'Est. Entrega', array('class' => 'col-sm-3 control-label')) !!}
      <div class="col-sm-10">
        <div class="input-group">
          <span class="input-group-addon">
            <i class="fa fa-calendar"></i>
          </span>
          {!!Form::text('fechaEstimadaReciboCompra',(isset($ordencompra) ? $ordencompra['fechaEstimadaReciboCompra'] : null),['class'=>'form-control', 'readonly'])!!}
        </div>
      </div>
    </div>

    <div class="form-group col-md-6 required"   id='test' >
      {!!Form::label('fechaRealReciboCompra', 'Entrega', array('class' => 'col-sm-3 control-label')) !!}
      <div class="col-sm-10">
        <div class="input-group">
          <span class="input-group-addon">
            <i class="fa fa-calendar"></i>
          </span>
          {!!Form::text('fechaRealReciboCompra',null,['class'=>'form-control'])!!}
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
          {!!Form::text('nombreProveedor',(isset($ordencompra) ? $ordencompra['nombreProveedor'] : null),['class'=>'form-control', 'readonly', 'id' => 'nombreProveedor'])!!}
          {!!Form::hidden('Tercero_idProveedor', (isset($ordencompra) ? $ordencompra['Tercero_idProveedor'] : null), array('id' => 'Tercero_idProveedor')) !!}
        </div>
      </div>
    </div>
    <br><br><br><br><br><br><br><br><br><br><br><br>
    <div class="form-group col-md-6" id='test'>
      {!!Form::label('Users_idCrea', 'Solicitante', array('class' => 'col-sm-3 control-label')) !!}
      <div class="col-sm-10">
        <div class="input-group">
          <span class="input-group-addon">
            <i class="fa fa-user"></i>
          </span>
          {!!Form::text('nombreElaborador',(isset($elaborador) ? $creador['nombreElaborador'] : \Session::get('nombreUsuario')),['class'=>'form-control', 'readonly'])!!}
          {!!Form::hidden('Users_idCrea', (isset($creador) ? $creador['idUsuario'] : \Session::get('idUsuario')), array('id' => 'Users_idCrea')) !!}
        </div>
      </div>
    </div>

    <div class="form-group col-md-6" id='test'>
      {!!Form::label('estadoReciboCompra', 'Estado', array('class' => 'col-sm-3 control-label')) !!}
      <div class="col-sm-10">
        <div class="input-group">
          <span class="input-group-addon">
            <i class="fa fa-bars"></i>
          </span>
          {!!Form::text('estadoReciboCompra',(isset($recibocompra) ? $recibocompra->estadoReciboCompra : 'Activo'),['class'=>'form-control', 'readonly'])!!}
        </div>
      </div>
    </div>

    <br><br><br><br><br>

        <div class="form-group">
          <div class="col-lg-12">
            <div class="panel panel-primary">
              <div class="panel-heading">Recibos</div>
              <div class="panel-body">
                <div class="form-group" id='test'>
                  <div class="col-sm-12">
                    <div class="row show-grid">
                      <div class="col-md-1" style="width: 40px;height: 50px;">
                      </div>
                      <div class="col-md-1" style="width: 100px;display:inline-block;height:50px;">Referencia</div>
                      <div class="col-md-1" style="width: 300px;display:inline-block;height:50px;">Descripción</div>
                      <div class="col-md-1" style="width: 100px;display:inline-block;height:50px;">Cantidad OC</div>
                      <div class="col-md-1" style="width: 100px;display:inline-block;height:50px;">Cantidad Recibo</div>
                      <div class="col-md-1 requiredMulti" style="width: 100px;display:inline-block;height:50px;">Tipo Calidad</div>
                      <div class="col-md-1" style="width: 100px;display:inline-block;height:50px;">Costo OC</div>
                      <div class="col-md-1" style="width: 100px;display:inline-block;height:50px;">Costo Recibo</div>
                      <div class="col-md-1" style="width: 100px;display:inline-block;height:50px;">Valor Total</div>
                        
                      <div id="contenedor_recibo">
                      </div>
                    </div>
                  </div>
                </div>  

                <div class="form-group col-md-6" id='test' style="display:inline-block">
                  <button class="btn btn-primary" type="button" onclick="calcularTotales()">Calcular</button>
                </div>

                <div class="form-group col-md-6" id='test' style="display:inline-block">
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
                {!!Form::hidden('eliminarReciboCompraProducto', null, array('id' => 'eliminarReciboCompraProducto'))!!}
              </div>
            </div>

            <div class="panel panel-primary">
              <div class="panel-heading">Resultados</div>
              <div class="panel-body">
                <div class="form-group" id='test'>
                  <div class="col-sm-12">
                    <div class="row show-grid">
                      <div class="col-md-1" style="width: 200px;display:inline-block;height:50px;">Resultado del recibo</div>
                      <div class="col-md-1" style="width: 200px;display:inline-block;height:50px;">Orden de Compra</div>
                      <div class="col-md-1" style="width: 200px;display:inline-block;height:50px;">Recibo</div>
                      <div class="col-md-1" style="width: 100px;display:inline-block;height:50px;">Diferencia</div>
                      <div class="col-md-1" style="width: 100px;display:inline-block;height:50px;">Porcentaje</div>
                      <div class="col-md-1" style="width: 100px;display:inline-block;height:50px;">Peso</div>
                      <div class="col-md-1" style="width: 100px;display:inline-block;height:50px;">Resultado</div>

                      <div id="contenedor_resultado">
                      </div>
                    </div>
                  </div>
                </div> 

                <div class="form-group col-md-6" id='test' style="display:inline-block">
                  {!!Form::label('totalResultado', 'Valor Total Resultados: ', array('class' => 'col-sm-2 control-label')) !!}
                  <div class="col-md-8">
                    <div class="input-group">
                      <span class="input-group-addon">
                        <i class="fa fa-dollar"></i>
                      </span>
                      {!!Form::text('totalResultado',null,['class'=>'form-control','readonly', 'placeholder'=>''])!!}
                    </div>
                  </div>
                </div>
              </div>
                  {!!Form::hidden('eliminarReciboCompraResultado', null, array('id' => 'eliminarReciboCompraResultado'))!!}
            </div>

          </div>
        </div>

        <div class="form-group col-md-12" id='test'>
          {!!Form::label('observacionReciboCompra', 'Observaciones', array('class' => 'col-sm-3 control-label')) !!}
          <div class="col-sm-12">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="fa fa-pencil-square-o "></i>
              </span>
              {!!Form::textarea('observacionReciboCompra',null,['class'=>'form-control ckeditor','style'=>'height:100px'])!!}
            </div>
          </div>
        </div>

    </fieldset>
	@if(isset($recibocompra))
 		@if(isset($_GET['accion']) and $_GET['accion'] == 'eliminar')
   			{!!Form::submit('Eliminar',["class"=>"btn btn-primary"])!!}
  		@else
   			{!!Form::submit('Modificar',["class"=>"btn btn-primary", 'onclick' =>'validarFormulario(event)'])!!}
  		@endif
 	@else
  		{!!Form::submit('Adicionar',["class"=>"btn btn-primary", 'onclick' =>'validarFormulario(event)'])!!}
 	@endif

	{!! Form::close() !!}
</div>
<script>
  CKEDITOR.replace(('observacionReciboCompra'), {
      fullPage: true,
      allowedContent: true
    });  

  $(document).ready( function () {

    $("#fechaRealReciboCompra").datetimepicker(
      ({
        format: "YYYY-MM-DD"
      })
    );
});
</script>
@stop

<div id="modalOrdenCompra" class="modal fade" role="dialog">
  <div class="modal-dialog" style="width:90%;">
    <div style="" class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Orden de Compra</h4>
      </div>
      <div class="modal-body">
        <div id="divTabla" class="container">
            <div class="row" style="width:90%;">
                <div class="container" style="width:130%;">
                    <table id="tordencompra" name="tordencompra" class="display table-bordered" width="100%">
                        <thead>
                            <tr class="btn-default active">
                                <th><b>ID</b></th>
                                <th><b>Número de Orden</b></th>
                                <th><b>Estimado de entrega</b></th>
                                <th><b>Proveedor</b></th>
                                <th><b>ID Proveedor</b></th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr class="btn-default active">
                                <th>ID</th>
                                <th>Número de Orden</th>
                                <th>Estimado de entrega</th>
                                <th>ID Proveedor</th>
                                <th>Proveedor</th>
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