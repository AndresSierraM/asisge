@extends('layouts.vista')

@section('content')
@include('alerts.request')
{!!Html::script('js/compania.js')!!}

<script>

  var companiaObjetivos = '<?php echo (isset($compania) ? json_encode($compania->companiaobjetivos) : "");?>';
  companiaObjetivos = (companiaObjetivos != '' ? JSON.parse(companiaObjetivos) : '');
  var valor = [0,''];

  $(document).ready(function(){
    
    objetivos = new Atributos('objetivos','contenedor_objetivos','objetivos_');
    objetivos.campos = ['idCompaniaObjetivo','nombreCompaniaObjetivo'];
    objetivos.etiqueta = ['input','textarea'];
    objetivos.tipo = ['hidden',''];
    objetivos.estilo = ['','width: 600px; height: 100px;'];
    objetivos.clase = ['','form-control'];
    objetivos.sololectura = [false,false];

    for(var j=0, k = companiaObjetivos.length; j < k; j++)
    {
        objetivos.agregarCampos(JSON.stringify(companiaObjetivos[j]),'L');
    }

  });
</script>
	@if(isset($compania))
		@if(isset($_GET['accion']) and $_GET['accion'] == 'eliminar')
			{!!Form::model($compania,['route'=>['compania.destroy',$compania->idCompania],'method'=>'DELETE'])!!}
		@else
			{!!Form::model($compania,['route'=>['compania.update',$compania->idCompania],'method'=>'PUT'])!!}
		@endif
	@else
		{!!Form::open(['route'=>'compania.store','method'=>'POST'])!!}
	@endif

<div id='form-section' >

	<div class="container">
		<div class="navbar-header pull-left">
	  	<a class="navbar-brand"  >Compa&ntilde;&iacute;a</a>
	</div>
	</div>

  <div class="form-container">
	<fieldset id="compania-form-fieldset">	
		<div class="form-group" id='test'>
          {!! Form::label('codigoCompania', 'C&oacute;digo', array('class' => 'col-sm-2 control-label')) !!}
          <div class="col-sm-10">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="fa fa-barcode"></i>
              </span>
              {!!Form::text('codigoCompania',null,['class'=>'form-control','placeholder'=>'Ingresa el código de la compania'])!!}
              {!! Form::hidden('id', null, array('id' => 'id')) !!}
            </div>
          </div>
        </div>


		
		    <div class="form-group" id='test'>
          {!! Form::label('nombreCompania', 'Nombre', array('class' => 'col-sm-2 control-label')) !!}
          <div class="col-sm-10">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="fa fa-pencil-square-o "></i>
              </span>
				      {!!Form::text('nombreCompania',null,['class'=>'form-control','placeholder'=>'Ingresa el nombre de la compania'])!!}
            </div>
          </div>
        </div>

        <div class="form-group" id='test'>
          {!! Form::label('misionCompania', 'Misi&oacute;n', array('class' => 'col-sm-2 control-label')) !!}
          <div class="col-sm-10">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="fa fa-pencil-square-o "></i>
              </span>
              {!!Form::textarea('misionCompania',null,['class'=>'form-control','placeholder'=>'Ingresa la mision de la compania'])!!}
            </div>
          </div>
        </div>
        <div class="form-group" id='test'>
          <div class="col-sm-10">
            <div class="row show-grid">
                <div class="col-md-1" style="width: 600px;">Objetivos</div>
                <div class="col-md-1" style="width: 30px;"><a href="javascript:objetivos.agregarCampos(valor,'A')">+</a></div>
                <div id="contenedor_objetivos">
                </div>
            </div>
            
            
          </div>
        </div>
    </fieldset>
	@if(isset($compania))
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