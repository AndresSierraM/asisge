@extends('layouts.grid')
@section('titulo')<h3 id="titulo"><center>Evaluación de Proveedor</center></h3>@stop

@section('content')
@include('alerts.request')
{!!Html::script('js/evaluacionproveedor.js'); !!}
	@if(isset($evaluacionproveedor))
		@if(isset($_GET['accion']) and $_GET['accion'] == 'eliminar')
			{!!Form::model($evaluacionproveedor,['route'=>['evaluacionproveedor.destroy',$evaluacionproveedor->idEvaluacionProveedor],'method'=>'DELETE'])!!}
		@else
			{!!Form::model($evaluacionproveedor,['route'=>['evaluacionproveedor.update',$evaluacionproveedor->idEvaluacionProveedor],'method'=>'PUT'])!!}
		@endif
	@else
		{!!Form::open(['route'=>'evaluacionproveedor.store','method'=>'POST'])!!}
	@endif


<script type="text/javascript">

  var resultadoevaluacion = '<?php echo (isset($resultadoevaluacion) ? json_encode($resultadoevaluacion) : "");?>';
  resultadoevaluacion = (resultadoevaluacion != '' ? JSON.parse(resultadoevaluacion) : '');

  valorEvaluacionProveedor = ['','','',1,1,1,''];

  $(document).ready(function(){

    ////////////////////////////
    //R E S U L T A D O
    ///////////////////////////

      resultado = new Atributos('resultado','contenedor_resultado','resultados_');

      resultado.altura = '35px';
      resultado.campoid = 'idEvaluacionProveedorResultado';
      resultado.campoEliminacion = 'eliminarEvaluacionProveedor';
      resultado.botonEliminacion = false;

      resultado.campos   = [
      'descripcionEvaluacionProveedorResultado',
      'porcentajeEvaluacionProveedorResultado',
      'pesoEvaluacionProveedorResultado',
      'resultadoEvaluacionProveedorResultado',
      'idEvaluacionProveedorResultado'];

      resultado.etiqueta = [
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
      'hidden'];
      
      resultado.estilo   = [
      'width: 400px;height:35px;',
      'width: 200px;height:35px;',
      'width: 200px; height:35px;',
      'width: 200px;height:35px;',
      ''];

      resultado.clase = ['','','','','']; 
      resultado.sololectura = [true,true,true,true,true]; 
      resultado.completar = ['off','off','off','off','off']; 
      resultado.opciones = ['','','','','']; 
      resultado.funciones  = ['','','','',''];

    for(var j=0, k = resultadoevaluacion.length; j < k; j++)
    {
      resultado.agregarCampos(JSON.stringify(resultadoevaluacion[j]),'L');
      calcularTotales();

    }
  });
</script>


<div id='form-section' >

	<fieldset id="evaluacionproveedor-form-fieldset">	
    <input type="hidden" id="token" value="{{csrf_token()}}"/>
		<div class="form-group col-md-6" id='test'>
      {!!Form::label('Tercero_idProveedor', 'Proveedor', array('class' => 'col-sm-3 control-label')) !!}
      <div class="col-sm-10">
        <div class="input-group">
          <span class="input-group-addon">
            <i class="fa fa-user"></i>
          </span>
          {!!Form::select('Tercero_idProveedor',$proveedor, @$evaluacionproveedor->Tercero_idProveedor,["class" => "chosen-select form-control", "placeholder" => "Seleccione", 'onchange'=>'cargarResultadoProveedor(this.value)'])!!}
          {!!Form::hidden('idEvaluacionProveedor', null, array('id' => 'idEvaluacionProveedor')) !!}
          {!!Form::hidden('eliminarEvaluacionProveedor', null, array('id' => 'eliminarEvaluacionProveedor')) !!}
        </div>
      </div>
    </div>

    <div class="form-group col-md-6" id='test'>
      {!!Form::label('fechaElaboracionEvaluacionProveedor', 'Elaboración', array('class' => 'col-sm-3 control-label')) !!}
      <div class="col-sm-10">
        <div class="input-group">
          <span class="input-group-addon">
            <i class="fa fa-calendar"></i>
          </span>
          {!!Form::text('fechaElaboracionEvaluacionProveedor',(isset($evaluacionproveedor) ? $evaluacionproveedor->fechaElaboracionEvaluacionProveedor : date('Y-m-d')),['class'=>'form-control', 'readonly'])!!}
        </div>
      </div>
    </div>

    <div class="form-group col-md-6" id='test'>
      {!!Form::label('fechaInicialEvaluacionProveedor', 'Fecha Inicial', array('class' => 'col-sm-3 control-label')) !!}
      <div class="col-sm-10">
        <div class="input-group">
          <span class="input-group-addon">
            <i class="fa fa-calendar"></i>
          </span>
          {!!Form::text('fechaInicialEvaluacionProveedor',(isset($evaluacionproveedor) ? $evaluacionproveedor->fechaInicialEvaluacionProveedor : null),['class'=>'form-control'])!!}
        </div>
      </div>
    </div>

    <div class="form-group col-md-6" id='test'>
      {!!Form::label('fechaFinalEvaluacionProveedor', 'Fecha Final', array('class' => 'col-sm-3 control-label')) !!}
      <div class="col-sm-10">
        <div class="input-group">
          <span class="input-group-addon">
            <i class="fa fa-calendar"></i>
          </span>
          {!!Form::text('fechaFinalEvaluacionProveedor',(isset($evaluacionproveedor) ? $evaluacionproveedor->fechaInicialEvaluacionProveedor : null),['class'=>'form-control'])!!}
        </div>
      </div>
    </div>

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

    <br><br><br><br><br>

        <div class="form-group">
          <div class="col-lg-12">
            <div class="panel panel-primary">
              <div class="panel-heading">Resultados</div>
              <div class="panel-body">
                <div class="form-group" id='test'>
                  <div class="col-sm-12">
                    <div class="row show-grid">
                      <div class="col-md-1" style="width: 400px;display:inline-block;height:50px;">Concepto</div>
                      <div class="col-md-1" style="width: 200px;display:inline-block;height:50px;">Porcentaje</div>
                      <div class="col-md-1" style="width: 200px;display:inline-block;height:50px;">Peso</div>
                      <div class="col-md-1" style="width: 200px;display:inline-block;height:50px;">Resultado</div>

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

            </div>

          </div>
        </div>

        <div class="form-group col-md-12" id='test'>
          {!!Form::label('observacionEvaluacionProveedor', 'Observaciones', array('class' => 'col-sm-3 control-label')) !!}
          <div class="col-sm-12">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="fa fa-pencil-square-o "></i>
              </span>
              {!!Form::textarea('observacionEvaluacionProveedor',null,['class'=>'form-control ckeditor','style'=>'height:100px'])!!}
            </div>
          </div>
        </div>

    </fieldset>
	@if(isset($evaluacionproveedor))
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
  CKEDITOR.replace(('observacionEvaluacionProveedor'), {
      fullPage: true,
      allowedContent: true
    });  

  $(document).ready( function () {

    $("#fechaInicialEvaluacionProveedor, #fechaFinalEvaluacionProveedor").datetimepicker(
      ({
        format: "YYYY-MM-DD"
      })
    );
});
</script>
@stop