@extends('layouts.vista')
@section('titulo')<h3 id="titulo"><center>Roles</center></h3>@stop

@section('content')
@include('alerts.request')


{!!Html::script('js/tercero.js')!!}
  <script>

    var rolOpcion = '<?php echo (isset($rol) ? json_encode($rol->rolOpcion) : "");?>';
    rolOpcion = (rolOpcion != '' ? JSON.parse(rolOpcion) : '');
    var valorPermisos = [0,'','',0,0,0,0];

    $(document).ready(function(){


      permisos = new Atributos('permisos','contenedor_permisos','permisos_');
      permisos.campos   = ['Opcion_idOpcion',   'nombrePaquete' ,   'nombreOpcion',   'adicionarRolOpcion','modificarRolOpcion','eliminarRolOpcion','consultarRolOpcion'];
      permisos.etiqueta = ['input',             'input',            'input',          'input',              'input',            'input',            'input'];
      permisos.tipo     = ['input',             'text',             'text',           'checkbox',           'checkbox',         'checkbox',         'checkbox'];
      permisos.estilo   = ['', 'width: 250px; height:35px;','width: 400px;height:35px;','width: 70px;height:30px;','width: 70px;height:30px;','width: 70px;height:30px;','width: 70px;height:30px;'];
      permisos.clase = ['','','','','','',''];
      permisos.sololectura = [false,false,false,false,false,false,false];

      for(var j=0, k = rolOpcion.length; j < k; j++)
      {
        permisos.agregarCampos(JSON.stringify(rolOpcion[j]),'L');
      }

    });

    var $modal = $('#ajax-modal');
     
    $('.ajax .demo').on('click', function(){
      // create the backdrop and wait for next modal to be triggered
      $('body').modalmanager('loading');
     
      setTimeout(function(){
         $modal.load('opciongridphpselect.blade.php', '', function(){
          $modal.modal();
        });
      }, 1000);
    });
     
    $modal.on('click', '.update', function(){
      $modal.modal('loading');
      setTimeout(function(){
        $modal
          .modal('loading')
          .find('.modal-body')
            .prepend('<div class="alert alert-info fade in">' +
              'Updated!<button type="button" class="close" data-dismiss="alert">&times;</button>' +
            '</div>');
      }, 1000);
    });

  </script>

	@if(isset($rol))
		@if(isset($_GET['accion']) and $_GET['accion'] == 'eliminar')
			{!!Form::model($rol,['route'=>['rol.destroy',$rol->idRol],'method'=>'DELETE', 'files' => true])!!}
		@else
			{!!Form::model($rol,['route'=>['rol.update',$rol->idRol],'method'=>'PUT', 'files' => true])!!}
		@endif
	@else
		{!!Form::open(['route'=>'rol.store','method'=>'POST', 'files' => true])!!}
	@endif


<div id='form-section' >

	<fieldset id="rol-form-fieldset">	
		<div class="form-group" id='test'>
          {!! Form::label('codigoRol', 'C&oacute;digo', array('class' => 'col-sm-2 control-label')) !!}
          <div class="col-sm-10">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="fa fa-barcode"></i>
              </span>
              {!!Form::text('codigoRol',null,['class'=>'form-control','placeholder'=>'Ingresa el codigo del rol'])!!}
              {!! Form::hidden('id', null, array('id' => 'id')) !!}
            </div>
          </div>
        </div>


		
		    <div class="form-group" id='test'>
          {!! Form::label('nombreRol', 'Nombre', array('class' => 'col-sm-2 control-label')) !!}
          <div class="col-sm-10">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="fa fa-pencil-square-o "></i>
              </span>
      				{!!Form::text('nombreRol',null,['class'=>'form-control','placeholder'=>'Ingresa el nombre del rol'])!!}
            </div>
          </div>
        </div>
      <div class="panel-body">
          <div class="form-group" id='test'>
            <div class="col-sm-12">
              <div class="row show-grid">
                <div class="col-md-1" style="width: 40px;" onclick="//permisos.agregarCampos(valorPermisos,'A')">
                  {!! HTML::decode(HTML::link('opcionselect', Form::label('modal','',array('class'=>'fa fa-list','title' => 'Seleccionar Permisos')))) !!}
                </div>
                <div class="col-md-1" style="width: 250px;">Paquete</div>
                <div class="col-md-1" style="width: 400px;">Opci&oacute;n</div>
                <div class="col-md-1" style="width: 70px;"><center><span title="Adicionar" class="fa fa-plus"></span></center></div>
                <div class="col-md-1" style="width: 70px;"><center><span title="Modificar" class="fa fa-pencil"></span></center></div>
                <div class="col-md-1" style="width: 70px;"><center><span title="Eliminar / Anular" class="fa fa-trash"></span></center></div>
                <div class="col-md-1" style="width: 70px;"><center><span title="Consultar / Imprimir" class="fa fa-print"></span></center></div>
                <div id="contenedor_permisos">
                </div>
              </div>
            </div>
          </div>
        </div>
    </fieldset>
	@if(isset($rol))
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