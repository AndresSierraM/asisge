@extends('layouts.vista')
@section('titulo')<h3 id="titulo"><center>Categorías de Agenda</center></h3>@stop

@section('content')
@include('alerts.request')

{!!Html::script('js/categoriaagenda.js')!!}
<!-- Librerías para el selector de colores (color Picker) -->
{!! Html::style('assets/colorpicker/css/bootstrap-colorpicker.min.css'); !!}
{!! Html::script('assets/colorpicker/js/bootstrap-colorpicker.js'); !!}


<script>
    var idRol = '<?php echo isset($idRol) ? $idRol : "";?>';
    var nombreRol = '<?php echo isset($nombreRol) ? $nombreRol : "";?>';

    var dependenciapermisos = '<?php echo (isset($categoriaagenda) ? json_encode($categoriaagenda->dependenciaPermiso) : "");?>';
    dependenciapermisos = (dependenciapermisos != '' ? JSON.parse(dependenciapermisos) : '');
    var valorCategoriaAgenda = ['','', 0];

    $(document).ready(function(){

      protCampos = new Atributos('protCampos','contenedor_protCampos','categoriaagendacampo');

      protCampos.altura = '35px';
      protCampos.campoid = 'idCategoriaAgendaCampo';
      protCampos.campoEliminacion = 'eliminarDocumentoCRMCampo';

      protCampos.campos   = [
      'idCategoriaAgendaCampo',
      'CategoriaAgenda_idCategoriaAgenda',
      'CampoCRM_idCampoCRM',
      'nombreCampoCRM',
      'obligatorioDocumentoCRMCampo',
      'consultaDocumentoCRMCampo'
      ];

      protCampos.etiqueta = [
      'input',
      'input',
      'input',
      'input',
      'checkbox',
      'checkbox'
      ];

      protCampos.tipo = [
      'hidden',
      'hidden',
      'hidden',
      'text',
      'checkbox',
      'checkbox'
      ];

      protCampos.estilo = [
      '',
      '',
      '',
      'width: 560px;height:35px;',
      'width: 100px;height:35px; display:inline-block;',
      'width: 100px;height:35px; display:inline-block;'
      ];

      protCampos.clase    = ['','','','','','','','',''];
      protCampos.sololectura = [true,true,true,true,false,false];  
      protCampos.funciones = ['','','','','',''];
      protCampos.completar = ['off','off','off','off','off','off'];
      protCampos.opciones = ['','','','','',''];
      for(var j=0, k = dependenciapermisos.length; j < k; j++)
      {
        protCampos.agregarCampos(JSON.stringify(dependenciapermisos[j]),'L');
        console.log(JSON.stringify(dependenciapermisos[j]))
      }

    });

  </script>


	 @if(isset($categoriaagenda))
    @if(isset($_GET['accion']) and $_GET['accion'] == 'eliminar')
      {!!Form::model($categoriaagenda,['route'=>['categoriaagenda.destroy',$categoriaagenda->idCategoriaAgenda],'method'=>'DELETE'])!!}
    @else
      {!!Form::model($categoriaagenda,['route'=>['categoriaagenda.update',$categoriaagenda->idCategoriaAgenda],'method'=>'PUT'])!!}
    @endif
  @else
    {!!Form::open(['route'=>'categoriaagenda.store','method'=>'POST'])!!}
  @endif


<div id='form-section'>

  <fieldset id="categoriaagenda-form-fieldset"> 
      	<div class="form-group" id='test'>
	        {!!Form::label('codigoCategoriaAgenda', 'C&oacute;digo', array('class' => 'col-sm-2 control-label')) !!}
	      <div class="col-sm-10">
	        <div class="input-group">
	            <span class="input-group-addon">
	              <i class="fa fa-barcode"></i>
	            </span>
	            {!!Form::text('codigoCategoriaAgenda',null,['class'=>'form-control','placeholder'=>'Ingresa el código del tipo de tarea'])!!}
	          {!!Form::hidden('idCategoriaAgenda', null, array('id' => 'idCategoriaAgenda')) !!}
	          {!!Form::hidden('eliminarCategoriaAgenda', null, array('id' => 'eliminarCategoriaAgenda')) !!}
	        </div>
	      </div>
	    </div>


    
      	<div class="form-group" id='test'>
          {!!Form::label('nombreCategoriaAgenda', 'Nombre', array('class' => 'col-sm-2 control-label')) !!}
          <div class="col-sm-10">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="fa fa-pencil-square-o "></i>
              </span>
        	  {!!Form::text('nombreCategoriaAgenda',null,['class'=>'form-control','placeholder'=>'Ingresa el nombre del tipo de tarea'])!!}
            </div>
          </div>
      	</div>



      	<div class="form-group" id='test'>
	      {!!Form::label('colorCategoriaAgenda', 'Color', array('class' => 'col-sm-2 control-label')) !!}
	      <div class="col-sm-10">
	        <div class="input-group">
	          <span class="input-group-addon">
	              <i class="fa fa-sliders"></i>
	          </span>
	      	  <div id="colorCategoriaAgenda" class="input-group colorpicker-component" style="width: 100%;">
			  <input id="colorFondoCategoriaAgenda" type="hidden" value="#255986" class="form-control"/>
			  <span class="input-group-addon"><i style="width: 100%;"></i></span>
			</div>
	      	  <script>
				  $(function () {
				      $('#colorCategoriaAgenda').colorpicker();
				  });
			</script>
	        </div>
	      </div>
      	</div>  

      <br><br><br><br><br>

        <div class="form-group">
          <div class="col-lg-12">
            <div class="panel panel-primary">
              <div class="panel-heading">Contenido</div>
              <div class="panel-body">
                <div class="panel-group" id="accordion">
                  <div class="panel panel-info">
                    <div class="panel-heading">
                      <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#permisoCategoriaAgenda">Contenido</a>
                      </h4>
                    </div>
                    <div id="permisoCategoriaAgenda" class="panel-collapse collapse">
                      <div class="panel-body">
                        <div class="form-group" id='test'>
                          <div class="col-sm-12">
                            <div class="row show-grid">
                              <div class="col-md-1" style="width: 40px; height: 42px; cursor: pointer;" onclick="abrirModalCampos();">
                                <span class="glyphicon glyphicon-plus"></span>
                              </div>
                              <div class="col-md-1" style="width: 560px;">Campo</div>
                              <div class="col-md-1" style="width: 100px;">Obligatorio</div>
                              <div class="col-md-1" style="width: 100px;">Consulta</div>
                              <div id="contenedor_protCampos"> 
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>  
                </div>
              </div>
            </div>
          </div>
        </div>
    </fieldset>

<div id="myModalRol" class="modal fade" role="dialog">
  <div class="modal-dialog" style="width:100%;">

    <!-- Modal content-->
    <div style="" class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Selecci&oacute;n de Roles</h4>
      </div>
      <div class="modal-body">
      <iframe style="width:100%; height:500px; " id="rol" name="rol" src="{!! URL::to ('rolselect')!!}"> </iframe> 
      </div>
    </div>
  </div>
</div>

	@if(isset($categoriaagenda))
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

<div id="ModalCampos" class="modal fade" role="dialog">
  <div class="modal-dialog" style="width:70%;">

    <!-- Modal content-->
    <div style="" class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Selecci&oacute;n de Campos</h4>
      </div>
      <div class="modal-body">
      <?php 
        echo '<iframe style="width:100%; height:400px; " id="campos" name="campos" src="http://'.$_SERVER["HTTP_HOST"].'/campocrmgridselect"></iframe>'
      ?>
      </div>
    </div>
  </div>
</div>